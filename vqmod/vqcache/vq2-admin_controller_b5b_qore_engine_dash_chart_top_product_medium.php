<?php
class ControllerB5bQoreEngineDashChartTopProductMedium extends Controller{
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/sale');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$data['b5b_qore_engine']['language']['heading_top_product'] = $this->language->get('heading_top_product');

		$data['text_view'] = $this->language->get('text_view');
		$data['b5b_qore_engine']['language']['today'] = $this->language->get('entry_today');
		$data['b5b_qore_engine']['language']['this_week'] = $this->language->get('entry_this_week');
		$data['b5b_qore_engine']['language']['this_month'] = $this->language->get('entry_this_month');
		$data['b5b_qore_engine']['language']['this_year'] = $this->language->get('entry_this_year');
		$data['b5b_qore_engine']['language']['all_time'] = $this->language->get('entry_all_time');
		$data['b5b_qore_engine']['language']['highest_orders'] = $this->language->get('entry_highest_orders');
		$data['b5b_qore_engine']['language']['highest_customers'] = $this->language->get('entry_highest_customers');
		$data['b5b_qore_engine']['language']['text_sold'] = $this->language->get('text_sold');
		$data['b5b_qore_engine']['language']['text_top_product_intro'] = $this->language->get('text_top_product_intro');
		$data['b5b_qore_engine']['language']['text_top_customer_intro'] = $this->language->get('text_top_customer_intro');

		$complete_statuses = $this->config->get('config_complete_status');

		$this->load->model('localisation/order_status');

		foreach($complete_statuses as $complete_status){
			$order_statuses = $this->model_localisation_order_status->getOrderStatus($complete_status);
			$data['order_statuses'][] = $order_statuses['name'];
		}


				/* B5B - QoreEngine - Start */
				$this->load->language('b5b_qore_engine/general/general');

				$data['b5b_qore_engine']['language']['error_incompatible_version'] = $this->language->get('error_incompatible_version');
				$data['b5b_qore_engine']['language']['text_base5builder'] = $this->language->get('text_base5builder');
				$data['b5b_qore_engine']['language']['text_base5builder_support'] = $this->language->get('text_base5builder_support');
				$data['b5b_qore_engine']['language']['error_error_occured'] = $this->language->get('error_error_occured');
				$data['b5b_qore_engine']['language']['text_refreshing_page'] = $this->language->get('text_refreshing_page');
				$data['b5b_qore_engine']['language']['text_powered_by'] = $this->language->get('text_powered_by');

				$this->load->model('b5b_qore_engine/general/settings');


				/* B5B - BETA FEATURE - START */
				// Check if page has been added to compatibility list

				$data['custom_page_is_compatible'] = FALSE;

				if(isset($this->request->get['route'])){;
					/*
					// Temporarily disabled. Will be enabled once feature is completed
					$custom_compatible_pages = unserialize($this->model_b5b_qore_engine_general_settings->getSettings('compatible_page_route_circloid'));

					if($custom_compatible_pages && in_array($this->request->get['route'], $custom_compatible_pages)){
						$data['custom_page_is_compatible'] = TRUE;
					}
					*/
					$custom_compatible_pages = "";
				}

				/* B5B - BETA FEATURE - END */
				

				$table_exists = $this->model_b5b_qore_engine_general_settings->tableExsits('b5b_qore_engine_settings');

				if($table_exists){
					if(isset($this->request->get['route'])){
						$data['b5b_qore_engine_route'] = $this->request->get['route'];
					}else{
						$data['b5b_qore_engine_route'] = '';
					}

					$data['b5b_qore_engine_is_admin'] = 1;
					$data['b5b_qore_engine_active_theme'] = $this->model_b5b_qore_engine_general_settings->getSettings('active_theme');

					$info_path = DIR_TEMPLATE . 'b5b_qore_engine/themes/' . $data['b5b_qore_engine_active_theme'] . '/info.xml';

					if(file_exists($info_path)){
						$xml = simplexml_load_file($info_path);
						$data['b5b_qore_engine_active_theme_version'] = (string)$xml->version;
					}else{
						$data['b5b_qore_engine_active_theme_version'] = "";
					}

					$data['b5b_qore_engine_color_preset'] = $this->model_b5b_qore_engine_general_settings->getSettings('color_preset_' . $data['b5b_qore_engine_active_theme']);

					$data['b5b_qore_engine_white_label'] = unserialize($this->model_b5b_qore_engine_general_settings->getSettings('white_label_' . $data['b5b_qore_engine_active_theme'] . '_settings'));
				}

