<?php
class ModelExtensionPaymentStorecash extends Model {
    public function getMethod($address, $total) {
        $this->load->language('extension/payment/storecash');

        $method_data = array(
            'code'       => 'storecash',
            'title'      => $this->language->get('text_title'),
            'terms'      => '',
            'sort_order' => $this->config->get('payment_storecash')
        );

        return $method_data;
    }
}