<?php
class ControllerExtensionReportPackageSale extends Controller {
    public function index() {
        $this->load->language('extension/report/package_sale');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('report_package_sale', $this->request->post);

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
            'href' => $this->url->link('extension/report/package_sale', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/report/package_sale', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=report', true);

        if (isset($this->request->post['report_package_sale_status'])) {
            $data['report_package_sale_status'] = $this->request->post['report_package_sale_status'];
        } else {
            $data['report_package_sale_status'] = $this->config->get('report_package_sale_status');
        }

        if (isset($this->request->post['report_package_sale_sort_order'])) {
            $data['report_package_sale_sort_order'] = $this->request->post['report_package_sale_sort_order'];
        } else {
            $data['report_package_sale_sort_order'] = $this->config->get('report_package_sale_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/report/package_sale_form', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/report/sale_order')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function report() {
        $this->load->language('extension/report/package_sale');

        if (!$this->user->hasPermission('access', 'extension/report/package_sale')) {
            $data['heading_title'] = $this->language->get('error_permission');
            return $this->load->view('extension/report/sale_order_info', $data);
        }

        if (isset($this->request->get['filter_store_id'])) {
            $filter_store_id = $this->request->get['filter_store_id'];
        } else {
            $filter_store_id = null;
        }

        $this->load->model('setting/store');

        $data['stores'] = $stores = $this->model_setting_store->getStores();

        $this->load->model('extension/report/product_customer');

        $results = $this->model_extension_report_product_customer->getPackageSales($filter_store_id);
        $data['orders'] = array();

        foreach ($results as $result) {
            $data['orders'][] = array(
                'total' => $result['total'],
                'name'  => $result['name']
            );
        }

        $data['user_token'] = $this->session->data['user_token'];

        $url = '';

        $data['results'] = count($data['orders']);
        $data['filter_store_id'] = $filter_store_id;

        return $this->load->view('extension/report/package_sale_info', $data);
    }
}