<?php
class ControllerB5bQoreEngineDashMapMedium extends Controller{
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/map');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['user_token'] = $this->session->data['user_token'];
		
		return $this->load->view('dashboard/map_medium', $data);
	}

	public function map() {
		$json = array();

		$this->load->model('extension/dashboard/map');

		$results = $this->model_extension_dashboard_map->getTotalOrdersByCountry();

		$highest_orders = 0;
		$highest_sales = 0;

		foreach ($results as $result) {
			$json[strtolower($result['iso_code_2'])] = array(
				'country'  => $result['name'],
				'total'  => $result['total'],
				'amount' => $this->currency->format($result['amount'], $this->config->get('config_currency'))
				);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
