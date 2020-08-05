	<div class="wrap settings_wrap">
		<div class="clear_both"></div>
			<div class="title_line">
				<div id="icon-options-general" class="icon32"></div>
				<?php
				if($sliderTemplate){
					?>
					<div class="view_title"><i class="revicon-pencil-1"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var

['New_Slider_Temp']?></div>
					<?php
					$template_value = 'true';
				}else{
					?>
					<div class="view_title"><i class="revicon-pencil-1"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var

['New_Sldr']?></div>
					<?php
					$template_value = 'false';
				}
				?>
				<input type="hidden" id="revslider_template" value="<?php echo $template_value; ?>"></input>

				<a href="<?php echo GlobalsRevSlider::LINK_HELP_SLIDER?>" class="button-secondary float_right mtop_10 mleft_10" target="_blank"><?php echo ControllerExtensionModulerevslideropencart::$lang_var

['help']?></a>

			</div>
			<div class="settings_panel">
				<div class="settings_panel_left">
					<div id="main_dlier_settings_wrapper" class="postbox unite-postbox ">
					  <h3 class="box-closed"><span><?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Main_Slider_Settings'] ?></span></h3>
					  <div class="p10">
							<?php $settingsSliderMain->draw("form_slider_main",true)?>

							<div id="layout-preshow">
								<strong>Layout Example</strong><?php echo ControllerExtensionModulerevslideropencart::$lang_var

['theme_style']?>
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
							<a id="button_save_slider" class='button-primary revgreen' href='javascript:void(0)' ><i class="revicon-cog"></i><span id="create_slider_text"><?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Create_Slider']?></span></a>

							<span class="hor_sap"></span>
							<a id="button_cancel_save_slider" class='button-primary revred' href='<?php echo self::getViewUrl("sliders") ?>' ><i class="revicon-cancel"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Close']?> </a>
					  </div>
					</div>
				</div>
				<div class="settings_panel_right">
					<?php $settingsSliderParams->draw("form_slider_params",true); ?>
				</div>
				<div class="clear"></div>
			</div>
	</div>

	<script type="text/javascript">
		var g_jsonTaxWithCats = <?php echo $jsonTaxWithCats?>;

		jQuery(document).ready(function(){

			RevSliderAdmin.initAddSliderView();
			
			<?php if($sliderTemplate){ ?>
			RevSliderAdmin.initSliderViewTemplate();
			<?php } ?>
		});
	</script>

