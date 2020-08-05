<?php
class ModelCatalogPackage extends Model {
    public function getClass($class_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "class WHERE class_id = '" . (int)$class_id . "'");

        return $query->row;
    }

    public function getClassPackages($class_id) {
        $query = $this->db->query("SELECT cp.package_id FROM " . DB_PREFIX . "class_package cp LEFT JOIN package p ON cp.package_id = p.package_id WHERE cp.class_id = '" . (int)$class_id . "' ORDER BY p.sort_order, p.name");

        foreach ($query->rows as &$package) {
            $package_id = $package["package_id"];
            $package = $this->getPackageDetails($package_id);
            $package['products'] = $this->getPackageProducts($package_id);
        }

        return $query->rows;
    }

    public function getPackageDetails($package_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "package WHERE package_id = '" . (int)$package_id . "'");

        return $query->row;
    }

    public function getPackageProducts($package_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "package_product WHERE package_id = " . (int)$package_id . " ORDER BY sort_order");

        return $query->rows;
    }

    public function getCustomerPackages($customer_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_package WHERE customer_id = " . (int)$customer_id);
        if (isset ($query->row['data']))
            return json_decode($query->row['data'], true, JSON_UNESCAPED_UNICODE);

        return false;
    }

    public function setCustomerPackages($customer_id, $packages) {
        return $this->db->query("
            INSERT INTO " . DB_PREFIX . "customer_package SET
            customer_id = " . (int)$customer_id . ",
            data = '" . $this->db->escape(json_encode($packages, JSON_UNESCAPED_UNICODE)) . "'
            ON DUPLICATE KEY UPDATE data = '" . $this->db->escape(json_encode($packages, JSON_UNESCAPED_UNICODE)) . "'
        ");
    }
}