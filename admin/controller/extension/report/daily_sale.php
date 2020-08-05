<?php
class ControllerExtensionReportDailySale extends Controller {
    public function index() {
        $this->load->language('extension/report/daily_sale');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('report_sale_order', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=report', true));
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
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=report', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/report/sale_order', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/report/sale_order', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=report', true);

        if (isset($this->request->post['report_sale_order_status'])) {
            $data['report_sale_order_status'] = $this->request->post['report_sale_order_status'];
        } else {
            $data['report_sale_order_status'] = $this->config->get('report_sale_order_status');
        }

        if (isset($this->request->post['report_sale_order_sort_order'])) {
            $data['report_sale_order_sort_order'] = $this->request->post['report_sale_order_sort_order'];
        } else {
            $data['report_sale_order_sort_order'] = $this->config->get('report_sale_order_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/report/sale_order_form', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/report/sale_order')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function report() {
        $this->load->language('extension/report/daily_sale');

        if (!$this->user->hasPermission('access', 'extension/report/daily_sale')) {
            $data['heading_title'] = $this->language->get('error_permission');
            return $this->load->view('extension/report/sale_order_info', $data);
        }

        if (isset($this->request->get['filter_date_start'])) {
            $filter_date_start = $this->request->get['filter_date_start'];
        } else {
            $filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $filter_order_status_id = $this->request->get['filter_order_status_id'];
        } else {
            $filter_order_status_id = 0;
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $this->load->model('extension/report/daily_sale');
        $this->load->model('localisation/order_status');
        $this->load->model('setting/store');

        $stores = $this->model_setting_store->getStores();
        $mapped = array();
        foreach ($stores as $store) {
            $mapped[$store['store_id']] = $store['name'];
        }

        $mapped[0] = $this->config->get('config_name');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        $data['orders'] = array();
        $data['payment_types'] = array();

        $filter_data = array(
            'filter_date_start'      => $filter_date_start
        );

        $results = $this->model_extension_report_daily_sale->getOrders($filter_data);

        $store_orders = array();

        foreach ($results as $result) {
            if (!isset($store_orders[$result['store_id']])) {
                $store_orders[$result['store_id']] = array(
                    'date_start' => date($this->language->get('date_format_short'), strtotime($filter_date_start)),
                    'store'      => $mapped[$result['store_id']],
                    'type_total' => array(),
                    'orders'     => 0,
                    'total'      => 0
                );
            }

            $data['payment_types'][$result['payment_method']] = $result['payment_method'];
            $store_orders[$result['store_id']]['orders']++;

            if (!isset($store_orders[$result['store_id']]['type_total'][$result['payment_method']])) {
                $store_orders[$result['store_id']]['type_total'][$result['payment_method']] = 0;
            }

            $store_orders[$result['store_id']]['type_total'][$result['payment_method']] += $result['total'];
            $store_orders[$result['store_id']]['total'] += $result['total'];
        }

        foreach ($store_orders as &$value) {
            $value['total'] =  $this->currency->format($value['total'], $this->config->get('config_currency'));
            foreach ($value['type_total'] as &$type_total) {
                $type_total = $this->currency->format($type_total, $this->config->get('config_currency'));
            }

            foreach ($data['payment_types'] as $k => $v) {
                if (!isset($value['type_total'][$k])) {
                    $value['type_total'][$k] = $this->currency->format(0, $this->config->get('config_currency'));
                }
            }
            ksort($value['type_total']);
        }

        sort($data['payment_types']);

        $data['orders'] = $store_orders;

        $data['user_token'] = $this->session->data['user_token'];

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        if (isset($this->request->get['filter_group'])) {
            $url .= '&filter_group=' . $this->request->get['filter_group'];
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }

        $pagination = new Pagination();
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('report/report', 'user_token=' . $this->session->data['user_token'] . '&code=daily_sale' . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = count($data['orders']);

        $data['filter_date_start'] = $filter_date_start;
        $data['filter_order_status_id'] = $filter_order_status_id;

        return $this->load->view('extension/report/daily_sale_info', $data);
    }
}