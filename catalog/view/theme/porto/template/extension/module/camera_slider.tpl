<?php
if($registry->has('theme_options') == false) { 
 header("location: themeinstall/index.php"); 
 exit; 
}
$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
$page_direction = $theme_options->get( 'page_direction' );
?>

<div class="<?php if($slider['settings']['layout_type'] == 1) { echo 'container'; } else { echo 'fullwidth'; } ?>" id="camera_<?php echo $slider['id']; ?>">
	<div class="camera_slider">
		<div class="spinner"></div>
		<div class="camera_wrap" id="camera_wrap_<?php echo $slider['id']; ?>" style="height: <?php echo $slider['settings']['slider_height']; ?>px">
			<?php foreach($slider['content'] as $sliders) {
				if($sliders[$language_id]['status'] == 1) { 
					$link = false;
					$image = $sliders[$language_id]['slider'];
					
					if($sliders[$language_id]['link'] != '') {
						$link = $sliders[$language_id]['link'];
					} ?>
					<div><?php if($link) { echo '<a href="' . $link . '">'; } ?><img src="image/<?php echo $image; ?>" alt="Slider"><?php if($link) { echo '</a>'; } ?></div>
			<?php	}
			} ?>
		</div>
	</div>
</div>

<script type="text/javascript">
 var camera_slider = $("#camera_wrap_<?php echo $slider['id']; ?>");
    
 camera_slider.owlCarousel({
 	 slideSpeed : 300,
  	 lazyLoad : true,
     items: 1,
     autoPlay: 7000,
     stopOnHover: true,
     nav: true,
     navText: ['', ''],
     <?php if($page_direction[$config->get( 'config_language_id' )] == 'RTL'): ?>
     rtl: true,
     <?php endif; ?>
  });

$(window).load(function() {	
  $("#camera_<?php echo $slider['id']; ?> .spinner").fadeOut(200);
  $("#camera_wrap_<?php echo $slider['id']; ?>").css("height", "auto");
});	
</script>