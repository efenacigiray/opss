<?php
if($registry->has('theme_options') == false) {
    header("location: themeinstall/index.php");
    exit;
}

$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
$page_direction = $theme_options->get( 'page_direction' );
$url = $registry->get('url'); ?>
<!DOCTYPE html>
<html class="quickview <?php echo ($page_direction[$config->get( 'config_language_id' )] == 'RTL' ? ' rtl' : '' ) ?>" <?php echo ($page_direction[$config->get( 'config_language_id' )] == 'RTL' ? 'dir="rtl"' : '' ) ?>
<head>
    <link href="//fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,700,600,300,800" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/css?family=Oswald:300italic,400italic,600italic,700italic,800italic,400,700,600,300,800" rel="stylesheet" type="text/css">

     <?php
     if( $theme_options->get( 'font_status' ) == '1' ) {
        $lista_fontow = array();
        if( $theme_options->get( 'body_font' ) != '' && $theme_options->get( 'body_font' ) != 'standard' && $theme_options->get( 'body_font' ) != 'Arial' && $theme_options->get( 'body_font' ) != 'Georgia' && $theme_options->get( 'body_font' ) != 'Times New Roman' ) {
            $font = $theme_options->get( 'body_font' );
            $lista_fontow[$font] = $font;
        }

        if( $theme_options->get( 'categories_bar' ) != '' && $theme_options->get( 'categories_bar' ) != 'standard' && $theme_options->get( 'categories_bar' ) != 'Arial' && $theme_options->get( 'categories_bar' ) != 'Georgia' && $theme_options->get( 'categories_bar' ) != 'Times New Roman' ) {
            $font = $theme_options->get( 'categories_bar' );
            if(!isset($lista_fontow[$font])) {
                $lista_fontow[$font] = $font;
            }
        }

        if( $theme_options->get( 'headlines' ) != '' && $theme_options->get( 'headlines' ) != 'standard' && $theme_options->get( 'headlines' ) != 'Arial' && $theme_options->get( 'headlines' ) != 'Georgia' && $theme_options->get( 'headlines' ) != 'Times New Roman' ) {
            $font = $theme_options->get( 'headlines' );
            if(!isset($lista_fontow[$font])) {
                $lista_fontow[$font] = $font;
            }
        }

        if( $theme_options->get( 'footer_headlines' ) != '' && $theme_options->get( 'footer_headlines' ) != 'standard'  && $theme_options->get( 'footer_headlines' ) != 'Arial' && $theme_options->get( 'footer_headlines' ) != 'Georgia' && $theme_options->get( 'footer_headlines' ) != 'Times New Roman' ) {
            $font = $theme_options->get( 'footer_headlines' );
            if(!isset($lista_fontow[$font])) {
                $lista_fontow[$font] = $font;
            }
        }

        if( $theme_options->get( 'page_name' ) != '' && $theme_options->get( 'page_name' ) != 'standard' && $theme_options->get( 'page_name' ) != 'Arial' && $theme_options->get( 'page_name' ) != 'Georgia' && $theme_options->get( 'page_name' ) != 'Times New Roman' ) {
            $font = $theme_options->get( 'page_name' );
            if(!isset($lista_fontow[$font])) {
                $lista_fontow[$font] = $font;
            }
        }

        if( $theme_options->get( 'button_font' ) != '' && $theme_options->get( 'button_font' ) != 'standard' && $theme_options->get( 'button_font' ) != 'Arial' && $theme_options->get( 'button_font' ) != 'Georgia' && $theme_options->get( 'button_font' ) != 'Times New Roman' ) {
            $font = $theme_options->get( 'button_font' );
            if(!isset($lista_fontow[$font])) {
                $lista_fontow[$font] = $font;
            }
        }

        if( $theme_options->get( 'custom_price' ) != '' && $theme_options->get( 'custom_price' ) != 'standard' && $theme_options->get( 'custom_price' ) != 'Arial' && $theme_options->get( 'custom_price' ) != 'Georgia' && $theme_options->get( 'custom_price' ) != 'Times New Roman' ) {
            $font = $theme_options->get( 'custom_price' );
            if(!isset($lista_fontow[$font])) {
                $lista_fontow[$font] = $font;
            }
        }

        foreach($lista_fontow as $font) {
            echo '<link href="//fonts.googleapis.com/css?family=' . $font . ':800,700,600,500,400,300" rel="stylesheet" type="text/css">';
            echo "\n";
        }
     }
     ?>

     <?php $lista_plikow = array(
            'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/css/bootstrap.css',
            'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/css/animate.css',
            'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/css/stylesheet.css',
            'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/css/owl.carousel.css',
            'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/css/font-icons.css',
            'catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css'
     );

     //RTL
     if($page_direction[$config->get( 'config_language_id' )] == 'RTL'){
         $lista_plikow[] = 'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/css/rtl.css';
         $lista_plikow[] = 'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/css/bootstrap_rtl.css';
     }

     echo $theme_options->compressorCodeCss( $config->get('theme_' . $config->get('config_theme') . '_directory'), $lista_plikow, 0, HTTP_SERVER );

     // Custom colors, fonts and backgrounds
     include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/css/custom_colors.php'); ?>

     <?php if($theme_options->get( 'custom_code_css_status' ) == 1) { ?>
     <link rel="stylesheet" href="catalog/view/theme/<?php echo $config->get('theme_' . $config->get('config_theme') . '_directory'); ?>/skins/store_<?php echo $theme_options->get( 'store' ); ?>/<?php echo $theme_options->get( 'skin' ); ?>/css/custom_code.css">
     <?php } ?>

     <?php $lista_plikow = array();

     $lista_plikow[] = 'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/js/jquery-2.1.1.min.js';
     $lista_plikow[] = 'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/js/jquery-migrate-1.2.1.min.js';
     $lista_plikow[] = 'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/js/jquery.easing.1.3.js';
     $lista_plikow[] = 'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/js/bootstrap.min.js';
     $lista_plikow[] = 'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/js/jquery.elevateZoom-3.0.3.min.js';
     $lista_plikow[] = 'catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/js/common.js';
     $lista_plikow[] = 'catalog/view/javascript/jquery/datetimepicker/moment.js';
     $lista_plikow[] = 'catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js';

     echo $theme_options->compressorCodeJs( $config->get('theme_' . $config->get('config_theme') . '_directory'), $lista_plikow, 0, HTTP_SERVER ); ?>

     <script type="text/javascript" src="catalog/view/theme/<?php echo $config->get('theme_' . $config->get('config_theme') . '_directory'); ?>/js/owl.carousel.min.js"></script>

    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script src="catalog/view/theme/<?php echo $config->get('theme_' . $config->get('config_theme') . '_directory'); ?>/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="<?php echo $theme_options->get( 'body_custom_class' ); ?>">

  <div class="product-info">
    <div class="row">
        <div class="col-sm-12">
            <div class="row" id="quickview_product">
                <script>
                    $(document).ready(function(){
                        $('#ex1, .review-link').live('click', function () {
                             top.location.href = "<?php echo $url->link('product/product&product_id=' . $product_id); ?>";
                             return false;
                         });

                        $('#image').elevateZoom({
                            zoomType: "inner",
                            cursor: "pointer",
                            zoomWindowFadeIn: 500,
                            zoomWindowFadeOut: 750
                        });

                        $('.thumbnails a, .thumbnails-carousel a').click(function() {
                            var smallImage = $(this).attr('data-image');
                            var largeImage = $(this).attr('data-zoom-image');
                            var ez =   $('#image').data('elevateZoom');
                            ez.swaptheimage(smallImage, largeImage);
                            return false;
                        });
                    });
                </script>
                <?php $image_grid = 5; $product_center_grid = 7;
                if ($theme_options->get( 'product_image_size' ) == 1) {
                    $image_grid = 4; $product_center_grid = 8;
                }

                if ($theme_options->get( 'product_image_size' ) == 3) {
                    $image_grid = 8; $product_center_grid = 4;
                }
                ?>
                <div class="col-sm-<?php echo $image_grid; ?> popup-gallery">
                  <div class="row">
                      <?php if ($images && $theme_options->get( 'position_image_additional' ) == 2) { ?>
                      <div class="col-sm-2">
                        <div class="thumbnails thumbnails-left clearfix">
                            <ul>
                              <?php if($thumb) { ?>
                              <li><p><a href="<?php echo $popup; ?>" class="popup-image" data-image="<?php echo $thumb; ?>" data-zoom-image="<?php echo $popup; ?>"><img src="<?php echo $theme_options->productImageThumb($product_id, $config->get('theme_default_image_additional_width'), $config->get('theme_default_image_additional_height')); ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></p></li>
                              <?php } ?>
                              <?php foreach ($images as $image) { ?>
                              <li><p><a href="<?php echo $image['popup']; ?>" class="popup-image" data-image="<?php echo $image['popup']; ?>" data-zoom-image="<?php echo $image['popup']; ?>"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></p></li>
                              <?php } ?>
                          </ul>
                        </div>
                      </div>
                      <?php } ?>

                      <div class="col-sm-<?php if($theme_options->get( 'position_image_additional' ) == 2) { echo 10; } else { echo 12; } ?>">
                        <?php if ($thumb) { ?>
                          <div class="product-image inner-cloud-zoom">
                             <?php if($special && $theme_options->get( 'display_text_sale' ) != '0') { ?>
                                <?php $text_sale = 'Sale';
                                if($theme_options->get( 'sale_text', $config->get( 'config_language_id' ) ) != '') {
                                    $text_sale = $theme_options->get( 'sale_text', $config->get( 'config_language_id' ) );
                                } ?>
                                <?php if($theme_options->get( 'type_sale' ) == '1') { ?>
                                <?php $product_detail = $theme_options->getDataProduct( $product_id );
                                $roznica_ceny = $product_detail['price']-$product_detail['special'];
                                $procent = ($roznica_ceny*100)/$product_detail['price']; ?>
                                <div class="onsale"> %<?php echo round($procent); ?> İndirimli</div>
                                <?php } else { ?>
                                <div class="onsale"><?php echo $text_sale; ?></div>
                                <?php } ?>
                             <?php } ?>

                                 <?php if($theme_options->get( 'display_text_new' ) != '0' && $theme_options->isLatestProduct( $product_id )) { ?>
                                     <div class="onhot"><?php if($theme_options->get( 'new_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'new_text', $config->get( 'config_language_id' ) ); } else { echo 'New'; } ?></div>
                                 <?php } ?>

                             <a href="#" title="<?php echo $heading_title; ?>" id="ex1"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" itemprop="image" data-zoom-image="<?php echo $popup; ?>" /></a>
                          </div>
                         <?php } else { ?>
                         <div class="product-image">
                             <a href="#" id="ex1"><img src="image/no_image.jpg" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" itemprop="image" /></a>
                         </div>
                         <?php } ?>
                      </div>

                      <?php if ($images && $theme_options->get( 'position_image_additional' ) != 2) { ?>
                      <div class="col-sm-12">
                           <div class="overflow-thumbnails-carousel">
                              <div class="thumbnails-carousel">
                                <?php if($thumb) { ?>
                                     <div class="item"><a href="<?php echo $popup; ?>" class="popup-image" data-image="<?php echo $thumb; ?>" data-zoom-image="<?php echo $popup; ?>"><img src="<?php echo $theme_options->productImageThumb($product_id, $config->get('theme_default_image_additional_width'), $config->get('theme_default_image_additional_height')); ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></div>
                                <?php } ?>
                                 <?php foreach ($images as $image) { ?>
                                     <div class="item"><a href="<?php echo $image['popup']; ?>" class="popup-image" data-image="<?php echo $image['popup']; ?>" data-zoom-image="<?php echo $image['popup']; ?>"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></div>
                                 <?php } ?>
                              </div>
                          </div>
                      </div>
                      <?php } ?>
                  </div>
                </div>

                <div class="col-sm-<?php echo $product_center_grid; ?> product-center clearfix">
                 <div itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer">
                  <h2 class="product-title"><?php echo $heading_title; ?></h2>
                  <?php if ($review_status) { ?>
                  <div class="review">
                    <?php if($rating > 0) { ?>
                    <span itemprop="review" class="hidden" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
                        <span itemprop="itemreviewed"><?php echo $heading_title; ?></span>
                        <span itemprop="rating"><?php echo $rating; ?></span>
                        <span itemprop="votes"><?php preg_match_all('/\(([0-9]+)\)/', $tab_review, $wyniki);
                        if(isset($wyniki[1][0])) { echo $wyniki[1][0]; } else { echo 0; } ?></span>
                    </span>
                    <?php } ?>
                    <div class="rating"><i class="fa fa-star<?php if($rating >= 1) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 2) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 3) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 4) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 5) { echo ' active'; } ?>"></i>&nbsp;&nbsp;&nbsp;<a href="#" class="review-link"><?php echo $reviews; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" class="review-link"><?php echo $text_write; ?></a></div>
                  </div>
                  <?php } ?>
                  <div class="description">
                    <?php if ($manufacturer) { ?>
                    <span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>" itemprop="brand"><?php echo $manufacturer; ?></a><br />
                    <?php } ?>
                    <span><?php echo $text_model; ?></span> <?php echo $model; ?><br />
                    <?php if ($reward) { ?>
                    <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
                    <?php } ?>
                    <span><?php echo $text_stock; ?></span> <?php echo $stock; ?></div>
                  <?php if ($price) { ?>
                  <div class="price">
                    <?php if (!$special) { ?>
                    <span class="price-new"><span itemprop="price" id="price-old"><?php echo $price; ?></span></span>
                    <?php } else { ?>
                    <span class="price-new"><span itemprop="price" id="price-special"><?php echo $special; ?></span></span> <span class="price-old" id="price-old"><?php echo $price; ?></span>
                    <?php } ?>
                    <br />
                    <?php if ($tax) { ?>
                    <span class="price-tax"><?php echo $text_tax; ?> <span id="price-tax"><?php echo $tax; ?></span></span><br />
                    <?php } ?>
                    <?php if ($points) { ?>
                    <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
                    <?php } ?>
                    <?php if ($discounts) { ?>
                    <br />
                    <div class="discount">
                      <?php foreach ($discounts as $discount) { ?>
                      <?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?><br />
                      <?php } ?>
                    </div>
                    <?php } ?>
                  </div>
                  <?php } ?>
                 </div>

                 <div id="product">
                  <?php if ($options) { ?>
                  <div class="options">
                    <h2><?php echo $text_option; ?></h2>
                    <?php foreach ($options as $option) { ?>
                    <?php if ($option['type'] == 'select') { ?>
                    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                      <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                      <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
                        <option value=""><?php echo $text_select; ?></option>
                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                        <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                        <?php if ($option_value['price']) { ?>
                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                        <?php } ?>
                        </option>
                        <?php } ?>
                      </select>
                    </div>
                    <?php } ?>
                    <?php if ($option['type'] == 'radio') { ?>
                    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                      <label class="control-label"><?php echo $option['name']; ?></label>
                      <div id="input-option<?php echo $option['product_option_id']; ?>">
                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                        <div class="radio <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { echo 'radio-type-button2'; } ?>">
                          <label>
                            <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                            <span <?php if ($option_value['image']) { echo 'class="with-image"'; } ?>><?php if (!$option_value['image']) { ?><?php echo $option_value['name']; ?><?php } ?>
                            <?php if ($option_value['image']) { ?>
                            <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { ?>width="<?php if($theme_options->get( 'product_page_radio_image_width' ) > 0) { echo $theme_options->get( 'product_page_radio_image_width' ); } else { echo 25; } ?>px" height="<?php if($theme_options->get( 'product_page_radio_image_height' ) > 0) { echo $theme_options->get( 'product_page_radio_image_height' ); } else { echo 25; } ?>px"<?php } ?> />
                            <?php } ?>
                            <?php if($theme_options->get( 'product_page_radio_style' ) != 1) { ?><?php if ($option_value['price']) { ?>
                            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                            <?php } ?><?php } ?></span>
                          </label>
                        </div>
                        <?php } ?>

                        <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { ?>
                        <script type="text/javascript">
                             $(document).ready(function(){
                                  $('#input-option<?php echo $option['product_option_id']; ?>').on('click', 'span', function () {
                                       $('#input-option<?php echo $option['product_option_id']; ?> span').removeClass("active");
                                       $(this).addClass("active");
                                  });
                             });
                        </script>
                        <?php } ?>
                      </div>
                    </div>
                    <?php } ?>
                    <?php if ($option['type'] == 'checkbox') { ?>
                    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                      <label class="control-label"><?php echo $option['name']; ?></label>
                      <div id="input-option<?php echo $option['product_option_id']; ?>">
                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                        <div class="checkbox <?php if($theme_options->get( 'product_page_checkbox_style' ) == 1) { echo 'radio-type-button2'; } ?>">
                          <label>
                            <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                            <span><?php echo $option_value['name']; ?>
                            <?php if($theme_options->get( 'product_page_checkbox_style' ) != 1) { ?><?php if ($option_value['price']) { ?>
                            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                            <?php } ?><?php } ?></span>
                          </label>
                        </div>
                        <?php } ?>

                        <?php if($theme_options->get( 'product_page_checkbox_style' ) == 1) { ?>
                        <script type="text/javascript">
                             $(document).ready(function(){
                                  $('#input-option<?php echo $option['product_option_id']; ?>').on('click', 'span', function () {
                                       if($(this).hasClass("active") == true) {
                                            $(this).removeClass("active");
                                       } else {
                                            $(this).addClass("active");
                                       }
                                  });
                             });
                        </script>
                        <?php } ?>
                      </div>
                    </div>
                    <?php } ?>
                    <?php if ($option['type'] == 'image') { ?>
                    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                      <label class="control-label"><?php echo $option['name']; ?></label>
                      <div id="input-option<?php echo $option['product_option_id']; ?>">
                        <?php foreach ($option['product_option_value'] as $option_value) { ?>
                        <div class="radio <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { echo 'radio-type-button'; } ?>">
                          <label>
                            <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                            <span <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { ?>data-toggle="tooltip" data-placement="top" title="<?php echo $option_value['name']; ?> <?php if ($option_value['price']) { ?>(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)<?php } ?>"<?php } ?>><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { ?>width="<?php if($theme_options->get( 'product_page_radio_image_width' ) > 0) { echo $theme_options->get( 'product_page_radio_image_width' ); } else { echo 25; } ?>px" height="<?php if($theme_options->get( 'product_page_radio_image_height' ) > 0) { echo $theme_options->get( 'product_page_radio_image_height' ); } else { echo 25; } ?>px"<?php } ?> /> <?php if($theme_options->get( 'product_page_radio_style' ) != 1) { ?><?php echo $option_value['name']; ?>
                            <?php if ($option_value['price']) { ?>
                            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                            <?php } ?><?php } ?></span>
                          </label>
                        </div>
                        <?php } ?>
                        <?php if($theme_options->get( 'product_page_radio_style' ) == 1) { ?>
                        <script type="text/javascript">
                             $(document).ready(function(){
                                  $('#input-option<?php echo $option['product_option_id']; ?>').on('click', 'span', function () {
                                       $('#input-option<?php echo $option['product_option_id']; ?> span').removeClass("active");
                                       $(this).addClass("active");
                                  });
                             });
                        </script>
                        <?php } ?>
                      </div>
                    </div>
                    <?php } ?>
                    <?php if ($option['type'] == 'text') { ?>
                    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                      <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                      <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                    </div>
                    <?php } ?>
                    <?php if ($option['type'] == 'textarea') { ?>
                    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                      <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                      <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
                    </div>
                    <?php } ?>
                    <?php if ($option['type'] == 'file') { ?>
                    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                      <label class="control-label"><?php echo $option['name']; ?></label>
                      <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" class="btn btn-default btn-block" style="margin-top: 7px"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                      <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
                    </div>
                    <?php } ?>
                    <?php if ($option['type'] == 'date') { ?>
                    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                      <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                      <div class="input-group date">
                        <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                        </span></div>
                    </div>
                    <?php } ?>
                    <?php if ($option['type'] == 'datetime') { ?>
                    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                      <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                      <div class="input-group datetime">
                        <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                        </span></div>
                    </div>
                    <?php } ?>
                    <?php if ($option['type'] == 'time') { ?>
                    <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                      <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                      <div class="input-group time">
                        <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                        </span></div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                  </div>
                  <?php } ?>

                  <?php if ($recurrings) { ?>
                  <div class="options">
                      <h2><?php echo $text_payment_recurring ?></h2>
                      <div class="form-group required">
                        <select name="recurring_id" class="form-control">
                          <option value=""><?php echo $text_select; ?></option>
                          <?php foreach ($recurrings as $recurring) { ?>
                          <option value="<?php echo $recurring['recurring_id'] ?>"><?php echo $recurring['name'] ?></option>
                          <?php } ?>
                        </select>
                        <div class="help-block" id="recurring-description"></div>
                      </div>
                  </div>
                  <?php } ?>

                  <div class="cart">
                    <div class="add-to-cart clearfix">
                      <?php $enquiry = false; if($config->get( 'product_blocks_module' ) != '') { $enquiry = $theme_options->productIsEnquiry($product_id); }
                      if(is_array($enquiry)) { ?>
                          <a href="#" class="button review-link"><?php if($theme_options->get( 'more_details_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'more_details_text', $config->get( 'config_language_id' ) ); } else { echo 'More details'; } ?></a>
                      <?php } else { ?>
                          <p><?php echo $entry_qty; ?></p>
                          <div class="quantity">
                               <input type="text" name="quantity" id="quantity_wanted" size="2" value="<?php echo $minimum; ?>" />
                               <a href="#" id="q_up"><i class="fa fa-plus"></i></a>
                               <a href="#" id="q_down"><i class="fa fa-minus"></i></a>
                          </div>
                          <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                          <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" rel="<?php echo $product_id; ?>" data-loading-text="<?php echo $text_loading; ?>" class="button" />
                           <a class="hidden add-wishlist" onclick="parent.wishlist.add('<?php echo $product_id; ?>');"><i class="porto-icon-wishlist"></i></a>
                           <a class="hidden add-compare" onclick="parent.compare.add('<?php echo $product_id; ?>');"><i class="fa fa-exchange"></i></a>
                      <?php } ?>
                    </div>

                    <div class="single-add-to-wishlist"><a onclick="parent.wishlist.add('<?php echo $product_id; ?>');"><?php echo $button_wishlist; ?></a></div>
                    <div class="single-add-to-compare"><a onclick="parent.compare.add('<?php echo $product_id; ?>');"><?php echo $button_compare; ?></a></div>


                    <?php if ($minimum > 1) { ?>
                    <div class="minimum"><?php echo $text_minimum; ?></div>
                    <?php } ?>
                  </div>
                 </div><!-- End #product -->
                </div>
            </div>
        </div>
    </div>
  </div>

<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
    $.ajax({
        url: 'index.php?route=product/product/getRecurringDescription',
        type: 'post',
        data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
        dataType: 'json',
        beforeSend: function() {
            $('#recurring-description').html('');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();

            if (json['success']) {
                $('#recurring-description').html(json['success']);
            }
        }
    });
});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
    $.ajax({
        url: 'index.php?route=checkout/cart/add',
        type: 'post',
        data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-cart').button('loading');
        },
        complete: function() {
            $('#button-cart').button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();
            $('.form-group').removeClass('has-error');

            if (json['error']) {
                if (json['error']['option']) {
                    for (i in json['error']['option']) {
                        var element = $('#input-option' + i.replace('_', '-'));

                        if (element.parent().hasClass('input-group')) {
                            element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                        } else {
                            element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                        }
                    }
                }

                if (json['error']['recurring']) {
                    $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
                }

                // Highlight any found errors
                $('.text-danger').parent().addClass('has-error');
            }

            if (json['success']) {
                parent.$.notify({
                    message: json['success'],
                    target: '_blank'
                },{
                    // settings
                    element: 'body',
                    position: null,
                    type: "info",
                    allow_dismiss: true,
                    newest_on_top: false,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 2031,
                    delay: 5000,
                    timer: 1000,
                    url_target: '_blank',
                    mouse_over: null,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                    onShow: null,
                    onShown: null,
                    onClose: null,
                    onClosed: null,
                    icon_type: 'class',
                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-success" role="alert">' +
                        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                        '<span data-notify="message"><i class="fa fa-check-circle"></i>&nbsp; {2}</span>' +
                        '<div class="progress" data-notify="progressbar">' +
                            '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                        '</div>' +
                        '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
                });

                parent.$('#mini-cart #cart_content').load('index.php?route=common/cart/info #cart_content_ajax');
                parent.$('#mini-cart #total_item_ajax').load('index.php?route=common/cart/info #total_item');
            }
        }
    });
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
    pickTime: false
});