				/* B5B - QoreEngine - End */
				
		return $this->load->view('dashboard/chart_top_product_medium', $data);
	}

	public function chart(){
		$this->load->language('extension/dashboard/sale');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$implode = array();

		foreach ($this->config->get('config_complete_status') as $order_status_id) {
			$implode[] = "'" . (int)$order_status_id . "'";
		}
		
		$json = array();

		$json['type'] = "product";
		$json['name'] = array();
		$json['total'] = array();
		$json['language']['error_no_data'] = $this->language->get('error_no_chart_during_timeframe');

		// Set the timeframe
		if (isset($this->request->get['range'])) {
			$range = $this->request->get['range'];
		} else {
			$range = 'month';
		}

		$day_of_year = date("z") + 1;
		$today_date = date("Y-m-d H:i:s");
		$beginning_of_today = date("Y-m-d 00:00:00");
		$first_day_of_month = date("Y-m-1");
		$first_day_of_year = date("Y-1-1");

		$first_day_of_week = $this->firstDayOfWeek();
		
		// Collect data based on the timeframe selected (Day, Week, Month, Year)
		switch ($range) {
			case 'day':
			$sql = "SELECT SUM(op.quantity) AS quantity, op.name AS product_name, op.product_id AS product_id FROM `" . DB_PREFIX . "order_product` AS op JOIN `" . DB_PREFIX . "order` AS o ON (op.order_id = o.order_id) WHERE o.store_id = '" . $this->config->get("config_store_id") . "' AND o.order_status_id IN(" . implode(",", $implode) . ") AND date_added BETWEEN '" . $beginning_of_today . "' AND '" . $today_date . "' GROUP BY op.name ORDER BY SUM(op.quantity) DESC LIMIT 5";
			break;


			case 'week':
			$sql = "SELECT SUM(op.quantity) AS quantity, op.name AS product_name, op.product_id AS product_id FROM `" . DB_PREFIX . "order_product` AS op JOIN `" . DB_PREFIX . "order` AS o ON (op.order_id = o.order_id) WHERE o.store_id = '" . $this->config->get("config_store_id") . "' AND o.order_status_id IN(" . implode(",", $implode) . ") AND date_added BETWEEN '" . $first_day_of_week . "' AND '" . $today_date . "' GROUP BY op.name ORDER BY SUM(op.quantity) DESC LIMIT 5";
			break;

			default:
			case 'month':
			$sql = "SELECT SUM(op.quantity) AS quantity, op.name AS product_name, op.product_id AS product_id FROM `" . DB_PREFIX . "order_product` AS op JOIN `" . DB_PREFIX . "order` AS o ON (op.order_id = o.order_id) WHERE o.store_id = '" . $this->config->get("config_store_id") . "' AND o.order_status_id IN(" . implode(",", $implode) . ") AND date_added BETWEEN '" . $first_day_of_month . "' AND '" . $today_date . "' GROUP BY op.name ORDER BY SUM(op.quantity) DESC LIMIT 5";
			break;

			case 'year':
			$sql = "SELECT SUM(op.quantity) AS quantity, op.name AS product_name, op.product_id AS product_id FROM `" . DB_PREFIX . "order_product` AS op JOIN `" . DB_PREFIX . "order` AS o ON (op.order_id = o.order_id) WHERE o.store_id = '" . $this->config->get("config_store_id") . "' AND o.order_status_id IN(" . implode(",", $implode) . ") AND date_added BETWEEN '" . $first_day_of_year . "' AND '" . $today_date . "' GROUP BY op.name ORDER BY SUM(op.quantity) DESC LIMIT 5";
			break;
		}

		$query = $this->db->query($sql);

		if($query->num_rows){
			$rows =  $query->rows;
			foreach($rows as $row){
				$json['name'][] = $row['product_name'];
				$json['id'][] = $row['product_id'];
				$json['total'][] = $row['quantity'];
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

	private function firstDayOfWeek(){
		$today_nth_day = date("w");
		$first_day_of_week_mktime = mktime(0, 0, 0, date("m"), date("d") - $today_nth_day, date("Y"));
		$first_day_of_week = date("Y-m-d", $first_day_of_week_mktime);
		return $first_day_of_week;
	}
}