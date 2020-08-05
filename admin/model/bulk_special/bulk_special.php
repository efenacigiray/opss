<?php
class ModelBulkSpecialBulkSpecial extends Model {
	public function addSpecial($data) {

		$filter = array(
			'filter_category_id'		=>	isset($data['bulk_special_category']) ? $data['bulk_special_category'] : '',
			'filter_manufacturer_id' 	=> 	isset($data['bulk_special_manufacturer']) ? $data['bulk_special_manufacturer'] : '',
			'filter_name' 				=> 	isset($data['bulk_special_name']) ? $data['bulk_special_name'] : '',
			'filter_price_start'		=> 	isset($data['bulk_special_price_start']) ? $data['bulk_special_price_start'] : '',
			'filter_price_end'			=> 	isset($data['bulk_special_price_end']) ? $data['bulk_special_price_end'] : '', 
		);
		
		$products = array();
		$products = $this->getProducts($filter);
		
		foreach ($products as $product) {
			if(version_compare(VERSION, '2.3.0.0') < 0 ) {
				$this->event->trigger('pre.admin.bulk_special.add', $data);
			}
			
			if($data['bulk_special_price'] == '0') {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$data['bulk_special_cutomer_group'] . "' AND bulk_special = 1");
			} else {

				$bulk_special_price = $this->_price($data['bulk_special_discount_type'], $product['price'],$data['bulk_special_price']);

				if(empty($data['bulk_special_date_start'])) {
					$data['bulk_special_date_start'] = '0000-00-00';
				}

				if(empty($data['bulk_special_date_end'])) {
					$data['bulk_special_date_end'] = '0000-00-00';
				}
				
				if(!$data['bulk_special_discount_previous']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$data['bulk_special_cutomer_group'] . "' AND bulk_special = 1");
				}
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product['product_id'] . "', customer_group_id = '" . (int)$data['bulk_special_cutomer_group'] . "', price = '" . (float)$bulk_special_price . "', date_start = '" . $this->db->escape($data['bulk_special_date_start']) . "', date_end = '" . $this->db->escape($data['bulk_special_date_end']) . "', bulk_special = 1");
			}
			
			if(version_compare(VERSION, '2.3.0.0') < 0 ) {
				$this->event->trigger('post.admin.bulk_special.add', $product['product_id']);
			}
			
		}
		
	}

	public function addIndividualSpecial($data) {
		
		foreach ($data['product_special'] as $product) {
			if(version_compare(VERSION, '2.3.0.0') < 0 ) {
				$this->event->trigger('pre.admin.bulk_special.add', $data);
			}
			if($product['bulk_special_price'] == '0') {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$product['bulk_special_cutomer_group'] . "' AND bulk_special = 1");
			} else {

				$bulk_special_price = $this->_price($product['bulk_special_discount_type'], $product['price'],$product['bulk_special_price']);

				if(empty($product['bulk_special_date_start'])) {
					$product['bulk_special_date_start'] = '0000-00-00';
				}
				if(empty($product['bulk_special_date_end'])) {
					$product['bulk_special_date_end'] = '0000-00-00';
				}
				if(!$product['bulk_special_discount_previous']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product['product_id'] . "' AND customer_group_id = '" . (int)$product['bulk_special_cutomer_group'] . "' AND bulk_special = 1");
				}
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product['product_id'] . "', customer_group_id = '" . (int)$product['bulk_special_cutomer_group'] . "', price = '" . (float)$bulk_special_price . "', date_start = '" . $this->db->escape($product['bulk_special_date_start']) . "', date_end = '" . $this->db->escape($product['bulk_special_date_end']) . "', bulk_special = 1");
			}
			if(version_compare(VERSION, '2.3.0.0') < 0 ) {
				$this->event->trigger('post.admin.bulk_special.add', (int)$product['product_id']);
			}
		}
		
	}

	public function getProducts($data = array()) {
		$sql = "SELECT p.product_id,p.price,pd.name";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if ((isset($data['filter_price_start']) && !empty($data['filter_price_start'])) AND (isset($data['filter_price_end']) && !empty($data['filter_price_end']))) {
			$sql .=" AND p.price >= '".(float) $data['filter_price_start']."' AND p.price <= '".(float) $data['filter_price_end']."'";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$sql .= " GROUP BY p.product_id";

		
		$sql .= " ORDER BY p.sort_order";
		

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		

		$product_data = array();

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getCategories() {
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		$sql .= " GROUP BY cp.category_id ORDER BY sort_order ASC";
		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getManufacturers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	private function _price( $bulk_special_discount_type, $price,$bulk_special_price ) {

		if($bulk_special_discount_type == 'percentage') {
			$bulk_special_price =  $price - ($price * ($bulk_special_price / 100)) ;
	
		} else {
			$bulk_special_price = $price - $bulk_special_price;
		}

		return $bulk_special_price;
	}
	
}
