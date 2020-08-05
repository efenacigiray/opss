<?php 
if($registry->has('theme_options') == true) { 

$class = 25; 
$all = 5;
$id = rand(0, 5000)*rand(5000, 50000);

$theme_options = $registry->get('theme_options');
$config = $registry->get('config'); ?>

<div class="index20-products-tabs row">
  <div class="category-list col-sm-2">
       <div class="description"><?php echo $module['content']['title']; ?></div>
       <ul id="matrialtab<?php echo $id; ?>" class="select-tab clearfix">
       	<?php $i = 0; foreach($module['content']['products_tabs'] as $product_tab) {
       		echo '<li'.($i == 0 ? ' class="active"' : '').'><a href="#matrialartstabs-'.$id.'-'.$i.'">'.$product_tab['name'].'</a></li>';
       	$i++; } ?>
       </ul>
  </div>
  
  <div class="category-detail col-sm-10">
       <div class="tab-content clearfix">
            <?php $s = 0; foreach($module['content']['products_tabs'] as $product_tab) { ?>
            <div class="tab-pane <?php if($s == 0) { echo 'active'; } ?>" id="matrialartstabs-<?php echo $id.'-'.$s; ?>">
                   <div class="box-content products">
                     <div class="box-product">
                     	<div id="myCarousel<?php echo $id; ?>">
                     		<!-- Carousel items -->
                     		<div class="carousel-inner">
                     			<?php $i = 0; $row_fluid = 0; $item = 0; foreach ($product_tab['products'] as $product) { $row_fluid++; ?>
                 	    			<?php if($i == 0) { $item++; echo '<div class="active item"><div class="product-grid"><div class="row">'; } ?>
                 	    			<div class="col-sm-<?php echo $class; ?> <?php if($class != 12) { ?>col-xs-6<?php } ?> <?php if($i > 9) { echo 'hidden-product'; } ?>">
                 	    				<?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
                 	    			</div>
                     			<?php $i++; } ?>
                     			<?php if($i > 0) { echo '</div></div></div>'; } ?>
                     		</div>
                 		</div>
                     </div>
                 </div>
                 
                 <?php if($i>10) { ?><div class="skin20-loader-products"></div><div class="text-center"><a href="#" class="skin20-load-more-products" title="matrialartstabs-<?php echo $id.'-'.$s; ?>"><?php if($theme_options->get( 'load_more_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'load_more_text', $config->get( 'config_language_id' ) )); } else { echo 'Load more'; } ?></a></div><?php } ?>
            </div>
            <?php $s++; } ?>
       </div>
  </div>
</div>     

<script type="text/javascript">
$('#matrialtab<?php echo $id; ?> a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
</script>
<?php } ?>