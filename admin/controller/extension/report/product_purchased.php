<?php
include(DIR_STORAGE . 'vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ControllerExtensionReportProductPurchased extends Controller {
    public function index() {
        $this->load->language('extension/report/product_purchased');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('report_product_purchased', $this->request->post);

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
            'href' => $this->url->link('extension/report/product_purchased', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/report/product_purchased', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=report', true);

        if (isset($this->request->post['report_product_purchased_status'])) {
            $data['report_product_purchased_status'] = $this->request->post['report_product_purchased_status'];
        } else {
            $data['report_product_purchased_status'] = $this->config->get('report_product_purchased_status');
        }

        if (isset($this->request->post['report_product_purchased_sort_order'])) {
            $data['report_product_purchased_sort_order'] = $this->request->post['report_product_purchased_sort_order'];
        } else {
            $data['report_product_purchased_sort_order'] = $this->config->get('report_product_purchased_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/report/product_purchased_form', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/report/product_purchased')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
        
    public function report() {
        $this->load->language('extension/report/product_purchased');

        if (isset($this->request->get['filter_date_start'])) {
            $filter_date_start = $this->request->get['filter_date_start'];
        } else {
            $filter_date_start = '';
        }

        if (isset($this->request->get['filter_date_end'])) {
            $filter_date_end = $this->request->get['filter_date_end'];
        } else {
            $filter_date_end = '';
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $filter_order_status_id = $this->request->get['filter_order_status_id'];
        } else {
            $filter_order_status_id = 0;
        }

        if (isset($this->request->get['filter_manufacturer'])) {
            $filter_manufacturer = $this->request->get['filter_manufacturer'];
        } else {
            $filter_manufacturer = '';
        }

        if (isset($this->request->get['filter_manufacturer_name'])) {
            $filter_manufacturer_name = $this->request->get['filter_manufacturer_name'];
        } else {
            $filter_manufacturer_name = '';
        }

        if (isset($this->request->get['filter_category'])) {
            $filter_category = $this->request->get['filter_category'];
        } else {
            $filter_category = '';
        }

        if (isset($this->request->get['filter_category_name'])) {
            $filter_category_name = $this->request->get['filter_category_name'];
        } else {
            $filter_category_name = '';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $this->load->model('extension/report/product');

        $data['products'] = array();

        $filter_data = array(
            'filter_date_start'      => $filter_date_start,
            'filter_date_end'        => $filter_date_end,
            'filter_category'         => $filter_category,
            'filter_manufacturer'     => $filter_manufacturer,
            'filter_order_status_id'  => $filter_order_status_id,
            'start'                  => 0,
            'limit'                  => 1000000
        );

        $product_total = $this->model_extension_report_product->getTotalPurchased($filter_data);

        $results = $this->model_extension_report_product->getPurchased($filter_data);

        foreach ($results as $result) {
            $data['products'][$result['product_id']] = array(
                'name'       => $result['name'],
                'model'      => $result['model'],
                'quantity'   => $result['tquantity'],
                'pre_return' => $this->currency->format($result['total'], $this->config->get('config_currency')),
                'total'      => $result['total'],
                'product_id' => $result['product_id']
            );
        }

        $filter_data = array(
            'filter_date_start'       => $filter_date_start,
            'filter_date_end'         => $filter_date_end,
            'filter_category'         => $filter_category,
            'filter_manufacturer'     => $filter_manufacturer,
            'filter_order_status_id'  => $this->config->get('config_cancelled_status'),
            'start'                   => 0,
            'limit'                   => 1000000
        );

        $returns = $this->model_extension_report_product->getPurchased($filter_data);


        foreach ($returns as $return) {
            if (isset($data['products'][$return['product_id']])) {
                $data['products'][$return['product_id']]['quantity'] -= $return['tquantity'];
                $data['products'][$return['product_id']]['return'] -= $return['tquantity'];
                $data['products'][$return['product_id']]['total'] = $data['products'][$return['product_id']]['total'] - $return['total'];
            }
        }

        foreach ($data['products'] as $key => &$value) {
            $value["total"] = $this->currency->format($value["total"], $this->config->get('config_currency'));
            // echo($value['name'] . " - ");
            // echo($value['model'] . " - ");
            // echo($value['product_id'] . '<br>');
        }

        $data['user_token'] = $this->session->data['user_token'];

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }

        if (isset($this->request->get['filter_manufacturer'])) {
            $url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
        }

        if (isset($this->request->get['filter_category'])) {
            $url .= '&filter_category=' . $this->request->get['filter_category'];
        }

        $pagination = new Pagination();
        $pagination->total = $product_total;
        $pagination->page = $page;
        $pagination->limit = 100000;
        $pagination->url = $this->url->link('report/report', 'user_token=' . $this->session->data['user_token'] . '&code=product_purchased' . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

        $data['filter_date_start'] = $filter_date_start;
        $data['filter_date_end'] = $filter_date_end;
        $data['filter_order_status_id'] = $filter_order_status_id;
        $data['filter_manufacturer'] = $filter_manufacturer;
        $data['filter_category'] = $filter_category;
        $data['filter_manufacturer_name'] = $filter_manufacturer_name;
        $data['filter_category_name'] = $filter_category_name;


        if (isset($this->request->get['excel'])) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Filtreler');
            $sheet->setCellValue('B1', 'Kategori:' . $filter_category_name);
            $sheet->setCellValue('C1', 'Üretici:' . $filter_manufacturer_name);
            $sheet->setCellValue('D1', 'Tarih:' . $filter_date_start . ' - ' . $filter_date_end);
            $sheet->setCellValue('A2', 'Ürün Adı');
            $sheet->setCellValue('B2', 'Ürün Kodu');
            $sheet->setCellValue('C2', 'Adet');
            $sheet->setCellValue('D2', 'İade Edilen');
            $sheet->setCellValue('E2', 'İade Öncesi Toplam');
            $sheet->setCellValue('F2', 'Toplam');

            $i = 3;
            $prorpr = $data['products']; 
            foreach ($prorpr as $pvalue) {
                $sheet->setCellValue('A' . $i, (string)$pvalue['name']);
                $sheet->setCellValue('B' . $i, (string)$pvalue['model']);
                $sheet->setCellValue('C' . $i, (string)$pvalue['quantity']);
                $sheet->setCellValue('D' . $i, (string)$pvalue['return']);
                $sheet->setCellValue('E' . $i, str_replace(array('₺', '.', ','), ['', '', '.',], $pvalue['pre_return']));
                $sheet->setCellValue('F' . $i, str_replace(array('₺', '.', ','), ['', '', '.',], $pvalue['total']));
                $i++;
            }
            
            $writer = new Xls($spreadsheet);
            
            $filename = 'satilan-urunler';
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xls"'); 
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output'); // download file 
        }

        return $this->load->view('extension/report/product_purchased_info', $data);
    }
}