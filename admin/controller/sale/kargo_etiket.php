<?php
class ControllerSaleKargoEtiket extends Controller {
    private $error = array();
    private $font = "FreeSansBold.ttf";

    public function index() {

        $this->document->setTitle("Kargo Etiketleri");

        $data['title'] = "Kargo Etiketleri";

        if ($this->request->server['HTTPS']) {
            $data['base'] = HTTPS_SERVER;
        } else {
            $data['base'] = HTTP_SERVER;
        }

        $this->load->model('sale/order');

        $this->load->model('setting/setting');

        $data['orders'] = array();

        $orders = array();

        if (isset($this->request->post['selected'])) {
            $orders = $this->request->post['selected'];
        } elseif (isset($this->request->get['order_id'])) {
            $orders[] = $this->request->get['order_id'];
        }

        foreach ($orders as $order_id) {
            $order_info = $this->model_sale_order->getOrder($order_id);

            // Make sure there is a shipping method
            if ($order_info && $order_info['shipping_code']) {
                $store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

                if ($store_info) {
                    $store_address = $store_info['config_address'];
                    $store_email = $store_info['config_email'];
                    $store_telephone = $store_info['config_telephone'];
                    $store_fax = $store_info['config_fax'];
                } else {
                    $store_address = $this->config->get('config_address');
                    $store_email = $this->config->get('config_email');
                    $store_telephone = $this->config->get('config_telephone');
                    $store_fax = $this->config->get('config_fax');
                }

                $siparis_ontag = '2020';

                $kargo_bak = $this->db->query("SELECT * FROM " . DB_PREFIX . "kargo_entegrasyon WHERE order_id = '" . (int) $order_id . "'");
                $chechRecord = $kargo_bak->row;

                $musteri_no = $this->config->get('config_yt_code');

                if ($chechRecord) {
                    $barkod = $siparis_ontag.$order_id;
                    $kargo_adi = $chechRecord['kargo_adi'];
                    $baslik = 'YURTİÇİ KARGO ETİKETİ';
                } else {
                    $barkod = false;
                    $kargo_adi = false;
                    $baslik = '-';
                }

                $data['orders'][] = array(
                    'order_id'         => $order_id,
                    'barkod'           => $barkod,
                    'kargo_adi'        => $kargo_adi,
                    'baslik'           => $baslik,
                    'musteri_no'       => $musteri_no,
                    'store_name'       => $order_info['store_name'],
                    'store_address'    => nl2br($store_address),
                    'store_email'      => $store_email,
                    'store_telephone'  => $store_telephone,
                    'store_fax'        => $store_fax,
                    'email'            => $order_info['email'],
                    'telephone'        => $order_info['telephone'],
                    'firstname'         => $order_info['shipping_firstname'],
                    'lastname'          => $order_info['shipping_lastname'],
                    'address_1'         => $order_info['shipping_address_1'],
                    'address_2'         => $order_info['shipping_address_2'],
                    'city'              => $order_info['shipping_city'],
                    'zone'              => $order_info['shipping_zone'],
                    'shipping_method'  => $order_info['shipping_method'],
                    'total'            => $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']),
                    'payment_method'   => $order_info['payment_method'],
                    'payment_code'     => $order_info['payment_code'],
                    'comment'          => nl2br($order_info['comment'])
                );
            }
        }
        $this->config->set('template_engine', 'template');
        $this->response->setOutput($this->load->view('sale/kargo_etiket', $data));
    }

}
