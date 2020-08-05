<?php
class ControllerExtensionReportProductCustomer extends Controller {
    public function index() {
        $this->load->language('extension/report/product_customer');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('report_product_customer', $this->request->post);

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
            'href' => $this->url->link('extension/report/product_customer', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/report/product_customer', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=report', true);

        if (isset($this->request->post['report_product_customer_status'])) {
            $data['report_product_customer_status'] = $this->request->post['report_product_customer_status'];
        } else {
            $data['report_product_customer_status'] = $this->config->get('report_product_customer_status');
        }

        if (isset($this->request->post['report_product_customer_sort_order'])) {
            $data['report_product_customer_sort_order'] = $this->request->post['report_product_customer_sort_order'];
        } else {
            $data['report_product_customer_sort_order'] = $this->config->get('report_product_customer_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/report/product_customer_form', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/report/sale_order')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function report() {
        $this->load->language('extension/report/product_customer');

        if (!$this->user->hasPermission('access', 'extension/report/product_customer')) {
            $data['heading_title'] = $this->language->get('error_permission');
            return $this->load->view('extension/report/sale_order_info', $data);
        }

        if (isset($this->request->get['filter_product_id'])) {
            $filter_product_id = $this->request->get['filter_product_id'];
        } else {
            $filter_product_id = null;
        }

        if (isset($this->request->get['filter_store_id'])) {
            $filter_store_id = $this->request->get['filter_store_id'];
        } else {
            $filter_store_id = -1;
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $this->load->model('setting/store');

        $stores = $this->model_setting_store->getStores();
        $mapped = array();
        foreach ($stores as $store) {
            $mapped[$store['store_id']] = $store['name'];
        }

        $mapped[0] = $this->config->get('config_name');

        $data['stores'] = $mapped;

        $this->load->model('extension/report/product_customer');
        $results = $this->model_extension_report_product_customer->getOrders($filter_product_id, $filter_store_id);
        $data['orders'] = array();

        foreach ($results as $result) {
            $data['orders'][$result['customer_id']] = array(
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'customer'   => $result['firstname'] . " " . $result['lastname'],
                'store'      => $mapped[$result['store_id']],
                'quantity'   => $result['quantity'],
                'total'      => $result['total']
            );

            $data['heading_title'] = $result['name'];
        }

        $returns = $this->model_extension_report_product_customer->getOrders($filter_product_id, $filter_store_id, true);

        foreach ($returns as $return) {
            if (isset($data['orders'][$return['customer_id']])) {
                $data['orders'][$return['customer_id']]['quantity'] -= $return['quantity'];
            }
        }

        $data['user_token'] = $this->session->data['user_token'];

        $url = '';

        $pagination = new Pagination();
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('report/report', 'user_token=' . $this->session->data['user_token'] . '&code=product_customer' . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = count($data['orders']);

        $data['filter_product_id'] = $filter_product_id;
        $data['filter_store_id'] = $filter_store_id;

        return $this->load->view('extension/report/product_customer_info', $data);
    }
}