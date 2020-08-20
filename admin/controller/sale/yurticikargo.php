<?php
class ControllerSaleYurticikargo extends Controller {

	public function index() {

		$kargo_hazir_id = '15';

		$wsdl = "http://webservices.yurticikargo.com:8080/KOPSWebServices/ShippingOrderDispatcherServices?wsdl";

		$order_id = $this->request->post['order_id'];

		$order_data = $this->getOrderData($order_id);

		$giden = 0;
		$gitmeyen = 0;
		$error = '';
		$id = 0;
		$status = false;

		$ontag = '2020';

		$siparis_no = $ontag.''.$order_data["order_id"];
		$adi = $order_data["adi"];
		$soyadi = $order_data["soyadi"];
		$adres = $order_data["adres"];
		$semt_adi = $order_data["semt_adi"];
		$sehir_adi = $order_data["sehir_adi"];
		$toplam_tutar = $order_data["toplam_tutar"];
		$telefon = $order_data["telefon"];
		$payment_code = $order_data["payment_code"];

		$desi = 2;

		if ($payment_code == "cod") { // kapıda ödemeler nakit

			$wsUserName = "COLORINGT"; // gönderici ödemeli tahsilatlı
			$wsPassword = "2536vBZBvC6n02zN";
			$userLanguage = "TR";

			$toplam_tutar = str_replace("TL","",$toplam_tutar);
			$toplam_tutar = str_replace(",",".",$toplam_tutar);
			$toplam_tutar = trim($toplam_tutar);

			$gonderi_bilgileri = array(
				"cargoKey" => $siparis_no,
				"invoiceKey" => $siparis_no,
				"receiverCustName" => $adi." ".$soyadi,
				"receiverAddress" => $adres,
				"cityName" => $sehir_adi,
				"townName" => $semt_adi,
				"taxOfficeId" => NULL,
				"taxNumber" => NULL,
				"taxOfficeName" => NULL,
				"ttDocumentId" => $siparis_no,
				"ttCollectionType" => "0",
				"ttInvoiceAmount" => $toplam_tutar,
				"ttInvoiceAmountSpecified" => true,
				"ttDocumentSaveType" => "0",
				"dcSelectedCredit" => NULL,
				"dcCreditRule" => NULL,
				"receiverPhone1" => $telefon,
				"desi" => $desi,
				"kg"   => "1",
				"cargoCount" => "1",
				"description" => "Kargo"
			);

		} elseif ($payment_code == "codkk") { // kapıda ödemeler nakit

			$wsUserName = "COLORINGT"; // gönderici ödemeli tahsilatlı
			$wsPassword = "2536vBZBvC6n02zN";
			$userLanguage = "TR";

			$toplam_tutar = str_replace("TL","",$toplam_tutar);
			$toplam_tutar = str_replace(",",".",$toplam_tutar);
			$toplam_tutar = trim($toplam_tutar);

			$gonderi_bilgileri = array(
				"cargoKey" => $siparis_no,
				"invoiceKey" => $siparis_no,
				"receiverCustName" => $adi." ".$soyadi,
				"receiverAddress" => $adres,
				"cityName" => $sehir_adi,
				"townName" => $semt_adi,
				"taxOfficeId" => NULL,
				"taxNumber" => NULL,
				"taxOfficeName" => NULL,
				"ttDocumentId" => $siparis_no,
				"ttCollectionType" => "1",
				"ttInvoiceAmount" => $toplam_tutar,
				"ttInvoiceAmountSpecified" => true,
				"ttDocumentSaveType" => "0",
				"dcSelectedCredit" => "3",
				"dcCreditRule" => "1",
				"receiverPhone1" => $telefon,
				"desi" => $desi,
				"kg"   => "1",
				"cargoCount" => "1",
				"description" => "Kargo"

			);

		} else {

			$wsUserName = "COLORINGO";
			$wsPassword = "C300062Ua8Z9sRMy";
			$userLanguage = "TR";

			$gonderi_bilgileri = array(
				"cargoKey" => $siparis_no,
				"invoiceKey" => $siparis_no,
				"receiverCustName" => $adi." ".$soyadi,
				"receiverAddress" => $adres,
				"cityName" => $sehir_adi,
				"townName" => $semt_adi,
				"taxOfficeId" => NULL,
				"taxNumber" => NULL,
				"taxOfficeName" => NULL,
				"ttDocumentId" => NULL,
				"dcSelectedCredit" => NULL,
				"dcCreditRule" => NULL,
				"receiverPhone1" => $telefon,
				"desi" => $desi,
				"kg"   => "1",
				"cargoCount" => "1",
				"description" => "Kargo"
			);

		}

		$client = new SoapClient($wsdl,array("trace" => 1, "exceptions" => 1,'encoding' => 'utf-8'));

		$gonder = $client->createShipment(array('ShippingOrderVO'=>$gonderi_bilgileri,'wsUserName'=>$wsUserName,'wsPassword'=>$wsPassword,'userLanguage'=>$userLanguage));


		if ($gonder->ShippingOrderResultVO->outFlag == "0") {

			$status = true;
			$id = $order_data['order_id'];
			$message = $gonder->ShippingOrderResultVO->outResult;

			$this->db->query("INSERT INTO " . DB_PREFIX . "kargo_entegrasyon SET order_id = '".$order_data['order_id']."', kargo_adi = 'yurtici', takip_no = 'Bekleniyor', durum = '1'");

			$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '".$order_data['order_id']."', order_status_id = '".$kargo_hazir_id."', notify = '0', date_added = NOW()");

			$this->db->query("UPDATE " . DB_PREFIX . "order SET order_status_id = '".$kargo_hazir_id."' WHERE order_id = '".$order_data['order_id']."'");

		}else{
			$responseArr = $gonder->ShippingOrderResultVO->shippingOrderDetailVO;
			$status = false;
			$id = $order_data['order_id'];
			$message = $responseArr->errMessage;

		}

		echo json_encode(array('status' => $status, 'id' => $id, 'message' => $message));

	}

    private function getOrderData($order_id) {

		$this->load->model('sale/order');
		$order_info = $this->model_sale_order->getOrder($order_id);

		$telefon = $order_info["telephone"];

		$telefon_bosluksuz = str_replace(" ","",$telefon);
		$telefon_ilk = substr($telefon_bosluksuz,0,1);

		if ($telefon_ilk == "0") {
			$telefon = substr($telefon_bosluksuz,-10);
		} else {
			$telefon = $telefon_bosluksuz;
		}

        $order_data = array(
            'order_id' 	 		=> $order_info['order_id'],
            'adi'		 		=> $order_info['shipping_firstname'],
            'soyadi' 	 		=> $order_info['shipping_lastname'],
            'adres' 	 		=> $order_info['shipping_address_1'],
            'semt_adi' 	 		=> $order_info['shipping_city'],
            'sehir_adi'  		=> $order_info['shipping_zone'],
            'toplam_tutar' 		=> round($order_info["total"],2),
            'payment_code'   	=> $order_info['payment_code'],
            'telefon' 		 	=> $telefon,
        );

        return $order_data;

    }

}
