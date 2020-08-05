<?php
// Heading
$_['heading_title']				= '<b><i class="fa fa-fw fa-refresh" style="color:#2E52A4"></i></b> <b>Gelişmiş Sipariş Yönetimi Modülü</b>';

$_['module_title']				= '<span>Gelişmiş Sipariş Yönetimi Modülü</span> ';

// Text
$_['text_module']				= 'Modüller';
$_['text_success']         		= 'Başarılı, Düzenlemeler yapıldı.';

// Tabs
$_['text_tab_0']					= 'Mağazalar';
$_['entry_method']	= 'Güncelleme Yöntemi:<span class="help">Opencart API çalışmaz ise bunu deneyin</span>';
$_['text_api']	= 'Opencart API';
$_['text_internal']	= 'Hızlı Sipariş Düzenleme';
$_['entry_bg_mode']	= 'Renk:<span class="help">Her bir sipariş durumunun hangi renkte görüneceğini seçin</span>';
$_['entry_bg_mode_text']	= 'Sadece Yazı Formatı';
$_['entry_bg_mode_cell']	= 'Hücre';
$_['entry_bg_mode_row']	= 'Full Satır';
$_['entry_bg_mode_label']	= 'Etiket';
$_['entry_tracking_column']	 = 'Kargo Kolonu:<span class="help">Kargo takip numarası olan bir kolon görünsün.</span>';
$_['entry_notify']			  = 'Bildirim İşaretli Gelsin:<span class="help">Müşteriye bildir butonu işaretli gelsin.</span>';
$_['entry_barcode']	  = 'Barkod:<span class="help">Barkod taramasında otomatik olarak sipariş durumu güncelleme formunu açar, ayrıca sipariş numarasını manuel olarak girip yazarak da çalışır.</span>';
$_['entry_barcode_enabled']	  = 'Barkod Durumu:<span class="help">Barkod okuyucusu aktif veya pasif olsun.</span>';
$_['entry_fraud_coupon_off']	  = 'Kupon Sahtekarlığını Düzelt:<span class="help">3.0 sürümünde kupon kullanıldığında sahtekarlık algılamasını düzelt.</span>';
$_['entry_message_mode']	      = 'Email Mesaj:<span class="help">Sipariş durumunu güncellerken e-posta nasıl olacağını seçin
</span>';
$_['text_message_mode_default']	      = 'Varsayılan - İçerisinde yönetici yorumu yazan varsayılan opencart mesajı';
$_['text_message_mode_msgonly']	      = 'Yönetici yorumu - E-posta yönetici yorumudur (veya boşsa varsayılan opencart mesajıdır)';
$_['entry_extra_info']	        = 'Extra Bilgi:<span class="help">Sipariş için ilave bilgi alanı oluştur.</span>';
$_['entry_extra_info_help']	= 'Available tags (full list in docs):<br/>';

$_['text_tab_1']					= 'Kargo Takip';
$_['entry_shipping_title']	= 'Kargo Firması:';
$_['entry_shipping_url']		= 'Url:';
$_['tab_add_shipping']		= 'Ekle';
$_['text_info_tracking']		= '';

$_['text_tab_2']					= 'Sipariş Durumları';
$_['entry_message']			= 'Öntanımlı Mesaj:<br/><br/><span class="help">Bu sipariş durumu seçildiğinde kutucuğa yazılan mesaj otomatik müşteriye gönderilir.</br>Manuel mesaj ve değişkenlrei kullanarak fotmat hazırlayabilirsiniz.</span>';
$_['entry_next_status']		= 'Bir Sonraki Durum:<span class="help">Pencere açıldığında default olarak bu durum seçili gelir</span>';
$_['entry_status_color']		= 'Renk:<span class="help"></span>';

$_['text_tab_3']					= 'Özel Tanımlı Alanlar';
$_['tab_add_input']			= 'Ekle';
$_['entry_input_title']			= 'Başlık:';
$_['entry_input_tag']			= 'Etiket:';
$_['info_msg_custom_tags'] = '<p>Kendi etiketinizi oluşturun. Bu sipariş durumu güncelleme penceresinde görünecektir.</p><p>Bu şekilde kullanın <b class="tag">{tag_name}</b></p><p>Sorgu şeklinde de kullanabilirsiniz <b class="tag">{if_tag_name}</b>...<b class="tag">{/if_tag_name}</b> eğer bir değer varsa o değeri göstersin gibi.</p><p class="text-center"><img class="img-thumbnail" style="width:75%" src="view/quick_status_updater/info/custom_inputs.png" alt="" /></p>';

$_['text_tab_about']			= 'Hakkında';

