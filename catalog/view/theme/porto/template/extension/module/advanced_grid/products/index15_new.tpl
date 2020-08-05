<?php 
if($registry->has('theme_options') == true) { 

$class = 3; 
$all = 4;
$id = rand(0, 5000)*rand(5000, 50000);

$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
$page_direction = $theme_options->get( 'page_direction' );

if(count($module['content']['products']) == 6) { $class = 2; $all = 6; }
if(count($module['content']['products']) == 5) { $class = 25; $all = 5; }
if(count($module['content']['products']) == 3) { $class = 4;  $all = 3; }
if(count($module['content']['products']) == 2) { $class = 6; $all = 2; }
if(count($module['content']['products']) == 1) { $class = 12; $all = 1; } ?>

<div class="box clearfix index15newproducts box-with-products products-grid-with-carousel">
  <?php if($module['content']['title'] != '') { ?>
  <div class="box-heading"><?php echo $module['content']['title']; ?></div>
  <div class="strip-line"></div>
  <?php } ?>
  <div class="clear"></div>
  <div class="box-content products">
    <div class="box-product">
    	<div id="myCarousel<?php echo $id; ?>">
    	     <div class="owl-carousel">
         		<?php foreach ($module['content']['products'] as $product) { ?>
     	    		<div class="item">
     	    			<div class="product-grid"><?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?></div>
     	    		</div>
         		<?php } ?>
    		</div>
     </div>
   </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
 $("#myCarousel<?php echo $id; ?> .owl-carousel").owlCarousel({
 	margin: 30,
 	responsive:{
 		0:{
 			items:1
 		},
 		480: {
 			items:2
 		},
 		768:{
 			items:3
 		},
 		1000:{
 			items:4
 		}
 	},
     <?php if($page_direction[$config->get( 'config_language_id' )] == 'RTL'): ?>
     rtl: true
     <?php endif; ?>
  });
});
</script>
<?php } ?>