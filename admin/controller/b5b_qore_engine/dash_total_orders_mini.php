<?php
class ControllerB5bQoreEngineDashTotalOrdersMini extends Controller{
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/order');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');

		$data['user_token'] = $this->session->data['user_token'];

        $completed = $this->config->get('config_complete_status');
        $processing = $this->config->get('config_processing_status');
        $statuses = array_merge($completed, $processing);

		$order_total = $this->model_sale_order->getTotalOrders();

		if ($order_total >= 1000000000000) {
			$data['total'] = round($order_total / 1000000000000, 2) . 'T';
		} elseif ($order_total >= 1000000000) {
			$data['total'] = round($order_total / 1000000000, 2) . 'B';
		} elseif ($order_total >= 1000000) {
			$data['total'] = round($order_total / 1000000, 2) . 'M';
		} elseif ($order_total >= 10000) {
			$data['total'] = round($order_total / 1000, 2) . 'K';
		} elseif ($order_total >= 1000) {
			$data['total'] = number_format($order_total);
		} else {
			$data['total'] = $order_total;
		}

		$data['order'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true);

		return $this->load->view('dashboard/total_orders_mini', $data);
	}
}