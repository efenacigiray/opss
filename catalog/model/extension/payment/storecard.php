<?php
class ModelExtensionPaymentStorecard extends Model {
    public function getMethod($address, $total) {
        $this->load->language('extension/payment/storecard');

        $method_data = array(
            'code'       => 'storecard',
            'title'      => $this->language->get('text_title'),
            'terms'      => '',
            'sort_order' => $this->config->get('payment_storecard_sort_order')
        );

        return $method_data;
    }
}
