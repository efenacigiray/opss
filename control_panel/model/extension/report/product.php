<?php
class ModelExtensionReportProduct extends Model {
    public function getProductsViewed($data = array()) {
        $sql = "SELECT pd.name, p.model, p.viewed FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.viewed > 0 ORDER BY p.viewed DESC";

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

    public function getTotalProductViews() {
        $query = $this->db->query("SELECT SUM(viewed) AS total FROM " . DB_PREFIX . "product");

        return $query->row['total'];
    }

    public function getTotalProductsViewed() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE viewed > 0");

        return $query->row['total'];
    }

    public function reset() {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = '0'");
    }

    public function getPurchased($data = array()) {
        $sql = "SELECT op.product_id, op.name, op.model, SUM(op.quantity) AS tquantity, SUM((op.price + op.tax) * op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)";

        if (!empty($data['filter_manufacturer'])) {
            $sql .= " LEFT JOIN product p ON op.product_id = p.product_id";
        }

        if (!empty($data['filter_category'])) {
            $sql .= " LEFT JOIN product_to_category p2c ON op.product_id = p2c.product_id";
        }

        if (!empty($data['filter_order_status_id'])) {
            if (is_array($data['filter_order_status_id'])) {
                $ids = implode(',', $data['filter_order_status_id']);
                $sql .= " WHERE o.order_status_id IN (" . $ids . ")";
            } else {
                $sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
            }
        } else {
            $cancelled = implode(',', $this->config->get('config_cancelled_status'));
            $sql .= " WHERE o.order_status_id > '0' and o.order_status_id NOT IN ($cancelled)";
        }

        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }

        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }

        if (!empty($data['filter_manufacturer'])) {
            $sql .= " AND p.manufacturer_id = " . (int)$data['filter_manufacturer'];
        }

        if (!empty($data['filter_category'])) {
            $sql .= " AND p2c.category_id = " . (int)$data['filter_category'];
        }

        $sql .= " GROUP BY op.product_id ORDER BY total DESC";

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

    public function getTotalPurchased($data) {
        $sql = "SELECT COUNT(DISTINCT op.product_id) AS total FROM `" . DB_PREFIX . "order_product` op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)";

        if (!empty($data['filter_manufacturer'])) {
            $sql .= " LEFT JOIN product p ON op.product_id = p.product_id";
        }

        if (!empty($data['filter_category'])) {
            $sql .= " LEFT JOIN product_to_category p2c ON op.product_id = p2c.product_id";
        }

        if (!empty($data['filter_order_status_id'])) {
            if (is_array($data['filter_order_status_id'])) {
                $sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
            } else {
                $sql .= " WHERE o.order_status_id IN ('" . implode(',', $data['filter_order_status_id']) . "')";
            }
        } else {
            $cancelled = implode(',', $this->config->get('config_cancelled_status'));
            $sql .= " WHERE o.order_status_id > '0' and o.order_status_id NOT IN ($cancelled)";
        }

        if (!empty($data['filter_manufacturer'])) {
            $sql .= " AND p.manufacturer_id = " . (int)$data['filter_manufacturer'];
        }

        if (!empty($data['filter_category'])) {
            $sql .= " AND p2c.category_id = " . (int)$data['filter_category'];
        }

        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }

        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }
}
