<?php echo $header;
$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
$page_direction = $theme_options->get( 'page_direction' );
include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/wrapper_top.tpl'); ?>

<?php if($theme_options->get( 'add_to_cart_sticky' ) == 1) { ?>
<div class="sticky-product">
    <div class="container">
        <div class="sticky-image">
            <?php if ($thumb) { ?>
                <img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
            <?php } else { ?>
                 <img src="image/no_image.jpg" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
            <?php } ?>
        </div>

        <div class="sticky-detail">
            <div class="product-name-area">
                <h2 class="product-name"><?php echo $heading_title; ?></h2>
                <div class="price-box">
                    <?php if (!$special) { ?>
                    <p class="special-price"><span class="price"><?php echo $price; ?></span></p>
                    <?php } else { ?>
                    <p class="old-price"><span class="price"><?php echo $price; ?></span></p>
                    <p class="special-price"><span class="price"><?php echo $special; ?></span></p>
                    <?php } ?>
                </div>
            </div>

            <div class="ratings">
                <div class="rating"><i class="fa fa-star<?php if($rating >= 1) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 2) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 3) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 4) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 5) { echo ' active'; } ?>"></i></div>
            </div>

            <p class="availability in-stock"><span>(<?php echo $stock; ?>)</span></p>
        </div>

        <div class="add-to-cart">
            <button type="button" data-loading-text="<?php echo $text_loading; ?>" title="<?php echo $button_cart; ?>" id="button-cart2" rel="<?php echo $product_id; ?>" class="button btn-cart"><span><span><i class="fa fa-shopping-cart"></i><?php echo $button_cart; ?></span></span></button>
        </div>
    </div>
</div>
<?php } ?>

