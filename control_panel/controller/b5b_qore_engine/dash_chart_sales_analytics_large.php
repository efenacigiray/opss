<?php
class ControllerB5bQoreEngineDashChartSalesAnalyticsLarge extends Controller{
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/sale');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$data['heading_title'] = $this->language->get('text_sales_analytics');

		$data['text_view'] = $this->language->get('text_view');
		$data['b5b_qore_engine']['language']['today'] = $this->language->get('entry_today');
		$data['b5b_qore_engine']['language']['this_week'] = $this->language->get('entry_this_week');
		$data['b5b_qore_engine']['language']['this_month'] = $this->language->get('entry_this_month');
		$data['b5b_qore_engine']['language']['this_year'] = $this->language->get('entry_this_year');
		$data['b5b_qore_engine']['language']['all_time'] = $this->language->get('entry_all_time');
		$data['b5b_qore_engine']['language']['all_statuses'] = $this->language->get('text_all_statuses');
		$data['b5b_qore_engine']['language']['highest_orders'] = $this->language->get('entry_highest_orders');
		$data['b5b_qore_engine']['language']['highest_customers'] = $this->language->get('entry_highest_customers');

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		return $this->load->view('dashboard/chart_sales_analytics_large', $data);
	}

	public function chart() {
		$this->load->language('extension/dashboard/chart');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$json = array();

		$this->load->model('extension/dashboard/sale');
		$this->load->model('extension/dashboard/chart');
		$this->load->model('customer/customer');

		$json['order'] = array();
		$json['customer'] = array();
		$json['xaxis'] = array();
		$json['language']['error_no_chart_all_time_1'] = $this->language->get('error_no_chart_all_time_1');
		$json['language']['error_no_chart_all_time_2'] = $this->language->get('error_no_chart_all_time_2');

		$json['order']['label'] = $this->language->get('text_order');
		$json['customer']['label'] = $this->language->get('text_customer');
		$json['order']['data'] = array();
		$json['customer']['data'] = array();

		if (isset($this->request->get['range'])) {
			$range = $this->request->get['range'];
		} else {
			$range = 'year';
		}

		if (isset($this->request->get['status_id'])) {
			$order_status_id = urldecode($this->request->get['status_id']);
		} else {
			$order_status_id = 'all';
		}

		switch ($range) {
			default:
			case 'day':
			$results = $this->model_extension_dashboard_sale->circloid_getTotalOrdersByDay($order_status_id);

			foreach ($results as $key => $value) {
				$json['order']['data'][] = array($key, $value['total']);
			}

			$results = $this->model_extension_dashboard_chart->getTotalCustomersByDay();

			foreach ($results as $key => $value) {
				$json['customer']['data'][] = array($key, $value['total']);
			}

			for ($i = 0; $i < 24; $i++) {
				$json['xaxis'][] = array($i, $i);
			}
			break;
			case 'week':
			$results = $this->model_extension_dashboard_sale->circloid_getTotalOrdersByWeek($order_status_id);

			foreach ($results as $key => $value) {
				$json['order']['data'][] = array($key, $value['total']);
			}

			$results = $this->model_extension_dashboard_chart->getTotalCustomersByWeek();

			foreach ($results as $key => $value) {
				$json['customer']['data'][] = array($key, $value['total']);
			}

			$date_start = strtotime('-' . date('w') . ' days');

			for ($i = 0; $i < 7; $i++) {
				$date = date('Y-m-d', $date_start + ($i * 86400));

				$json['xaxis'][] = array(date('w', strtotime($date)), date('D', strtotime($date)));
			}
			break;
			case 'month':
			$results = $this->model_extension_dashboard_sale->circloid_getTotalOrdersByMonth($order_status_id);

			foreach ($results as $key => $value) {
				$json['order']['data'][] = array($key, $value['total']);
			}

			$results = $this->model_extension_dashboard_chart->getTotalCustomersByMonth();

			foreach ($results as $key => $value) {
				$json['customer']['data'][] = array($key, $value['total']);
			}

			for ($i = 1; $i <= date('t'); $i++) {
				$date = date('Y') . '-' . date('m') . '-' . $i;

				$json['xaxis'][] = array(date('j', strtotime($date)), date('d', strtotime($date)));
			}
			break;
			case 'year':
			$results = $this->model_extension_dashboard_sale->circloid_getTotalOrdersByYear($order_status_id);

			foreach ($results as $key => $value) {
				$json['order']['data'][] = array($key, $value['total']);
			}

			$results = $this->model_extension_dashboard_chart->getTotalCustomersByYear();

			foreach ($results as $key => $value) {
				$json['customer']['data'][] = array($key, $value['total']);
			}

			for ($i = 1; $i <= 12; $i++) {
				$json['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i)));
			}
			break;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}