// Buttons
$_['button_save']				= 'Kaydet';
$_['button_save_close']		= 'Kaydet & Kapat';
$_['button_cancel']				= 'İptal';

// order list page
$_['text_qosu_column_tracking']				= 'Kargo Takip';
$_['text_qosu_unknown']				= 'Tanımsiz Sipariş ID:';
$_['text_qosu_add_history']				= 'Güncelleme durumu';
$_['text_qosu_order_id']						= 'Sipariş id';
$_['text_qosu_dialog_title']					= 'Sipariş Durumunu Güncelle';
$_['text_qosu_tracking_number']		= 'Kargo Takip #';
$_['text_qosu_select_checkbox']			= 'En az bir tanesini seçiniz';
$_['text_qosu_order_status']				= 'Sipariş Durumu:';
$_['text_qosu_notify']							= 'Müşteriye Bildir';
$_['text_qosu_comment']					= 'Sipariş Notu:';
$_['text_qosu_barcode']					= 'Barkodu Aktif/Pasif';


// Error
$_['error_permission']		= 'Hata! Düzenleme yetkiniz yok.';
$_['error_curl'] = 'Curl Hatası - Kod: %d; Mesaj: %s';


// Info
$_['text_howto']					= 'Nasıl Çalışır ?';
$_['info_title_default']					= 'Yardım';
$_['info_msg_default']	= 'Bu konuda bir yardım bulunmuyor';

$_['info_title_color_mode']	= 'Renk Yönetimi ';
$_['info_msg_color_mode']	= '<div class="infoblock indent-left"><div class="context">1</div><p><b>Sadece Yazı:</b> Sadece sipariş durumu yazısını renklendir</p><p><img class="img-thumbnail" src="view/quick_status_updater/info/bgcolor_text.png" alt="" /></p></div>
<div class="infoblock indent-left"><div class="context">2</div><p><b>Etiket:</b> Hücre içinde etiketi renklendir</p><p><img class="img-thumbnail" src="view/quick_status_updater/info/bgcolor_label.png" alt="" /></p></div>
<div class="infoblock indent-left"><div class="context">3</div><p><b>Hücret:</b> Hücrenin içini renklendir</p><p><img class="img-thumbnail" src="view/quick_status_updater/info/bgcolor_cell.png" alt="" /></p></div>
<div class="infoblock indent-left"><div class="context">4</div><p><b>Full Satır:</b> Tüm satırı renklendir</p><p><img class="img-thumbnail" src="view/quick_status_updater/info/bgcolor_row.png" alt="" /></p></div>
';

$_['info_title_extra_info']	= 'Ek Bilgi';
$_['info_msg_extra_info']	= '<p>Bazı özel alanlar ekleyebilirsiniz. Bu sadece hızlı bakış penceresinde görünür.<br/>Örnek "Müşteri: <b class="tag">{customer}</b>" popup penceresinde görünür:</p><p class="text-center"><img class="img-thumbnail" src="view/quick_status_updater/info/extra_info.png" alt="" /></p><hr /><h4 class="text-center">Etiketler</h4>';

$_['info_title_tracking_url']	= 'Kargo Takip';
$_['info_msg_tracking_url']	= '<p>Kargo firmasının takip urlsini girin. Böylece kargoya verildiğinde müşteriye otomatik takip linki gönderilebilir.</p>
<h5>2 yöntem kullanılabilir</h5>
<div class="infoblock indent-left"><div class="context">1</div><p>Kargo firmaları sabit bir linkin sonuna takip kodu ekleterek sorgulama yapar. Bu alana o url yi yazın.</p><p><img class="img-thumbnail" src="view/quick_status_updater/info/tracking1.png" alt="" /></p><p>Mesaj içeriğine de bu şekilde yazın <b class="tag">{tracking_url}{tracking_no}</b></p></div>
<div class="infoblock indent-left"><div class="context">2</div><p>URL ve etiketi bitişik şekilde yazın <b class="tag">kargolink{tracking_no}</b></p><p><img class="img-thumbnail" src="view/quick_status_updater/info/tracking2.png" alt="" /></p><p>Mesaj içeriğine sadece bu etiketi yazın<b class="tag">{tracking_url}</b></p></div>
<h5>Etiketler</h5>
<p class="infotags">
<span><b class="tag">{tracking_no}</b> Takip No</span>
<span><b class="tag">{shipping_postcode}</b> Teslimat Posta Kodu</span>
<span><b class="tag">{shipping_postcode_uk}</b> Posta Kodu (İngiltere Formatı)</span>
<span><b class="tag">{payment_postcode}</b> Fatura Posta Kodu</span>
<span><b class="tag">{lang}</b> Dil Kodu (tr, en, fr, es, ...)</span>
<span><b class="tag">{LANG}</b> Dil Kodu (TR, EN, FR, ES, ...)</span>
</p>
';


