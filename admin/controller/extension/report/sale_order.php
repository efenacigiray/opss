<?php
class ControllerExtensionReportSaleOrder extends Controller {
    public function index() {
        $this->load->language('extension/report/sale_order');

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
        $this->load->language('extension/report/sale_order');

        if (!$this->user->hasPermission('access', 'extension/report/sale_order')) {
            $data['heading_title'] = $this->language->get('error_permission');
            return $this->load->view('extension/report/sale_order_info', $data);
        }

        if (isset($this->request->get['filter_date_start'])) {
            $filter_date_start = $this->request->get['filter_date_start'];
        } else {
            $filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
        }

        if (isset($this->request->get['filter_date_end'])) {
            $filter_date_end = $this->request->get['filter_date_end'];
        } else {
            $filter_date_end = date('Y-m-d');
        }

        if (isset($this->request->get['filter_store_id'])) {
            $filter_store_id = $this->request->get['filter_store_id'];
        } else {
            $filter_store_id = '';
        }

        if (isset($this->request->get['filter_group'])) {
            $filter_group = $this->request->get['filter_group'];
        } else {
            $filter_group = 'week';
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $filter_order_status_id = $this->request->get['filter_order_status_id'];
        } else {
            $filter_order_status_id = -3;
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $this->load->model('extension/report/sale');
        $this->load->model('setting/store');

        $data['stores'] = $store_results = $this->model_setting_store->getStores();

        foreach ($data['stores'] as $key => $value) {
            if (!in_array($value['store_id'] , $this->session->data['stores'])) 
                unset($data['stores'][$key]);
        }

        foreach ($store_results as $store) {
            $stores[$store['store_id']] = $store['name'];
        }

        $stores[0] = $this->config->get('config_name');


        $data['orders'] = array();

        $filter_data = array(
            'filter_date_start'      => $filter_date_start,
            'filter_date_end'        => $filter_date_end,
            'filter_store_id'        => $filter_store_id,
            'filter_group'           => $filter_group,
            'filter_order_status_id' => $filter_order_status_id,
            'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit'                  => $this->config->get('config_limit_admin')
        );

        if ($filter_data['filter_order_status_id'] == -3) {
            $completed = $this->config->get('config_complete_status');
            $processing = $this->config->get('config_processing_status');
            $filter_data['filter_order_status_id'] = array_merge($completed, $processing);
        }

        $order_total = $this->model_extension_report_sale->getTotalOrders($filter_data);
        $results = $this->model_extension_report_sale->getOrders($filter_data);

        foreach ($results as $result) {
            $data['orders'][date($this->language->get('date_format_short'), strtotime($result['date_start']))] = array(
                'date_start' => date($this->language->get('date_format_short'), strtotime($result['date_start'])),
                'date_end'   => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
                'orders'     => $result['orders'],
                'products'   => $result['products'],
                'tax'        => $result['tax'],
                'untaxed'    => $result['total'] - $result['tax'],
                'commission' => ($result['total'] - $result['tax']) * 0.1,
                'total'      => $result['total'],
                'pre_return' => $this->currency->format($result['total'], $this->config->get('config_currency'))
            );
        }

        $filter_data = array(
            'filter_date_start'      => $filter_date_start,
            'filter_date_end'        => $filter_date_end,
            'filter_group'           => $filter_group,
            'filter_order_status_id' => 13,
            'start'                  => 0,
            'limit'                  => 100000
        );

        $returns = $this->model_extension_report_sale->getOrders($filter_data);

        foreach ($returns as $return) {
            $return_date = date($this->language->get('date_format_short'), strtotime($return['date_start']));
            $tax = $return['tax'];
            $untaxed = $return['total'] - $return['tax'];
            $commission = ($return['total'] - $return['tax']) * 0.1;
            $total = $return['total'];
            $products = $return['products'];

            if (isset($data['orders'][$return_date])) {
                $data['orders'][$return_date]['products'] -= $products;
                $data['orders'][$return_date]['tax'] -= $tax;
                $data['orders'][$return_date]['untaxed'] -= $untaxed;
                $data['orders'][$return_date]['commission'] -= $commission;
                $data['orders'][$return_date]['returns'] = $this->currency->format($total, $this->config->get('config_currency'));
                $data['orders'][$return_date]['total'] -= $total;
            }
        }

        foreach ($data['orders'] as $key => &$value) {
            $value['tax'] = $this->currency->format($value['tax'], $this->config->get('config_currency'));
            $value['untaxed'] = $this->currency->format($value['untaxed'], $this->config->get('config_currency'));
            $value['commission'] = $this->currency->format($value['commission'], $this->config->get('config_currency'));
            $value['total'] = $this->currency->format($value['total'], $this->config->get('config_currency'));
        }

        $data['user_token'] = $this->session->data['user_token'];

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['groups'] = array();

        $data['groups'][] = array(
            'text'  => $this->language->get('text_year'),
            'value' => 'year',
        );

        $data['groups'][] = array(
            'text'  => $this->language->get('text_month'),
            'value' => 'month',
        );

        $data['groups'][] = array(
            'text'  => $this->language->get('text_week'),
            'value' => 'week',
        );

        $data['groups'][] = array(
            'text'  => $this->language->get('text_day'),
            'value' => 'day',
        );

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

        if (isset($this->request->get['filter_store_id'])) {
            $url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
        }

        $pagination = new Pagination();
        $pagination->total = $order_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('report/report', 'user_token=' . $this->session->data['user_token'] . '&code=sale_order' . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

        $data['filter_date_start'] = $filter_date_start;
        $data['filter_date_end'] = $filter_date_end;
        $data['filter_group'] = $filter_group;
        $data['filter_order_status_id'] = $filter_order_status_id;
        $data['filter_store_id'] = $filter_store_id;

        return $this->load->view('extension/report/sale_order_info', $data);
    }
}