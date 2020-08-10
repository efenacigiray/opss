<?php
class ModelToolBackup extends Model {
    public function getTables() {
        $table_data = array();

        $query = $this->db->query("SHOW TABLES FROM `" . DB_DATABASE . "`");

        foreach ($query->rows as $result) {
            if (utf8_substr($result['Tables_in_' . DB_DATABASE], 0, strlen(DB_PREFIX)) == DB_PREFIX) {
                if (isset($result['Tables_in_' . DB_DATABASE])) {
                    $table_data[] = $result['Tables_in_' . DB_DATABASE];
                }
            }
        }

        return $table_data;
    }

    public function getManufacturer($manufacturer_name, $stores) {
        $query = $this->db->query("SELECT manufacturer_id FROM manufacturer WHERE name = '" . $this->db->escape($manufacturer_name) . "' LIMIT 1");

        if (!$query->num_rows) {
            $query = $this->db->query("INSERT INTO manufacturer SET name = '" . $this->db->escape($manufacturer_name) . "'");
            $id = $this->db->getLastId();

            foreach ($stores as $store) {
                $query = $this->db->query("INSERT INTO manufacturer_to_store SET store_id = " . (int)$store . ", manufacturer_id = " . (int)$id);
            }

            return $id;
        }

        return $query->row['manufacturer_id'];
    }

    public function getTaxClass($tax_rate) {
        $query = $this->db->query("SELECT tax_rate_id FROM tax_rate WHERE rate = " . (int)$tax_rate . " LIMIT 1");
        $tax_rate_id = $query->row['tax_rate_id'];
        $query = $this->db->query("SELECT tax_class_id FROM tax_rule WHERE tax_rate_id = " . (int)$tax_rate_id . " LIMIT 1");
        return $query->row['tax_class_id'];
    }

    public function exists($model) {
        $results = $this->db->query("SELECT product_id FROM product WHERE model = '" . $model . "' LIMIT 1");
        if ($results->num_rows) {
            return $results->row['product_id'];
        }
        return false;
    }

    public function getStores($stores) {
        $stores_query = "";
        if (empty($stores) || is_null($stores)) {
            $query = $this->db->query("SELECT store_id FROM store");
        } else {
            $stores = explode(',', $stores);
            foreach ($stores as $store) {
                $stores_query .= "'" . trim($store) . "', ";
            }
            $stores_query = trim($stores_query, ", ");
            $query = $this->db->query("SELECT store_id FROM store WHERE name IN (" . $stores_query .")");
        }

        $store_ids = array(0);
        foreach ($query->rows as $value) {
            $store_ids[] = $value['store_id'];
        }

        return $store_ids;
    }

    public function getCategories($categories) {
        if (is_null($categories) || empty($categories))
            return array();

        $category_ids = [];

        $categories = explode(',', $categories);
        foreach ($categories as $cat_name) {
            $cat_name = trim($cat_name);
            $parent_query = "";
            if (strpos($cat_name, ">") !== false) {
                list($has_parent, $cat_name) = explode(">", $cat_name);
                $has_parent = trim($has_parent);
                $cat_name = trim($cat_name);
                $parent_query = "AND parent_id = (SELECT cc.category_id FROM category cc LEFT JOIN category_description ccd ON cc.category_id = ccd.category_id WHERE ccd.name = '" . $this->db->escape($has_parent) . "' AND cc.parent_id = 0 LIMIT 1)";
            }

            $query = $this->db->query("SELECT c.category_id FROM category c LEFT JOIN category_description cd ON c.category_id = cd.category_id WHERE cd.name = '" . $this->db->escape($cat_name) . "' " . $parent_query . " LIMIT 1;");
            var_dump("SELECT c.category_id FROM category c LEFT JOIN category_description cd ON c.category_id = cd.category_id WHERE cd.name = '" . $this->db->escape($cat_name) . "' " . $parent_query . " LIMIT 1;");
            if ($query->num_rows)
                $category_ids[] = $query->row['category_id'];
        }

        return $category_ids;
    }

