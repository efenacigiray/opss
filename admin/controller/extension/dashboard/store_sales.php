<?php
class ControllerExtensionDashboardStoreSales extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/dashboard/store_sales');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('dashboard_store_sales', $this->request->post);

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
            'href' => $this->url->link('extension/dashboard/store_sales', 'user_token=' . $this->session->data['user_token'], true)
        );

        if (isset($this->request->post['dashboard_store_sales_width'])) {
            $data['dashboard_store_sales_width'] = $this->request->post['dashboard_store_sales_width'];
        } else {
            $data['dashboard_store_sales_width'] = $this->config->get('dashboard_store_sales_width');
        }
        
        $data['columns'] = array();
        
        for ($i = 3; $i <= 12; $i++) {
            $data['columns'][] = $i;
        }

        if (isset($this->request->post['dashboard_store_sales_status'])) {
            $data['dashboard_store_sales_status'] = $this->request->post['dashboard_store_sales_status'];
        } else {
            $data['dashboard_store_sales_status'] = $this->config->get('dashboard_store_sales_status');
        }

        if (isset($this->request->post['dashboard_store_sales_sort_order'])) {
            $data['dashboard_store_sales_sort_order'] = $this->request->post['dashboard_store_sales_sort_order'];
        } else {
            $data['dashboard_store_sales_sort_order'] = $this->config->get('dashboard_store_sales_sort_order');
        }

        $data['action'] = $this->url->link('extension/dashboard/store_sales', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=dashboard', true);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/dashboard/store_sales_form', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/dashboard/store_sales')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
    
    public function dashboard() {
        $this->load->language('extension/dashboard/store_sales');

        $data['user_token'] = $this->session->data['user_token'];

        $this->load->model('setting/store');

        $data['stores'] = $this->model_setting_store->getStores();

        #$this->load->model('extension/dashboard/store_sales');
        #$results = $this->model_extension_dashboard_store_sales->getStoreSales();

        return $this->load->view('extension/dashboard/store_sales_info', $data);
    }
}