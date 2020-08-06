<?php
class ControllerB5bQoreEngineDashCompletedOrdersMini extends Controller{
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/order');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$data['heading_title'] = $this->language->get('text_completed_orders');

		$data['text_view'] = $this->language->get('text_view');

		$data['user_token'] = $this->session->data['user_token'];

		// Completed Orders
		$this->load->model('sale/order');

		$implode = implode(',', $this->config->get('config_complete_status'));

		$completed_orders = $this->model_sale_order->getTotalOrders(array('filter_order_status' => $implode));

		if ($completed_orders >= 1000000000000) {
			$data['total'] = round($completed_orders / 1000000000000, 2) . 'T';
		} elseif ($completed_orders >= 1000000000) {
			$data['total'] = round($completed_orders / 1000000000, 2) . 'B';
		} elseif ($completed_orders >= 1000000) {
			$data['total'] = round($completed_orders / 1000000, 2) . 'M';
		} elseif ($completed_orders >= 10000) {
			$data['total'] = round($completed_orders / 1000, 2) . 'K';
		} elseif ($completed_orders >= 1000 ) {
			$data['total'] = number_format($completed_orders);
		} else {
			$data['total'] = $completed_orders;
		}

		$data['completed_orders'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&filter_order_status=' . $implode, true);

		return $this->load->view('dashboard/completed_orders_mini', $data);
	}
}