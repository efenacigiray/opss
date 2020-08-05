<div id="dialog_update_plugin" class="api_wrapper" title="<?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Update_Slider_Plugin']?>" style="display:none;">
	<div class="api-caption"><?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Update_rev_Slider_Plugin']?>:</div>
	<div class="api-desc">
		<?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Update_rev_Slider_Plugin_desc'] ?>
		<br> <?php echo ControllerExtensionModulerevslideropencart::$lang_var

['File_example']?>
	</div>
	<br>
	<form action="<?php echo UniteBaseClassRev::$url_ajax?>" enctype="multipart/form-data" method="post">
		<input type="hidden" name="action" value="revslider_ajax_action">
		<input type="hidden" name="client_action" value="update_plugin">		
		<?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Choose_update_file']?>   
		<br>
		<input type="file" name="update_file" class="input_update_slider">
		<input type="submit" class='button-secondary' value="<?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Update_Slider']?>">
	</form>
</div>



