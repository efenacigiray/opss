	<div class="wrap settings_wrap">

	

		<div class="title_line">

			<div id="icon-options-general" class="icon32"></div>		

			<div class="view_title"><?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Edit_Slides'];?>: <?php echo $slider->getTitle()?></div>

				

		</div>

	

		<div class="vert_sap"></div>

		<?php echo ControllerExtensionModulerevslideropencart::$lang_var

['multiple_sources'];?> &nbsp;

		

		<?php if($showSortBy == true): ?> 

			<?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Sort_by'];?>: <?php echo $selectSortBy?> &nbsp; <span class="hor_sap"></span>

		<?php endif?>

		

		<?php // echo $linkNewPost?>

		<span id="slides_top_loader" class="slides_posts_loader" style="display:none;"><?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Updating_Sorting'];?></span>

		
		<div class="vert_sap"></div>

		<div class="sliders_list_container">
			<?php require self::getPathTemplate("slides_list_posts"); ?>
		</div>

		<div class="vert_sap_medium"></div>

		<div class="list_slides_bottom">
			<?php // echo $linkNewPost?>
			<a class="button-primary revyellow" href='<?php echo self::getViewUrl(RevSliderAdmin::VIEW_SLIDERS);?>' ><i class="revicon-cancel"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Close'];?></a>
			<a href="<?php echo $linksSliderSettings?>" class="button-primary revgreen"><i class="revicon-cog"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Slider_Settings'];?></a>
		</div>

		

	</div>



	

	<script type="text/javascript">

		var g_messageDeleteSlide = "<?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Warning_Removing'];?>";

		var g_messageChangeImage = "<?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Select_Slide_Image'];?>";

		

		jQuery(document).ready(function() {

			

			RevSliderAdmin.initSlidesListViewPosts("<?php echo $sliderID?>");

			

		});

		

	</script>

