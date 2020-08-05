<div class="punch_font_wrap block_bg_white m_bottom_15">
	<h2><?php echo "Punch Fonts"; ?></h2>

	<div id="eg-grid-google-font-wrapper">
		<?php
		$fonts = new ThemePunch_Fonts();
		$custom_fonts = $fonts->get_all_fonts();
		
		if(!empty($custom_fonts)){
			foreach($custom_fonts as $font){
				$cur_font = $font['url'];
				$cur_font = explode('+', $cur_font);
				$cur_font = implode(' ', $cur_font);
				$cur_font = explode(':', $cur_font);
				
				$title = $cur_font['0'];
				
				?>
				<div class="postbox eg-postbox" style="width:100%;min-width:500px">
					<h3 class="box-closed"><span style="font-weight:400"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Font_Family']; ?></span><span style="text-transform:uppercase;"><?php echo $title; ?> </span><div class="postbox-arrow"></div></h3>
					<div class="inside" style="display:none;padding:0px !important;margin:0px !important;height:100%;position:relative;background:#ebebeb">
						<div class="tp-googlefont-row">
							<div class="eg-cus-row-l"><label><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Handle']; ?></label> tp-<input type="text" name="esg-font-handle[]" value="<?php echo @$font['handle']; ?>" readonly="readonly"></div>
							<div class="eg-cus-row-l"><label><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Parameter']; ?></label><input type="text" name="esg-font-url[]" value="<?php echo @$font['url']; ?>"></div>
						</div>
						<div class="tp-googlefont-save-wrap-settings">
							<a class="button-primary revblue eg-font-edit" href="javascript:void(0);"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Edit']; ?></a>
							<a class="button-primary revred eg-font-delete" href="javascript:void(0);"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Remove']; ?></a>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
		<div>
			<i style="font-size:10px;color:#777"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Google_Font_desc']; ?></i>
		</div>
	</div>
</div>
	<a class="button-primary revblue" id="eg-font-add" href="javascript:void(0);"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Add_New_Font']; ?></a>
	
	<div id="font-dialog-wrap" class="essential-dialog-wrap" title="<?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Add_Font']; ?>"  style="display: none; padding:20px !important;">
		
		<div class="tp-googlefont-cus-row-l"><label><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Handle']; ?></label><span style="margin-left:-20px;margin-right:2px;"><strong>tp-</strong></span><input type="text" name="eg-font-handle" value="" /></div>
		<div style="margin-top:0px; padding-left:100px; margin-bottom:20px;">
			<i style="font-size:12px;color:#777; line-height:20px;"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Unique_handle']; ?></i>
		</div>
		<div class="tp-googlefont-cus-row-l"><label><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Parameter']; ?></label><input type="text" name="eg-font-url" value="" /></div>
		<div style="padding-left:100px;">
			<i style="font-size:12px;color:#777; line-height:20px;"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Google_Font_desc']; ?></i>
		</div>
		
	</div>
	
	
	<script type="text/javascript">
		jQuery(function(){
			UniteAdminRev.initGoogleFonts();
			UniteAdminRev.initAccordion();
		});
	</script>