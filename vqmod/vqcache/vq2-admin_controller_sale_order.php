<?php
class ControllerSaleOrder extends Controller {
    private $error = array();

    public function index() {

			$this->load->model('localisation/order_status');
			if (version_compare(VERSION, '2', '>=')) {
				$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
			} else {
				$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
			}
			

      if (version_compare(VERSION, '3', '>=')) {
        $this->load->language('extension/module/quick_status_updater');
      } else {
        $this->load->language('module/quick_status_updater');
      }
    
        $this->load->language('sale/order');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/order');

        $this->getList();
    }

    public function add() {
        $this->load->language('sale/order');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/order');

        $this->getForm();
    }

    public function edit() {
        $this->load->language('sale/order');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/order');

        $this->getForm();
    }

    public function delete() {
        $this->load->language('sale/order');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->session->data['success'] = $this->language->get('text_success');

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status'])) {
            $url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total=' . $this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->response->redirect($this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . $url, true));
    }

    protected function getList() {

		if (version_compare(VERSION, '2', '>=')) {
			$data['qosu_os'] = $qosu_os = $this->config->get('qosu_order_statuses');
			$data['text_qosu_column_tracking'] = $this->language->get('text_qosu_column_tracking');
			$data['text_qosu_add_history'] = $this->language->get('text_qosu_add_history');
			$data['text_qosu_dialog_title'] = $this->language->get('text_qosu_dialog_title');
			$data['text_qosu_tracking_number'] = $this->language->get('text_qosu_tracking_number');
			$data['text_qosu_select_checkbox'] = $this->language->get('text_qosu_select_checkbox');
			$data['text_qosu_barcode'] = $this->language->get('text_qosu_barcode');
			$data['qosu_tracking_column'] = $this->config->get('qosu_tracking_column');
			$data['qosu_bg_mode'] = $this->config->get('qosu_bg_mode');
			$data['qosu_barcode'] = $this->config->get('qosu_barcode');
			$data['qosu_barcode_enabled'] = $this->config->get('qosu_barcode_enabled');

			$data['button_save'] = $this->config->get('button_save');
			$data['button_cancel'] = $this->config->get('button_cancel');
			$data['button_close'] = $this->config->get('button_close');
			$data['text_wait'] = $this->config->get('text_wait');

      if (version_compare(VERSION, '3', '>=')) {
        $this->load->model('setting/extension');
        $extensions = $this->model_setting_extension->getInstalled('feed');
      } else {
        $this->load->model('extension/extension');
        $extensions = $this->model_extension_extension->getInstalled('feed');
      }

      if (version_compare(VERSION, '3', '<') && in_array('openbaypro', $extensions)) {
        $data['qosu_openbay'] = true;
      }
		} else {
			$this->data['qosu_os'] = $qosu_os = $this->config->get('qosu_order_statuses');
      $this->data['text_qosu_column_tracking'] = $this->language->get('text_qosu_column_tracking');
			$this->data['text_qosu_add_history'] = $this->language->get('text_qosu_add_history');
			$this->data['text_qosu_dialog_title'] = $this->language->get('text_qosu_dialog_title');
			$this->data['text_qosu_tracking_number'] = $this->language->get('text_qosu_tracking_number');
			$this->data['text_qosu_select_checkbox'] = $this->language->get('text_qosu_select_checkbox');
			$this->data['text_qosu_barcode'] = $this->language->get('text_qosu_barcode');
			$this->data['qosu_tracking_column'] = $this->config->get('qosu_tracking_column');
			$this->data['qosu_bg_mode'] = $this->config->get('qosu_bg_mode');
			$this->data['qosu_barcode'] = $this->config->get('qosu_barcode');
			$this->data['qosu_barcode_enabled'] = $this->config->get('qosu_barcode_enabled');

			$this->data['button_save'] = $this->config->get('button_save');
			$this->data['button_cancel'] = $this->config->get('button_cancel');
			$this->data['button_close'] = $this->config->get('button_close');
			$this->data['text_wait'] = $this->config->get('text_wait');

      $this->load->model('setting/extension');
      $extensions = $this->model_setting_extension->getInstalled('feed');
      if (version_compare(VERSION, '3', '<') && in_array('openbaypro', $extensions)) {
        $this->data['qosu_openbay'] = true;
      }
		}
			
        if (isset($this->request->get['filter_order_id'])) {
            $filter_order_id = $this->request->get['filter_order_id'];
        } else {
            $filter_order_id = '';
        }

        if (isset($this->request->get['filter_customer'])) {
            $filter_customer = $this->request->get['filter_customer'];
        } else {
            $filter_customer = '';
        }

        if (isset($this->request->get['filter_class'])) {
            $filter_class = $this->request->get['filter_class'];
        } else {
            $filter_class = '';
        }

        if (isset($this->request->get['filter_order_status'])) {
            $filter_order_status = $this->request->get['filter_order_status'];
        } else {
            $filter_order_status = '';
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $filter_order_status_id = $this->request->get['filter_order_status_id'];
        } else {
            $filter_order_status_id = '';
        }

        if (isset($this->request->get['filter_store_id'])) {
            $filter_store_id = $this->request->get['filter_store_id'];
        } else {
            $filter_store_id = '';
        }

        if (isset($this->request->get['filter_payment_type'])) {
            $filter_payment_type = $this->request->get['filter_payment_type'];
        } else {
            $filter_payment_type = '';
        }

        if (isset($this->request->get['filter_total'])) {
            $filter_total = $this->request->get['filter_total'];
        } else {
            $filter_total = '';
        }

        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = '';
        }

        if (!$this->user->hasPermission('modify', 'sale/order')) {
            $filter_date_added = date('Y-m-d');
        }

