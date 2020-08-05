<?php echo $header;
if(isset($mfilter_json)) {
    if(!empty($mfilter_json)) {
        echo '<div id="mfilter-json" style="display:none">' . base64_encode( $mfilter_json ) . '</div>';
    }
}

$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/wrapper_top.tpl'); ?>

<div id="mfilter-content-container">
    <label class="control-label" for="input-search"><b><?php echo $entry_search; ?></b></label>
    <div class="row" id="content-search">
      <div class="col-sm-4">
        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control" />
      </div>
      <div class="col-sm-3">
        <select name="category_id" class="form-control">
          <option value="0"><?php echo $text_category; ?></option>
          <?php foreach ($categories as $category_1) { ?>
          <?php if ($category_1['category_id'] == $category_id) { ?>
          <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
          <?php } ?>
          <?php foreach ($category_1['children'] as $category_2) { ?>
          <?php if ($category_2['category_id'] == $category_id) { ?>
          <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
          <?php } ?>
          <?php foreach ($category_2['children'] as $category_3) { ?>
          <?php if ($category_3['category_id'] == $category_id) { ?>
          <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
          <?php } ?>
          <?php } ?>
          <?php } ?>
          <?php } ?>
        </select>
      </div>
      <div class="col-sm-3" style="padding-top: 7px">
        <label class="checkbox-inline">
          <?php if ($sub_category) { ?>
          <input type="checkbox" name="sub_category" value="1" checked="checked" />
          <?php } else { ?>
          <input type="checkbox" name="sub_category" value="1" />
          <?php } ?>
          <?php echo $text_sub_category; ?></label>
      </div>
    </div>
    <p>
      <label class="checkbox-inline">
        <?php if ($description) { ?>
        <input type="checkbox" name="description" value="1" id="description" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="description" value="1" id="description" />
        <?php } ?>
        <?php echo $entry_description; ?></label>
    </p>
    <input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary" />
    <h2 style="padding-top: 20px;font-size: 20px"><?php echo $text_search; ?></h2>

  <?php if ($products) { ?>
  <!-- Filter -->
  <div class="product-filter clearfix">
    <div class="sort">
        <?php echo $text_sort; ?>
        <select onchange="location = this.value;">
          <?php foreach ($sorts as $sorts) { ?>
          <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
          <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
    </div>

    <div class="options">
        <div class="button-group display" data-toggle="buttons-radio">
            <button id="grid" <?php if($theme_options->get('default_list_grid') == '1') { echo 'class="active"'; } ?> rel="tooltip" title="Grid" onclick="display('grid');"></button>
            <button id="list" <?php if($theme_options->get('default_list_grid') != '1') { echo 'class="active"'; } ?> rel="tooltip" title="List" onclick="display('list');"></button>
        </div>
    </div>

    <div class="product-compare"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div>

    <?php echo $pagination; ?>
    <div class="limit">
        <?php echo $text_limit; ?>
        <select onchange="location = this.value;">
          <?php foreach ($limits as $limitm) { ?>
          <?php if ($limitm['value'] == $limit) { ?>
          <option value="<?php echo $limitm['href']; ?>" selected="selected"><?php echo $limitm['text']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $limitm['href']; ?>"><?php echo $limitm['text']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
    </div>
  </div>

  <!-- Products list -->
  <div class="product-list"<?php if(!($theme_options->get('default_list_grid') == '1')) { echo ' class="active"'; } ?>>
    <?php foreach ($products as $product) { ?>
    <div class="item">
        <div class="item-area clearfix">
            <div class="product-image-area">
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
                </div><!-- End .product-image -->
            </div>

            <div class="details-area">
                <h2 class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h2>
                <?php if ($product['rating'] && $theme_options->get( 'display_rating' ) != '0') { ?>
                <div class="rating-wrap">
                    <div class="rating-content">
                        <div class="star-rating add-tooltip" title="<?php echo $product['rating']; ?>.00">
                            <span style="width:<?php echo $product['rating']*20; ?>%"><?php echo $product['rating']; ?>.00</span>
                        </div><!-- End .star-rating -->
                    </div><!-- End .rating-content -->
                </div><!-- End .rating-wrap -->
                <?php } ?>

                <div class="short-desc">
                    <?php echo $product['description']; ?>
                </div>

                <div class="action-area">
                    <div class="price-box">
                        <span class="price">
                            <?php if (!$product['special']) { ?>
                            <?php echo '<ins><span class="amount">' . $product['price'] . '</span></ins>'; ?>
                            <?php } else { ?>
                            <del><span class="amount"><?php echo $product['price']; ?></span></del> <ins><span class="amount"><?php echo $product['special']; ?></span></ins>
                            <?php } ?>
                        </span>
                    </div>

                    <div class="actions">
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

                        <?php if($theme_options->get( 'display_add_to_wishlist' ) != '0') { ?>
                        <a onclick="wishlist.add('<?php echo $product['product_id']; ?>');" class="product-btn btn-wishlist" title="Wishlist"><i class="fa fa-heart-o"></i></a>
                        <?php } ?>

                        <?php if($theme_options->get( 'quick_view' ) == 1) { ?>
                        <div class="quickview"><a href="index.php?route=product/quickview&product_id=<?php echo $product['product_id']; ?>" class="quickviewlink quickview-icon" title="<?php if($theme_options->get( 'quickview_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'quickview_text', $config->get( 'config_language_id' ) )); } else { echo 'Quick View'; } ?>"><i class="fa fa-search"></i></a></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
  </div>

  <!-- Products grid -->
  <?php
  $class = 3;
  $row = 4;

  if($theme_options->get( 'product_per_pow2' ) == 6) { $class = 2; }
  if($theme_options->get( 'product_per_pow2' ) == 5) { $class = 25; }
  if($theme_options->get( 'product_per_pow2' ) == 3) { $class = 4; }

  if($theme_options->get( 'product_per_pow2' ) > 1) { $row = $theme_options->get( 'product_per_pow2' ); }
  ?>
  <div class="product-grid"<?php if($theme_options->get('default_list_grid') == '1') { echo ' class="active"'; } ?>>
    <div class="row">
        <?php $row_fluid = 0; foreach ($products as $product) { $row_fluid++; ?>
            <?php $r=$row_fluid-floor($row_fluid/$row)*$row; if($row_fluid>$row && $r == 1) { echo '</div><div class="row">'; } ?>
            <div class="col-sm-<?php echo $class; ?> col-xs-6">
                <?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
            </div>
        <?php } ?>
    </div>
  </div>
  <div class="row pagination-results">
    <div class="limit">
        <?php echo $text_limit; ?>
        <select onchange="location = this.value;">
          <?php foreach ($limits as $limitm) { ?>
          <?php if ($limitm['value'] == $limit) { ?>
          <option value="<?php echo $limitm['href']; ?>" selected="selected"><?php echo $limitm['text']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $limitm['href']; ?>"><?php echo $limitm['text']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
    </div>
    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
  </div>
  <?php } else { ?>
  <p style="padding-bottom: 10px"><?php echo $text_empty; ?></p>
  <?php } ?>
</div>
<script type="text/javascript"><!--
$('#content-search input[name=\'search\']').keydown(function(e) {
    if (e.keyCode == 13) {
        $('#button-search').trigger('click');
    }
});

$('select[name=\'category_id\']').bind('change', function() {
    if (this.value == '0') {
        $('input[name=\'sub_category\']').attr('disabled', 'disabled');
        $('input[name=\'sub_category\']').removeAttr('checked');
    } else {
        $('input[name=\'sub_category\']').removeAttr('disabled');
    }
});

$('select[name=\'category_id\']').trigger('change');

$('#button-search').bind('click', function() {
    url = 'index.php?route=product/search';

    var search = $('#content-search input[name=\'search\']').attr('value');

    if (search) {
        url += '&search=' + encodeURIComponent(search);
    }

    var category_id = $('#content select[name=\'category_id\']').attr('value');

    if (category_id > 0) {
        url += '&category_id=' + encodeURIComponent(category_id);
    }

    var sub_category = $('#content input[name=\'sub_category\']:checked').attr('value');

    if (sub_category) {
        url += '&sub_category=true';
    }

    var filter_description = $('#content input[name=\'description\']:checked').attr('value');

    if (filter_description) {
        url += '&description=true';
    }

    location = url;
});

function display(view) {

    if (view == 'list') {
        $('.product-grid').removeClass("active");
        $('.product-list').addClass("active");

        $('.display').html('<button id="grid" rel="tooltip" title="Grid" onclick="display(\'grid\');"></button> <button class="active" id="list" rel="tooltip" title="List" onclick="display(\'list\');"></button>');

        localStorage.setItem('display', 'list');
    } else {

        $('.product-grid').addClass("active");
        $('.product-list').removeClass("active");

        $('.display').html('<button class="active" id="grid" rel="tooltip" title="Grid" onclick="display(\'grid\');"></button> <button id="list" rel="tooltip" title="List" onclick="display(\'list\');"></button>');

        localStorage.setItem('display', 'grid');
    }
}

if (localStorage.getItem('display') == 'list') {
    display('list');
} else if (localStorage.getItem('display') == 'grid') {
    display('grid');
} else {
    display('<?php if($theme_options->get('default_list_grid') == '1') { echo 'grid'; } else { echo 'list'; } ?>');
}
//--></script>
<?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>