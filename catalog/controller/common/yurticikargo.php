<?php
class ControllerCommonYurticikargo extends Controller {

    public function index() {

    $wsdl = "http://webservices.yurticikargo.com:8080/KOPSWebServices/ShippingOrderDispatcherServices?wsdl";

    $this->load->model('checkout/order');

    $kargoya_verildi_id = "3";
    $tamamlandi_id = "5";
    $nokta_say = 0;
    $nokta_say2 = 0;

    $kargo_kontrol = $this->db->query("SELECT * FROM " . DB_PREFIX . "kargo_entegrasyon WHERE kargo_adi = 'yurtici' AND durum IN(1,10)");

    foreach ($kargo_kontrol->rows AS $rows) {

       $nokta_say++;
       if($nokta_say%49==0) { echo "/"; $nokta_say2++; }
       if($nokta_say2==275) { echo "<br>"; $nokta_say2=0;}

        $order_id = $rows['order_id'];
        $durum = $rows['durum'];
        $ontag = "2020";
        $siparis_no = $ontag.''.$order_id;

        $data = array_merge(
          array("wsUserName"        => $this->config->get('config_yt_uname');,
                "wsPassword"        => $this->config->get('config_yt_pass');,
                "wsLanguage"        => "TR",
                "keys"              => $siparis_no,
                "keyType"           => 0,
                "addHistoricalData" => false,
                "onlyTracking"      => true,
          )

        );

        $client = new SoapClient($wsdl);

        $gonder = $client->queryShipment($data);

        $veri_detay = $gonder->ShippingDeliveryVO->shippingDeliveryDetailVO;

        echo '<div class="col-sm-12">';

        if ($veri_detay->operationCode == "5") {    //Teslim Olmuşsa

            $takip_no = $veri_detay->shippingDeliveryItemDetailVO->trackingUrl;
            $takip_no_sade = explode("code=", $takip_no);

            $this->db->query("UPDATE " . DB_PREFIX . "kargo_entegrasyon SET takip_no = '".$takip_no_sade[1]."', durum = '100' WHERE order_id = '".$order_id."'");

            $this->model_checkout_order->addOrderHistory($order_id, $tamamlandi_id, $takip_no_sade[1]);

            echo "<span>".$order_id." nolu sipariş teslim edildi. Takip No: ".$takip_no_sade[1]." <span></br>";


        }else if ($veri_detay->operationCode == "1"){   // Dağıtımdaysa

            $takip_no = $veri_detay->shippingDeliveryItemDetailVO->trackingUrl;
            $takip_no_sade = explode("code=", $takip_no);

                if ($durum == "1") { //Sipariş Bekleme durumundaysa


                    $this->model_checkout_order->addOrderHistory($order_id, $kargoya_verildi_id, $takip_no_sade[1]);

                    $this->db->query("UPDATE " . DB_PREFIX . "kargo_entegrasyon SET takip_no = '".$takip_no_sade[1]."', durum = '10' WHERE order_id = '".$order_id."'");
                    echo "<span>".$order_id." nolu sipariş dağıtımda. Takip No: ".$takip_no_sade[1]." <span></br>";

                } else { // bi değişiklik yok işlem yapma

                    echo '<span>'.$order_id.' nolu siparişte değişiklik yoktur. <span></br>';
                }
        } else {

            $hata_mesaji = $veri_detay->operationMessage;
            echo '<span>'.$order_id.' nolu sipariş '.$hata_mesaji.'<span></br>';

        }

        echo '</div>';

        } //Foreach Kapanışı
    }
}
