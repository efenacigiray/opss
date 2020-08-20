<?php

class ModelSaleKargo extends Model {

	public function addTakipno($order_id, $takip_no, $kargo_id) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "kargo_takip SET order_id = '" . (int)$order_id . "', takip_no = '" . $this->db->escape($takip_no) . "', kargo_id = '" . (int)$kargo_id . "'");

	}



	public function editTakipno($order_id, $takip_no, $kargo_id) {

		$this->db->query("UPDATE " . DB_PREFIX . "kargo_takip SET takip_no = '" . $this->db->escape($takip_no) . "', kargo_id = '" . (int)$kargo_id . "' WHERE order_id= '" . (int)$order_id . "'");

	}



	public function getTakipno($order_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "kargo_takip WHERE order_id = '" . (int)$order_id . "'");



		return $query->row;

	}



	public function getKargoadi($kargo_id) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "kargo WHERE kargo_id = '" . (int)$kargo_id . "'");



		return $query->row;

	}

	public function editOrderStatus($orderid,$status){

			$query = 'UPDATE ' . DB_PREFIX . 'order SET order_status_id = ' . $status . ' WHERE order_id= ' . (int) $orderid;

			return $this->db->query($query);



	}

	public function getKargolar() {

				$kargolar = array();



				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "kargo");



				foreach ($query->rows as $result) {

					$kargolar[] = array(

						'kargo_id'         => $result['kargo_id'],

						'kargo_adi'        => $result['kargo_adi'],

						'takip_url'        => $result['takip_url'],

					);

				}



			return $kargolar;

	}



	public function editKargo($kargo_id, $data) {

		$this->db->query("UPDATE " . DB_PREFIX . "kargo SET kargo_adi = '" . $this->db->escape($data['kargo_adi']) . "', takip_url = '" . $this->db->escape($data['takip_url']) . "', status = '1' WHERE kargo_id = '" . (int)$kargo_id . "'");



	}



        public function addKargo($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "kargo SET kargo_adi = '" . $this->db->escape($data['kargo_adi']) . "', takip_url = '" . $this->db->escape($data['takip_url']) . "', status = '1'");

}



}

