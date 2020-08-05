<?php
class ControllerB5bQoreEngineDashProcessingOrdersMini extends Controller{
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/order');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$data['heading_title'] = $this->language->get('text_processing_orders');

		$data['text_view'] = $this->language->get('text_view');

		$data['user_token'] = $this->session->data['user_token'];

		// Processing Orders
		$this->load->model('sale/order');

		$implode = implode(',', $this->config->get('config_processing_status'));

		$processing_orders = $this->model_sale_order->getTotalOrders(array('filter_order_status' => $implode));

		if ($processing_orders >= 1000000000000) {
			$data['total'] = round($processing_orders / 1000000000000, 2) . 'T';
		} elseif ($processing_orders >= 1000000000) {
			$data['total'] = round($processing_orders / 1000000000, 2) . 'B';
		} elseif ($processing_orders >= 1000000) {
			$data['total'] = round($processing_orders / 1000000, 2) . 'M';
		} elseif ($processing_orders >= 10000) {
			$data['total'] = round($processing_orders / 1000, 2) . 'K';
		} elseif ($processing_orders >= 1000 ) {
			$data['total'] = number_format($processing_orders);
		} else {
			$data['total'] = $processing_orders;
		}

		$data['processing_orders'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&filter_order_status=' . $implode, true);

		return $this->load->view('dashboard/processing_orders_mini', $data);
	}
}