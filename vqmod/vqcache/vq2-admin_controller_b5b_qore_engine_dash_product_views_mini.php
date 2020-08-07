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
				
		return $this->load->view('dashboard/product_views_mini', $data);
	}
}