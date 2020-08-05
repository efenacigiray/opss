<div class="widget">
    <h2 class="widget-title"><?php echo $module['content']['title']; ?></h2>
    <ul class="product_list_widget">
    	<?php foreach($module['content']['products'] as $product) { ?>
        <li>
            <div class="product-image">
                <div class="inner">
                    <a href="<?php echo $product['href']; ?>">	
                    	<?php if($theme_options->get( 'product_image_effect' ) == '1') {
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
                </div>  
            </div>
            <div class="product-details">
                <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                <?php if ($product['rating'] && $theme_options->get( 'display_rating' ) != '0') { ?>
                		<div class="star-rating add-tooltip" title="<?php echo $product['rating']; ?>.00">
                			<span style="width:<?php echo $product['rating']*20; ?>%"><?php echo $product['rating']; ?>.00</span>
                		</div><!-- End .star-rating -->
                <?php } elseif($theme_options->get( 'display_rating' ) != '0') { ?>
	                <div class="star-rating add-tooltip">
	                </div><!-- End .star-rating -->
                <?php } ?>
				<?php if (!$product['special']) { ?>
				<?php echo '<span class="amount">' . $product['price'] . '</span>'; ?>
				<?php } else { ?>
				<del><span class="amount"><?php echo $product['price']; ?></span></del> <ins><span class="amount"><?php echo $product['special']; ?></span></ins>
				<?php } ?>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>