        if (isset($this->request->get['filter_date_end'])) {
            $filter_date_end = $this->request->get['filter_date_end'];
        } else {
            $filter_date_end = '';
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $filter_date_modified = $this->request->get['filter_date_modified'];
        } else {
            $filter_date_modified = '';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'o.order_id';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_class'])) {
            $url .= '&filter_class=' . urlencode(html_entity_decode($this->request->get['filter_class'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status'])) {
            $url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }

        if (isset($this->request->get['filter_store_id'])) {
            $url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
        }

        if (isset($this->request->get['filter_payment_type'])) {
            $url .= '&filter_payment_type=' . $this->request->get['filter_payment_type'];
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total=' . $this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        $data['invoice'] = $this->url->link('sale/order/invoice', 'user_token=' . $this->session->data['user_token'], true);
        $data['shipping'] = $this->url->link('sale/order/shipping', 'user_token=' . $this->session->data['user_token'], true);
        $data['add'] = $this->url->link('sale/order/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['delete'] = str_replace('&amp;', '&', $this->url->link('sale/order/delete', 'user_token=' . $this->session->data['user_token'] . $url, true));

        $data['orders'] = array();

        $filter_data = array(
            'filter_order_id'        => $filter_order_id,
            'filter_class'           => $filter_class,
            'filter_store_id'        => $filter_store_id,
            'filter_payment_type'    => $filter_payment_type,
            'filter_customer'        => $filter_customer,
            'filter_order_status'    => $filter_order_status,
            'filter_order_status_id' => $filter_order_status_id,
            'filter_total'           => $filter_total,
            'filter_date_added'      => $filter_date_added,
            'filter_date_end'        => $filter_date_end,
            'filter_date_modified'   => $filter_date_modified,
            'filter_stores'          => $this->session->data['stores_query'],
            'sort'                   => $sort,
            'order'                  => $order,
            'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit'                  => $this->config->get('config_limit_admin')
        );

        $this->load->model('catalog/class');
        $this->load->model('setting/store');
        $this->load->model('catalog/package');
        $this->load->model('setting/extension');

        $data['stores'] = $store_results = $this->model_setting_store->getStores();

        foreach ($data['stores'] as $key => $value) {
            if (!in_array($value['store_id'] , $this->session->data['stores'])) 
                unset($data['stores'][$key]);
        }

        foreach ($store_results as $store) {
            $stores[$store['store_id']] = $store['name'];
        }

        $stores[0] = $this->config->get('config_name');

        $extensions = $this->model_setting_extension->getInstalled('payment');

        foreach ($extensions as $key => $value) {
            if (!is_file(DIR_APPLICATION . 'controller/extension/payment/' . $value . '.php') && !is_file(DIR_APPLICATION . 'controller/payment/' . $value . '.php')) {
                $this->model_setting_extension->uninstall('payment', $value);

                unset($extensions[$key]);
            }
        }

        $data['payment_types'] = array();

        // Compatibility code for old extension folders
        $files = glob(DIR_APPLICATION . 'controller/extension/payment/*.php');

        if ($files) {
            foreach ($files as $file) {
                $extension = basename($file, '.php');

                $this->load->language('extension/payment/' . $extension, 'extension');

                $text_link = $this->language->get('extension')->get('text_' . $extension);

                if ($text_link != 'text_' . $extension) {
                    $link = $text_link;
                } else {
                    $link = '';
                }

                if ($this->config->get('payment_' . $extension . '_status')) {
                    $data['payment_types'][] = array(
                        'name' => $this->language->get('extension')->get('heading_title'),
                        'code' => $extension
                    );
                }
            }
        }

        $filter_data['start'] = 0;
        $filter_data['limit'] = 250;

        $order_total = $this->model_sale_order->getTotalOrders($filter_data);

        $results = $this->model_sale_order->getOrders($filter_data);

        $data['total_data'] = array();
        $data['package_data'] = array();
        $data['ovrl_total'] = 0;
        $data['total_count'] = $order_total;

        foreach ($results as $result) {
            $edit = $this->url->link('sale/order/edit', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $result['order_id'] . $url, true);
            if (!is_null($result['user_id'])) {
                $edit = $this->url->link('sale/store_order/edit', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $result['order_id'] . $url, true);
            }

            if (!isset($data['total_data'][$result['payment_method']])) {
                $data['total_data'][$result['payment_method']] = array('total' => $result['total'], 'quantity' => 1);
            } else {
                $data['total_data'][$result['payment_method']]['total'] += $result['total'];
                $data['total_data'][$result['payment_method']]['quantity']++;
            }

            $data['ovrl_total'] += $result['total'];

            $packages = $this->model_catalog_package->getCustomerPackages($result['customer_id']);

            foreach ($packages as $package) {
                if (isset($data['package_data'][$package['name']]))
                    $data['package_data'][$package['name']]++;
                else
                    $data['package_data'][$package['name']] = 1;
            }

            $data['orders'][] = array(

      'tracking_no'      => isset($result['tracking_no']) ? $result['tracking_no'] : '',
      'tracking_url'      => isset($result['tracking_url']) ? $result['tracking_url'] : '',
      'tracking_carrier' => isset ($result['tracking_carrier']) ? $result['tracking_carrier'] : '',
      
                'order_id'      => $result['order_id'],
			'order_status_id'        => $result['order_status_id'],
                'customer'      => $result['customer'],
                'class'         => $this->model_catalog_class->getCustomerClassName($result['customer_id']),
                'store'         => $stores[$result['store_id']],
                'payment_type'  => $result['payment_method'],
                'order_status'  => $result['order_status'] ? $result['order_status'] : $this->language->get('text_missing'),
                'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
                'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
                'shipping_code' => $result['shipping_code'],
                'view'          => $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $result['order_id'] . $url, true),
                'edit'          => $edit
            );
        }

        $data['user_token'] = $this->session->data['user_token'];

        arsort($data['package_data']);

        foreach ($data['total_data'] as $key => $value) {
            $data['total_data'][$key]['total'] = $this->currency->format($data['total_data'][$key]['total'], $result['currency_code'], $result['currency_value']);
        }

        if (isset($result)) {
            $data['ovrl_total'] = $this->currency->format($data['ovrl_total'], $result['currency_code'], $result['currency_value']);
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_class'])) {
            $url .= '&filter_class=' . urlencode(html_entity_decode($this->request->get['filter_class'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status'])) {
            $url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }

        if (isset($this->request->get['filter_store_id'])) {
            $url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
        }

        if (isset($this->request->get['filter_payment_type'])) {
            $url .= '&filter_payment_type=' . $this->request->get['filter_payment_type'];
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total=' . $this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_order'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=o.order_id' . $url, true);
        $data['sort_customer'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=customer' . $url, true);
        $data['sort_status'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=order_status' . $url, true);
        $data['sort_total'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=o.total' . $url, true);
        $data['sort_date_added'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=o.date_added' . $url, true);
        $data['sort_date_modified'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&sort=o.date_modified' . $url, true);

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_class'])) {
            $url .= '&filter_class=' . urlencode(html_entity_decode($this->request->get['filter_class'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status'])) {
            $url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }

        if (isset($this->request->get['filter_store_id'])) {
            $url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
        }

        if (isset($this->request->get['filter_payment_type'])) {
            $url .= '&filter_payment_type=' . $this->request->get['filter_payment_type'];
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total=' . $this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $order_total;
        $pagination->page = $page;
        $pagination->limit = 250;
        $pagination->url = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * 250) + 1 : 0, ((($page - 1) * 250) > ($order_total - 250)) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + 250), $order_total, ceil($order_total / 250));

        $data['excel'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . $url . '&excel=1'
            , true);
        $data['filter_order_id'] = $filter_order_id;
        $data['filter_customer'] = $filter_customer;
        $data['filter_order_status'] = $filter_order_status;
        $data['filter_order_status_id'] = $filter_order_status_id;
        $data['filter_store_id'] = $filter_store_id;
        $data['filter_payment_type'] = $filter_payment_type;
        $data['filter_total'] = $filter_total;
        $data['filter_date_added'] = $filter_date_added;
        $data['filter_date_end'] = $filter_date_end;
        $data['filter_date_modified'] = $filter_date_modified;
        $data['filter_class'] = $filter_class;

        $data['sort'] = $sort;
        $data['order'] = $order;

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        // API login
        $data['catalog'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

        // API login
        $this->load->model('user/api');

        $api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

        if ($api_info && $this->user->hasPermission('modify', 'sale/order')) {
            $session = new Session($this->config->get('session_engine'), $this->registry);

            $session->start();

            $this->model_user_api->deleteApiSessionBySessonId($session->getId());

            $this->model_user_api->addApiSession($api_info['api_id'], $session->getId(), $this->request->server['REMOTE_ADDR']);

            $session->data['api_id'] = $api_info['api_id'];

            $data['api_token'] = $session->getId();
        } else {
            $data['api_token'] = '';
        }

        if (isset($this->request->get['excel'])) {
            $fileName = "Siparisler" . time() . ".xls";
            function filterData(&$str) {
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            }

            function change_key( $array, $old_key, $new_key ) {
                if( ! array_key_exists( $old_key, $array ) )
                    return $array;

                $keys = array_keys( $array );
                $keys[ array_search( $old_key, $keys ) ] = $new_key;

                return array_combine( $keys, $array );
            }

            // headers for download
            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Type: application/vnd.ms-excel");

            $flag = false;
            foreach($data['orders'] as $row) {
                unset($row['tracking_no']);
                unset($row['tracking_url']);
                unset($row['tracking_carrier']);
                unset($row['view']);
                unset($row['edit']);
                unset($row['order_status_id']);
                unset($row['date_modified']);
                unset($row['shipping_code']);
                if(!$flag) {
                    $row = change_key($row, 'order_id', 'Sipariş No');
                    $row = change_key($row, 'order_status', 'Durum');
                    $row = change_key($row, 'customer', 'Müşteri');
                    $row = change_key($row, 'class', 'Sınıf');
                    $row = change_key($row, 'store', 'Okul');
                    $row = change_key($row, 'payment_type', 'Ödeme Türü');
                    $row = change_key($row, 'total', 'Toplam');
                    $row = change_key($row, 'date_added', 'Eklenme Tarihi');
                    // display column names as first row
                    echo implode("\t", array_keys($row)) . "\n";
                    $flag = true;
                }
                // filter data
                array_walk($row, 'filterData');
                echo implode("\t", array_values($row)) . "\n";
            }
            exit;
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


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
				

        $this->load->model('tool/gkd_lib');

        $data['gkd_qosu_parts'] = $this->model_tool_gkd_lib->fetch('module/quick_status_updater_inc', $data, 'all');
      
        $this->response->setOutput($this->load->view('sale/order_list', $data));
    }

    public function getForm() {
        $data['text_form'] = !isset($this->request->get['order_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status'])) {
            $url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total=' . $this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        $data['cancel'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . $url, true);

        $data['user_token'] = $this->session->data['user_token'];

        if (isset($this->request->get['order_id'])) {
            $order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
        }

        if (!empty($order_info)) {
            $data['order_id'] = $this->request->get['order_id'];
            $data['store_id'] = $order_info['store_id'];
            $data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

            $data['customer'] = $order_info['customer'];
            $data['customer_id'] = $order_info['customer_id'];
            $data['customer_group_id'] = $order_info['customer_group_id'];
            $data['firstname'] = $order_info['firstname'];
            $data['lastname'] = $order_info['lastname'];
            $data['email'] = $order_info['email'];
            $data['telephone'] = $order_info['telephone'];
            $data['account_custom_field'] = $order_info['custom_field'];

            $this->load->model('customer/customer');

            $data['addresses'] = $this->model_customer_customer->getAddresses($order_info['customer_id']);

            $data['payment_firstname'] = $order_info['payment_firstname'];
            $data['payment_lastname'] = $order_info['payment_lastname'];
            $data['payment_company'] = $order_info['payment_company'];
            $data['payment_address_1'] = $order_info['payment_address_1'];
            $data['payment_address_2'] = $order_info['payment_address_2'];
            $data['payment_city'] = $order_info['payment_city'];
            $data['payment_postcode'] = $order_info['payment_postcode'];
            $data['payment_country_id'] = $order_info['payment_country_id'];
            $data['payment_zone_id'] = $order_info['payment_zone_id'];
            $data['payment_custom_field'] = $order_info['payment_custom_field'];
            $data['payment_method'] = $order_info['payment_method'];
            $data['payment_code'] = $order_info['payment_code'];

            $data['shipping_firstname'] = $order_info['shipping_firstname'];
            $data['shipping_lastname'] = $order_info['shipping_lastname'];
            $data['shipping_company'] = $order_info['shipping_company'];
            $data['shipping_address_1'] = $order_info['shipping_address_1'];
            $data['shipping_address_2'] = $order_info['shipping_address_2'];
            $data['shipping_city'] = $order_info['shipping_city'];
            $data['shipping_postcode'] = $order_info['shipping_postcode'];
            $data['shipping_country_id'] = $order_info['shipping_country_id'];
            $data['shipping_zone_id'] = $order_info['shipping_zone_id'];
            $data['shipping_custom_field'] = $order_info['shipping_custom_field'];
            $data['shipping_method'] = $order_info['shipping_method'];
            $data['shipping_code'] = $order_info['shipping_code'];

            // Products
            $data['order_products'] = array();

            $products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

            foreach ($products as $product) {
                $data['order_products'][] = array(
                    'product_id' => $product['product_id'],
                    'name'       => $product['name'],
                    'model'      => $product['model'],
                    'option'     => $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']),
                    'quantity'   => $product['quantity'],
                    'price'      => $product['price'],
                    'total'      => $product['total'],
                    'reward'     => $product['reward']
                );
            }

            // Vouchers
            $data['order_vouchers'] = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);

            $data['coupon'] = '';
            $data['voucher'] = '';
            $data['reward'] = '';

            $data['order_totals'] = array();

            $order_totals = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);

            foreach ($order_totals as $order_total) {
                // If coupon, voucher or reward points
                $start = strpos($order_total['title'], '(') + 1;
                $end = strrpos($order_total['title'], ')');

                if ($start && $end) {
                    $data[$order_total['code']] = substr($order_total['title'], $start, $end - $start);
                }
            }

            $data['order_status_id'] = $order_info['order_status_id'];
            $data['comment'] = $order_info['comment'];
            $data['currency_code'] = $order_info['currency_code'];
        } else {
            $data['order_id'] = 0;
            $data['store_id'] = 0;
            $data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

            $data['customer'] = '';
            $data['customer_id'] = '';
            $data['customer_group_id'] = $this->config->get('config_customer_group_id');
            $data['firstname'] = '';
            $data['lastname'] = '';
            $data['email'] = '';
            $data['telephone'] = '';
            $data['customer_custom_field'] = array();

            $data['addresses'] = array();

            $data['payment_firstname'] = '';
            $data['payment_lastname'] = '';
            $data['payment_company'] = '';
            $data['payment_address_1'] = '';
            $data['payment_address_2'] = '';
            $data['payment_city'] = '';
            $data['payment_postcode'] = '';
            $data['payment_country_id'] = '';
            $data['payment_zone_id'] = '';
            $data['payment_custom_field'] = array();
            $data['payment_method'] = '';
            $data['payment_code'] = '';

            $data['shipping_firstname'] = '';
            $data['shipping_lastname'] = '';
            $data['shipping_company'] = '';
            $data['shipping_address_1'] = '';
            $data['shipping_address_2'] = '';
            $data['shipping_city'] = '';
            $data['shipping_postcode'] = '';
            $data['shipping_country_id'] = '';
            $data['shipping_zone_id'] = '';
            $data['shipping_custom_field'] = array();
            $data['shipping_method'] = '';
            $data['shipping_code'] = '';

            $data['order_products'] = array();
            $data['order_vouchers'] = array();
            $data['order_totals'] = array();

            $data['order_status_id'] = $this->config->get('config_order_status_id');
            $data['comment'] = '';
            $data['affiliate_id'] = '';
            $data['affiliate'] = '';
            $data['currency_code'] = $this->config->get('config_currency');

            $data['coupon'] = '';
            $data['voucher'] = '';
            $data['reward'] = '';
        }

        // Stores
        $this->load->model('setting/store');

        $data['stores'] = array();

        $data['stores'][] = array(
            'store_id' => 0,
            'name'     => $this->config->get('config_name')
        );

        $results = $this->model_setting_store->getStores();

        foreach ($results as $result) {
            $data['stores'][] = array(
                'store_id' => $result['store_id'],
                'name'     => $result['name']
            );
        }

        // Customer Groups
        $this->load->model('customer/customer_group');

        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

        // Custom Fields
        $this->load->model('customer/custom_field');

        $data['custom_fields'] = array();

        $filter_data = array(
            'sort'  => 'cf.sort_order',
            'order' => 'ASC'
        );

        $custom_fields = $this->model_customer_custom_field->getCustomFields($filter_data);

        foreach ($custom_fields as $custom_field) {
            $data['custom_fields'][] = array(
                'custom_field_id'    => $custom_field['custom_field_id'],
                'custom_field_value' => $this->model_customer_custom_field->getCustomFieldValues($custom_field['custom_field_id']),
                'name'               => $custom_field['name'],
                'value'              => $custom_field['value'],
                'type'               => $custom_field['type'],
                'location'           => $custom_field['location'],
                'sort_order'         => $custom_field['sort_order']
            );
        }

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $this->load->model('localisation/country');

        $data['countries'] = $this->model_localisation_country->getCountries();

        $this->load->model('localisation/currency');

        $data['currencies'] = $this->model_localisation_currency->getCurrencies();

        $data['voucher_min'] = $this->config->get('config_voucher_min');

        $this->load->model('sale/voucher_theme');

        $data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();

        // API login
        $data['catalog'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

        // API login
        $this->load->model('user/api');

        $api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

        if ($api_info && $this->user->hasPermission('modify', 'sale/order')) {
            $session = new Session($this->config->get('session_engine'), $this->registry);

            $session->start();

            $this->model_user_api->deleteApiSessionBySessonId($session->getId());

            $this->model_user_api->addApiSession($api_info['api_id'], $session->getId(), $this->request->server['REMOTE_ADDR']);

            $session->data['api_id'] = $api_info['api_id'];

            $data['api_token'] = $session->getId();
        } else {
            $data['api_token'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


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
				
        $this->response->setOutput($this->load->view('sale/order_form', $data));
    }

    public function info() {

      if (version_compare(VERSION, '3', '>=')) {
        $this->load->language('extension/module/quick_status_updater');
      } else {
        $this->load->language('module/quick_status_updater');
      }

      if (version_compare(VERSION, '2', '>=')) {
        $data['qosu_shipping'] = $this->config->get('qosu_shipping');
        $data['text_qosu_tracking_number'] = $this->language->get('text_qosu_tracking_number');
      } else {
        $this->data['qosu_shipping'] = $this->config->get('qosu_shipping');
        $this->data['text_qosu_tracking_number'] = $this->language->get('text_qosu_tracking_number');
      }
      
        $this->load->model('sale/order');

        if (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
        } else {
            $order_id = 0;
        }

        $order_info = $this->model_sale_order->getOrder($order_id);

        if ($order_info) {
            $this->load->language('sale/order');

            $this->document->setTitle($this->language->get('heading_title'));

            $data['text_ip_add'] = sprintf($this->language->get('text_ip_add'), $this->request->server['REMOTE_ADDR']);
            $data['text_order'] = sprintf($this->language->get('text_order'), $this->request->get['order_id']);

            $url = '';

            if (isset($this->request->get['filter_order_id'])) {
                $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
            }

            if (isset($this->request->get['filter_customer'])) {
                $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_order_status'])) {
                $url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
            }

            if (isset($this->request->get['filter_order_status_id'])) {
                $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
            }

            if (isset($this->request->get['filter_total'])) {
                $url .= '&filter_total=' . $this->request->get['filter_total'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['filter_date_modified'])) {
                $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $data['breadcrumbs'] = array();

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
            );

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . $url, true)
            );

            $data['shipping'] = $this->url->link('sale/order/shipping', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
            $data['invoice'] = $this->url->link('sale/order/invoice', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
            $data['edit'] = $this->url->link('sale/order/edit', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
            $data['cancel'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . $url, true);

            $data['user_token'] = $this->session->data['user_token'];

            $data['order_id'] = $this->request->get['order_id'];

            $data['store_id'] = $order_info['store_id'];

      if (version_compare(VERSION, '2', '>=')) {
        $data['tracking_no'] = isset($order_info['tracking_no']) ? $order_info['tracking_no'] : '';
        $data['tracking_url'] = isset($order_info['tracking_url']) ? $order_info['tracking_url'] : '';
        $data['tracking_carrier'] = isset($order_info['tracking_carrier']) ? $order_info['tracking_carrier'] : '';
      } else {
        $this->data['tracking_no'] = isset($order_info['tracking_no']) ? $order_info['tracking_no'] : '';
        $this->data['tracking_url'] = isset($order_info['tracking_url']) ? $order_info['tracking_url'] : '';
        $data['tracking_carrier'] = isset($order_info['tracking_carrier']) ? $order_info['tracking_carrier'] : '';
      }
      
            $data['store_name'] = $order_info['store_name'];

            if ($order_info['store_id'] == 0) {
                $data['store_url'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;
            } else {
                $data['store_url'] = $order_info['store_url'];
            }

            if ($order_info['invoice_no']) {
                $data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
            } else {
                $data['invoice_no'] = '';
            }

            $data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));

            $data['firstname'] = $order_info['firstname'];
            $data['lastname'] = $order_info['lastname'];

            if ($order_info['customer_id']) {
                $data['customer'] = $this->url->link('customer/customer/edit', 'user_token=' . $this->session->data['user_token'] . '&customer_id=' . $order_info['customer_id'], true);
            } else {
                $data['customer'] = '';
            }

            $this->load->model('customer/customer_group');

            $customer_group_info = $this->model_customer_customer_group->getCustomerGroup($order_info['customer_group_id']);

            if ($customer_group_info) {
                $data['customer_group'] = $customer_group_info['name'];
            } else {
                $data['customer_group'] = '';
            }

            $data['email'] = $order_info['email'];
            $data['telephone'] = $order_info['telephone'];

            $data['shipping_method'] = $order_info['shipping_method'];
            $data['payment_method'] = $order_info['payment_method'];

            // Payment Address
            if ($order_info['payment_address_format']) {
                $format = $order_info['payment_address_format'];
            } else {
                $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
            }

            $find = array(
                '{firstname}',
                '{lastname}',
                '{company}',
                '{address_1}',
                '{address_2}',
                '{city}',
                '{postcode}',
                '{zone}',
                '{zone_code}',
                '{country}'
            );

            $replace = array(
                'firstname' => $order_info['payment_firstname'],
                'lastname'  => $order_info['payment_lastname'],
                'company'   => $order_info['payment_company'],
                'address_1' => $order_info['payment_address_1'],
                'address_2' => $order_info['payment_address_2'],
                'city'      => $order_info['payment_city'],
                'postcode'  => $order_info['payment_postcode'],
                'zone'      => $order_info['payment_zone'],
                'zone_code' => $order_info['payment_zone_code'],
                'country'   => $order_info['payment_country']
            );

            $data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

            // Shipping Address
            if ($order_info['shipping_address_format']) {
                $format = $order_info['shipping_address_format'];
            } else {
                $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
            }

            $find = array(
                '{firstname}',
                '{lastname}',
                '{company}',
                '{address_1}',
                '{address_2}',
                '{city}',
                '{postcode}',
                '{zone}',
                '{zone_code}',
                '{country}'
            );

            $replace = array(
                'firstname' => $order_info['shipping_firstname'],
                'lastname'  => $order_info['shipping_lastname'],
                'company'   => $order_info['shipping_company'],
                'address_1' => $order_info['shipping_address_1'],
                'address_2' => $order_info['shipping_address_2'],
                'city'      => $order_info['shipping_city'],
                'postcode'  => $order_info['shipping_postcode'],
                'zone'      => $order_info['shipping_zone'],
                'zone_code' => $order_info['shipping_zone_code'],
                'country'   => $order_info['shipping_country']
            );

            $data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

            // Uploaded files
            $this->load->model('tool/upload');

            $data['products'] = array();

            $products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);

            foreach ($products as $product) {
                $option_data = array();

                $options = $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

                foreach ($options as $option) {
                    if ($option['type'] != 'file') {
                        $option_data[] = array(
                            'name'  => $option['name'],
                            'value' => $option['value'],
                            'type'  => $option['type']
                        );
                    } else {
                        $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                        if ($upload_info) {
                            $option_data[] = array(
                                'name'  => $option['name'],
                                'value' => $upload_info['name'],
                                'type'  => $option['type'],
                                'href'  => $this->url->link('tool/upload/download', 'user_token=' . $this->session->data['user_token'] . '&code=' . $upload_info['code'], true)
                            );
                        }
                    }
                }

                $data['products'][] = array(
                    'order_product_id' => $product['order_product_id'],
                    'product_id'       => $product['product_id'],
                    'name'             => $product['name'],
                    'model'            => $product['model'],
                    'option'           => $option_data,
                    'quantity'         => $product['quantity'],
                    'price'            => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                    'total'            => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
                    'href'             => $this->url->link('catalog/product/edit', 'user_token=' . $this->session->data['user_token'] . '&product_id=' . $product['product_id'], true)
                );
            }

            $data['vouchers'] = array();

            $vouchers = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);

            foreach ($vouchers as $voucher) {
                $data['vouchers'][] = array(
                    'description' => $voucher['description'],
                    'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
                    'href'        => $this->url->link('sale/voucher/edit', 'user_token=' . $this->session->data['user_token'] . '&voucher_id=' . $voucher['voucher_id'], true)
                );
            }

            $data['totals'] = array();

            $totals = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);

            foreach ($totals as $total) {
                $data['totals'][] = array(
                    'title' => $total['title'],
                    'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
                );
            }

            $data['comment'] = nl2br($order_info['comment']);

            $this->load->model('customer/customer');

            $data['reward'] = $order_info['reward'];

            $data['reward_total'] = $this->model_customer_customer->getTotalCustomerRewardsByOrderId($this->request->get['order_id']);

            $data['commission'] = $this->currency->format($order_info['commission'], $order_info['currency_code'], $order_info['currency_value']);

            $this->load->model('customer/customer');

            $data['commission_total'] = $this->model_customer_customer->getTotalTransactionsByOrderId($this->request->get['order_id']);

            $this->load->model('localisation/order_status');

            $order_status_info = $this->model_localisation_order_status->getOrderStatus($order_info['order_status_id']);

            if ($order_status_info) {
                $data['order_status'] = $order_status_info['name'];
            } else {
                $data['order_status'] = '';
            }

            $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

            $data['order_status_id'] = $order_info['order_status_id'];

            $data['account_custom_field'] = $order_info['custom_field'];

            // Custom Fields
            $this->load->model('customer/custom_field');

            $data['account_custom_fields'] = array();

            $filter_data = array(
                'sort'  => 'cf.sort_order',
                'order' => 'ASC'
            );

            $custom_fields = $this->model_customer_custom_field->getCustomFields($filter_data);

            foreach ($custom_fields as $custom_field) {
                if ($custom_field['location'] == 'account' && isset($order_info['custom_field'][$custom_field['custom_field_id']])) {
                    if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
                        $custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($order_info['custom_field'][$custom_field['custom_field_id']]);

                        if ($custom_field_value_info) {
                            $data['account_custom_fields'][] = array(
                                'name'  => $custom_field['name'],
                                'value' => $custom_field_value_info['name']
                            );
                        }
                    }

                    if ($custom_field['type'] == 'checkbox' && is_array($order_info['custom_field'][$custom_field['custom_field_id']])) {
                        foreach ($order_info['custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
                            $custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($custom_field_value_id);

                            if ($custom_field_value_info) {
                                $data['account_custom_fields'][] = array(
                                    'name'  => $custom_field['name'],
                                    'value' => $custom_field_value_info['name']
                                );
                            }
                        }
                    }

                    if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
                        $data['account_custom_fields'][] = array(
                            'name'  => $custom_field['name'],
                            'value' => $order_info['custom_field'][$custom_field['custom_field_id']]
                        );
                    }

                    if ($custom_field['type'] == 'file') {
                        $upload_info = $this->model_tool_upload->getUploadByCode($order_info['custom_field'][$custom_field['custom_field_id']]);

                        if ($upload_info) {
                            $data['account_custom_fields'][] = array(
                                'name'  => $custom_field['name'],
                                'value' => $upload_info['name']
                            );
                        }
                    }
                }
            }

            // Custom fields
            $data['payment_custom_fields'] = array();

            foreach ($custom_fields as $custom_field) {
                if ($custom_field['location'] == 'address' && isset($order_info['payment_custom_field'][$custom_field['custom_field_id']])) {
                    if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
                        $custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($order_info['payment_custom_field'][$custom_field['custom_field_id']]);

                        if ($custom_field_value_info) {
                            $data['payment_custom_fields'][] = array(
                                'name'  => $custom_field['name'],
                                'value' => $custom_field_value_info['name'],
                                'sort_order' => $custom_field['sort_order']
                            );
                        }
                    }

                    if ($custom_field['type'] == 'checkbox' && is_array($order_info['payment_custom_field'][$custom_field['custom_field_id']])) {
                        foreach ($order_info['payment_custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
                            $custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($custom_field_value_id);

                            if ($custom_field_value_info) {
                                $data['payment_custom_fields'][] = array(
                                    'name'  => $custom_field['name'],
                                    'value' => $custom_field_value_info['name'],
                                    'sort_order' => $custom_field['sort_order']
                                );
                            }
                        }
                    }

                    if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
                        $data['payment_custom_fields'][] = array(
                            'name'  => $custom_field['name'],
                            'value' => $order_info['payment_custom_field'][$custom_field['custom_field_id']],
                            'sort_order' => $custom_field['sort_order']
                        );
                    }

                    if ($custom_field['type'] == 'file') {
                        $upload_info = $this->model_tool_upload->getUploadByCode($order_info['payment_custom_field'][$custom_field['custom_field_id']]);

                        if ($upload_info) {
                            $data['payment_custom_fields'][] = array(
                                'name'  => $custom_field['name'],
                                'value' => $upload_info['name'],
                                'sort_order' => $custom_field['sort_order']
                            );
                        }
                    }
                }
            }

            // Shipping
            $data['shipping_custom_fields'] = array();

            foreach ($custom_fields as $custom_field) {
                if ($custom_field['location'] == 'address' && isset($order_info['shipping_custom_field'][$custom_field['custom_field_id']])) {
                    if ($custom_field['type'] == 'select' || $custom_field['type'] == 'radio') {
                        $custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($order_info['shipping_custom_field'][$custom_field['custom_field_id']]);

                        if ($custom_field_value_info) {
                            $data['shipping_custom_fields'][] = array(
                                'name'  => $custom_field['name'],
                                'value' => $custom_field_value_info['name'],
                                'sort_order' => $custom_field['sort_order']
                            );
                        }
                    }

                    if ($custom_field['type'] == 'checkbox' && is_array($order_info['shipping_custom_field'][$custom_field['custom_field_id']])) {
                        foreach ($order_info['shipping_custom_field'][$custom_field['custom_field_id']] as $custom_field_value_id) {
                            $custom_field_value_info = $this->model_customer_custom_field->getCustomFieldValue($custom_field_value_id);

                            if ($custom_field_value_info) {
                                $data['shipping_custom_fields'][] = array(
                                    'name'  => $custom_field['name'],
                                    'value' => $custom_field_value_info['name'],
                                    'sort_order' => $custom_field['sort_order']
                                );
                            }
                        }
                    }

                    if ($custom_field['type'] == 'text' || $custom_field['type'] == 'textarea' || $custom_field['type'] == 'file' || $custom_field['type'] == 'date' || $custom_field['type'] == 'datetime' || $custom_field['type'] == 'time') {
                        $data['shipping_custom_fields'][] = array(
                            'name'  => $custom_field['name'],
                            'value' => $order_info['shipping_custom_field'][$custom_field['custom_field_id']],
                            'sort_order' => $custom_field['sort_order']
                        );
                    }

                    if ($custom_field['type'] == 'file') {
                        $upload_info = $this->model_tool_upload->getUploadByCode($order_info['shipping_custom_field'][$custom_field['custom_field_id']]);

                        if ($upload_info) {
                            $data['shipping_custom_fields'][] = array(
                                'name'  => $custom_field['name'],
                                'value' => $upload_info['name'],
                                'sort_order' => $custom_field['sort_order']
                            );
                        }
                    }
                }
            }

            $data['ip'] = $order_info['ip'];
            $data['forwarded_ip'] = $order_info['forwarded_ip'];
            $data['user_agent'] = $order_info['user_agent'];
            $data['accept_language'] = $order_info['accept_language'];

            // Additional Tabs
            $data['tabs'] = array();

            if ($this->user->hasPermission('access', 'extension/payment/' . $order_info['payment_code'])) {
                if (is_file(DIR_CATALOG . 'controller/extension/payment/' . $order_info['payment_code'] . '.php')) {
                    $content = $this->load->controller('extension/payment/' . $order_info['payment_code'] . '/order');
                } else {
                    $content = '';
                }

                if ($content) {
                    $this->load->language('extension/payment/' . $order_info['payment_code']);

                    $data['tabs'][] = array(
                        'code'    => $order_info['payment_code'],
                        'title'   => $this->language->get('heading_title'),
                        'content' => $content
                    );
                }
            }

            $this->load->model('setting/extension');

            $extensions = $this->model_setting_extension->getInstalled('fraud');

            foreach ($extensions as $extension) {
                if ($this->config->get('fraud_' . $extension . '_status')) {
                    $this->load->language('extension/fraud/' . $extension, 'extension');

                    $content = $this->load->controller('extension/fraud/' . $extension . '/order');

                    if ($content) {
                        $data['tabs'][] = array(
                            'code'    => $extension,
                            'title'   => $this->language->get('extension')->get('heading_title'),
                            'content' => $content
                        );
                    }
                }
            }

            // The URL we send API requests to
            $data['catalog'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

            // API login
            $this->load->model('user/api');

            $api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

            if ($api_info && $this->user->hasPermission('modify', 'sale/order')) {
                $session = new Session($this->config->get('session_engine'), $this->registry);

                $session->start();

                $this->model_user_api->deleteApiSessionBySessonId($session->getId());

                $this->model_user_api->addApiSession($api_info['api_id'], $session->getId(), $this->request->server['REMOTE_ADDR']);

                $session->data['api_id'] = $api_info['api_id'];

                $data['api_token'] = $session->getId();
            } else {
                $data['api_token'] = '';
            }

            $data['header'] = $this->load->controller('common/header');
            $data['column_left'] = $this->load->controller('common/column_left');
            $data['footer'] = $this->load->controller('common/footer');


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
				
            $this->response->setOutput($this->load->view('sale/order_info', $data));
        } else {
            return new Action('error/not_found');
        }
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'sale/order')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function createInvoiceNo() {
        $this->load->language('sale/order');

        $json = array();

        if (!$this->user->hasPermission('modify', 'sale/order')) {
            $json['error'] = $this->language->get('error_permission');
        } elseif (isset($this->request->get['order_id'])) {
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
            } else {
                $order_id = 0;
            }

            $this->load->model('sale/order');

            $invoice_no = $this->model_sale_order->createInvoiceNo($order_id);

            if ($invoice_no) {
                $json['invoice_no'] = $invoice_no;
            } else {
                $json['error'] = $this->language->get('error_action');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function addReward() {
        $this->load->language('sale/order');

        $json = array();

        if (!$this->user->hasPermission('modify', 'sale/order')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
            } else {
                $order_id = 0;
            }

            $this->load->model('sale/order');

            $order_info = $this->model_sale_order->getOrder($order_id);

            if ($order_info && $order_info['customer_id'] && ($order_info['reward'] > 0)) {
                $this->load->model('customer/customer');

                $reward_total = $this->model_customer_customer->getTotalCustomerRewardsByOrderId($order_id);

                if (!$reward_total) {
                    $this->model_customer_customer->addReward($order_info['customer_id'], $this->language->get('text_order_id') . ' #' . $order_id, $order_info['reward'], $order_id);
                }
            }

            $json['success'] = $this->language->get('text_reward_added');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function removeReward() {
        $this->load->language('sale/order');

        $json = array();

        if (!$this->user->hasPermission('modify', 'sale/order')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
            } else {
                $order_id = 0;
            }

            $this->load->model('sale/order');

            $order_info = $this->model_sale_order->getOrder($order_id);

            if ($order_info) {
                $this->load->model('customer/customer');

                $this->model_customer_customer->deleteReward($order_id);
            }

            $json['success'] = $this->language->get('text_reward_removed');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function addCommission() {
        $this->load->language('sale/order');

        $json = array();

        if (!$this->user->hasPermission('modify', 'sale/order')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
            } else {
                $order_id = 0;
            }

            $this->load->model('sale/order');

            $order_info = $this->model_sale_order->getOrder($order_id);

            if ($order_info) {
                $this->load->model('customer/customer');

                $affiliate_total = $this->model_customer_customer->getTotalTransactionsByOrderId($order_id);

                if (!$affiliate_total) {
                    $this->model_customer_customer->addTransaction($order_info['affiliate_id'], $this->language->get('text_order_id') . ' #' . $order_id, $order_info['commission'], $order_id);
                }
            }

            $json['success'] = $this->language->get('text_commission_added');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function removeCommission() {
        $this->load->language('sale/order');

        $json = array();

        if (!$this->user->hasPermission('modify', 'sale/order')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
            } else {
                $order_id = 0;
            }

            $this->load->model('sale/order');

            $order_info = $this->model_sale_order->getOrder($order_id);

            if ($order_info) {
                $this->load->model('customer/customer');

                $this->model_customer_customer->deleteTransactionByOrderId($order_id);
            }

            $json['success'] = $this->language->get('text_commission_removed');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function history() {
        $this->load->language('sale/order');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }


      if (!empty($this->request->get['delete_id'])) {
        if ($this->user->hasPermission('modify', 'sale/order')) {
          $query = $this->db->query("DELETE FROM " . DB_PREFIX . "order_history WHERE order_history_id = '" . (int)$this->request->get['delete_id'] . "'");
        } else {
          echo '<div class="alert alert-danger"><i class="fa fa-warning"></i> You have no permissions to edit orders.</div>';
        }
      }

      if (version_compare(VERSION, '2', '>=')) {
        $data['token'] = isset($this->session->data['user_token']) ? 'user_token='.$this->session->data['user_token'] : 'token='.$this->session->data['token'];
        $data['text_qosu_confirm'] = $this->language->get('text_confirm');
        $data['qosu_order_id'] = $this->request->get['order_id'];
      } else {
        $data['token'] = 'token='.$this->session->data['token'];
        $this->data['text_qosu_confirm'] = $this->language->get('text_confirm');
        $this->data['qosu_order_id'] = $this->request->get['order_id'];
      }
      
        $data['histories'] = array();

        $this->load->model('sale/order');

        $results = $this->model_sale_order->getOrderHistories($this->request->get['order_id'], ($page - 1) * 10, 10);

        foreach ($results as $result) {
            $data['histories'][] = array(
     'id' => $result['order_history_id'],
                'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
                'status'     => $result['status'],
                'comment'    => nl2br($result['comment']),
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
            );
        }

        $history_total = $this->model_sale_order->getTotalOrderHistories($this->request->get['order_id']);

        $pagination = new Pagination();
        $pagination->total = $history_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->url = $this->url->link('sale/order/history', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $this->request->get['order_id'] . '&page={page}', true);

			if(isset($this->request->get['reverse'])) {
				$pagination->url = $this->url->link('sale/order/history', 'reverse&' . (isset($this->session->data['user_token']) ? 'user_token='.$this->session->data['user_token'] : 'token='.$this->session->data['token']) . '&order_id=' . $this->request->get['order_id'] . '&page={page}', 'SSL');
			}
			

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));


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
				
        $this->response->setOutput($this->load->view('sale/order_history', $data));
    }

    public function invoice() {
        $this->load->language('sale/order');

        $data['title'] = $this->language->get('text_invoice');

        if ($this->request->server['HTTPS']) {
            $data['base'] = HTTPS_SERVER;
        } else {
            $data['base'] = HTTP_SERVER;
        }

        $data['direction'] = $this->language->get('direction');
        $data['lang'] = $this->language->get('code');

        $this->load->model('sale/order');
        $this->load->model('customer/customer');
        $this->load->model('setting/setting');

        $data['orders'] = array();

        $orders = array();

        if (isset($this->request->post['selected'])) {
            $orders = $this->request->post['selected'];
        } elseif (isset($this->request->get['order_id'])) {
            $orders[] = $this->request->get['order_id'];
        }

        foreach ($orders as $order_id) {
            $order_info = $this->model_sale_order->getOrder($order_id);

            if ($order_info) {
                $store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

                if ($store_info) {
                    $store_address = $store_info['config_address'];
                    $store_email = $store_info['config_email'];
                    $store_telephone = $store_info['config_telephone'];
                    $store_fax = $store_info['config_fax'];
                } else {
                    $store_address = $this->config->get('config_address');
                    $store_email = $this->config->get('config_email');
                    $store_telephone = $this->config->get('config_telephone');
                    $store_fax = $this->config->get('config_fax');
                }

                if ($order_info['invoice_no']) {
                    $invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
                } else {
                    $invoice_no = '';
                }

                if ($order_info['payment_address_format']) {
                    $format = $order_info['payment_address_format'];
                } else {
                    $format = '{tckn}' . "\n" . ' {firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . ' {zone}' . ' {country}';
                }



                $find = array(
                    '{tckn}',
                    '{firstname}',
                    '{lastname}',
                    '{company}',
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}'
                );

                $replace = array(
                    'tckn'      => $order_info['tckn'],
                    'firstname' => $order_info['payment_firstname'],
                    'lastname'  => $order_info['payment_lastname'],
                    'company'   => $order_info['payment_company'],
                    'address_1' => $order_info['payment_address_1'],
                    'address_2' => $order_info['payment_address_2'],
                    'city'      => $order_info['payment_city'],
                    'postcode'  => $order_info['payment_postcode'],
                    'zone'      => $order_info['payment_zone'],
                    'zone_code' => $order_info['payment_zone_code'],
                    'country'   => $order_info['payment_country']
                );

                $payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

                if ($order_info['shipping_address_format']) {
                    $format = $order_info['shipping_address_format'];
                } else {
                    $format = '{tckn}' . "\n" . '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . ' {zone}' . ' {country}';
                }

                $find = array(
                    '{tckn}',
                    '{firstname}',
                    '{lastname}',
                    '{company}',
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}'
                );

                $replace = array(
                    'tckn'      => $order_info['tckn'],
                    'firstname' => $order_info['shipping_firstname'],
                    'lastname'  => $order_info['shipping_lastname'],
                    'company'   => $order_info['shipping_company'],
                    'address_1' => $order_info['shipping_address_1'],
                    'address_2' => $order_info['shipping_address_2'],
                    'city'      => $order_info['shipping_city'],
                    'postcode'  => $order_info['shipping_postcode'],
                    'zone'      => $order_info['shipping_zone'],
                    'zone_code' => $order_info['shipping_zone_code'],
                    'country'   => $order_info['shipping_country']
                );

                $shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

                $this->load->model('tool/upload');

                $product_data = array();

                $products = $this->model_sale_order->getOrderProducts($order_id);

                foreach ($products as $product) {
                    $option_data = array();

                    $options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

                    foreach ($options as $option) {
                        if ($option['type'] != 'file') {
                            $value = $option['value'];
                        } else {
                            $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                            if ($upload_info) {
                                $value = $upload_info['name'];
                            } else {
                                $value = '';
                            }
                        }

                        $option_data[] = array(
                            'name'  => $option['name'],
                            'value' => $value
                        );
                    }

                    $product_data[] = array(
                        'name'     => $product['name'],
                        'model'    => $product['model'],
                        'option'   => $option_data,
                        'quantity' => $product['quantity'],
                        'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                        'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
                    );
                }

                $voucher_data = array();

                $vouchers = $this->model_sale_order->getOrderVouchers($order_id);

                foreach ($vouchers as $voucher) {
                    $voucher_data[] = array(
                        'description' => $voucher['description'],
                        'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
                    );
                }

                $total_data = array();

                $totals = $this->model_sale_order->getOrderTotals($order_id);

                foreach ($totals as $total) {
                    $total_data[] = array(
                        'title' => $total['title'],
                        'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
                    );
                }

                $data['invoice_image'] = HTTPS_CATALOG . 'image/catalog/fatura.png';

                $data['orders'][] = array(

      'tracking_no'      => isset($result['tracking_no']) ? $result['tracking_no'] : '',
      'tracking_url'      => isset($result['tracking_url']) ? $result['tracking_url'] : '',
      'tracking_carrier' => isset ($result['tracking_carrier']) ? $result['tracking_carrier'] : '',
      
                    'order_id'         => $order_id,
                    'invoice_no'       => $invoice_no,
                    'date_added'       => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
                    'store_name'       => $order_info['store_name'],
                    'store_url'        => rtrim($order_info['store_url'], '/'),
                    'store_address'    => nl2br($store_address),
                    'store_email'      => $store_email,
                    'store_telephone'  => $store_telephone,
                    'store_fax'        => $store_fax,
                    'fname'            => $order_info['firstname'] . " " . $order_info['lastname'],
                    'email'            => $order_info['email'],
                    'telephone'        => $order_info['telephone'],
                    'shipping_address' => $shipping_address,
                    'shipping_method'  => $order_info['shipping_method'],
                    'payment_address'  => $payment_address,
                    'payment_method'   => $order_info['payment_method'],
                    'product'          => $product_data,
                    'voucher'          => $voucher_data,
                    'total'            => $total_data,
                    'comment'          => nl2br($order_info['comment'])
                );
            }
        }


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
				
        $this->response->setOutput($this->load->view('sale/order_invoice', $data));
    }

    public function shipping() {
        $this->load->language('sale/order');

        $data['title'] = $this->language->get('text_shipping');

        if ($this->request->server['HTTPS']) {
            $data['base'] = HTTPS_SERVER;
        } else {
            $data['base'] = HTTP_SERVER;
        }

        $data['direction'] = $this->language->get('direction');
        $data['lang'] = $this->language->get('code');

        $this->load->model('sale/order');

        $this->load->model('catalog/product');

        $this->load->model('setting/setting');

        $data['orders'] = array();

        $orders = array();

        if (isset($this->request->post['selected'])) {
            $orders = $this->request->post['selected'];
        } elseif (isset($this->request->get['order_id'])) {
            $orders[] = $this->request->get['order_id'];
        }

        foreach ($orders as $order_id) {
            $order_info = $this->model_sale_order->getOrder($order_id);

            // Make sure there is a shipping method
            if ($order_info && $order_info['shipping_code']) {
                $store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

                if ($store_info) {
                    $store_address = $store_info['config_address'];
                    $store_email = $store_info['config_email'];
                    $store_telephone = $store_info['config_telephone'];
                } else {
                    $store_address = $this->config->get('config_address');
                    $store_email = $this->config->get('config_email');
                    $store_telephone = $this->config->get('config_telephone');
                }

                if ($order_info['invoice_no']) {
                    $invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
                } else {
                    $invoice_no = '';
                }

                if ($order_info['shipping_address_format']) {
                    $format = $order_info['shipping_address_format'];
                } else {
                    $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
                }

                $find = array(
                    '{firstname}',
                    '{lastname}',
                    '{company}',
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}'
                );

                $replace = array(
                    'firstname' => $order_info['shipping_firstname'],
                    'lastname'  => $order_info['shipping_lastname'],
                    'company'   => $order_info['shipping_company'],
                    'address_1' => $order_info['shipping_address_1'],
                    'address_2' => $order_info['shipping_address_2'],
                    'city'      => $order_info['shipping_city'],
                    'postcode'  => $order_info['shipping_postcode'],
                    'zone'      => $order_info['shipping_zone'],
                    'zone_code' => $order_info['shipping_zone_code'],
                    'country'   => $order_info['shipping_country']
                );

                $shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

                $this->load->model('tool/upload');

                $product_data = array();

                $products = $this->model_sale_order->getOrderProducts($order_id);

                foreach ($products as $product) {
                    $option_weight = '';

                    $product_info = $this->model_catalog_product->getProduct($product['product_id']);

                    if ($product_info) {
                        $option_data = array();

                        $options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

                        foreach ($options as $option) {
                            if ($option['type'] != 'file') {
                                $value = $option['value'];
                            } else {
                                $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                                if ($upload_info) {
                                    $value = $upload_info['name'];
                                } else {
                                    $value = '';
                                }
                            }

                            $option_data[] = array(
                                'name'  => $option['name'],
                                'value' => $value
                            );

                            $product_option_value_info = $this->model_catalog_product->getProductOptionValue($product['product_id'], $option['product_option_value_id']);

                            if ($product_option_value_info) {
                                if ($product_option_value_info['weight_prefix'] == '+') {
                                    $option_weight += $product_option_value_info['weight'];
                                } elseif ($product_option_value_info['weight_prefix'] == '-') {
                                    $option_weight -= $product_option_value_info['weight'];
                                }
                            }
                        }

                        $product_data[] = array(
                            'name'     => $product_info['name'],
                            'model'    => $product_info['model'],
                            'option'   => $option_data,
                            'quantity' => $product['quantity'],
                            'location' => $product_info['location'],
                            'sku'      => $product_info['sku'],
                            'upc'      => $product_info['upc'],
                            'ean'      => $product_info['ean'],
                            'jan'      => $product_info['jan'],
                            'isbn'     => $product_info['isbn'],
                            'mpn'      => $product_info['mpn'],
                            'weight'   => $this->weight->format(($product_info['weight'] + (float)$option_weight) * $product['quantity'], $product_info['weight_class_id'], $this->language->get('decimal_point'), $this->language->get('thousand_point'))
                        );
                    }
                }

                $data['orders'][] = array(

      'tracking_no'      => isset($result['tracking_no']) ? $result['tracking_no'] : '',
      'tracking_url'      => isset($result['tracking_url']) ? $result['tracking_url'] : '',
      'tracking_carrier' => isset ($result['tracking_carrier']) ? $result['tracking_carrier'] : '',
      
                    'order_id'         => $order_id,
                    'invoice_no'       => $invoice_no,
                    'date_added'       => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
                    'store_name'       => $order_info['store_name'],
                    'store_url'        => rtrim($order_info['store_url'], '/'),
                    'store_address'    => nl2br($store_address),
                    'store_email'      => $store_email,
                    'store_telephone'  => $store_telephone,
                    'email'            => $order_info['email'],
                    'telephone'        => $order_info['telephone'],
                    'shipping_address' => $shipping_address,
                    'shipping_method'  => $order_info['shipping_method'],
                    'product'          => $product_data,
                    'comment'          => nl2br($order_info['comment'])
                );
            }
        }


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
				
        $this->response->setOutput($this->load->view('sale/order_shipping', $data));
    }
}
