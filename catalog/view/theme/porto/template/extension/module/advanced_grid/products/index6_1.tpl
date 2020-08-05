<div class="container-fluid">
    <h2 class="title spaced">
        <?php echo html_entity_decode($module['content']['title']); ?>
    </h2>

    <div class="owl-carousel collection-carousel-long">
    	<?php foreach($module['content']['products'] as $product) { ?>
        <div class="product">
            <div class="product-image">
                <figure class="inner-image">
                    <a href="<?php echo $product['href']; ?>">
                    	<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="<?php if($theme_options->get( 'product_image_effect' ) == '1') { echo 'product-image-normal'; } ?> <?php if($theme_options->get( 'product_image_effect' ) == '2') { echo 'zoom-image-effect'; } ?>" />
                    	<?php if($theme_options->get( 'product_image_effect' ) == '1') {
                    		$nthumb = str_replace(' ', "%20", ($product['thumb']));
                    		$nthumb = str_replace(HTTP_SERVER, "", $nthumb);
                    		$image_size = getimagesize($nthumb);
                    		$image_swap = $theme_options->productImageSwap($product['product_id'], $image_size[0], $image_size[1]);
                    		if($image_swap != '') echo '<img src="' . $image_swap . '" alt="' . $product['name'] . '" class="product-image-hover" />';
                    	} ?> 
                </figure>
                <div class="product-action">
                    <a onclick="wishlist.add('<?php echo $product['product_id']; ?>');" class="product-btn btn-wishlist" title="Wishlist"><i class="fa fa-heart-o"></i></a>
                    <a onclick="cart.add('<?php echo $product['product_id']; ?>');" class="product-btn btn-add-cart" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                    <?php if($theme_options->get( 'quick_view' ) == 1) { ?>
                    <div class="quickview"><a href="index.php?route=product/quickview&product_id=<?php echo $product['product_id']; ?>" class="product-btn btn-quickview" title="Quickview"><i class="fa fa-eye"></i><?php if($theme_options->get( 'quickview_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'quickview_text', $config->get( 'config_language_id' ) )); } else { echo 'Quick View'; } ?></a></div>
                    <?php } ?>
                </div>
            </div><!-- End .product-image -->

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
            <?php } ?>
            <span class="price">
                <?php if (!$product['special']) { ?>
                <?php echo '<ins><span class="amount">' . $product['price'] . '</span></ins>'; ?>
                <?php } else { ?>
                <del><span class="amount"><?php echo $product['price']; ?></span></del> <ins><span class="amount"><?php echo $product['special']; ?></span></ins>
                <?php } ?>
            </span>
        </div><!-- End .product -->
        <?php } ?>
    </div>
</div><!-- End .container-fluid -->

<div class="lg-margin"></div><!-- space -->