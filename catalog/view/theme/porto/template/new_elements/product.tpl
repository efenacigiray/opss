<?php
$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
?>
    <div class="product">
        <div class="product-image">
            <figure class="inner-image">
                <a href="<?php echo $product['href']; ?>">
                    <?php $image_swap = ''; if($theme_options->get( 'product_image_effect' ) == '1') {
                        $nthumb = str_replace(' ', "%20", ($product['thumb']));
                        $nthumb = str_replace(HTTP_SERVER, "", $nthumb);
                        $image_size = getimagesize($nthumb);
                        $image_swap = $theme_options->productImageSwap($product['product_id'], $image_size[0], $image_size[1]);
                        if($image_swap != '') echo '<img src="' . $image_swap . '" alt="' . $product['name'] . '" class="product-image-hover" />';
                    } ?>
                    <?php if($theme_options->get( 'lazy_loading_images' ) != '0') { ?>
                    <img src="image/catalog/blank.gif" data-echo="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="<?php if($theme_options->get( 'product_image_effect' ) == '1' && $image_swap != '') { echo 'product-image-normal'; } ?> <?php if($theme_options->get( 'product_image_effect' ) == '2') { echo 'zoom-image-effect'; } ?>" />
                    <?php } else { ?>
                    <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="<?php if($theme_options->get( 'product_image_effect' ) == '1' && $image_swap != '') { echo 'product-image-normal'; } ?> <?php if($theme_options->get( 'product_image_effect' ) == '2') { echo 'zoom-image-effect'; } ?>" />
                    <?php } ?>
                </a>
            </figure>

            <?php if($product['special'] && $theme_options->get( 'display_text_sale' ) != '0') { ?>
                <?php $text_sale = 'Sale';
                if($theme_options->get( 'sale_text', $config->get( 'config_language_id' ) ) != '') {
                    $text_sale = $theme_options->get( 'sale_text', $config->get( 'config_language_id' ) );
                } ?>
                <?php if($theme_options->get( 'type_sale' ) == '1') { ?>
                    <?php $product_detail = $theme_options->getDataProduct( $product['product_id'] );
                    $roznica_ceny = $product_detail['price']-$product_detail['special'];
                    $procent = ($roznica_ceny*100)/$product_detail['price']; ?>
                    <div class="onsale"> %<?php echo round($procent); ?> İndirimli</div>
                <?php } else { ?>
                    <div class="onsale"><?php echo $text_sale; ?></div>
                <?php } ?>
            <?php } ?>
            <?php if($theme_options->get( 'display_text_new' ) != '0' && $theme_options->isLatestProduct( $product['product_id'] )) { ?>
                 <div class="onhot"><?php if($theme_options->get( 'new_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'new_text', $config->get( 'config_language_id' ) ); } else { echo 'New'; } ?></div>
            <?php } ?>

            <?php if($theme_options->get( 'quick_view' ) == 1) { ?>
            <div class="quickview"><a href="index.php?route=product/quickview&product_id=<?php echo $product['product_id']; ?>" class="quickview-icon"><i class="fa fa-eye"></i> &nbsp;<span><?php if($theme_options->get( 'quickview_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'quickview_text', $config->get( 'config_language_id' ) )); } else { echo 'Quick View'; } ?></span></a></div>
            <?php } ?>
        </div><!-- End .product-image -->
        <?php if($theme_options->get( 'display_add_to_wishlist' ) != '0') { ?>
        <a onclick="wishlist.add('<?php echo $product['product_id']; ?>');" class="addwishlist hiddenwishlist" title="Wishlist"><i class="porto-icon-wishlist"></i></a>
        <?php } ?>
        <h3><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h3>
        <?php if ($product['rating'] && $theme_options->get( 'display_rating' ) != '0') { ?>
        <div class="rating-wrap">
            <span class="rating-before"><span class="rating-line"></span></span>
            <div class="rating-content">
                <div class="star-rating add-tooltip" title="<?php echo $product['rating']; ?>.00">
                    <span style="width:<?php echo $product['rating']*20; ?>%"><?php echo $product['rating']; ?>.00</span>
                </div><!-- End .star-rating -->
            </div><!-- End .rating-content -->
            <span class="rating-after"><span class="rating-line"></span></span>
        </div><!-- End .rating-wrap -->
        <?php } elseif($theme_options->get( 'display_rating' ) != '0') { ?>
        <div class="rating-wrap">
            <span class="rating-before"><span class="rating-line"></span></span>
            <div class="rating-content">
                <div class="star-rating add-tooltip">
                </div><!-- End .star-rating -->
            </div><!-- End .rating-content -->
            <span class="rating-after"><span class="rating-line"></span></span>
        </div><!-- End .rating-wrap -->
        <?php } ?>

        <div class="hidden"><h3><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h3></div>

        <span class="price">
            <?php if (!$product['special']) { ?>
            <?php echo '<ins><span class="amount">' . $product['price'] . '</span></ins>'; ?>
            <?php } else { ?>
            <del><span class="amount"><?php echo $product['price']; ?></span></del> <ins><span class="amount"><?php echo $product['special']; ?></span></ins>
            <?php } ?>
        </span>

        <div class="product-action">
            <?php if($theme_options->get( 'display_add_to_wishlist' ) != '0') { ?>
            <a onclick="wishlist.add('<?php echo $product['product_id']; ?>');" class="product-btn btn-wishlist" title="Wishlist"><i class="fa fa-heart-o"></i></a>
            <?php } ?>
            <?php if($theme_options->get( 'display_add_to_cart' ) != '0') { ?>
                 <?php $enquiry = false; if($config->get( 'product_blocks_module' ) != '') { $enquiry = $theme_options->productIsEnquiry($product['product_id']); }
                 if(is_array($enquiry)) { ?>
                 <a href="javascript:openPopup('<?php echo $enquiry['popup_module']; ?>', '<?php echo $product['product_id']; ?>')" class="product-btn btn-add-cart button-enquiry">
                      <?php if($enquiry['icon'] != '' && $enquiry['icon_position'] == 'left') { echo '<img src="image/' . $enquiry['icon']. '" align="left" class="icon-enquiry" alt="Icon">'; } ?>
                      <span class="text-enquiry"><?php echo $enquiry['block_name']; ?></span>
                      <?php if($enquiry['icon'] != '' && $enquiry['icon_position'] == 'right') { echo '<img src="image/' . $enquiry['icon']. '" align="right" class="icon-enquiry" alt="Icon">'; } ?>
                 </a>
                 <?php } else { ?>
                 <a onclick="cart.add('<?php echo $product['product_id']; ?>');" class="product-btn btn-add-cart"><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></a>
                 <?php } ?>
            <?php } ?>
            <?php if($theme_options->get( 'display_add_to_compare' ) != '0') { ?>
            <a onclick="compare.add('<?php echo $product['product_id']; ?>');" class="product-btn btn-quickview" title="Quickview"><i class="fa fa-exchange"></i></a>
            <?php } ?>
        </div>
    </div><!-- End .product -->