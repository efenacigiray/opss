<?php
class ModelLocalisationOrderStatus extends Model {
	public function addOrderStatus($data) {
		foreach ($data['order_status'] as $language_id => $value) {
			if (isset($order_status_id)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_status SET order_status_id = '" . (int)$order_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_status SET language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");

				$order_status_id = $this->db->getLastId();
			}
		}

		$this->cache->delete('order_status');
		
		return $order_status_id;
	}

	public function editOrderStatus($order_status_id, $data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "'");

		foreach ($data['order_status'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_status SET order_status_id = '" . (int)$order_status_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->cache->delete('order_status');
	}

	public function deleteOrderStatus($order_status_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "'");

		$this->cache->delete('order_status');
	}

	public function getOrderStatus($order_status_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}


		private function cmp($a, $b) {
			if (!isset($a['sort_order']) || !isset($b['sort_order'])) return 0;
			if ($a['sort_order'] == $b['sort_order']) return 0;
			return ($a['sort_order'] < $b['sort_order']) ? -1 : 1;
		}
			
	public function getOrderStatuses($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "order_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sql .= " ORDER BY name";

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

			// get order status options and order
			$qosu_os = $this->config->get('qosu_order_statuses');
			if ($qosu_os) {

				foreach ($query->rows as &$s) {
					if (isset($qosu_os[$s['order_status_id']])) {
						$s = array_merge($s, $qosu_os[$s['order_status_id']]);
					}
				}

				usort($query->rows, array($this, 'cmp'));
			}
			

			return $query->rows;
		} else {
			$order_status_data = $this->cache->get('order_status.' . (int)$this->config->get('config_language_id'));

			if (!$order_status_data) {
				$query = $this->db->query("SELECT order_status_id, name FROM " . DB_PREFIX . "order_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY name");

				$order_status_data = $query->rows;

			// get order status options and order
			$qosu_os = $this->config->get('qosu_order_statuses');
			if($qosu_os) {

				foreach($order_status_data as &$s) {
					if(isset($qosu_os[$s['order_status_id']])) {
						$s = $s + $qosu_os[$s['order_status_id']];
					}
				}

				usort($order_status_data, array($this, 'cmp'));
			}
			

				$this->cache->set('order_status.' . (int)$this->config->get('config_language_id'), $order_status_data);
			}

			return $order_status_data;
		}
	}

	public function getOrderStatusDescriptions($order_status_id) {
		$order_status_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "'");

		foreach ($query->rows as $result) {
			$order_status_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $order_status_data;
	}

	public function getTotalOrderStatuses() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_status WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row['total'];
	}
}