    public function backup($tables) {
        $output = '';

        foreach ($tables as $table) {
            if (DB_PREFIX) {
                if (strpos($table, DB_PREFIX) === false) {
                    $status = false;
                } else {
                    $status = true;
                }
            } else {
                $status = true;
            }

            if ($status) {
                $output .= 'TRUNCATE TABLE `' . $table . '`;' . "\n\n";

                $query = $this->db->query("SELECT * FROM `" . $table . "`");

                foreach ($query->rows as $result) {
                    $fields = '';

                    foreach (array_keys($result) as $value) {
                        $fields .= '`' . $value . '`, ';
                    }

                    $values = '';

                    foreach (array_values($result) as $value) {
                        $value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
                        $value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
                        $value = str_replace('\\', '\\\\',  $value);
                        $value = str_replace('\'', '\\\'',  $value);
                        $value = str_replace('\\\n', '\n',  $value);
                        $value = str_replace('\\\r', '\r',  $value);
                        $value = str_replace('\\\t', '\t',  $value);

                        $values .= '\'' . $value . '\', ';
                    }

                    $output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
                }

                $output .= "\n\n";
            }
        }

        return $output;
    }

    public function createPackage($package_name, $stores, $clean_name = "") {
        $result = $this->db->query("SELECT * from package where name = '" . $this->db->escape($package_name) . "'");
        if (!$result->num_rows) {
            $this->db->query("INSERT INTO package set name = '" . $this->db->escape($package_name) . "', image = '', sort_order = 0");
            $id = $this->db->getLastId();

            foreach ($stores as $store_id) {
                $this->db->query("INSERT INTO package_to_store set package_id = " . $id . ", store_id = " . $store_id);
            }

            return $id;
        }
        //$this->db->query("UPDATE package set name = '" . $this->db->escape($package_name) . "' where package_id = " . $result->row['package_id']);
        return $result->row['package_id'];
    }

    public function createClass($class_name, $stores) {
        $result = $this->db->query("SELECT * from class where name = '" . $this->db->escape($class_name) . "'");
        if (!$result->num_rows) {
            $this->db->query("INSERT INTO class set name = '" . $this->db->escape($class_name) . "', image = '', sort_order = 0");
            $id = $this->db->getLastId();

            foreach ($stores as $store_id) {
                $this->db->query("INSERT INTO class_to_store set class_id = " . $id . ", store_id = " . $store_id);
            }

            return $id;
        }
        return $result->row['class_id'];
    }

    public function addPackageToClass($class_id, $package_id) {
        $this->db->query("DELETE FROM class_package WHERE class_id = " .$class_id." AND package_id = " . $package_id);
        $this->db->query("INSERT INTO class_package SET class_id = " . $class_id . ", package_id = " . $package_id);
    }

    public function deletePackageProducts($package_id) {
        $this->db->query("DELETE FROM package_product WHERE package_id = " . $package_id);
    }

    public function addProductToPackage($package_id, $product_id, $quantity) {
        $price = 0;
        $this->db->query("DELETE FROM package_product WHERE package_id = " . $package_id . " AND product_id = " . $product_id);
        $this->db->query("INSERT INTO package_product SET package_id = " . $package_id . ", product_id = " . $product_id . ", quantity = " . $quantity . ", type = 1, sort_order = 0, package_price = " . $price);
    }

    public function update($product_id, $data) {
        $this->db->query("UPDATE product_description SET name = '" . $this->db->escape($data['product_description'][1]['name']) . "' WHERE product_id = " . $product_id);
        $this->db->query("UPDATE product SET quantity = '" . (int)$data['quantity'] . "', price = '" . (float)$data['price'] . "' WHERE product_id = " . $product_id);
    }