$('.datetime').datetimepicker({
    pickDate: true,
    pickTime: true
});

$('.time').datetimepicker({
    pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
    var node = this;

    $('#form-upload').remove();

    $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

    $('#form-upload input[name=\'file\']').trigger('click');

    timer = setInterval(function() {
        if ($('#form-upload input[name=\'file\']').val() != '') {
            clearInterval(timer);

            $.ajax({
                url: 'index.php?route=tool/upload',
                type: 'post',
                dataType: 'json',
                data: new FormData($('#form-upload')[0]),
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(node).button('loading');
                },
                complete: function() {
                    $(node).button('reset');
                },
                success: function(json) {
                    $('.text-danger').remove();

                    if (json['error']) {
                        $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                    }

                    if (json['success']) {
                        alert(json['success']);

                        $(node).parent().find('input').attr('value', json['code']);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    }, 500);
});
//--></script>

<script type="text/javascript">
var ajax_price = function() {
    $.ajax({
        type: 'POST',
        url: 'index.php?route=product/liveprice/index',
        data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
        dataType: 'json',
            success: function(json) {
            if (json.success) {
                change_price('#price-special', json.new_price.special);
                change_price('#price-tax', json.new_price.tax);
                change_price('#price-old', json.new_price.price);
            }
        }
    });
}

var change_price = function(id, new_price) {
    $(id).html(new_price);
}

$('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\'], .product-info input[type=\'checkbox\'], .product-info select, .product-info textarea, .product-info input[name=\'quantity\']').on('change', function() {
    ajax_price();
});
</script>

</body>
</html>