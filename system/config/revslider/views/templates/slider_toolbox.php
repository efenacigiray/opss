
	<div id="toolbox_wrapper" class="toolbox_wrapper postbox unite-postbox">
		<h3 class="box_closed tp-accordion tpa-closed"><div class="postbox-arrow"></div><i style="float:left;margin-top:4px;font-size:14px;" class="eg-icon-export"></i><span><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Import_Export'] ?></span></h3>
		<div class="toggled-content tp-closedatstart p20">
			
			<div class="api-caption"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Import_Slider']?>:</div>
			<div class="divide20"></div>
			
			<form action="<?php echo UniteBaseClassRev::$url_ajax?>" enctype="multipart/form-data" method="post">			    
			    <input type="hidden" name="action" value="revslider_ajax_action">
			    <input type="hidden" name="client_action" value="import_slider">
			    <input type="hidden" name="sliderid" value="<?php echo $sliderID?>">					
				<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("revslider_actions"); ?>">				
				<input type="file" name="import_file" class="input_import_slider" style="width:100%">
				<br><br>
				<span style="font-weight: 700;"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['note_styles']?></span><br><br>
				<table>
					<tr>
						<td><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Custom_Animations']?></td>
						<td><input type="radio" name="update_animations" value="true" checked="checked"> <?php echo ControllerExtensionModulerevslideropencart::$lang_var['overwrite']?></td>
						<td><input type="radio" name="update_animations" value="false"> <?php echo ControllerExtensionModulerevslideropencart::$lang_var['append']?></td>
					</tr>
					<tr>
						<td><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Static_Styles']?></td>
						<td><input type="radio" name="update_static_captions" value="true" checked="checked"> <?php echo ControllerExtensionModulerevslideropencart::$lang_var['overwrite']?></td>
						<td><input type="radio" name="update_static_captions" value="false"> <?php echo ControllerExtensionModulerevslideropencart::$lang_var['append']?></td>
					</tr>
				</table>
				<div class="divide20"></div>				
				<input type="submit" class='button-primary revgreen' value="Import Slider">
			</form>	
			<div class="divide20"></div>
			<div class="api-desc"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['api-desc']?>.</div>
			<hr>
			<div class="divide20"></div>
			
			<div class="api-caption"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Export_Slider']?>:</div>
			<div class="divide20"></div>
			
			<a id="button_export_slider" class='button-primary revblue' href='javascript:void(0)' ><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Export_Slider']?></a> <div style="display: none;"><input type="checkbox" name="export_dummy_images"> <?php echo ControllerExtensionModulerevslideropencart::$lang_var['Export_Slider_Dummy']?></div>
			<!-- replace image url's -->
			
			<div class="divide20"></div>
			<hr>
			<div class="divide10"></div>
			<div class="api-caption"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Replace_Image_Url']?>:</div>
			<div class="divide5"></div>
			<div class="api-desc"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Replace_api_desc']?>.</div>
						
			<div class="divide10"></div>
			
			<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Replace_From']?>:
			<div class="divide5"></div>			
			<input type="text" class="text-sidebar-link" id="replace_url_from">
			
			<div class="divide10"></div>
			
			<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Replace_to']?>:
			<div class="divide5"></div>
			<input type="text" class="text-sidebar-link" id="replace_url_to">
			
			<div class="divide10"></div>
			
			<a id="button_replace_url" class='button-primary revyellow' href='javascript:void(0)' ><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Replace']?></a>
			<div id="loader_replace_url" class="loader_round" style="display:none;"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Replacing']?> </div>
			<div id="replace_url_success" class="success_message" class="display:none;"></div>


		</div>	
	</div>
	

