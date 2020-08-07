<?php
class ControllerB5bQoreEngineDashChartMostViewedProductsMedium extends Controller{
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/sale');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$data['b5b_qore_engine']['language']['heading_most_viewed_products'] = $this->language->get('heading_most_viewed_products');

		$data['text_view'] = $this->language->get('text_view');
		$data['b5b_qore_engine']['language']['today'] = $this->language->get('entry_today');
		$data['b5b_qore_engine']['language']['this_week'] = $this->language->get('entry_this_week');
		$data['b5b_qore_engine']['language']['this_month'] = $this->language->get('entry_this_month');
		$data['b5b_qore_engine']['language']['this_year'] = $this->language->get('entry_this_year');
		$data['b5b_qore_engine']['language']['all_time'] = $this->language->get('entry_all_time');
		$data['b5b_qore_engine']['language']['text_views'] = $this->language->get('text_views');
		$data['b5b_qore_engine']['language']['text_most_viewed_products_intro'] = $this->language->get('text_most_viewed_products_intro');

		$complete_statuses = $this->config->get('config_complete_status');

		$this->load->model('localisation/order_status');

		foreach($complete_statuses as $complete_status){
			$order_statuses = $this->model_localisation_order_status->getOrderStatus($complete_status);
			$data['order_statuses'][] = $order_statuses['name'];
		}

		return $this->load->view('dashboard/chart_most_viewed_products_medium', $data);
	}

	public function chart(){
		$this->load->language('extension/dashboard/sale');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}
		
		$json = array();

		$json['type'] = "customer";
		$json['total'] = array();
		$json['name'] = array();
		$json['language']['error_no_data'] = $this->language->get('error_no_chart_during_timeframe');



		// $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");


		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store ps ON (p.product_id = ps.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.status = '1' AND ps.store_id = '" . (int)$this->config->get("config_store_id") . "' ORDER BY p.viewed DESC LIMIT 5";

		$query = $this->db->query($sql);

		if($query->num_rows){
			$rows =  $query->rows;

			foreach($rows as $row){
				$json['name'][] = $row['name'];
				$json['id'][] = $row['product_id'];
				$json['total'][] = $row['viewed'];
				$json['total_formated'][] = "";
			}
		}else{
			$json['name'][] = "";
			$json['id'][] = "";
			$json['total'][] = "";
			$json['total_formated'][] = "";
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}