<?php 
if($registry->has('theme_options') == true) { 

$class = 2; 
$all = 6;
$id = rand(0, 5000)*rand(5000, 50000);

$theme_options = $registry->get('theme_options');
$config = $registry->get('config'); ?>

<div class="justarrived">
	<?php if($module['content']['title'] != '') { ?>
	<h2 class="slider-title">
		<span class="inline-title"><?php echo $module['content']['title']; ?></span>
		<span class="line" style="width: 100%"></span>
	</h2>
	<?php } ?>
	<?php $i = 0; $row_fluid = 0; $item = 0; foreach ($module['content']['products'] as $product) { $row_fluid++; ?>
		<?php if($i == 0) { $item++; echo '<div class="active item"><div class="product-grid"><div class="row">'; } ?>
		<?php $r=$row_fluid-floor($row_fluid/$all)*$all; if($row_fluid>$all && $r == 1) { echo '</div><div class="row">'; } ?>
		<div class="col-sm-<?php echo $class; ?> <?php if($class != 12) { ?>col-xs-6<?php } ?> <?php if($class == 2) { echo 'col-md-25 col-lg-2 col-sm-3 '; } if($class == 2 && $r == 0) { echo 'hidden-md hidden-sm'; } if($class == 2 && $r == 5) { echo 'hidden-sm'; } ?> <?php if($class == 25) { echo 'col-md-25 col-lg-25 col-sm-3 '; } if($class == 25 && $r == 0) { echo 'hidden-sm'; } ?>">
			<?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
		</div>
	<?php $i++; } ?>
	<?php if($i > 0) { echo '</div></div></div>'; } ?>
</div>
<?php } ?>