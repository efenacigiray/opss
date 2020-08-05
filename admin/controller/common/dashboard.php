<?php
class ControllerCommonDashboard extends Controller {
    public function index() {
        $this->load->language('common/dashboard');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['user_token'] = $this->session->data['user_token'];

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        // Check install directory exists
        if (is_dir(DIR_APPLICATION . 'install')) {
            $data['error_install'] = $this->language->get('error_install');
        } else {
            $data['error_install'] = '';
        }

        // Dashboard Extensions
        $dashboards = array();

        $this->load->model('setting/extension');

        // Get a list of installed modules
        $extensions = array();
        if ($this->user->hasPermission('access', 'common/dashboard')) {
            $extensions = $this->model_setting_extension->getInstalled('dashboard');
        }

        // Add all the modules which have multiple settings for each module
        foreach ($extensions as $code) {
            if ($this->config->get('dashboard_' . $code . '_status') && $this->user->hasPermission('access', 'extension/dashboard/' . $code)) {
                $output = $this->load->controller('extension/dashboard/' . $code . '/dashboard');

                if ($output) {
                    $dashboards[] = array(
                        'code'       => $code,
                        'width'      => $this->config->get('dashboard_' . $code . '_width'),
                        'sort_order' => $this->config->get('dashboard_' . $code . '_sort_order'),
                        'output'     => $output
                    );
                }
            }
        }

        $sort_order = array();

        foreach ($dashboards as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $dashboards);

        // Split the array so the columns width is not more than 12 on each row.
        $width = 0;
        $column = array();
        $data['rows'] = array();

        foreach ($dashboards as $dashboard) {
            $column[] = $dashboard;

            $width = ($width + $dashboard['width']);

            if ($width >= 12) {
                $data['rows'][] = $column;

                $width = 0;
                $column = array();
            }
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        // Run currency update
        if ($this->config->get('config_currency_auto')) {
            $this->load->model('localisation/currency');

            $this->model_localisation_currency->refresh();
        }

        foreach ($data['rows'] as $row => $content) {
            foreach ($content as $key => $value) {
                if ($value['code'] == 'store_sales') {
                    $data['store_sales'] = $value['output'];
                }
            }
        }


        if (!$this->user->hasPermission('access', 'common/dashboard')) {
            $data['rows'] = array();
            $data['users_online_mini'] = "";
            $data['total_orders_mini'] = "";
            $data['total_sales_mini'] = "";
            $data['total_customers_mini'] = "";
            $data['completed_orders_mini'] = "";
            $data['processing_orders_mini'] = "";
            $data['returned_orders_mini'] = "";
            $data['product_views_mini'] = "";
            $data['chart_most_viewed_products_medium'] = "";
            $data['chart_sales_analytics_large'] = "";
            $data['latest_orders_large'] = "";
            $data['map_medium'] = "";
            $data['activity_medium'] = "";
            $data['chart_top_customer_medium'] = "";
            $data['chart_top_product_medium'] = "";
            $data["store_sales"] = "";
        }

        $this->response->setOutput($this->load->view('common/dashboard', $data));
    }
}