<div itemscope itemtype="http://schema.org/Product">
  <span itemprop="name" class="hidden"><?php echo $heading_title; ?></span>
  <div class="product-info">
    <div class="row">
        <div class="col-sm-12">
            <div class="row" id="quickview_product">
                <?php if($theme_options->get( 'product_image_zoom' ) != 2) { ?>
                <script>
                    $(document).ready(function(){
                         if($(window).width() > 992) {
                            <?php if($theme_options->get( 'product_image_zoom' ) == 1) { ?>
                                $('#image').elevateZoom({
                                    zoomType: "inner",
                                    cursor: "pointer",
                                    zoomWindowFadeIn: 500,
                                    zoomWindowFadeOut: 750
                                });
                            <?php } else { ?>
                                $('#image').elevateZoom({
                                    zoomWindowFadeIn: 500,
                                    zoomWindowFadeOut: 500,
                                    zoomWindowOffetx: 20,
                                    zoomWindowOffety: -1,
                                    cursor: "pointer",
                                    lensFadeIn: 500,
                                    lensFadeOut: 500,
                                });
                            <?php } ?>

                            var z_index = 0;

                            $(document).on('click', '.open-popup-image', function () {
                              $('.popup-gallery').magnificPopup('open', z_index);
                              return false;
                            });

                            $('.thumbnails a, .thumbnails-carousel a').click(function() {
                                var smallImage = $(this).attr('data-image');
                                var largeImage = $(this).attr('data-zoom-image');
                                var ez =   $('#image').data('elevateZoom');
                                $('#ex1').attr('href', largeImage);
                                ez.swaptheimage(smallImage, largeImage);
                                z_index = $(this).index('.thumbnails a, .thumbnails-carousel a');
                                return false;
                            });
                        } else {
                            $(document).on('click', '.open-popup-image', function () {
                              $('.popup-gallery').magnificPopup('open', 0);
                              return false;
                            });
                        }
                    });
                </script>
                <?php } ?>
                <?php $image_grid = 5; $product_center_grid = 7;
                if ($theme_options->get( 'product_image_size' ) == 1) {
                    $image_grid = 4; $product_center_grid = 8;
                }

                if ($theme_options->get( 'product_image_size' ) == 3) {
                    $image_grid = 8; $product_center_grid = 4;
                }
                ?>
                <div class="col-sm-<?php echo $image_grid; ?> popup-gallery">
                  <?php
                  $product_image_top = $modules_old_opencart->getModules('product_image_top');
                  if( count($product_image_top) ) {
                    foreach ($product_image_top as $module) {
                        echo $module;
                    }
                  } ?>

                  <div class="row">
                      <?php if (($images || $theme_options->get( 'product_image_zoom' ) != 2) && $theme_options->get( 'position_image_additional' ) == 2) { ?>
                      <div class="col-sm-2">
                        <div class="thumbnails thumbnails-left clearfix">
                            <ul>
                              <?php if($theme_options->get( 'product_image_zoom' ) != 2 && $thumb) { ?>
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
                          <div class="product-image <?php if($theme_options->get( 'product_image_zoom' ) != 2) { if($theme_options->get( 'product_image_zoom' ) == 1) { echo 'inner-cloud-zoom'; } else { echo 'cloud-zoom'; } } ?>">
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

                             <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" id="ex1" <?php if($theme_options->get( 'product_image_zoom' ) == 2) { ?>class="popup-image"<?php } else { echo 'class="open-popup-image"'; } ?>><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" itemprop="image" data-zoom-image="<?php echo $popup; ?>" /></a>
                          </div>
                         <?php } else { ?>
                         <div class="product-image">
                             <img src="image/no_image.jpg" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" itemprop="image" />
                         </div>
                         <?php } ?>
                      </div>

                      <?php if (($images || $theme_options->get( 'product_image_zoom' ) != 2) && $theme_options->get( 'position_image_additional' ) != 2) { ?>
                      <div class="col-sm-12">
                           <div class="overflow-thumbnails-carousel">
                              <div class="thumbnails-carousel">
                                <?php if($theme_options->get( 'product_image_zoom' ) != 2 && $thumb) { ?>
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

                  <?php
                  $product_image_bottom = $modules_old_opencart->getModules('product_image_bottom');
                  if( count($product_image_bottom) ) {
                    foreach ($product_image_bottom as $module) {
                        echo $module;
                    }
                  } ?>
                </div>

                <div class="col-sm-<?php echo $product_center_grid; ?> product-center clearfix">
                 <div itemprop="offerDetails" itemscope itemtype="http://schema.org/Offer">
                 <?php if($theme_options->get( 'product_breadcrumb' ) != '2') { ?>
                      <?php $product_prev_next = $theme_options->getNextPrevProduct( $product_id ); ?>
                      <div class="prev-next-products">
                      <?php if(is_array($product_prev_next['prev'])) { ?>
                            <div class="product-nav product-prev">
                                <a href="<?php echo $product_prev_next['prev']['href']; ?>" title="Previous Product"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                                <div class="product-pop theme-border-color">
                                    <img src="<?php echo $product_prev_next['prev']['thumb']; ?>" alt="Previous">
                                    <h3 class="product-name"><?php echo $product_prev_next['prev']['name']; ?></h3>
                                </div>
                            </div>
                      <?php } ?>

                       <?php if(is_array($product_prev_next['next'])) { ?>
                                <div class="product-nav product-next">
                                    <a href="<?php echo $product_prev_next['next']['href']; ?>" title="Previous Product"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                                    <div class="product-pop theme-border-color">
                                        <img src="<?php echo $product_prev_next['next']['thumb']; ?>" alt="Previous">
                                        <h3 class="product-name"><?php echo $product_prev_next['next']['name']; ?></h3>
                                    </div>
                                </div>
                       <?php } ?>
                      </div>
                  <?php } ?>

                  <h2 class="product-title"><?php echo $heading_title; ?></h2>
                  <?php if ($review_status) { ?>
                  <div class="review">
                    <?php if($rating > 0) { ?>
                    <span itemprop="review" class="hidden" itemscope itemtype="http://schema.org/Review-aggregate">
                        <span itemprop="itemreviewed"><?php echo $heading_title; ?></span>
                        <span itemprop="rating"><?php echo $rating; ?></span>
                        <span itemprop="votes"><?php preg_match_all('/\(([0-9]+)\)/', $tab_review, $wyniki);
                        if(isset($wyniki[1][0])) { echo $wyniki[1][0]; } else { echo 0; } ?></span>
                    </span>
                    <?php } ?>
                    <div class="rating"><i class="fa fa-star<?php if($rating >= 1) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 2) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 3) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 4) { echo ' active'; } ?>"></i><i class="fa fa-star<?php if($rating >= 5) { echo ' active'; } ?>"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click'); $('html, body').animate({scrollTop:$('#tab-review').offset().top}, '500', 'swing');"><?php echo $reviews; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click'); $('html, body').animate({scrollTop:$('#tab-review').offset().top}, '500', 'swing');"><?php echo $text_write; ?></a></div>
                  </div>
                  <?php } ?>

                  <?php
                  $product_options_top = $modules_old_opencart->getModules('product_options_top');
                  if( count($product_options_top) ) {
                    foreach ($product_options_top as $module) {
                        echo $module;
                    }
                  } ?>
                  <div class="description">
                    <?php if ($manufacturer) { ?>
                    <span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>" itemprop="brand"><?php echo $manufacturer; ?></a><br />
                    <?php } ?>
                    <span><?php echo $text_model; ?></span> <?php echo $model; ?><br />
                    <?php if ($reward) { ?>
                    <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
                    <?php } ?>
                    <span><?php echo $text_stock; ?></span> <?php echo $stock; ?></div>

                  <?php if($theme_options->get( 'position_product_tabs' ) == 3) { ?>
                    <?php
                          $language_id = $config->get( 'config_language_id' );
                      $tabs = array();

                      $tabs[] = array(
                        'heading' => $tab_description,
                        'content' => 'description',
                        'sort' => 1
                      );

                      if ($attribute_groups) {
                          $tabs[] = array(
                            'heading' => $tab_attribute,
                            'content' => 'attribute',
                            'sort' => 3
                          );
                      }

                      if ($review_status) {
                          $tabs[] = array(
                            'heading' => $tab_review,
                            'content' => 'review',
                            'sort' => 5
                          );
                      }

                      if(is_array($config->get('product_tabs'))) {
                          foreach($config->get('product_tabs') as $tab) {
                            if($tab['status'] == 1 || $tab['product_id'] == $product_id) {
                                foreach($tab['tabs'] as $zakladka) {
                                    if($zakladka['status'] == 1) {
                                        $heading = false; $content = false;
                                        if(isset($zakladka[$language_id])) {
                                            $heading = $zakladka[$language_id]['name'];
                                            $content = html_entity_decode($zakladka[$language_id]['html']);
                                        }
                                        $tabs[] = array(
                                            'heading' => $heading,
                                            'content' => $content,
                                            'sort' => $zakladka['sort_order']
                                        );
                                    }
                                }
                            }
                          }
                      }

                      usort($tabs, "cmp_by_optionNumber");
                    ?>
                    <div class="product-tab" role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php $i = 0; foreach($tabs as $tab) { $i++;
                            $id = 'tab_'.$i;
                            if($tab['content'] == 'description') { $id = 'tab-description'; }
                            if($tab['content'] == 'attribute') { $id = 'tab-attribute'; }
                            if($tab['content'] == 'review') { $id = 'tab-review'; }
                            $class = false;
                            if($i == 1) { $class = 'class="active"'; $new_active = $id; }
                            echo '<li role="presentation" ' . $class . '><a href="#'.$id.'" aria-controls="'.$id.'" role="tab" data-toggle="tab">'.$tab['heading'].'</a></li>';
                        } ?>
                    </ul>
                    <div class="tab-content">
                    <?php $i = 0; foreach($tabs as $tab) { $i++;
                        $id = 'tab_'.$i;
                        if($tab['content'] != 'description' && $tab['content'] != 'attribute' && $tab['content'] != 'review') {
                            echo '<div id="'.$id.'" class="tab-pane';
                            if($new_active == $id) { echo ' active'; }
                            echo '" role="tabpanel">'.$tab['content'].'</div>';
                        }
                    } ?>
                   <div role="tabpanel" class="tab-pane <?php if($new_active == 'tab-description') { echo 'active'; } ?>" id="tab-description" itemprop="description"><?php echo $description; ?></div>
                    <?php if ($attribute_groups) { ?>
                    <div role="tabpanel" class="tab-pane" id="tab-attribute">
                      <table class="attribute" cellspacing="0">
                        <?php foreach ($attribute_groups as $attribute_group) { ?>
                        <thead>
                          <tr>
                            <td colspan="2"><?php echo $attribute_group['name']; ?></td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                          <tr>
                            <td><?php echo $attribute['name']; ?></td>
                            <td><?php echo $attribute['text']; ?></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                        <?php } ?>
                      </table>
                    </div>
                    <?php } ?>
                    <?php if ($review_status) { ?>
                    <div id="tab-review" class="tab-pane" role="tabpanel">
                    <form class="form-horizontal" id="form-review">
                      <div id="review"></div>
                      <h2><?php echo $text_write; ?></h2>
                      <?php if ($review_guest) { ?>
                      <div class="form-group required">
                        <div class="col-sm-12">
                          <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                          <input type="text" name="name" value="" id="input-name" class="form-control" />
                        </div>
                      </div>
                      <div class="form-group required">
                        <div class="col-sm-12">
                             <label class="control-label"><?php echo $entry_rating; ?></label>

                           <div class="rating set-rating">
                              <i class="fa fa-star" data-value="1"></i>
                              <i class="fa fa-star" data-value="2"></i>
                              <i class="fa fa-star" data-value="3"></i>
                              <i class="fa fa-star" data-value="4"></i>
                              <i class="fa fa-star" data-value="5"></i>
                          </div>
                          <script type="text/javascript">
                              $(document).ready(function() {
                                $('.set-rating i').hover(function(){
                                    var rate = $(this).data('value');
                                    var i = 0;
                                    $('.set-rating i').each(function(){
                                        i++;
                                        if(i <= rate){
                                            $(this).addClass('active');
                                        }else{
                                            $(this).removeClass('active');
                                        }
                                    })
                                })

                                $('.set-rating i').mouseleave(function(){
                                    var rate = $('input[name="rating"]:checked').val();
                                    rate = parseInt(rate);
                                    i = 0;
                                      $('.set-rating i').each(function(){
                                        i++;
                                        if(i <= rate){
                                            $(this).addClass('active');
                                        }else{
                                            $(this).removeClass('active');
                                        }
                                      })
                                })

                                $('.set-rating i').click(function(){
                                    $('input[name="rating"]:nth('+ ($(this).data('value')-1) +')').prop('checked', true);
                                });
                              });
                          </script>
                          <div class="hidden">
                             &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                             <input type="radio" name="rating" value="1" />
                             &nbsp;
                             <input type="radio" name="rating" value="2" />
                             &nbsp;
                             <input type="radio" name="rating" value="3" />
                             &nbsp;
                             <input type="radio" name="rating" value="4" />
                             &nbsp;
                             <input type="radio" name="rating" value="5" />
                             &nbsp;<?php echo $entry_good; ?>
                          </div>
                       </div>
                      </div>

                      <div class="form-group required">
                        <div class="col-sm-12">
                          <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
                          <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                          <div class="help-block"><?php echo $text_note; ?></div>
                        </div>
                      </div>
                      <?php echo $captcha; ?>
                      <div class="buttons clearfix" style="margin-bottom: 0px">
                        <div class="pull-right">
                          <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
                        </div>
                      </div>
                      <?php } else { ?>
                      <?php echo $text_login; ?>
                      <?php } ?>
                    </form>
                    </div>
                    <?php } ?>
                    </div>
                   </div>
                  <?php } ?>

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
                  <?php
                  $product_options_center = $modules_old_opencart->getModules('product_options_center');
                  if( count($product_options_center) ) {
                    foreach ($product_options_center as $module) {
                        echo $module;
                    }
                  } ?>
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
                      <?php
                      $product_enquiry = $modules_old_opencart->getModules('product_enquiry');
                      if( count($product_enquiry) ) {
                        foreach ($product_enquiry as $module) {
                            echo $module;
                        }
                      } else { ?>
                          <p><?php echo $entry_qty; ?></p>
                          <div class="quantity">
                              <input type="text" name="quantity" id="quantity_wanted" size="2" value="<?php echo $minimum; ?>" />
                              <a href="#" id="q_up"><i class="fa fa-plus"></i></a>
                              <a href="#" id="q_down"><i class="fa fa-minus"></i></a>
                          </div>
                          <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                          <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" rel="<?php echo $product_id; ?>" data-loading-text="<?php echo $text_loading; ?>" class="button" />
                           <a class="hidden add-wishlist" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="porto-icon-wishlist"></i></a>
                           <a class="hidden add-compare" onclick="compare.add('<?php echo $product_id; ?>');"><i class="fa fa-exchange"></i></a>

                          <?php
                          $product_question = $modules_old_opencart->getModules('product_question');
                          if( count($product_question) ) {
                            foreach ($product_question as $module) {
                                echo $module;
                            }
                          } ?>
                      <?php } ?>
                    </div>

                    <div class="single-add-to-wishlist"><a onclick="wishlist.add('<?php echo $product_id; ?>');"><?php echo $button_wishlist; ?></a></div>
                    <div class="single-add-to-compare"><a onclick="compare.add('<?php echo $product_id; ?>');"><?php echo $button_compare; ?></a></div>

                    <?php if ($minimum > 1) { ?>
                    <div class="minimum"><?php echo $text_minimum; ?></div>
                    <?php } ?>
                  </div>
                 </div><!-- End #product -->

                    <?php if($theme_options->get( 'product_social_share' ) != '0') { ?>
                    <div class="share">
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a></div>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
                        <!-- AddThis Button END -->
                    </div>
                  <?php } ?>

                  <?php
                  $product_options_bottom = $modules_old_opencart->getModules('product_options_bottom');
                  if( count($product_options_bottom) ) {
                    foreach ($product_options_bottom as $module) {
                        echo $module;
                    }
                  } ?>
                </div>
            </div>
        </div>
    </div>
  </div>

  <?php
  $product_over_tabs = $modules_old_opencart->getModules('product_over_tabs');
  if( count($product_over_tabs) ) {
    foreach ($product_over_tabs as $module) {
        echo $module;
    }
  } ?>

<?php if($theme_options->get( 'position_product_tabs' ) != 3 && $theme_options->get( 'position_product_tabs' ) != 4) { ?>
  <?php
      $language_id = $config->get( 'config_language_id' );
      $tabs = array();

      $tabs[] = array(
        'heading' => $tab_description,
        'content' => 'description',
        'sort' => 1
      );

      if ($attribute_groups) {
          $tabs[] = array(
            'heading' => $tab_attribute,
            'content' => 'attribute',
            'sort' => 3
          );
      }

      if ($review_status) {
          $tabs[] = array(
            'heading' => $tab_review,
            'content' => 'review',
            'sort' => 5
          );
      }

      if(is_array($config->get('product_tabs'))) {
          foreach($config->get('product_tabs') as $tab) {
            if($tab['status'] == 1 || $tab['product_id'] == $product_id) {
                foreach($tab['tabs'] as $zakladka) {
                    if($zakladka['status'] == 1) {
                        $heading = false; $content = false;
                        if(isset($zakladka[$language_id])) {
                            $heading = $zakladka[$language_id]['name'];
                            $content = html_entity_decode($zakladka[$language_id]['html']);
                        }
                        $tabs[] = array(
                            'heading' => $heading,
                            'content' => $content,
                            'sort' => $zakladka['sort_order']
                        );
                    }
                }
            }
          }
      }

      usort($tabs, "cmp_by_optionNumber");
  ?>
  <div class="product-tab <?php if($theme_options->get( 'position_product_tabs' ) == 5) { echo 'sticky-tabs'; } ?> <?php if($theme_options->get( 'position_product_tabs' ) == 2) { echo 'vertical-tabs'; } ?>" role="tabpanel">
  <?php if($theme_options->get( 'position_product_tabs' ) == 5) { ?>
  <div class="sticky-nav-tabs"><div class="container">
      <ul class="nav" role="tablist">
        <?php $i = 0; foreach($tabs as $tab) { $i++;
            $id = 'tab_'.$i;
            if($tab['content'] == 'description') { $id = 'tab-description'; }
            if($tab['content'] == 'attribute') { $id = 'tab-attribute'; }
            if($tab['content'] == 'review') { $id = 'tab-review'; }
            $class = false;
            if($i == 1) { $class = 'class="active"'; $new_active = $id; }
            echo '<li role="presentation" ' . $class . '><a href="#'.$id.'" aria-controls="'.$id.'" role="tab" data-toggle="tab">'.$tab['heading'].'</a></li>';
        } ?>
      </ul>
  </div></div>
  <?php } ?>
  <ul class="nav nav-tabs" role="tablist">
    <?php $i = 0; foreach($tabs as $tab) { $i++;
        $id = 'tab_'.$i;
        if($tab['content'] == 'description') { $id = 'tab-description'; }
        if($tab['content'] == 'attribute') { $id = 'tab-attribute'; }
        if($tab['content'] == 'review') { $id = 'tab-review'; }
        $class = false;
        if($i == 1) { $class = 'class="active"'; $new_active = $id; }
        echo '<li role="presentation" ' . $class . '><a href="#'.$id.'" aria-controls="'.$id.'" role="tab" data-toggle="tab">'.$tab['heading'].'</a></li>';
    } ?>
  </ul>
  <div class="tab-content">
  <?php $i = 0; foreach($tabs as $tab) { $i++;
    $id = 'tab_'.$i;
    if($tab['content'] != 'description' && $tab['content'] != 'attribute' && $tab['content'] != 'review') {
        echo '<div id="'.$id.'" class="tab-pane';
        if($new_active == $id) { echo ' active'; }
        echo '" role="tabpanel">'.$tab['content'].'</div>';
    }
  } ?>
 <div role="tabpanel" class="tab-pane <?php if($new_active == 'tab-description') { echo 'active'; } ?>" id="tab-description" itemprop="description"><?php echo $description; ?></div>
  <?php if ($attribute_groups) { ?>
  <div role="tabpanel" class="tab-pane" id="tab-attribute">
    <table class="attribute" cellspacing="0">
      <?php foreach ($attribute_groups as $attribute_group) { ?>
      <thead>
        <tr>
          <td colspan="2"><?php echo $attribute_group['name']; ?></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
        <tr>
          <td><?php echo $attribute['name']; ?></td>
          <td><?php echo $attribute['text']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php } ?>
    </table>
  </div>
  <?php } ?>
  <?php if ($review_status) { ?>
  <div id="tab-review" class="tab-pane" role="tabpanel">
    <form class="form-horizontal" id="form-review">
      <div id="review"></div>
      <h2><?php echo $text_write; ?></h2>
      <?php if ($review_guest) { ?>
      <div class="form-group required">
        <div class="col-sm-12">
          <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
          <input type="text" name="name" value="" id="input-name" class="form-control" />
        </div>
      </div>
      <div class="form-group required">
        <div class="col-sm-12">
             <label class="control-label"><?php echo $entry_rating; ?></label>

           <div class="rating set-rating">
              <i class="fa fa-star" data-value="1"></i>
              <i class="fa fa-star" data-value="2"></i>
              <i class="fa fa-star" data-value="3"></i>
              <i class="fa fa-star" data-value="4"></i>
              <i class="fa fa-star" data-value="5"></i>
          </div>
          <script type="text/javascript">
              $(document).ready(function() {
                $('.set-rating i').hover(function(){
                    var rate = $(this).data('value');
                    var i = 0;
                    $('.set-rating i').each(function(){
                        i++;
                        if(i <= rate){
                            $(this).addClass('active');
                        }else{
                            $(this).removeClass('active');
                        }
                    })
                })

                $('.set-rating i').mouseleave(function(){
                    var rate = $('input[name="rating"]:checked').val();
                    rate = parseInt(rate);
                    i = 0;
                      $('.set-rating i').each(function(){
                        i++;
                        if(i <= rate){
                            $(this).addClass('active');
                        }else{
                            $(this).removeClass('active');
                        }
                      })
                })

                $('.set-rating i').click(function(){
                    $('input[name="rating"]:nth('+ ($(this).data('value')-1) +')').prop('checked', true);
                });
              });
          </script>
          <div class="hidden">
             &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
             <input type="radio" name="rating" value="1" />
             &nbsp;
             <input type="radio" name="rating" value="2" />
             &nbsp;
             <input type="radio" name="rating" value="3" />
             &nbsp;
             <input type="radio" name="rating" value="4" />
             &nbsp;
             <input type="radio" name="rating" value="5" />
             &nbsp;<?php echo $entry_good; ?>
          </div>
       </div>
      </div>

      <div class="form-group required">
        <div class="col-sm-12">
          <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
          <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
          <div class="help-block"><?php echo $text_note; ?></div>
        </div>
      </div>
      <?php echo $captcha; ?>
      <div class="buttons clearfix" style="margin-bottom: 0px">
        <div class="pull-right">
          <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
        </div>
      </div>
      <?php } else { ?>
      <?php echo $text_login; ?>
      <?php } ?>
    </form>
  </div>
  <?php } ?>
  </div>
 </div>
<?php } ?>

 <?php if($theme_options->get( 'position_product_tabs' ) == 4) { ?>
   <?php
      $language_id = $config->get( 'config_language_id' );
      $tabs = array();

      $tabs[] = array(
        'heading' => $tab_description,
        'content' => 'description',
        'sort' => 1
      );

      if ($attribute_groups) {
          $tabs[] = array(
            'heading' => $tab_attribute,
            'content' => 'attribute',
            'sort' => 3
          );
      }

      if ($review_status) {
          $tabs[] = array(
            'heading' => $tab_review,
            'content' => 'review',
            'sort' => 5
          );
      }

      if(is_array($config->get('product_tabs'))) {
          foreach($config->get('product_tabs') as $tab) {
            if($tab['status'] == 1 || $tab['product_id'] == $product_id) {
                foreach($tab['tabs'] as $zakladka) {
                    if($zakladka['status'] == 1) {
                        $heading = false; $content = false;
                        if(isset($zakladka[$language_id])) {
                            $heading = $zakladka[$language_id]['name'];
                            $content = html_entity_decode($zakladka[$language_id]['html']);
                        }
                        $tabs[] = array(
                            'heading' => $heading,
                            'content' => $content,
                            'sort' => $zakladka['sort_order']
                        );
                    }
                }
            }
          }
      }

      usort($tabs, "cmp_by_optionNumber");
   ?>
   <div class="accordion-product-tab" id="product_tab_accordion">
    <?php $i = 0; foreach($tabs as $tab) { $i++;
        $id = 'tab_'.$i;
        if($tab['content'] == 'description') { $id = 'tab-description'; }
        if($tab['content'] == 'attribute') { $id = 'tab-attribute'; }
        if($tab['content'] == 'review') { $id = 'tab-review'; } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#product_tab_accordion" href="#<?php echo $id; ?>" <?php if($i != 1) { ?>class="collapsed"<?php } ?>><?php echo $tab['heading']; ?></a>
                </h4>
            </div>

            <div id="<?php echo $id; ?>" class="panel-collapse collapse <?php if($i == 1) { echo 'in'; } ?>">
                <div class="panel-body">
                    <?php if($tab['content'] != 'description' && $tab['content'] != 'attribute' && $tab['content'] != 'review') {
                        echo $tab['content'];
                    }
                    ?>

                    <?php if($tab['content'] == 'description') {
                        echo $description;
                    } ?>

                    <?php if($tab['content'] == 'attribute' && $attribute_groups) { ?>
                        <div role="tabpanel" class="tab-pane" id="tab-attribute">
                          <table class="attribute" cellspacing="0">
                            <?php foreach ($attribute_groups as $attribute_group) { ?>
                            <thead>
                              <tr>
                                <td colspan="2"><?php echo $attribute_group['name']; ?></td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                              <tr>
                                <td><?php echo $attribute['name']; ?></td>
                                <td><?php echo $attribute['text']; ?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                            <?php } ?>
                          </table>
                        </div>
                    <?php } ?>

                    <?php if($tab['content'] == 'review' && $review_status) { ?>
                        <div id="tab-review" class="tab-pane" role="tabpanel">
                            <form class="form-horizontal" id="form-review">
                              <div id="review"></div>
                              <h2><?php echo $text_write; ?></h2>
                              <?php if ($review_guest) { ?>
                              <div class="form-group required">
                                <div class="col-sm-12">
                                  <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                                  <input type="text" name="name" value="" id="input-name" class="form-control" />
                                </div>
                              </div>
                              <div class="form-group required">
                                <div class="col-sm-12">
                                     <label class="control-label"><?php echo $entry_rating; ?></label>

                                   <div class="rating set-rating">
                                      <i class="fa fa-star" data-value="1"></i>
                                      <i class="fa fa-star" data-value="2"></i>
                                      <i class="fa fa-star" data-value="3"></i>
                                      <i class="fa fa-star" data-value="4"></i>
                                      <i class="fa fa-star" data-value="5"></i>
                                  </div>
                                  <script type="text/javascript">
                                      $(document).ready(function() {
                                        $('.set-rating i').hover(function(){
                                            var rate = $(this).data('value');
                                            var i = 0;
                                            $('.set-rating i').each(function(){
                                                i++;
                                                if(i <= rate){
                                                    $(this).addClass('active');
                                                }else{
                                                    $(this).removeClass('active');
                                                }
                                            })
                                        })

                                        $('.set-rating i').mouseleave(function(){
                                            var rate = $('input[name="rating"]:checked').val();
                                            rate = parseInt(rate);
                                            i = 0;
                                              $('.set-rating i').each(function(){
                                                i++;
                                                if(i <= rate){
                                                    $(this).addClass('active');
                                                }else{
                                                    $(this).removeClass('active');
                                                }
                                              })
                                        })

                                        $('.set-rating i').click(function(){
                                            $('input[name="rating"]:nth('+ ($(this).data('value')-1) +')').prop('checked', true);
                                        });
                                      });
                                  </script>
                                  <div class="hidden">
                                     &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                                     <input type="radio" name="rating" value="1" />
                                     &nbsp;
                                     <input type="radio" name="rating" value="2" />
                                     &nbsp;
                                     <input type="radio" name="rating" value="3" />
                                     &nbsp;
                                     <input type="radio" name="rating" value="4" />
                                     &nbsp;
                                     <input type="radio" name="rating" value="5" />
                                     &nbsp;<?php echo $entry_good; ?>
                                  </div>
                               </div>
                              </div>

                              <div class="form-group required">
                                <div class="col-sm-12">
                                  <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
                                  <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                                  <div class="help-block"><?php echo $text_note; ?></div>
                                </div>
                              </div>
                              <?php echo $captcha; ?>
                              <div class="buttons clearfix" style="margin-bottom: 0px">
                                <div class="pull-right">
                                  <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
                                </div>
                              </div>
                              <?php } else { ?>
                              <?php echo $text_login; ?>
                              <?php } ?>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
  </div>
 <?php } ?>

  <?php if ($tags) { ?>
  <div class="tags_product"><b><?php echo $text_tags; ?></b>
    <?php for ($i = 0; $i < count($tags); $i++) { ?>
    <?php if ($i < (count($tags) - 1)) { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
    <?php } else { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>

  <?php if ($products && $theme_options->get( 'product_related_status' ) != '0') { ?>
  <?php if($theme_options->get( 'position_product_tabs' ) == 3) { echo '<div style="height: 15px"></div>'; } ?>
  <?php
  $class = 3;
  $id = rand(0, 5000)*rand(0, 5000);
  $all = 4;
  $row = 4;

  if($theme_options->get( 'product_per_pow' ) == 6) { $class = 2; }
  if($theme_options->get( 'product_per_pow' ) == 5) { $class = 25; }
  if($theme_options->get( 'product_per_pow' ) == 3) { $class = 4; }

  if($theme_options->get( 'product_per_pow' ) > 1) { $row = $theme_options->get( 'product_per_pow' ); $all = $theme_options->get( 'product_per_pow' ); }
  ?>
    <?php if($theme_options->get( 'product_scroll_related' ) != 0) { ?>
      <script type="text/javascript">
      $(document).ready(function() {
        var owl<?php echo $id; ?> = $("#myCarousel<?php echo $id; ?>");
        owl<?php echo $id; ?>.owlCarousel({
              loop:false,
              margin:16,
              responsiveClass:true,
              nav:true,
              navText: ['<i class="fa fa-chevron-left">', '<i class="fa fa-chevron-right">'],
              autoplay: true,
              autoplayTimeout: 10000,
              <?php if($page_direction[$config->get( 'config_language_id' )] == 'RTL'): ?>
              rtl: true,
              <?php endif; ?>
              responsive:{
                0:{
                    items:1
                },
                480: {
                    items:2
                },
                768:{
                    items:<?php echo $theme_options->get( 'product_per_pow' ); ?>
                }
              }
         });
      });
      </script>
        <div class="carousel-wrapper" style="margin-bottom: 30px">
          <h2 class="slider-title">
            <span class="inline-title"><?php echo $text_related; ?></span>
            <span class="line"></span>
          </h2>
          <div class="owl-carousel home-products-carousel" id="myCarousel<?php echo $id; ?>">
                <?php $i = 0; $row_fluid = 0; $item = 0; foreach ($products as $product) { ?>
                    <?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
                <?php } ?>
          </div>
        </div>
    <?php } else { ?>
        <div class="carousel-wrapper">
          <h2 class="slider-title">
            <span class="inline-title"><?php echo $text_related; ?></span>
            <span class="line"></span>
          </h2>
          <div>
              <?php $i = 0; $row_fluid = 0; $item = 0; foreach ($products as $product) { $row_fluid++; ?>
                <?php if($i == 0) { $item++; echo '<div class="active item"><div class="product-grid"><div class="row">'; } ?>
                <?php $r=$row_fluid-floor($row_fluid/$all)*$all; if($row_fluid>$all && $r == 1) { if($theme_options->get( 'product_scroll_related' ) != '0') { echo '</div></div></div><div class="item"><div class="product-grid"><div class="row">'; $item++; } else { echo '</div><div class="row">'; } } else { $r=$row_fluid-floor($row_fluid/$row)*$row; if($row_fluid>$row && $r == 1) { echo '</div><div class="row">'; } } ?>
                <div style="padding-bottom: 30px" class="col-sm-<?php echo $class; ?> col-xs-6 <?php if($class == 2) { echo 'col-md-25 col-lg-2 col-sm-3 '; } if($class == 2 && $r == 0) { echo 'hidden-md hidden-sm'; } if($class == 2 && $r == 5) { echo 'hidden-sm'; } ?> <?php if($class == 25) { echo 'col-md-25 col-lg-25 col-sm-3 '; } if($class == 25 && $r == 0) { echo 'hidden-sm'; } ?>">
                    <?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
                </div>
              <?php $i++; } ?>
              <?php if($i > 0) { echo '</div></div></div>'; } ?>
          </div>
        </div>
    <?php } ?>
  <?php } ?>

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
                $.notify({
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

                $('#mini-cart #cart_content').load('index.php?route=common/cart/info #cart_content_ajax');
                $('#mini-cart #total_item_ajax').load('index.php?route=common/cart/info #total_item');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
<?php if($theme_options->get( 'add_to_cart_sticky' ) == 1) { ?>
$('#button-cart2').on('click', function() {
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
                $.notify({
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

                $('#mini-cart #cart_content').load('index.php?route=common/cart/info #cart_content_ajax');
                $('#mini-cart #total_item_ajax').load('index.php?route=common/cart/info #total_item');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});
<?php } ?>
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
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
    $.ajax({
        url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
        type: 'post',
        dataType: 'json',
        data: $("#form-review").serialize(),
        beforeSend: function() {
            $('#button-review').button('loading');
        },
        complete: function() {
            $('#button-review').button('reset');
        },
        success: function(json) {
            $('.alert-success, .alert-danger').remove();

            if (json['error']) {
                $('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
            }

            if (json['success']) {
                $('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

                $('input[name=\'name\']').val('');
                $('textarea[name=\'text\']').val('');
                $('input[name=\'rating\']:checked').prop('checked', false);
            }
        }
    });
});
</script>

<script type="text/javascript"><!--
$(document).ready(function() {
    $('.popup-gallery').magnificPopup({
        delegate: 'a.popup-image',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-with-zoom',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            titleSrc: function(item) {
                return item.el.attr('title');
            }
        }
    });
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

<script type="text/javascript">
$.fn.tabs = function() {
    var selector = this;

    this.each(function() {
        var obj = $(this);

        $(obj.attr('href')).hide();

        $(obj).click(function() {
            $(selector).removeClass('selected');

            $(selector).each(function(i, element) {
                $($(element).attr('href')).hide();
            });

            $(this).addClass('selected');

            $($(this).attr('href')).show();

            return false;
        });
    });

    $(this).show();

    $(this).first().click();
};
</script>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php if($theme_options->get( 'product_image_zoom' ) != 2) {
echo '<script type="text/javascript" src="catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/js/jquery.elevateZoom-3.0.3.min.js"></script>';
} ?>

<?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>