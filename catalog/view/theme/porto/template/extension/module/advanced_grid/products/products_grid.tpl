<?php 
if($registry->has('theme_options') == true) { 

$class = 3; 
$all = 4;
$id = rand(0, 5000)*rand(5000, 50000);

$theme_options = $registry->get('theme_options');
$config = $registry->get('config');

if(count($module['content']['products']) == 10) { $class = 25; $all = 5; }
if(count($module['content']['products']) == 6) { $class = 2; $all = 6; }
if(count($module['content']['products']) == 5) { $class = 25; $all = 5; }
if(count($module['content']['products']) == 3) { $class = 4;  $all = 3; }
if(count($module['content']['products']) == 2) { $class = 6; $all = 2; }
if(count($module['content']['products']) == 1) { $class = 12; $all = 1; } ?>

<div class="box clearfix box-with-products <?php if($module['content']['title'] == '') { echo 'without-heading'; } ?>">
  <?php if($module['content']['title'] != '') { ?>
  <div class="box-heading"><?php echo $module['content']['title']; ?></div>
  <div class="strip-line"></div>
  <?php } ?>
  <div class="clear"></div>
  <div class="box-content products">
    <div class="box-product">
    	<div id="myCarousel<?php echo $id; ?>">
    		<!-- Carousel items -->
    		<div class="carousel-inner">
    			<?php $i = 0; $row_fluid = 0; $item = 0; foreach ($module['content']['products'] as $product) { $row_fluid++; ?>
	    			<?php if($i == 0) { $item++; echo '<div class="active item"><div class="product-grid"><div class="row">'; } ?>
	    			<?php $r=$row_fluid-floor($row_fluid/$all)*$all; if($row_fluid>$all && $r == 1) { echo '</div><div class="row">'; } ?>
	    			<div class="col-sm-<?php echo $class; ?> <?php if($class != 12) { ?>col-xs-6<?php } ?> <?php if($class == 2) { echo 'col-md-25 col-lg-2 col-sm-3 '; } if($class == 2 && $r == 0) { echo 'hidden-md hidden-sm'; } if($class == 2 && $r == 5) { echo 'hidden-sm'; } ?> <?php if($class == 25) { echo 'col-md-25 col-lg-25 col-sm-3 '; } if($class == 25 && $r == 0) { echo 'hidden-sm'; } ?>">
	    				<?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
	    			</div>
    			<?php $i++; } ?>
    			<?php if($i > 0) { echo '</div></div></div>'; } ?>
    		</div>
		</div>
    </div>
  </div>
</div>
<?php } ?>