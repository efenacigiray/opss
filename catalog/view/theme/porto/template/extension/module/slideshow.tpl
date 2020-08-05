<?php
if($registry->has('theme_options') == false) { 
 header("location: themeinstall/index.php"); 
 exit; 
}
$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
$page_direction = $theme_options->get( 'page_direction' );
?>

<div class="container">
     <div class="camera_slider">
     	<div class="camera_wrap" id="camera_wrap_<?php echo $module+20; ?>">
     		<?php foreach ($banners as $banner) { ?>
     		<?php if ($banner['link']) { ?>
     		<a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a>
     		<?php } else { ?>
     		<img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
     		<?php } ?>
     		<?php } ?>
     	</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  var camera_slider = $("#camera_wrap_<?php echo $module+20; ?>");
    
  camera_slider.owlCarousel({
  	  slideSpeed : 300,
  	  lazyLoad : true,
      items: 1,
      autoPlay: 7000,
      stopOnHover: true,
      navigation: true,
      navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
      <?php if($page_direction[$config->get( 'config_language_id' )] == 'RTL'): ?>
      rtl: true
      <?php endif; ?>
   });
});
</script>