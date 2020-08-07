<?php
class ControllerExtensionDashboardRecent extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/recent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('dashboard_recent', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=dashboard', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=dashboard', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/dashboard/recent', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/dashboard/recent', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=dashboard', true);

		if (isset($this->request->post['dashboard_recent_width'])) {
			$data['dashboard_recent_width'] = $this->request->post['dashboard_recent_width'];
		} else {
			$data['dashboard_recent_width'] = $this->config->get('dashboard_recent_width');
		}

		$data['columns'] = array();
		
		for ($i = 3; $i <= 12; $i++) {
			$data['columns'][] = $i;
		}
				
		if (isset($this->request->post['dashboard_recent_status'])) {
			$data['dashboard_recent_status'] = $this->request->post['dashboard_recent_status'];
		} else {
			$data['dashboard_recent_status'] = $this->config->get('dashboard_recent_status');
		}

		if (isset($this->request->post['dashboard_recent_sort_order'])) {
			$data['dashboard_recent_sort_order'] = $this->request->post['dashboard_recent_sort_order'];
		} else {
			$data['dashboard_recent_sort_order'] = $this->config->get('dashboard_recent_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/dashboard/recent_form', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/dashboard/recent')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function dashboard() {

    $this->load->language('module/quick_status_updater');

    $this->load->model('localisation/order_status');

    if (version_compare(VERSION, '2', '>=')) {
      $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
    } else {
      $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
    }

		if (version_compare(VERSION, '2', '>=')) {
			$data['qosu_os'] = $qosu_os = $this->config->get('qosu_order_statuses');
			$data['text_qosu_add_history'] = $this->language->get('text_qosu_add_history');
			$data['text_qosu_dialog_title'] = $this->language->get('text_qosu_dialog_title');
			$data['text_qosu_tracking_number'] = $this->language->get('text_qosu_tracking_number');
			$data['text_qosu_select_checkbox'] = $this->language->get('text_qosu_select_checkbox');
			$data['text_qosu_barcode'] = $this->language->get('text_qosu_barcode');
			$data['qosu_bg_mode'] = $this->config->get('qosu_bg_mode');
			$data['qosu_barcode'] = $this->config->get('qosu_barcode');
			$data['qosu_barcode_enabled'] = $this->config->get('qosu_barcode_enabled');

			$data['button_save'] = $this->config->get('button_save');
			$data['button_cancel'] = $this->config->get('button_cancel');
			$data['button_close'] = $this->config->get('button_close');
			$data['text_wait'] = $this->config->get('text_wait');

      $data['qosu_direction'] = $this->language->get('direction');

      // API login - v2.1+
      if (version_compare(VERSION, '2.1', '>=')) {
        $this->load->model('user/api');

        $api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

        if ($api_info) {
          $data['api_id'] = $api_info['api_id'];
          $data['api_key'] = $api_info['key'];
          $data['api_ip'] = $this->request->server['REMOTE_ADDR'];
        } else {
          $data['api_id'] = '';
          $data['api_key'] = '';
          $data['api_ip'] = '';
        }
      }
		} else {
			$this->data['qosu_os'] = $qosu_os = $this->config->get('qosu_order_statuses');
			$this->data['text_qosu_add_history'] = $this->language->get('text_qosu_add_history');
			$this->data['text_qosu_dialog_title'] = $this->language->get('text_qosu_dialog_title');
			$this->data['text_qosu_tracking_number'] = $this->language->get('text_qosu_tracking_number');
			$this->data['text_qosu_select_checkbox'] = $this->language->get('text_qosu_select_checkbox');
			$this->data['text_qosu_barcode'] = $this->language->get('text_qosu_barcode');
			$this->data['qosu_bg_mode'] = $this->config->get('qosu_bg_mode');
			$this->data['qosu_barcode'] = $this->config->get('qosu_barcode');
			$this->data['qosu_barcode_enabled'] = $this->config->get('qosu_barcode_enabled');

			$this->data['button_save'] = $this->config->get('button_save');
			$this->data['button_cancel'] = $this->config->get('button_cancel');
			$this->data['button_close'] = $this->config->get('button_close');
			$this->data['text_wait'] = $this->config->get('text_wait');

      $this->data['qosu_direction'] = $this->language->get('direction');
		}
			
		$this->load->language('extension/dashboard/recent');

		$data['user_token'] = $this->session->data['user_token'];

		// Last 5 Orders
		$data['orders'] = array();

		$filter_data = array(
			'sort'  => 'o.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 5
		);

		$this->load->model('sale/order');
		
		$results = $this->model_sale_order->getOrders($filter_data);

		foreach ($results as $result) {
			$data['orders'][] = array(
				'order_id'   => $result['order_id'],
			'order_status_id'        => $result['order_status_id'],
				'customer'   => $result['customer'],
				'status'     => $result['order_status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'view'       => $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $result['order_id'], true),
			);
		}


        $this->load->model('tool/gkd_lib');

        $data['gkd_qosu_parts'] = $this->model_tool_gkd_lib->fetch('module/quick_status_updater_inc', $data, 'all');
      
		return $this->load->view('extension/dashboard/recent_info', $data);
	}
}
