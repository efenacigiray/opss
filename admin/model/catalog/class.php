<?php
class ModelCatalogClass extends Model {
    public function addClass($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "class SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

        $class_id = $this->db->getLastId();

        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "class SET image = '" . $this->db->escape($data['image']) . "' WHERE class_id = '" . (int)$class_id . "'");
        }

        if (isset($data['class_store'])) {
            foreach ($data['class_store'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "class_to_store SET class_id = '" . (int)$class_id . "', store_id = '" . (int)$store_id . "'");
            }
        }

        // SEO URL
        if (isset($data['class_seo_url'])) {
            foreach ($data['class_seo_url'] as $store_id => $language) {
                foreach ($language as $language_id => $keyword) {
                    if (!empty($keyword)) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'class_id=" . (int)$class_id . "', keyword = '" . $this->db->escape($keyword) . "'");
                    }
                }
            }
        }

        foreach ($data['package'] as $package_id) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "class_package SET class_id = " . (int)$class_id . ", package_id = " . (int)$package_id);
        }

        $this->cache->delete('class');

        return $class_id;
    }

    public function getCustomerClassName($customer_id) {
        $result = $this->db->query("SELECT name FROM class WHERE class_id = (SELECT class_id FROM customer WHERE customer_id = " . (int)$customer_id . ")");
        if ($result->num_rows)
            return $result->row['name'];
        return "";
    }

    public function editClass($class_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "class SET name = '" . $this->db->escape($data['name']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE class_id = '" . (int)$class_id . "'");

        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "class SET image = '" . $this->db->escape($data['image']) . "' WHERE class_id = '" . (int)$class_id . "'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "class_to_store WHERE class_id = '" . (int)$class_id . "'");

        if (isset($data['class_store'])) {
            foreach ($data['class_store'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "class_to_store SET class_id = '" . (int)$class_id . "', store_id = '" . (int)$store_id . "'");
            }
        }

        $this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE query = 'class_id=" . (int)$class_id . "'");

        if (isset($data['class_seo_url'])) {
            foreach ($data['class_seo_url'] as $store_id => $language) {
                foreach ($language as $language_id => $keyword) {
                    if (!empty($keyword)) {
                        $this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'class_id=" . (int)$class_id . "', keyword = '" . $this->db->escape($keyword) . "'");
                    }
                }
            }
        }

        $this->db->query("DELETE FROM `" . DB_PREFIX . "class_package` WHERE class_id=" . (int)$class_id);

        foreach ($data['package'] as $package_id) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "class_package SET class_id = " . (int)$class_id . ", package_id = " . (int)$package_id);
        }

        $this->cache->delete('class');
    }

    public function deleteClass($class_id) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "class` WHERE class_id = '" . (int)$class_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "class_to_store` WHERE class_id = '" . (int)$class_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "seo_url` WHERE query = 'class_id=" . (int)$class_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "class_package` WHERE class_id=" . (int)$class_id);

        $this->cache->delete('class');
    }

    public function getClass($class_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "class WHERE class_id = '" . (int)$class_id . "'");

        return $query->row;
    }

    public function getClasses($data = array()) {
        $sql = "SELECT *, c.class_id as class_id FROM " . DB_PREFIX . "class c LEFT JOIN class_to_store cts ON (c.class_id = cts.class_id) WHERE cts.store_id IN (" . $this->session->data['stores_query'] . ")";

        if (!empty($data['filter_name'])) {
            $sql .= " AND c.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        $sort_data = array(
            'sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY c." . $data['sort'];
        } else {
            $sql .= " ORDER BY c.name";
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

    public function getClassStores($class_id) {
        $class_store_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "class_to_store WHERE class_id = '" . (int)$class_id . "'");

        foreach ($query->rows as $result) {
            $class_store_data[] = $result['store_id'];
        }

        return $class_store_data;
    }

    public function getClassSeoUrls($class_id) {
        $class_seo_url_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = 'class_id=" . (int)$class_id . "'");

        foreach ($query->rows as $result) {
            $class_seo_url_data[$result['store_id']][$result['language_id']] = $result['keyword'];
        }

        return $class_seo_url_data;
    }

    public function getTotalClasses() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "class c LEFT JOIN class_to_store cts ON (c.class_id = cts.class_id) WHERE cts.store_id IN (" . $this->session->data['stores_query'] . ")");

        return $query->row['total'];
    }

    public function getClassPackages($class_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "class_package WHERE class_id = " . (int)$class_id);

        return $query->rows;
    }
}
