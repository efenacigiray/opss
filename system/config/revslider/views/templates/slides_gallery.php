	
	<div class="wrap settings_wrap">
	
		<div class="clear_both"></div> 
	
		<div class="title_line">
			<div id="icon-options-general" class="icon32"></div>
			<div class="view_title"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Edit_Slides']?>: <?php echo $slider->getTitle()?></div>
			
			<a href="<?php echo GlobalsRevSlider::LINK_HELP_SLIDE_LIST?>" class="button-secondary float_right mtop_10 mleft_10" target="_blank"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['help']?></a>			
			
		</div>
		
		<div class="vert_sap"></div>
		<?php if($numSlides >= 5){ ?>
			<a class='button-primary revblue' id="button_new_slide_top" href='javascript:void(0)' ><i class="revicon-list-add"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['New_Slide']?></a>

			<a class='button-primary revblue' id="button_new_slide_transparent_top" href='javascript:void(0)' ><i class="revicon-list-add"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['New_Transparent']?></a>
			<span class="loader_round new_trans_slide_loader" style="display:none"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Adding_Slide']?></span>		

			<a class="button-primary revyellow" href='<?php echo self::getViewUrl(RevSliderAdmin::VIEW_SLIDERS);?>' ><i class="revicon-cancel"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Close']?></a>
		<?php } ?>
		
		<?php if($wpmlActive == true){ ?>
			<div id="langs_float_wrapper" class="langs_float_wrapper" style="display:none">
				<?php echo $langFloatMenu?>
			</div>
		<?php } ?>
				
		<div class="vert_sap"></div>
		<div class="sliders_list_container">
			<?php require self::getPathTemplate("slides_list");?>
		</div>
		<div class="vert_sap_medium"></div>
		<a class='button-primary revblue' id="button_new_slide" data-dialogtitle="<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Select_image']?>" href='javascript:void(0)' ><i class="revicon-list-add"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['New_Slide']?></a>
		<a class='button-primary revblue' id="button_new_slide_transparent" href='javascript:void(0)' ><i class="revicon-list-add"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['New_Transparent']?></a>
		<span class="loader_round new_trans_slide_loader" style="display:none"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Adding_Slide']?></span>
		<?php
		if($useStaticLayers == 'on'){
			?>		
			<a class='button-primary revgray' href='<?php echo self::getViewUrl(RevSliderAdmin::VIEW_SLIDE,"id=static_".$slider->getID()); ?>' style="width:150px; "><i class="eg-icon-lock"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Static_Global']?></a>
			<?php
		}
		?>
		<a class="button-primary revyellow" href='<?php echo self::getViewUrl(RevSliderAdmin::VIEW_SLIDERS);?>' ><i class="revicon-cancel"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Close']?></a>		
		<a href="<?php echo $linksSliderSettings?>" class="button-primary revgreen"><i class="revicon-cog"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['To_Settings']?></a>		

		
	</div>
	
	<div id="dialog_copy_move" data-textclose="<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Close']?>" data-textupdate="<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Do_It']?>" title="<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Copy_move_slide']?>" style="display:none">
		
		<br>
		
		<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Choose_Slider']?> :
		<?php echo $selectSliders?>
		
		<br><br>
		
		<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Choose_Operation']?> :
		 
		<input type="radio" id="radio_copy" value="copy" name="copy_move_operation" checked />
		<label for="radio_copy" style="cursor:pointer;"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Copy']?></label>
		&nbsp; &nbsp;
		<input type="radio" id="radio_move" value="move" name="copy_move_operation" />
		<label for="radio_move" style="cursor:pointer;"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Move']?></label>		
		
	</div>
	
	<?php require self::getPathTemplate("dialog_preview_slide");?>
	
	<script type="text/javascript">
	
		var g_patternViewSlide = '<?php echo $patternViewSlide?>';
		
		var g_messageChangeImage = "<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Select_Slide_Image']?>";
		
		jQuery(document).ready(function() {
			var g_messageDeleteSlide = "<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Delete_this_Slide']?>";
			RevSliderAdmin.initSlidesListView("<?php echo $sliderID?>");
			
		});
		
	</script>
	