 <div class="category-banner">
 	<div class="full-width-image-banner" style="<?php if($background_color != '') { echo 'background-color: ' . $background_color . ';'; } if($background_image != '') { echo 'background-image: url(image/' . $background_image . ');background-repeat: ' . $background_image_repeat . ';background-position: ' . $background_image_position . ';'; } ?>">
 		<?php echo $block_content; ?>
 	</div>
 </div>