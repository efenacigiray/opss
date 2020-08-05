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

<div class="index15newmasonrygrid">
	<?php if($module['content']['title'] != '') { ?>
	<div class="box-heading"><?php echo $module['content']['title']; ?></div>
	<?php } ?>
	
	<div class="masonry-grid">
		<div class="grid double">
			<?php $i = 0; foreach ($module['content']['products'] as $product) { $i++; ?>
				<?php if($i == 2 || $i == 4 || $i == 6 || $i == 8 || $i == 10) { echo '</div><div class="grid">'; } ?>
				<div class="item">
					<?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php } ?>