    public function clearPackage($package_id, $product_list) {
        $product_ids = implode(",", $product_list);
        $res = $this->db->query("DELETE FROM package_product wHERE package_id = " . $package_id . " AND product_id not in (" . $product_ids . ")");
    }

    public function clearClass($class_id, $package_list) {
        $package_ids = implode(",", $package_list);
        $res = $this->db->query("DELETE FROM class_package wHERE class_id = " . $class_id . " AND package_id not in (" . $package_ids . ")");
        var_dump($res->rows);
    }

    public function getCustomerGroup($name) {
        $row = $this->db->query("SELECT * FROM customer_group_description WHERE name = '" . $this->db->escape($name) . "' LIMIT 1");
        if ($row->num_rows > 0)
            return $row->row['customer_group_id'];
        $this->db->query("INSERT INTO customer_group SET approval = 0, sort_order = 0");
        $group_id = $this->db->getLastId();
        $this->db->query("INSERT INTO customer_group_description SET customer_group_id = " . $group_id . ", language_id = 1, name = '" . $name . "'");
    }

    public function addCustomer($data, $group_id) {
        if (isset($data['tckn'])) {
            $result = $this->db->query("SELECT * from customer where tckn = '" . $this->db->escape($data['tckn']) . "'" );
        } else {
            $result = $this->db->query("SELECT * from customer where stdn = '" . $this->db->escape($data['stdn']) . "' AND firstname = '" . $this->db->escape($data['firstname']) . "' AND lastname = '" . $this->db->escape($data['lastname']) . "'" );
        }

        if (!$result->num_rows) {
            echo "NOT FOUND<br>";
            $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$group_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', tckn = '" . $this->db->escape(isset($data['tckn']) ? $data['tckn'] : '') . "', stdn = '" . $this->db->escape(isset($data['stdn']) ? $data['stdn'] : '') ."', custom_field = '" . json_encode(array()) . "', newsletter = '0', salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1(rand())))) . "', status = '1', safe = '1', date_added = NOW(), class_id = " . (int)$data['class_id']);

            $customer_id = $this->db->getLastId();

            return $customer_id;
        }
        echo "found";
    }

    public function getClass($name) {
        $row = $this->db->query("SELECT * FROM class WHERE name = '" . $this->db->escape($name) . "' LIMIT 1");
        if ($row->num_rows > 0)
            return $row->row['class_id'];
        $this->db->query("INSERT INTO class SET name = '" . $this->db->escape($name) . "', sort_order = 0, image = ''");
        return $this->db->getLastId();
    }

    public function trimCustomerNames() {
        $query = $this->db->query("SELECT customer_id, firstname, lastname FROM customer");
        foreach ($query->rows as $customer) {
            $customer['firstname'] = str_replace("  ", " ", $customer['firstname']);
            $this->db->query("UPDATE customer set firstname = '" . $this->db->escape(trim($customer['firstname'])) . "', lastname = '" . $this->db->escape(trim($customer['lastname'])) . "' where customer_id = " . $customer['customer_id'] . " limit 1");
            //echo "UPDATE customer set firstname = '" . $this->db->escape(trim($customer['firstname'])) . "', lastname = '" . $this->db->escape(trim($customer['lastname'])) . "' where customer_id = " . $customer['customer_id'] . " limit 1<br>";
        }
    }

    public function productsToStore() {
        $query = $this->db->query("SELECT product_id FROM product");
        $stores_query = $this->db->query("SELECT store_id FROM store");
        foreach ($query->rows as $product) {
            $product_id = $product['product_id'];
            $this->db->query("DELETE FROM product_to_store where product_id = " . $product_id);
            foreach ($stores_query->rows as $store) {
                $this->db->query("INSERT INTO product_to_store SET product_id = " . $product_id . ", store_id = " . $store['store_id']);
            }
            $this->db->query("INSERT INTO product_to_store SET product_id = " . $product_id . ", store_id = 0");
        }
    }
}