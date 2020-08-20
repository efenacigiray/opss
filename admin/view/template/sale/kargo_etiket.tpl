<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="" lang="turkish" xml:lang="turkish">
    <head>
        <title>Kargo Etiketi</title>
        <base href="<?php echo $base; ?>" />
        <link rel="stylesheet" type="text/css" href="view/kargo/kargo-etiket.css" />
		<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
		<script src="view/kargo/JsBarcode.all.min.js"></script>
		  <script type="text/javascript">
		  $(document).ready(function () {
		  JsBarcode(".barcode").init();
		  });
		  </script>		
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
    </head>
    <body>
	<style>
.col-sm-3 {
    float: left;
    width: 24.4%;
    text-align: center;
    border: 1px solid;
}
.col-sm-9 {
    float: left;
    width: 74%;
    text-align: center;
    border: 1px solid;
}
.col-sm-12 {
    float: left;
    width: 99%;
    text-align: center;
    border: 1px solid;
}
</style>	
	<table class='main'>
	<tr>
        <?php foreach ($orders as $order) { ?>	
	<td>
		<table width="400px" height="100%" class="tabela1" cellspacing="0">
			<tr><td width="100%">
			<div class="col-sm-12"><span class="style6"><?php echo $order['baslik']; ?></span></div>
			</td></tr>
			
			<tr><td width="100%">
			<div class="col-sm-3"><span class="style1">MÜŞTERİ NO:</span></div>
			<div class="col-sm-3"><span class="style1"><?php echo $order['musteri_no']; ?></span></div>
			<div class="col-sm-3"><span class="style1">SİPARİŞ NO:</span></div>
			<div class="col-sm-3"><span class="style1"><?php echo $order['order_id']; ?></span></div>
			</td></tr>
			
			<tr><td width="100%">
			<div class="col-sm-3"><span class="style1">GÖND. AD:</span></div>
			<div class="col-sm-9"><span class="style1"><?php echo $order['store_name']; ?></span></div>
			</td></tr>
			
			<tr><td width="100%">
			<div class="col-sm-3" style="height: 60px;"><span class="style1">GÖND. ADRES:</span></div>
			<div class="col-sm-9" style="height: 60px;"><span class="style1"> <?php echo $order['store_address']; ?></span></div>
			</td></tr>
		
			<tr><td width="100%">
			<div class="col-sm-12"><span class="style1">
			<?php if ($order['barkod']) { ?>
							<?php if ($order['kargo_adi'] == 'ptt') { ?>
								<img src="../barkod.php?code=<?php echo $order['barkod']; ?>" width="250" height="70">
							<?php } else { ?>	
								<svg class="barcode" jsbarcode-format="CODE128" jsbarcode-value="<?php echo $order['barkod']; ?>" jsbarcode-textmargin="0" jsbarcode-height='50'></svg>	
							<?php } ?>
						<?php } ?>
			</span></div>			
			</td></tr>

			<tr><td width="100%">
			<div class="col-sm-3"><span class="style1">ALICI AD:</span></div>
			<div class="col-sm-9"><span class="style1"><?php echo $order['firstname']; ?> <?php echo $order['lastname']; ?></span></div>
			</td></tr>
			
			<tr><td width="100%">
			<div class="col-sm-3" style="height: 60px;"><span class="style1">ALICI ADRES:</span></div>
			<div class="col-sm-9" style="height: 60px;"><span class="style1"><?php echo $order['address_1']; ?></span></div>
			</td></tr>

			<tr><td width="100%">
			<div class="col-sm-3"><span class="style1">ALICI TEL:</span></div>
			<div class="col-sm-9"><span class="style1"><?php echo $order['telephone']; ?></span></div>
			</td></tr>
			
			<tr><td width="100%">
			<div class="col-sm-3"><span class="style1">ALICI İL:</span></div>
			<div class="col-sm-3"><span class="style1"><?php echo $order['zone']; ?></span></div>
			<div class="col-sm-3"><span class="style1">ALICI İLÇE:</span></div>
			<div class="col-sm-3"><span class="style1"><?php echo $order['city']; ?></span></div>
			</td></tr>
			
			<tr><td width="100%">
			<div class="col-sm-3"><span class="style1">ÖDEME TİPİ:</span></div>
			<div class="col-sm-9"><span class="style1"><?php echo $order['payment_method']; ?></span></div>
			</td></tr>
			
			<tr><td width="100%">
			<div class="col-sm-3"><span class="style1">EK HİZMET:</span></div>
			<div class="col-sm-9">
			<?php if($order['payment_code'] == 'cod') { ?>	
				<span class="style1">Ödeme Şartlı ( Tahsilatlı )</span>
			<?php } else { ?>
				<span class="style1">-</span>
			<?php } ?>
			</div>
			</td></tr>
			
			<tr><td width="100%">
			<div class="col-sm-3"><span class="style1">ÖDEME ŞARTI:</span></div>
			<div class="col-sm-9">
			<?php if($order['payment_code'] == 'cod') { ?>	
				<span class="style1"><?php echo $order['total']; ?></span>
			<?php } else { ?>
				<span class="style1">-</span>
			<?php } ?>	
				</div>
			</td></tr>
			<tr><td width="100%">
			<div class="col-sm-12" style="padding-bottom: 10px; padding-top: 10px;"><span class="style6"><?php echo $order['city']; ?> / <?php echo $order['zone']; ?></span></div>
			</td></tr>								
        </table>
</td>
</tr>
 <?php } ?>
</table>		

    </body>
</html>

