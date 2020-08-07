<?php
class ControllerB5bQoreEngineDashProductViewsMini extends Controller{
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/order');
		$this->load->language('b5b_qore_engine/dashboard/general');

		$data['heading_title'] = $this->language->get('text_product_views');

		$data['text_view'] = $this->language->get('text_view');

		$data['user_token'] = $this->session->data['user_token'];

		// Product Views
		$this->load->model('catalog/product');

		$product_viewed_total = $this->model_catalog_product->getTotalProducts();

		if ($product_viewed_total >= 1000000000000) {
			$data['total'] = round($product_viewed_total / 1000000000000, 2) . 'T';
		} elseif ($product_viewed_total >= 1000000000) {
			$data['total'] = round($product_viewed_total / 1000000000, 2) . 'B';
		} elseif ($product_viewed_total >= 1000000) {
			$data['total'] = round($product_viewed_total / 1000000, 2) . 'M';
		} elseif ($product_viewed_total >= 10000) {
			$data['total'] = round($product_viewed_total / 1000, 2) . 'K';
		} elseif ($product_viewed_total >= 1000 ) {
			$data['total'] = number_format($product_viewed_total);
		} else {
			$data['total'] = $product_viewed_total;
		}

		$data['product_views'] = $this->url->link('report/product_viewed', 'user_token=' . $this->session->data['user_token'], true);

		return $this->load->view('dashboard/product_views_mini', $data);
	}
}