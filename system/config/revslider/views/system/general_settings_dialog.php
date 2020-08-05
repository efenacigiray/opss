<?php 
//$generalSettings = self::getSettings("general");
//$settingsOutput = new UniteSettingsRevProductRev();
//$settingsOutput->init($generalSettings);
function checked($includes_globally, $arg = 'on'){
	//return true;
}
$generalSettings = self::getSettings("general");
$role = $generalSettings->getSettingValue("role",UniteBaseAdminClassRev::ROLE_ADMIN);
$includes_globally = $generalSettings->getSettingValue("includes_globally",'on');
$pages_for_includes = $generalSettings->getSettingValue("pages_for_includes",'');
$js_to_footer = $generalSettings->getSettingValue("js_to_footer",'off');
$show_dev_export = $generalSettings->getSettingValue("show_dev_export",'off');

$enable_logs = $generalSettings->getSettingValue("enable_logs",'off');
?>

<div id="dialog_general_settings" title="<?php echo ControllerExtensionModulerevslideropencart::$lang_var

['general_settings'];?>" style="display:none;">
	<div class="settings_wrapper unite_settings_wide">
		<form name="form_general_settings" id="form_general_settings">
				<script type="text/javascript">
					g_settingsObj['form_general_settings'] = {}					
				</script>
				<table class="form-table">				
					<tbody>												
						<tr id="show_dev_export_row" valign="top">
							<th scope="row">
								<?php echo ControllerExtensionModulerevslideropencart::$lang_var

['Export_option']; ?>
							</th>
							<td>
								<span id="js_to_footer_wrapper" class="radio_settings_wrapper">
									<div class="radio_inner_wrapper">
										<input type="radio" id="show_dev_export_1" value="on" name="show_dev_export" <?php checked($show_dev_export, 'on'); ?>>
										<label for="show_dev_export_1" style="cursor:pointer;"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['On']; ?></label>
									</div>
					
									<div class="radio_inner_wrapper">
										<input type="radio" id="show_dev_export_2" value="off" name="show_dev_export" <?php checked($show_dev_export, 'off'); ?>>
										<label for="show_dev_export_2" style="cursor:pointer;"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['off']; ?></label>
									</div>					
								</span>					
								<div class="description_container">
									<span class="description"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['export_Slider']?></span>				
								</div>
							</td>
						</tr>
						<tr id="use_hammer_js_row" valign="top">
							<th scope="row">
								<?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Enable_Logs']; ?>
							</th>
							<td>
								<span id="enable_logs_wrapper" class="radio_settings_wrapper">
									<div class="radio_inner_wrapper">
										<input type="radio" id="enable_logs_1" value="on" name="enable_logs" <?php checked($enable_logs, 'on'); ?>>
										<label for="enable_logs_1" style="cursor:pointer;"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['On']; ?></label>
									</div>
					
									<div class="radio_inner_wrapper">
										<input type="radio" id="use_hammer_js_2" value="off" name="enable_logs" <?php checked($enable_logs, 'off'); ?>>
										<label for="use_hammer_js_2" style="cursor:pointer;"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['off']; ?></label>
									</div>
								</span>
								<div class="description_container">
									<span class="description"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Enable_console']?></span>				
								</div>
							</td>
						</tr>								
				</tbody>
			</table>				
		</form>
	</div>
<a id="button_save_general_settings" class="button-primary" original-title=""><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['update']; ?></a>
<span id="loader_general_settings" class="loader_round mleft_10" style="display: none;"></span>
<!-- 
&nbsp;
<a class="button-primary">Close</a>
-->
</div>
