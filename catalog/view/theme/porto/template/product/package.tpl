<?php echo $header;
$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_top.tpl'); ?>
<div class="table-responsive cart-info">
    <h3>SINIFINIZ İÇİN SATIŞA SUNULAN AŞAĞIDAKİ TÜM ÜRÜNLER VE ADETLERİ, OKULUNUZCA VE ÖĞRETMENLERİNİZ TARAFINDAN BELİRLENMİŞTİR.</h3>
    <?php foreach ($packages as $package) { ?>
    <h4><?php echo $package['name']; ?></h4>
    <table class="table table-bordered package-table">
        <thead>
            <tr>
                <td class="text-center">
                    <a onclick="updateWholePackage(this, <?php echo $package['package_id']; ?>);" data-state="remove">
                        <i alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" class="fa fa-check green"></i>
                    </a>
                </td>
                <td class="text-center"><?php echo $column_image; ?></td>
                <td class="text-center"><?php echo $column_name; ?></td>
                <td class="text-center">Ürün Bilgisi</td>
                <td class="text-center"><?php echo $column_quantity; ?></td>
                <td class="text-right"><?php echo $column_price; ?></td>
                <td class="text-right">Toplam Fiyatı</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($package['products'] as $product) { ?>
            <tr>
                <td class="text-center">
                    <?php if ($product['in_package']): ?>
                    <a data-package-id="<?php echo $package['package_id'] ?>" data-product-id="<?php echo $product['product_id'] ?>" onclick="updatePackage(this, '<?php echo $product['product_id']; ?>', '<?php echo $product['type'] ?>', <?php echo $package['package_id']; ?>);" data-state="remove">
                        <i alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" class="fa fa-check green"></i>
                    </a>
                    <?php elseif ($product['purchased_before']): ?>
                    <a data-package-id="<?php echo $package['package_id'] ?>" data-product-id="<?php echo $product['product_id'] ?>" onclick="updatePackage(this, '<?php echo $product['product_id']; ?>', '<?php echo $product['type'] ?>', <?php echo $package['package_id']; ?>);" data-state="add">
                        <i alt="Ekle" title="Ekle" class="fa fa-recycle"></i>
                    </a>
                    <?php else: ?>
                    <a data-package-id="<?php echo $package['package_id'] ?>" data-product-id="<?php echo $product['product_id'] ?>" onclick="updatePackage(this, '<?php echo $product['product_id']; ?>', '<?php echo $product['type'] ?>', <?php echo $package['package_id']; ?>);" data-state="add">
                        <i alt="Ekle" title="Ekle" class="fa fa-times red"></i>
                    </a>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?php if ($product['thumb']) { ?>
                    <a href="<?php echo $product['href']; ?>">
                        <img class="package-image" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" />
                    </a>
                    <?php } ?>
                </td>
                <td class="text-center">
                    <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                    <?php if (!$product['stock']) { ?>
                    <span class="text-danger">***</span>
                    <?php } ?>
                </td>
                <td class="text-center">
                    <span style="color:#0088CC;"><?php echo $product['package_description']; ?></span>
                    <?php if ($product['purchased_before'] === 1): ?>
                    <br><span style="color:red; font-size: 12px !important;">Bu ürünü daha önce online olarak satın aldınız!</span>
                    <br><span style="font-size: 12px !important">Sipariş Tarihi: <?php echo $product['date_purchased'] ?></span>
                    <br><a style="font-size: 12px !important" href="<?php echo $product['order_link'] ?>" target="_blank">Sipariş Detayı</a>
                    <?php endif ?>
                    <?php if ($product['purchased_before'] === 2): ?>
                    <br><span style="color:red; font-size: 12px !important;">Bu ürünü daha önce mağazadan satın aldınız!</span>
                    <br><span style="font-size: 12px !important">Sipariş Tarihi: <?php echo $product['date_purchased'] ?></span>
                    <br><a style="font-size: 12px !important" href="<?php echo $product['order_link'] ?>" target="_blank">Sipariş Detayı</a>
                    <?php endif ?>
                </td>
                <td class="text-left">
                    <?php echo $product['quantity']; ?>
                </td>
                <td class="text-right">
                    <?php if ($product['special']): ?>
                    <span class="package-special"><?php echo $product['original_price'] ? $product['original_price'] : $product['price']; ?></span>
                    <span class="package-price"><?php echo $product['special']; ?></span>
                    <?php else: ?>
                    <span class="package-price"><?php echo $product['price']; ?></span>
                    <?php endif ?>
                </td>
                <td class="text-right">
                    <span class="package-price"><?php echo $product['total_price']; ?></span>
                </td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot id="pkg-<?php echo $package['package_id'] ?>">
        <?php $value = end($package['totals']); ?>
        <tr>
            <td colspan="6" class="text-right"><?php echo $value['title'] ?></td>
            <td class="text-right"><?php echo $value['text'] ?></td>
        </tr>
        </tfoot>
    </table>
    <?php } ?>
</div>
<div class="cart-total">
    <table>
        <?php foreach ($totals as $total) { ?>
        <tr>
            <td class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
            <td class="text-right"><?php echo $total['text']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
<div class="buttons">
    <div class="pull-right"><a href="<?php echo $checkout; ?>" class="btn btn-primary">Seçilenleri Sepete Ekle</a></div>
</div>
<script type="text/javascript">
    function updatePackage(element, product_id, type, package_id) {
        if ($(element).attr("data-state") == "remove") {
            return removePackage(element, product_id, type, package_id);
        }
        return addPackage(element, product_id, package_id, type)
    }
    function addPackage(element, product_id, package_id, type) {
        if (type == 3) {
            alert('Bu ürün pakete tek başına eklenemez! Eğer satın almak istemiyorsanız, tüm paketi listeye ekleyiniz!');
            return;
        }

        $(element).children('i').removeClass('fa-times red fa-recycle').addClass('fa-spinner -pulse')
        $.get('index.php?route=product/package/add&product_id=' + product_id + "&package_id=" + package_id)
        .success(
            function(response) {
                console.log(element)
                totals = JSON.parse(response);
                html = '<table>';
                for (var i = totals.general.length - 1; i >= 0; i--) {
                    html += '<tr><td class="text-right">' + totals.general[i].title + ':</strong></td>';
                    html += '<td class="text-right">' + totals.general[i].text + '</td></tr>';
                }
                html += '</table>';
                $('div.cart-total').html(html);

                html = '';
                html += '<tr><td colspan="6" class="text-right">' + totals.package[0].title + ':</strong></td>';
                html += '<td class="text-right">' + totals.package[0].text + '</td></tr>';

                $('#pkg-' + package_id).html(html)
                $(element).attr("data-state", "remove").children('i').removeClass('fa-spinner -pulse').addClass('fa-check green').attr('title', 'Kaldır');
            }
        );
    }
    function removePackage(element, product_id, type, package_id) {
        if (type == 3) {
            alert('Bu ürün paketten çıkarılamaz! Eğer satın almak istemiyorsanız, tüm paketi listeden çıkarınız!');
            return;
        }
        if (type == 2) {
            if (!confirm('Ürün pakatten çıkarılacaktır!')) {
                return False
            }
        }
        $(element).children('i').removeClass('fa-check green').addClass('fa-spinner -pulse')
        $.get('index.php?route=product/package/remove&product_id=' + product_id + "&package_id=" + package_id)
        .success(
            function(response) {
                totals = JSON.parse(response);
                html = '<table>';
                for (var i = totals.general.length - 1; i >= 0; i--) {
                    html += '<tr><td class="text-right">' + totals.general[i].title + ':</strong></td>';
                    html += '<td class="text-right">' + totals.general[i].text + '</td></tr>';
                }
                html += '</table>';
                $('div.cart-total').html(html);
                html = '';
                html += '<tr><td colspan="6" class="text-right">' + totals.package[0].title + ':</strong></td>';
                html += '<td class="text-right">' + totals.package[0].text + '</td></tr>';

                $('#pkg-' + package_id).html(html)
                $(element).attr('data-state', 'add').children('i').removeClass('fa-spinner -pulse').addClass('fa-times red').attr('title', 'Ekle');
            }
        );
    }

    function removeWhole(package_id) {
        $.get('index.php?route=product/package/remove_whole&package_id=' + package_id).success(
            function(response) {
                totals = JSON.parse(response);
                html = '<table>';
                for (var i = totals.general.length - 1; i >= 0; i--) {
                    html += '<tr><td class="text-right">' + totals.general[i].title + ':</strong></td>';
                    html += '<td class="text-right">' + totals.general[i].text + '</td></tr>';
                }
                html += '</table>';
                $('div.cart-total').html(html);
                html = '';
                html += '<tr><td colspan="6" class="text-right">' + totals.package[0].title + ':</strong></td>';
                html += '<td class="text-right">' + totals.package[0].text + '</td></tr>';

                $('#pkg-' + package_id).html(html)
            }
        );
    }

    function addWhole(package_id) {
        $.get('index.php?route=product/package/add_whole&package_id=' + package_id).success(
            function(response) {
                totals = JSON.parse(response);
                html = '<table>';
                for (var i = totals.general.length - 1; i >= 0; i--) {
                    html += '<tr><td class="text-right">' + totals.general[i].title + ':</strong></td>';
                    html += '<td class="text-right">' + totals.general[i].text + '</td></tr>';
                }
                html += '</table>';
                $('div.cart-total').html(html);
                html = '';
                html += '<tr><td colspan="6" class="text-right">' + totals.package[0].title + ':</strong></td>';
                html += '<td class="text-right">' + totals.package[0].text + '</td></tr>';

                $('#pkg-' + package_id).html(html)
            }
        );
    }

    function updateWholePackage(element, package_id) {
        if ($(element).attr('data-state') == 'remove') {
            if (!confirm('Tüm paket ürünleri listeden çıkarılacaktır!')) {
                return false
            }
            $(element).attr('data-state', 'add').children('i').removeClass('fa-check green').addClass('fa-times red').attr('title', 'Ekle');
            removeWhole(package_id);
            $.each($(document).find('[data-package-id="' + package_id + '"] '), function(index, sub_element) {
                $(sub_element).attr('data-state', 'add').children('i').removeClass('fa-check green').addClass('fa-times red').attr('title', 'Ekle')
            });
        } else {
            $(element).attr("data-state", "remove").children('i').removeClass('fa-times red').addClass('fa-check green').attr('title', 'Kaldır');
            addWhole(package_id);
            $.each($(document).find('[data-package-id="' + package_id + '"]'), function(index, sub_element) {
                $(sub_element).attr('data-state', 'remove').children('i').removeClass('fa-times red').addClass('fa-check green').attr('title', 'Kaldır')
            });
        }
    }
</script>
<?php include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>