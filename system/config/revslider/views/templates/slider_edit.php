	<input type="hidden" id="sliderid" value="<?php echo $sliderID?>"></input>
	
	<div class="wrap settings_wrap">
		<div class="clear_both"></div> 
		
			<div class="title_line">
				<div id="icon-options-general" class="icon32"></div>
				<?php
				if($sliderTemplate){
					?>
					<div class="view_title"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Edit_Slider_Template']?></div>
					<?php
					$template_value = 'true';
				}else{
					?>
					<div class="view_title"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Edit_Slider']?></div>
					<?php
					$template_value = 'false';
				}
				?>
				<input type="hidden" id="revslider_template" value="<?php echo $template_value; ?>"></input>
				
				<a href="<?php echo GlobalsRevSlider::LINK_HELP_SLIDER?>" class="button-secondary float_right mtop_10 mleft_10" target="_blank"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['help']?></a>			
				
			</div>
		
			<div class="settings_panel">
			
				<div class="settings_panel_left">
					
					<div id="main_dlier_settings_wrapper" class="postbox unite-postbox ">
					  <h3 class="box-closed"><i style="float:left;margin-top:4px;font-size:14px;" class="eg-icon-cog"></i><span><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Main_Slider_Settings'] ?></span></h3>
					  <div class="p10">


							<?php $settingsSliderMain->draw("form_slider_main",true)?>
							
							<div id="layout-preshow">
								<strong>Layout Example </strong><span style="font-size:11px;font-style:italic;"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['theme_style']?></span>
								<div class="divide20"></div>
								<div id="layout-preshow-page">
									<div class="layout-preshow-text">BROWSER</div>
									<div id="layout-preshow-theme">
											<div class="layout-preshow-text">PAGE</div>
									</div>
									<div id="layout-preshow-slider">
											<div class="layout-preshow-text">SLIDER</div>
									</div>
									<div id="layout-preshow-grid">
											<div class="layout-preshow-text">LAYERS GRID</div>										
									</div>
								</div>
							</div>
							
							<div class="divide20"></div>
							
							<a class='button-primary revgreen' href='javascript:void(0)' id="button_save_slider" ><i class="revicon-cog"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Save_Settings']?></a>
							<span id="loader_update" class="loader_round" style="display:none;"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['updating']?> </span>
							<span id="update_slider_success" class="success_message"></span>
							<a class='button-primary revred' id="button_delete_slider"  href='javascript:void(0)' id="button_delete_slider" ><i class="revicon-trash"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Delete_Slider']?></a>
							<a class='button-primary revyellow' id="button_close_slider_edit"  href='<?php echo self::getViewUrl("sliders") ?>' ><i class="revicon-cancel"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Close']?></a>							
							<a class="button-primary revblue" href="<?php echo $linksEditSlides?>"  id="link_edit_slides"><i class="revicon-pencil-1"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Edit_Slides']?> </a>												
							<a class="button-primary revgray" href="javascript:void(0)"  id="button_preview_slider" title="<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Preview_Slider']?>"><i class="revicon-search-1"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Preview']?></a>							
							<div class="clear"></div>

							<div class="divide20"></div>
					  </div>
					</div>
					 
					<?php require self::getPathTemplate("slider_toolbox"); ?>
					<?php require self::getPathTemplate("slider_api"); ?>
					<?php require self::getPathTemplate("slider_css_js"); ?>
					
					
				</div>
				<div class="settings_panel_right">
					<?php $settingsSliderParams->draw("form_slider_params",true); ?>
				</div>
				
				<div class="clear"></div>
				
			</div>

	</div>

	<?php require self::getPathTemplate("dialog_preview_slider");?>

	<script type="text/javascript">
		var g_jsonTaxWithCats = <?php echo $jsonTaxWithCats?>;
	
		jQuery(document).ready(function(){			
			RevSliderAdmin.initEditSliderView();
			
			<?php if($sliderTemplate){ ?>
			RevSliderAdmin.initSliderViewTemplate();
			<?php } ?>
		});
		
		
		
	</script>
