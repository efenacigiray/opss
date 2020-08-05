<?php
class ControllerB5bQoreEngineDashChartTopCustomerMedium extends Controller{
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/sale');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$data['b5b_qore_engine']['language']['heading_top_customer'] = $this->language->get('heading_top_customer');

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

		return $this->load->view('dashboard/chart_top_customer_medium', $data);
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
			$sql = "SELECT SUM(total) AS total, store_id, CONCAT(firstname, ' ', lastname) AS name, customer_id FROM `" . DB_PREFIX . "order` WHERE store_id = '" . $this->config->get("config_store_id") . "' AND order_status_id IN(" . implode(",", $implode) . ") AND date_added BETWEEN '" . $beginning_of_today . "' AND '" . $today_date . "' GROUP BY customer_id ORDER BY SUM(total) DESC LIMIT 5";
			break;


			case 'week':
			$sql = "SELECT SUM(total) AS total, store_id, CONCAT(firstname, ' ', lastname) AS name, customer_id FROM `" . DB_PREFIX . "order` WHERE store_id = '" . $this->config->get("config_store_id") . "' AND order_status_id IN(" . implode(",", $implode) . ") AND date_added BETWEEN '" . $first_day_of_week . "' AND '" . $today_date . "' GROUP BY customer_id ORDER BY SUM(total) DESC LIMIT 5";
			break;

			default:
			case 'month':
			$sql = "SELECT SUM(total) AS total, store_id, CONCAT(firstname, ' ', lastname) AS name, customer_id FROM `" . DB_PREFIX . "order` WHERE store_id = '" . $this->config->get("config_store_id") . "' AND order_status_id IN(" . implode(",", $implode) . ") AND date_added BETWEEN '" . $first_day_of_month . "' AND '" . $today_date . "' GROUP BY customer_id ORDER BY SUM(total) DESC LIMIT 5";
			break;

			case 'year':
			$sql = "SELECT SUM(total) AS total, store_id, CONCAT(firstname, ' ', lastname) AS name, customer_id FROM `" . DB_PREFIX . "order` WHERE store_id = '" . $this->config->get("config_store_id") . "' AND order_status_id IN(" . implode(",", $implode) . ") AND date_added BETWEEN '" . $first_day_of_year . "' AND '" . $today_date . "' GROUP BY customer_id ORDER BY SUM(total) DESC LIMIT 5";
			break;
		}

		$query = $this->db->query($sql);

		if($query->num_rows){
			$rows =  $query->rows;
			foreach($rows as $row){
				$json['name'][] = $row['name'];
				$json['id'][] = $row['customer_id'];
				$json['total'][] = $row['total'];

				if ($row['total'] >= 1000000000000) {
					$json['total_formated'][] = $this->currency->format(round($row['total'] / 1000000000000, 2), $this->config->get('config_currency')) . 'T';
				} elseif ($row['total'] >= 1000000000) {
					$json['total_formated'][] = $this->currency->format(round($row['total'] / 1000000000, 2), $this->config->get('config_currency')) . 'B';
				} elseif ($row['total'] >= 1000000) {
					$json['total_formated'][] = $this->currency->format(round($row['total'] / 1000000, 2), $this->config->get('config_currency')) . 'M';
				}  elseif ($row['total'] >= 10000) {
					$json['total_formated'][] = $this->currency->format(round($row['total'] / 1000, 2), $this->config->get('config_currency')) . 'K';
				} else {
					$json['total_formated'][] = $this->currency->format($row['total'], $this->config->get('config_currency'));
				}
			}
		}else{
			$json['name'][] = "";
			$json['id'][] = "";
			$json['total'][] = "";
			$json['total_formated'][] = "";
		}

		// $query = $this->db->query($sql);

		// if($query->num_rows){
		// 	$rows =  $query->rows;
		// 	foreach($rows as $row){
		// 		$json['name'][] = $row['name'];
		// 		$json['id'][] = $row['customer_id'];
		// 		$json['total'][] = $row['total'];

		// 		if ($row['total'] >= 1000000000000) {
		// 			$json['total_formated'][] = $this->currency->format(round($row['total'] / 1000000000000, 2), $this->config->get('config_currency')) . 'T';
		// 		} elseif ($row['total'] >= 1000000000) {
		// 			$json['total_formated'][] = $this->currency->format(round($row['total'] / 1000000000, 2), $this->config->get('config_currency')) . 'B';
		// 		} elseif ($row['total'] >= 1000000) {
		// 			$json['total_formated'][] = $this->currency->format(round($row['total'] / 1000000, 2), $this->config->get('config_currency')) . 'M';
		// 		}  elseif ($row['total'] >= 10000) {
		// 			$json['total_formated'][] = $this->currency->format(round($row['total'] / 1000, 2), $this->config->get('config_currency')) . 'K';
		// 		} else {
		// 			$json['total_formated'][] = $this->currency->format($row['total'], $this->config->get('config_currency'));
		// 		}

		// 		$json['total_formated'][] = $this->currency->format($row['total'], $this->config->get('config_currency'));
		// 	}
		// }else{
		// 	$json['name'][] = "";
		// 	$json['id'][] = "";
		// 	$json['total'][] = "";
		// 	$json['total_formated'][] = "";
		// }


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