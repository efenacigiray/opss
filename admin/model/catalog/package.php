<?php
class ModelCatalogPackage extends Model {
    public function addPackage($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "package SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

        $package_id = $this->db->getLastId();

        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "package SET image = '" . $this->db->escape($data['image']) . "' WHERE package_id = '" . (int)$package_id . "'");
        }

        if (isset($data['package_store'])) {
            foreach ($data['package_store'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "package_to_store SET package_id = '" . (int)$package_id . "', store_id = '" . (int)$store_id . "'");
            }
        }

        // SEO URL
        if (isset($data['package_seo_url'])) {
            foreach ($data['package_seo_url'] as $store_id => $language) {
                foreach ($language as $language_id => $keyword) {
                    if (!empty($keyword)) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'package_id=" . (int)$package_id . "', keyword = '" . $this->db->escape($keyword) . "'");
                    }
                }
            }
        }

        foreach ($data['product'] as $product) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "package_product SET package_id = " . (int)$package_id . ", product_id = " . (int)$product['product_id'] . ", quantity = " . (int)$product["quantity"] . ", type = " . (int)$product["type"] . ", sort_order = " . (int)$product['sort_order']) . ", package_price = " . (double)$product['package_price'];
        }

        $this->cache->delete('package');

        return $package_id;
    }

    public function editPackage($package_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "package SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE package_id = '" . (int)$package_id . "'");

        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "package SET image = '" . $this->db->escape($data['image']) . "' WHERE package_id = '" . (int)$package_id . "'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "package_to_store WHERE package_id = '" . (int)$package_id . "'");

        if (isset($data['package_store'])) {
            foreach ($data['package_store'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "package_to_store SET package_id = '" . (int)$package_id . "', store_id = '" . (int)$store_id . "'");
            }
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "package_product WHERE package_id = '" . (int)$package_id . "'");

        foreach ($data['product'] as $product) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "package_product SET package_id = " . (int)$package_id . ", product_id = " . (int)$product['product_id'] . ", quantity = " . (int)$product["quantity"] . ", type = " . (int)$product["type"] . ", sort_order = " . (int)$product['sort_order'] . ", package_price = " . (double)$product['package_price']);
        }

        $this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE query = 'package_id=" . (int)$package_id . "'");

        if (isset($data['package_seo_url'])) {
            foreach ($data['package_seo_url'] as $store_id => $language) {
                foreach ($language as $language_id => $keyword) {
                    if (!empty($keyword)) {
                        $this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'package_id=" . (int)$package_id . "', keyword = '" . $this->db->escape($keyword) . "'");
                    }
                }
            }
        }

        $this->cache->delete('package');
    }

    public function deletePackage($package_id) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "package` WHERE package_id = '" . (int)$package_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "package_to_store` WHERE package_id = '" . (int)$package_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE query = 'package_id=" . (int)$package_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "package_product WHERE package_id = '" . (int)$package_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "class_package WHERE package_id = '" . (int)$package_id . "'");

        $this->cache->delete('package');
    }

    public function getCustomerPackages($customer_id) {
        $query = $this->db->query("SELECT * FROM package p LEFT JOIN class_package ctp ON p.package_id = ctp.package_id WHERE ctp.class_id = (SELECT class_id FROM customer WHERE customer_id = " . (int)$customer_id . ")");

        return $query->rows;
    }

    public function getPackage($package_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "package WHERE package_id = '" . (int)$package_id . "'");

        return $query->row;
    }

    public function getPackages($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "package p LEFT JOIN package_to_store pts ON (p.package_id = pts.package_id) WHERE pts.store_id IN (" . $this->session->data['stores_query'] . ")";

        if (!empty($data['filter_name'])) {
            $sql .= " AND p.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        $sort_data = array(
            'p.name',
            'p.sort_order'
        );

        $sql .= ' GROUP BY p.package_id';

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY p.name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getPackageStores($package_id) {
        $package_store_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "package_to_store WHERE package_id = '" . (int)$package_id . "'");

        foreach ($query->rows as $result) {
            $package_store_data[] = $result['store_id'];
        }

        return $package_store_data;
    }

    public function getPackageSeoUrls($package_id) {
        $package_seo_url_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'package_id=" . (int)$package_id . "'");

        foreach ($query->rows as $result) {
            $package_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
        }

        return $package_seo_url_data;
    }

    public function getPackageProducts($package_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "package_product WHERE package_id = " . (int)$package_id . " ORDER BY sort_order");

        return $query->rows;
    }


    public function getTotalPackages() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "package p LEFT JOIN package_to_store pts ON (p.package_id = pts.package_id) WHERE pts.store_id IN (" . $this->session->data['stores_query'] . ")");

        return $query->row['total'];
    }

    public function deleteCustomerCache($customer_id) {
        $query = $this->db->query("DELETE FROM customer_package WHERE customer_id = " . (int)$customer_id);
    }

    public function deleteClassCache($class_id) {
        $query = $this->db->query("SELECT customer_id FROM customer WHERE class_id = " . (int)$class_id);

        foreach ($query->rows as $customer) {
            $this->db->query("DELETE FROM customer_package WHERE customer_id = " . (int)$customer['customer_id']);
        }
    }
}