$_['info_title_tags']	= 'Etiketler';
$_['info_msg_tags_spec']	= '
<div class="infotags">
<h5>Özel Etiketler</h5>
<p>
<span><b class="tag">{tracking_url}</b> Takip url</span>
<span><b class="tag">{tracking_no}</b> Takip No</span>
<span><b class="tag">{tracking_title}</b> Kargo Takip Başlık</span>
<span><b class="tag">{if_tracking}...{/if_tracking}</b> Kargo varsa </span>
</p>
</div>';
$_['info_msg_tags']	= '
<div class="infotags">
<h5>Müşteri</h5>
<p>
<span><b class="tag">{customer_id}</b> Müşteri ID</span>
<span><b class="tag">{customer}</b> İsim Soyisim</span>
<span><b class="tag">{firstname}</b> İsim</span>
<span><b class="tag">{lastname}</b> Soyisim</span>
<span><b class="tag">{telephone}</b> Telefon</span>
<span><b class="tag">{email}</b> Eposta</span>
</p>
<h5>Sipariş</h5>
<p>
<span><b class="tag">{order_id}</b> Sipariş ID</span>
<span><b class="tag">{invoice_no}</b> Fatura Numarası</span>
<span><b class="tag">{invoice_prefix}</b> Fatura Ön Eki</span>
<span><b class="tag">{comment}</b> Sipariş Notu</span>
<span><b class="tag">{total}</b> Toplam</span>
<span><b class="tag">{reward}</b> Ödül</span>
<span><b class="tag">{commission}</b> Komisyon</span>
<span><b class="tag">{language_code}</b> Dil Kodu</span>
<span><b class="tag">{currency_code}</b> Para Birimi Kodu</span>
<span><b class="tag">{currency_value}</b> Kur Değeri</span>
<span><b class="tag">{amazon_order_id}</b> Amazon Sipariş ID</span>
</p>
<h5>Ödeme</h5>
<p>
<span><b class="tag">{payment_firstname}</b> İsim</span>
<span><b class="tag">{payment_lastname}</b> Soyisim</span>
<span><b class="tag">{payment_company}</b> Şirket</span>
<span><b class="tag">{payment_address_1}</b> Adres 1</span>
<span><b class="tag">{payment_address_2}</b> Adres 2</span>
<span><b class="tag">{payment_postcode}</b> Posta Kodu</span>
<span><b class="tag">{payment_city}</b> Şehir</span>
<span><b class="tag">{payment_zone}</b> Bölge</span>
<span><b class="tag">{payment_country}</b> Ülke</span>
<span><b class="tag">{payment_method}</b> Metod</span>
</p>
<h5>Kargo</h5>
<p>
<span><b class="tag">{shipping_firstname}</b> İsim</span>
<span><b class="tag">{shipping_lastname}</b> Soyisim</span>
<span><b class="tag">{shipping_company}</b> Şirket</span>
<span><b class="tag">{shipping_address_1}</b> Adres 1</span>
<span><b class="tag">{shipping_address_2}</b> Adres 2</span>
<span><b class="tag">{shipping_postcode}</b> Posta Kodu</span>
<span><b class="tag">{shipping_postcode_uk}</b> Posta Kodu (İngiltere Formatı)</span>
<span><b class="tag">{shipping_city}</b> Şehir</span>
<span><b class="tag">{shipping_zone}</b> Bölge</span>
<span><b class="tag">{shipping_country}</b> Ülke</span>
<span><b class="tag">{shipping_method}</b> Metod</span>
</p>
<h5>Diğer</h5>
<p>
<span><b class="tag">{store_name}</b> Mağaza Adı</span>
<span><b class="tag">{store_url}</b> Mağaza URL</span>
<span><b class="tag">{store_email}</b> Mağaza E-posta</span>
<span><b class="tag">{store_phone}</b> Mağaza Telefon</span>
<span><b class="tag">{ip}</b> Müşteri IP</span>
<span><b class="tag">{user_agent}</b> Kullanıcı</span>
</p>
<h5>Pro E-posta Şablonu</h5>
<p>
Pro E-posta Şablonu modülü yüklüyse, bu uzantının belirli etiketlerini de kullanabilirsiniz.</p>
<p>
<span><b class="tag">[link=URL][/link]</b> Link (URL veya etiketle değiştir
)</span>
<span><b class="tag">[button=URL][/button]</b> Buton (URL veya etiketle değiştir)</span>
</p>
</div>';
?>