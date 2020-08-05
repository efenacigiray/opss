<?php

class ControllerExtensionPaymentPaytrCheckout extends Controller {

    private $error = array();

    public function index()
    {
		ini_set('display_errors', 0); error_reporting(0);
        $this->load->language('extension/payment/paytr_checkout');
        $this->document->setTitle( $this->language->get('heading_title') );
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('payment_paytr_checkout', $this->request->post);


            $this->session->data['success'] = '<strong>PayTR Ödeme Altyapısı</strong> modül ayarları kaydedildi.!';

            $this->response->redirect($this->url->link('extension/payment/paytr_checkout', 'user_token=' . $this->session->data['user_token'], true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');

        $data['api_information'] = $this->language->get('api_information');
        $data['information_tab'] = $this->language->get('information_tab');
        $data['merchant_id'] = $this->language->get('merchant_id');
        $data['merchant_key'] = $this->language->get('merchant_key');
        $data['merchant_salt'] = $this->language->get('merchant_salt');
        $data['order_status'] = $this->language->get('order_status');
        $data['payment_approved'] = $this->language->get('payment_approved');
        $data['error_payment_approved'] = $this->language->get('error_payment_approved');
        $data['payment_notapproved'] = $this->language->get('payment_notapproved');
        $data['error_payment_notapproved'] = $this->language->get('error_payment_notapproved');
        $data['module_settings'] = $this->language->get('module_settings');
        $data['module_active'] = $this->language->get('module_active');
        $data['module_closed'] = $this->language->get('module_closed');
        $data['module_status'] = $this->language->get('module_status');
        $data['module_language'] = $this->language->get('module_language');
        $data['max_installments'] = $this->language->get('max_installments');
		$data['please_select'] = $this->language->get('please_select');

        $data['help_total'] = $this->language->get('help_total');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['errors_message'] = array(
            'warning'                               => $this->language->get('error_warning'),
            'payment_paytr_checkout_merchant_id'            => $this->language->get('error_paytr_checkout_merchant_id'),
            'payment_paytr_checkout_merchant_key'           => $this->language->get('error_paytr_checkout_merchant_key'),
            'payment_paytr_checkout_merchant_salt'          => $this->language->get('error_paytr_checkout_merchant_salt'),
            'payment_paytr_checkout_order_completed_id'     => $this->language->get('error_paytr_checkout_order_completed_id'),
            'payment_paytr_checkout_order_canceled_id'      => $this->language->get('error_paytr_checkout_order_canceled_id'),
            'payment_paytr_checkout_order_status_general'   => $this->language->get('error_paytr_checkout_order_status_general'),
            'payment_paytr_checkout_merchant_general'       => $this->language->get('error_paytr_checkout_merchant_general'),
            'payment_paytr_checkout_installment_number'		=> $this->language->get('error_paytr_checkout_installment_number')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_paytr'),
            'href' => HTTPS_SERVER . 'index.php?route=extension/payment/payment/paytr_checkout&user_token=' . $this->session->data['user_token'],
            'separator' => ' :: '
        );

        $data['action'] = HTTPS_SERVER . 'index.php?route=extension/payment/paytr_checkout&user_token=' . $this->session->data['user_token'];

        $data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&user_token=' . $this->session->data['user_token'];

        if (isset($this->request->post['payment_paytr_checkout_merchant_id'])) {
            $data['payment_paytr_checkout_merchant_id'] = trim( $this->request->post['payment_paytr_checkout_merchant_id'] );
        } else {
            $data['payment_paytr_checkout_merchant_id'] = $this->config->get('payment_paytr_checkout_merchant_id');
        }

        if (isset($this->request->post['payment_paytr_checkout_merchant_key'])) {
            $data['payment_paytr_checkout_merchant_key'] = trim( $this->request->post['payment_paytr_checkout_merchant_key'] );
        } else {
            $data['payment_paytr_checkout_merchant_key'] = $this->config->get('payment_paytr_checkout_merchant_key');
        }

        if (isset($this->request->post['payment_paytr_checkout_merchant_salt'])) {
            $data['payment_paytr_checkout_merchant_salt'] = trim( $this->request->post['payment_paytr_checkout_merchant_salt'] );
        } else {
            $data['payment_paytr_checkout_merchant_salt'] = $this->config->get('payment_paytr_checkout_merchant_salt');
        }

        if (isset($this->request->post['payment_paytr_checkout_status'])) {
           $data['payment_paytr_checkout_status'] = $this->request->post['payment_paytr_checkout_status'];

        } else {
            $data['payment_paytr_checkout_status'] = $this->config->get('payment_paytr_checkout_status');
        }


        if (isset($this->request->post['payment_paytr_checkout_installment_number'])) {
            $data['payment_paytr_checkout_installment_number'] = $this->request->post['payment_paytr_checkout_installment_number'];
        } else {

            if ( !$this->config->get('payment_paytr_checkout_installment_number') OR $this->config->get('payment_paytr_checkout_installment_number') == null ) {
                $data['payment_paytr_checkout_installment_number'] = 0;
            } else {
                $data['payment_paytr_checkout_installment_number'] = $this->config->get('payment_paytr_checkout_installment_number');
            }

        }

         if($this->language->get('code') == "tr")
            $data['installment_arr'] = array( 0 => 'Tüm Taksit Seçenekleri', 1 => 'Tek Çekim (Taksit Yok)', 2 => '2 Taksit\'e kadar', 3=> '3 Taksit\'e kadar', 4 => '4 Taksit\'e kadar', 5 => '5 Taksit\'e kadar', 6=> '6 Taksit\'e kadar', 7 => '7 Taksit\'e kadar', 8 => '8 Taksit\'e kadar', 9 => '9 Taksit\'e kadar', 10 => '10 Taksit\'e kadar', 11 => '11 Taksit\'e kadar', 12 => '12 Taksit\'e kadar', 13 => 'KATEGORİ BAZLI' );
        else 
            $data['installment_arr'] = array( 0 => 'All Installment Options', 1 => 'One Shot (No Installment)', 2 => 'Up to 2 Installments', 3=> 'Up to 3 Installments', 4 => 'Up to 4 Installments', 5 => 'Up to 5 Installments', 6=> 'Up to 6 Installments', 7 => 'Up to 7 Installments', 8 => 'Up to 8 Installments', 9 => 'Up to 9 Installments', 10 => 'Up to 10 Installments', 11 => 'Up to 11 Installments', 12 => 'Up to 12 Installments', 13 => 'CATEGORY BASED' );

        
		if($this->language->get('code') == "tr")
            $data['language_arr'] = array( 0 => 'Otomatik', 1 => 'Türkçe', 2 => 'İngilizce' );
        else 
            $data['language_arr'] = array( 0 => 'Automatic', 1 => 'Turkish', 2 => 'English' );

        if (isset($this->request->post['payment_paytr_checkout_lang'])) {
            $data['payment_paytr_checkout_lang'] = $this->request->post['payment_paytr_checkout_lang'];

        } else {
            $data['payment_paytr_checkout_lang'] = $this->config->get('payment_paytr_checkout_lang');
        }


        if (isset($this->request->post['payment_paytr_checkout_order_completed_id'])) {
            $data['payment_paytr_checkout_order_completed_id'] = $this->request->post['payment_paytr_checkout_order_completed_id'];
        } else {
            $data['payment_paytr_checkout_order_completed_id'] = $this->config->get('payment_paytr_checkout_order_completed_id');
        }

        if (isset($this->request->post['payment_paytr_checkout_order_canceled_id'])) {
            $data['payment_paytr_checkout_order_canceled_id'] = $this->request->post['payment_paytr_checkout_order_canceled_id'];
        } else {
            $data['payment_paytr_checkout_order_canceled_id'] = $this->config->get('payment_paytr_checkout_order_canceled_id');
        }

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if ( !$this->config->get('payment_paytr_checkout_merchant_id') OR !$this->config->get('payment_paytr_checkout_merchant_key') OR !$this->config->get('payment_paytr_checkout_merchant_salt') ) {
            $this->error['payment_paytr_checkout_merchant_general'] = 1;
        }

        $tree = $this->category_parser();
        $finish = array();
        $this->category_parser_clear( $tree, 0, array(), $finish );
        $data['payment_paytr_checkout_category_list'] = $finish;

        if ( isset($this->request->post['payment_paytr_checkout_category_installment']) ) {
            $data['payment_paytr_checkout_category_installment'] = $this->request->post['payment_paytr_checkout_category_installment'];
        } else {
            $data['payment_paytr_checkout_category_installment'] = $this->config->get('payment_paytr_checkout_category_installment');
        }

        $data['errors']      = $this->error;

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        if ( !array_key_exists( 'payment_paytr_checkout_installment_number', $data['errors'] ) AND $data['payment_paytr_checkout_installment_number'] == 13 ) {

            $data['installment_arr_for_categories'] = $data['installment_arr'];
            unset($data['installment_arr_for_categories'][13]);
            $data["kategori_bazli"]=true;
        }

        $this->response->setOutput($this->load->view('extension/payment/paytr_checkout', $data));
    }

    public function category_parser()
    {
        $cats = $this->db->query("SELECT c.category_id AS 'id',  c.parent_id AS 'parent_id', cd.name AS 'name' FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
        $cats = $cats->rows;
        $cat_tree = array();
        foreach ( $cats as $key => $item ) {
            if ( $item['parent_id'] == 0 ) {
                $cat_tree[ $item['id'] ] = array( 'id' => $item['id'], 'name' => $item['name'] );
                $this->parent_category_parser( $cats, $cat_tree[ $item['id'] ] );
            }
        }
        return $cat_tree;
    }

    public function parent_category_parser( &$cats = array(), &$cat_tree = array() ) 
    {
        foreach ( $cats as $key => $item ) {
            if ( $item['parent_id'] == $cat_tree['id'] ) {
                $cat_tree['parent'][ $item['id'] ] = array( 'id' => $item['id'], 'name' => $item['name'] );
                $this->parent_category_parser( $cats, $cat_tree['parent'][ $item['id'] ] );
            }
        }
    }

    public function category_parser_clear( $tree, $level = 0, $arr = array(), &$finish_him = array() )
    {
        foreach ( $tree as $id => $item ) {
            if ( $level == 0 ) { unset($arr); $arr=array(); $arr[] = $item['name']; }
            elseif ( $level == 1 OR $level == 2) {
                if ( count( $arr ) == ( $level + 1 ) ) { $deleted = array_pop($arr); }
                $arr[] = $item['name'];
            }
            if ( $level < 3 ) {
                $nav = null;
                foreach ( $arr as $key => $val ) {
                    $nav .= $val.( $level != 0 ? ' > ' : null );
                }
                $finish_him[ $item['id'] ] = rtrim($nav,' > ').'<br>';
                if ( !empty( $item['parent'] ) ) {
                    $this->category_parser_clear( $item['parent'], $level + 1, $arr, $finish_him );
                }
            }
        }
    }

    public function install(){}

    public function uninstall(){}

    protected function validate()
    {
        if ( !$this->user->hasPermission('modify', 'extension/payment/paytr_checkout') ) {
            $this->error['warning'] = 1;
        }

        if ( !$this->request->post['payment_paytr_checkout_merchant_id'] ) {
            $this->error['payment_paytr_checkout_merchant_id'] = 1;
        }

        if ( !$this->request->post['payment_paytr_checkout_merchant_key'] ) {
            $this->error['payment_paytr_checkout_merchant_key'] = 1;
        }

        if ( !$this->request->post['payment_paytr_checkout_merchant_salt'] ) {
            $this->error['payment_paytr_checkout_merchant_salt'] = 1;
        }

        if ( !$this->request->post['payment_paytr_checkout_order_completed_id'] ) {
            $this->error['payment_paytr_checkout_order_completed_id'] = 1;
        }

        if ( !$this->request->post['payment_paytr_checkout_order_canceled_id'] ) {
            $this->error['payment_paytr_checkout_order_canceled_id'] = 1;
        }

        if ( !$this->error ) { return true; }
            else { return false; }
    }

}

?>