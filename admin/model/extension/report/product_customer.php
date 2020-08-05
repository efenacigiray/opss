<?php
class ModelExtensionReportProductCustomer extends Model {
    public function getOrders($product_id, $store_id, $returns = false) {
        $sql = "SELECT *, op.total as `total` FROM `order` o LEFT JOIN order_product op ON o.order_id = op.order_id WHERE o.order_status_id > 0 AND op.product_id = " . (int)$product_id;

        if ($store_id >= 0)
            $sql .= " AND o.store_id = " . (int)$store_id;

        if ($returns) {
            $sql .= " AND order_status_id = 13";
        } else {
            $sql .= " AND order_status_id NOT IN (7,8,10,13)";
        }

        $results = $this->db->query($sql);
        return $results->rows;
    }

    public function getPackageSales($store_id) {
        $sql = "SELECT DISTINCT o.customer_id, (SELECT name FROM package WHERE package_id = cp.package_id) AS name, count(*) AS total, (SELECT count(*) FROM customer WHERE class_id = cp.class_id) FROM `order` o LEFT JOIN customer c ON o.customer_id = c.customer_id LEFT JOIN class_package cp ON c.class_id = cp.class_id WHERE o.order_status_id > 0 AND o.order_status_id NOT IN (7,8,10,13)";

        if ($store_id)
            $sql .= " AND o.store_id = " . (int)$store_id;

        $sql .= " GROUP BY cp.package_id";

        $results = $this->db->query($sql);
        return $results->rows;
    }
}