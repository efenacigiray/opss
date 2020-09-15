<?php
class ControllerCommonMngkargo extends Controller {

    public function index() {
        $kargoya_verildi_id = '3';
        $teslim_edildi_id = '19';
        $kargo_kontrol = $this->db->query("select * from kargo_takip where durum in(1, 10)");

        if ($kargo_kontrol->rows) {
            foreach ($kargo_kontrol->rows AS $row) {
                $sipontag = '';
                $MngInfo = array(
                    'pKullaniciAdi' => '124399974',
                    'pSifre' => 'EYVWKJDW',
                    'pSiparisNo' => $sipontag . $row['order_id']
                );

                $durum_bak = $this->checkMngKargo($MngInfo);

                $kargoDurumu = $durum_bak[0]['FaturaSiparisListesi'];
                if ($kargoDurumu['KARGO_STATU'] == 0) {
                    $takipno = 'Bekleniyor';
                } else {
                    $takipno = $kargoDurumu['CH_FATURA_SERI'] . $kargoDurumu['CH_FATURA_NO'];
                }

                echo "Sipariş No: " . $row['order_id'] . ", " . $kargoDurumu['KARGO_STATU_ACIKLAMA'] . "<br />";

                if ((int) $kargoDurumu['KARGO_STATU'] == 5 || (int) $kargoDurumu['KARGO_STATU'] == 7) {
                    echo "orderid: ".$row['order_id'].", statusid: Tamamlandı<br />";
                    $this->updateSiparis($row['order_id'], $teslim_edildi_id, $takipno);
                    $this->db->query("update kargo_takip set durum = '100' where order_id = '".$row['order_id']."'");
                } elseif ((int) $kargoDurumu['KARGO_STATU'] == 1 || (int) $kargoDurumu['KARGO_STATU'] == 2 ||
                          (int) $kargoDurumu['KARGO_STATU'] == 3 || (int) $kargoDurumu['KARGO_STATU'] == 4) {
                    echo "Sipariş No: ".$row['order_id'].", Takip No: ".$takipno.", Başarılı.<br />";
                    $this->updateSiparis($row['order_id'], $kargoya_verildi_id, $takipno);
                    $this->db->query("update kargo_takip set takip_no = '".$takipno."', durum = '10' where order_id = '".$row['order_id']."'");
                }
            }
        } else {
            echo "Veri Bulunamadı";
        }
    }

    public function checkMngKargo($MngInfo) {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://service.mngkargo.com.tr/musterikargosiparis/musterikargosiparis.asmx/FaturaSiparisListesi");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($MngInfo));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        $sxe = new SimpleXMLElement($server_output);

        $sxe->registerXPathNamespace('d', 'urn:schemas-microsoft-com:xml-diffgram-v1');

        $result = $sxe->xpath("//NewDataSet");

        $xmlParsed = json_decode(json_encode((array) $result), TRUE);

        curl_close($ch);

        return $xmlParsed;

    }

    public function updateSiparis($sipid, $durum, $takip_no) {
        $xq = $this->db->query("select * from order_history where order_id = '" . $sipid . "' and order_status_id = '" . $durum . "'");
        if ($xq->num_rows >= 1) {
        } else {
            $result = $this->db->query("UPDATE `order` SET order_status_id = '" . $durum . "' WHERE order_id= '" . (int) $sipid . "'");
            $this->db->query("insert into order_history set order_id = '" . $sipid . "', order_status_id = '" . $durum . "', notify = '0', date_added = NOW()");
        }
    }
}