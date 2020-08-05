<?php
class ModelExtensionDashboardStoreSales extends Model {
    public function getStoreSales($store_id, $start, $end) {
        $result = $this->db->query("
            SELECT * FROM `order`
            WHERE store_id = {$store_id} AND date_added BETWEEN '{$start}' AND '{$end}' AND order_status_id > 0 AND order_status_id NOT IN (7,8,10,13)");
        return $result->rows;
    }

    public function getGroupedStoreSales($store_id, $start, $end) {
        $result = $this->db->query("
            SELECT *,
                (SELECT name FROM class WHERE class_id = (SELECT class_id FROM customer WHERE customer_id = o.customer_id)) as class,
                (SELECT class_id FROM class WHERE class_id = (SELECT class_id FROM customer WHERE customer_id = o.customer_id)) AS class_id_o 
            FROM `order` o
                WHERE o.store_id = {$store_id} AND o.date_added BETWEEN '{$start}' AND '{$end}' AND o.order_status_id > 0 AND o.order_status_id NOT IN (7,8,10,13) GROUP BY o.customer_id");
        return $result->rows;
    }

    public function getStudentTotal($class_id) {
        if (!$class_id) {
             return 0;
        }
        $result = $this->db->query("SELECT count(*) as total FROM customer where class_id = {$class_id}");
        return $result->row['total'];
    }
}