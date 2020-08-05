<?php if($registry->has('theme_options') == true) {
$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
$cart_info = $theme_options->getCart(); ?>

<?php if($theme_options->get( 'header_type' ) == 3 || $theme_options->get( 'header_type' ) == 6 || $theme_options->get( 'header_type' ) == 10 || $theme_options->get( 'header_type' ) == 14 || $theme_options->get( 'header_type' ) == 15 || $theme_options->get( 'header_type' ) == 17 || $theme_options->get( 'header_type' ) == 18 || $theme_options->get( 'header_type' ) == 19 || $theme_options->get( 'header_type' ) == 20) { ?>
<div id="mini-cart" class="minicart-inline dropdown">
    <div class="dropdown-toggle cart-head" data-toggle="dropdown">
        <i class="minicart-icon"></i>
        <span class="cart-items" id="total_item_ajax"><span id="total_item"><?php echo $cart_info['total_item']; ?> <span class="hidden-xs"><?php if($theme_options->get( 'shopping_cart_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'shopping_cart_text', $config->get( 'config_language_id' ) ); } else { echo 'item(s)'; } ?> </span></span></span>
    </div>
    <div class="dropdown-menu" id="cart_content"><div id="cart_content_ajax">
        <?php if ($products || $vouchers) { ?>
        <div class="dropdown-cart-content" style="padding: 0px">
            <div class="mini-cart-info">
              <table>
                <?php foreach ($products as $product) { ?>
                <tr>
                  <td class="image"><?php if ($product['thumb']) { ?>
                    <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                    <?php } ?></td>
                  <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                    <div>
                      <?php foreach ($product['option'] as $option) { ?>
                      - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
                      <?php } ?>
                      <?php if ($product['recurring']): ?>
                      - <small><?php echo $text_payment_profile ?> <?php echo $product['profile']; ?></small><br />
                      <?php endif; ?>
                    </div>

                    <div class="price2"><?php echo $product['quantity']; ?> X <?php echo $product['total']; ?></div></td>
                  <td class="remove"><a href="javascript:;" onclick="check_package_status('<?php echo $product['cart_id']; ?>', '<?php echo $product['package_status'];?>')" title="<?php echo $button_remove; ?>">x</a></td>
                </tr>
                <?php } ?>
                <?php foreach ($vouchers as $voucher) { ?>
                <tr>
                  <td class="image"></td>
                  <td class="name"><?php echo $voucher['description']; ?><div class="price2">1 X <?php echo $voucher['amount']; ?></div></td>
                  <td class="remove"><a href="javascript:;" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>">x</a></td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <div class="mini-cart-total">
              <table>
                <?php foreach ($totals as $total) { ?>
                <tr>
                  <td class="right"><b><?php echo $total['title']; ?>:</b></td>
                  <td class="right"><?php echo $total['text']; ?></td>
                </tr>
                <?php } ?>
              </table>
            </div>

            <div class="checkout"><a href="<?php echo $cart; ?>" class="btn btn-default"><?php echo $text_cart; ?></a> &nbsp;<a href="<?php echo $checkout; ?>" class="btn btn-default"><?php echo $text_checkout; ?></a></div>
        </div>
        <?php } else { ?>
        <div class="dropdown-cart-content">
            <ul>
                <li class="empty">
                     <?php echo $text_empty; ?>
                </li>
            </ul>
        </div>
        <?php } ?>
    </div></div>
</div><!-- End .cart-dropdown -->
<?php } elseif($theme_options->get( 'header_type' ) == 22 || $theme_options->get( 'header_type' ) == 23 || $theme_options->get( 'header_type' ) == 27 || $theme_options->get( 'header_type' ) == 28) { ?>
<!-- Cart block -->
<div id="mini-cart" class="dropdown">
    <div class="dropdown-toggle cart-head" data-toggle="dropdown">
        <i class="minicart-icon"></i>
        <span class="cart-items" id="total_item_ajax"><span id="total_item"><?php echo $cart_info['total_item']; ?></span></span>
    </div>

    <div class="dropdown-menu" id="cart_content"><div id="cart_content_ajax">
        <div class="total-count clearfix"><span><?php echo $cart_info['total_item']; ?> <?php if($theme_options->get( 'shopping_cart_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'shopping_cart_text', $config->get( 'config_language_id' ) ); } else { echo 'item(s)'; } ?></span> <a class="link-cart" href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a></div>
        <?php if ($products || $vouchers) { ?>
        <div class="dropdown-cart-content" style="padding: 0px">
            <ol class="mini-products-list">
                <?php foreach ($products as $product) { ?>
                <li class="item">
                    <?php if ($product['thumb']) { ?>
                    <a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>" class="product-image2"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"></a>
                    <?php } ?>
                    <div class="product-details">
                        <p class="product-name">
                            <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                        </p>
                        <p class="qty-price">
                            <?php echo $product['quantity']; ?> X <span class="pricecart"><?php echo $product['total']; ?></span>
                        </p>
                        <a href="javascript:;" onclick="check_package_status('<?php echo $product['cart_id']; ?>', '<?php echo $product['package_status'];?>')" title="<?php echo $button_remove; ?>" class="btn-remove"><i class="fa fa-close"></i></a>
                    </div>
                    <div class="clearer"></div>
                </li>
                <?php } ?>
                <?php foreach ($vouchers as $voucher) { ?>
                <li class="item">
                    <div class="product-details">
                        <p class="product-name">
                            <?php echo $voucher['description']; ?>
                        </p>
                        <p class="qty-price">
                            1 X <span class="pricecart"><?php echo $voucher['amount']; ?></span>
                        </p>
                        <a href="javascript:;" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn-remove"><i class="fa fa-close"></i></a>
                    </div>
                    <div class="clearer"></div>
                </li>
                <?php } ?>
            </ol>
            <?php foreach ($totals as $total) { $title = $total['title']; $text = $total['text']; } ?>
            <div class="totals">
                <span class="total"><?php echo $title; ?>: </span>
                <span class="price-total"><?php echo $text; ?></span>
            </div>

            <div class="actions">
                <a class="btn btn-default" href="<?php echo $checkout; ?>"><i class="icon-right-thin"></i><?php echo $text_checkout; ?></a>
            </div>
        </div>
        <?php } else { ?>
        <div class="empty2"><?php echo $text_empty; ?></div>
        <?php } ?>
    </div></div>
</div>

<?php } elseif($theme_options->get( 'header_type' ) == 24 || $theme_options->get( 'header_type' ) == 26 || $theme_options->get( 'header_type' ) == 29) { ?>
<!-- Cart block -->
<div id="mini-cart" class="dropdown">
    <div class="dropdown-toggle cart-head" data-toggle="dropdown">
        <i class="minicart-icon"></i>
        <span class="cart-items" id="total_item_ajax"><span id="total_item"><?php echo $cart_info['total_item']; ?></span></span>
    </div>

    <div class="dropdown-menu" id="cart_content"><div id="cart_content_ajax">
        <?php if ($products || $vouchers) { ?>
        <div class="dropdown-cart-content" style="padding: 0px">
            <ol class="mini-products-list">
                <?php foreach ($products as $product) { ?>
                <li class="item">
                    <?php if ($product['thumb']) { ?>
                    <a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>" class="product-image2"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"></a>
                    <?php } ?>
                    <div class="product-details">
                        <p class="product-name">
                            <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                        </p>
                        <p class="qty-price">
                            <?php echo $product['quantity']; ?> X <span class="pricecart"><?php echo $product['total']; ?></span>
                        </p>
                        <a href="javascript:;" onclick="check_package_status('<?php echo $product['cart_id']; ?>', '<?php echo $product['package_status'];?>')" title="<?php echo $button_remove; ?>" class="btn-remove"><i class="fa fa-close"></i></a>
                    </div>
                    <div class="clearer"></div>
                </li>
                <?php } ?>
                <?php foreach ($vouchers as $voucher) { ?>
                <li class="item">
                    <div class="product-details">
                        <p class="product-name">
                            <?php echo $voucher['description']; ?>
                        </p>
                        <p class="qty-price">
                            1 X <span class="pricecart"><?php echo $voucher['amount']; ?></span>
                        </p>
                        <a href="javascript:;" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn-remove"><i class="fa fa-close"></i></a>
                    </div>
                    <div class="clearer"></div>
                </li>
                <?php } ?>
            </ol>
            <?php foreach ($totals as $total) { $title = $total['title']; $text = $total['text']; } ?>
            <div class="totals">
                <span class="total"><?php echo $title; ?>: </span>
                <span class="price-total"><?php echo $text; ?></span>
            </div>

            <div class="actions clearfix">
                <a class="btn btn-default" href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a>
                <a class="btn btn-default" href="<?php echo $checkout; ?>"><i class="icon-right-thin"></i><?php echo $text_checkout; ?></a>
            </div>
        </div>
        <?php } else { ?>
        <div class="empty2"><?php echo $text_empty; ?></div>
        <?php } ?>
    </div></div>
</div>

<?php } elseif($theme_options->get( 'header_type' ) == 25) { ?>
<!-- Cart block -->
<div id="mini-cart" class="dropdown">
    <div class="dropdown-toggle cart-head" data-toggle="dropdown">
        <i class="minicart-icon"></i>
        <span class="cart-items" id="total_item_ajax"><span id="total_item"><?php echo $cart_info['total_item']; ?> <span class="hidden-xs"><?php if($theme_options->get( 'shopping_cart_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'shopping_cart_text', $config->get( 'config_language_id' ) ); } else { echo 'item(s)'; } ?> </span></span></span>
    </div>

    <div class="dropdown-menu" id="cart_content"><div id="cart_content_ajax">
        <?php if ($products || $vouchers) { ?>
        <div class="dropdown-cart-content" style="padding: 0px">
            <ol class="mini-products-list">
                <?php foreach ($products as $product) { ?>
                <li class="item">
                    <?php if ($product['thumb']) { ?>
                    <a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>" class="product-image2"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"></a>
                    <?php } ?>
                    <div class="product-details">
                        <p class="product-name">
                            <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                        </p>
                        <p class="qty-price">
                            <?php echo $product['quantity']; ?> X <span class="pricecart"><?php echo $product['total']; ?></span>
                        </p>
                        <a href="javascript:;" onclick="check_package_status('<?php echo $product['cart_id']; ?>', '<?php echo $product['package_status'];?>')" title="<?php echo $button_remove; ?>" class="btn-remove"><i class="fa fa-close"></i></a>
                    </div>
                    <div class="clearer"></div>
                </li>
                <?php } ?>
                <?php foreach ($vouchers as $voucher) { ?>
                <li class="item">
                    <div class="product-details">
                        <p class="product-name">
                            <?php echo $voucher['description']; ?>
                        </p>
                        <p class="qty-price">
                            1 X <span class="pricecart"><?php echo $voucher['amount']; ?></span>
                        </p>
                        <a href="javascript:;" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn-remove"><i class="fa fa-close"></i></a>
                    </div>
                    <div class="clearer"></div>
                </li>
                <?php } ?>
            </ol>
            <?php foreach ($totals as $total) { $title = $total['title']; $text = $total['text']; } ?>
            <div class="totals">
                <span class="total"><?php echo $title; ?>: </span>
                <span class="price-total"><?php echo $text; ?></span>
            </div>

            <div class="actions clearfix">
                <a class="btn btn-default" href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a>
                <a class="btn btn-default" href="<?php echo $checkout; ?>"><i class="icon-right-thin"></i><?php echo $text_checkout; ?></a>
            </div>
        </div>
        <?php } else { ?>
        <div class="empty2"><?php echo $text_empty; ?></div>
        <?php } ?>
    </div></div>
</div>
<?php } else { ?>
<!-- Cart block -->
<div id="mini-cart" class="dropdown">
    <div class="dropdown-toggle cart-head" data-toggle="dropdown">
        <i class="minicart-icon"></i>
        <span class="cart-items" id="total_item_ajax"><span id="total_item"><?php echo $cart_info['total_item']; ?></span></span>
    </div>

    <div class="dropdown-menu" id="cart_content"><div id="cart_content_ajax">
        <?php if ($products || $vouchers) { ?>
        <div class="dropdown-cart-content" style="padding: 0px">
            <div class="mini-cart-info">
              <table>
                <?php foreach ($products as $product) { ?>
                <tr>
                  <td class="image"><?php if ($product['thumb']) { ?>
                    <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                    <?php } ?></td>
                  <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                    <div>
                      <?php foreach ($product['option'] as $option) { ?>
                      - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
                      <?php } ?>
                      <?php if ($product['recurring']): ?>
                      - <small><?php echo $text_payment_profile ?> <?php echo $product['profile']; ?></small><br />
                      <?php endif; ?>
                    </div>

                    <div class="price2"><?php echo $product['quantity']; ?> X <?php echo $product['total']; ?></div></td>
                  <td class="remove"><a href="javascript:;" onclick="check_package_status('<?php echo $product['cart_id']; ?>', '<?php echo $product['package_status'];?>')" title="<?php echo $button_remove; ?>">x</a></td>
                </tr>
                <?php } ?>
                <?php foreach ($vouchers as $voucher) { ?>
                <tr>
                  <td class="image"></td>
                  <td class="name"><?php echo $voucher['description']; ?><div class="price2">1 X <?php echo $voucher['amount']; ?></div></td>
                  <td class="remove"><a href="javascript:;" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>">x</a></td>
                </tr>
                <?php } ?>
              </table>
            </div>
            <div class="mini-cart-total">
              <table>
                <?php foreach ($totals as $total) { ?>
                <tr>
                  <td class="right"><b><?php echo $total['title']; ?>:</b></td>
                  <td class="right"><?php echo $total['text']; ?></td>
                </tr>
                <?php } ?>
              </table>
            </div>

            <div class="checkout"><a href="<?php echo $cart; ?>" class="btn btn-default"><?php echo $text_cart; ?></a> &nbsp;<a href="<?php echo $checkout; ?>" class="btn btn-default"><?php echo $text_checkout; ?></a></div>
        </div>
        <?php } else { ?>
        <div class="dropdown-cart-content">
            <ul>
                <li class="empty">
                     <?php echo $text_empty; ?>
                </li>
            </ul>
        </div>
        <?php } ?>
    </div></div>
</div>
<?php } ?>
<?php } ?>
<script type="text/javascript">
    function check_package_status(product_id, status) {
        if (status == 3) {
            alert("Bu ürün paketten çıkarılamaz!");
            return;
        }

        if (status == 2) {
            if (!confirm('Ürünü pakatten çıkarılacaktır!')) {
                return False
            }
        }

        cart.remove(product_id);
    }
</script>