<?php
class ControllerB5bQoreEngineDashReturnedOrdersMini extends Controller{
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/order');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$data['heading_title'] = $this->language->get('text_returned_orders');

		$data['text_view'] = $this->language->get('text_view');

		$data['user_token'] = $this->session->data['user_token'];

		// Returns
		$this->load->model('sale/return');

		$returned_orders = $this->model_sale_return->getTotalReturns(array('filter_return_status_id' => $this->config->get('config_return_status_id')));

		if ($returned_orders >= 1000000000000) {
			$data['total'] = round($returned_orders / 1000000000000, 2) . 'T';
		} elseif ($returned_orders >= 1000000000) {
			$data['total'] = round($returned_orders / 1000000000, 2) . 'B';
		} elseif ($returned_orders >= 1000000) {
			$data['total'] = round($returned_orders / 1000000, 2) . 'M';
		} elseif ($returned_orders >= 10000) {
			$data['total'] = round($returned_orders / 1000, 2) . 'K';
		} elseif ($returned_orders >= 1000 ) {
			$data['total'] = number_format($returned_orders);
		} else {
			$data['total'] = $returned_orders;
		}

		$data['returned_orders'] = $this->url->link('sale/return', 'user_token=' . $this->session->data['user_token'], true);

		return $this->load->view('dashboard/returned_orders_mini', $data);
	}
}