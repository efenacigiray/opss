<?php
class ControllerB5bQoreEngineDashTotalSalesMini extends Controller{
    private $error = array();

    public function index() {
        $this->load->language('extension/dashboard/sale');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_view'] = $this->language->get('text_view');

        $data['user_token'] = $this->session->data['user_token'];

        // Total Sales
        $this->load->model('extension/report/sale');

        $completed = $this->config->get('config_complete_status');
        $processing = $this->config->get('config_processing_status');
        $statuses = array_merge($completed, $processing);

        $sale_total = $this->model_extension_report_sale->getTotalSales(['filter_order_status' => $statuses] );

        if ($sale_total >= 1000000000000) {
            $data['total'] = $this->currency->format(round($sale_total / 1000000000000, 2), $this->config->get('config_currency')) . 'T';
        } elseif ($sale_total >= 1000000000) {
            $data['total'] = $this->currency->format(round($sale_total / 1000000000, 2), $this->config->get('config_currency')) . 'B';
        } elseif ($sale_total >= 1000000) {
            $data['total'] = $this->currency->format(round($sale_total / 1000000, 2), $this->config->get('config_currency')) . 'M';
        }  elseif ($sale_total >= 10000) {
            $data['total'] = $this->currency->format(round($sale_total / 1000, 2), $this->config->get('config_currency')) . 'K';
        } else {
            $data['total'] = $this->currency->format($sale_total, $this->config->get('config_currency'));
        }

        $data['sale'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'], true);

        return $this->load->view('dashboard/total_sales_mini', $data);
    }
}
