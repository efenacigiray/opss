<?php echo $header; ?><?php echo $column_left; ?>
<div id="content"><div class="container-fluid">
	<div class="page-header">
	    <h1>Popup</h1>
	    <ul class="breadcrumb">
		     <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		      <?php } ?>
	    </ul>
	  </div>
	  
	<link rel="stylesheet" type="text/css" href="view/stylesheet/css/colorpicker.css" />
	<script type="text/javascript" src="view/javascript/jquery/colorpicker.js"></script>    
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:600,500,400' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
	<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
	<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>  
	
	<script type="text/javascript">
	$(document).ready(function() {
	
		$('.colorpicker-input').ColorPicker({
			onChange: function (hsb, hex, rgb, el) {
				$(el).val("#" +hex);
				$(el).css("border-right", "20px solid #" + hex);
			},
			onShow: function (colpkr) {
				$(colpkr).show();
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).hide();
				return false;
			}
		});
	});
	</script>
	
	<script type="text/javascript">
	$.fn.tabs = function() {
		var selector = this;
		
		this.each(function() {
			var obj = $(this); 
			
			$(obj.attr('href')).hide();
			
			$(obj).click(function() {
				$(selector).removeClass('selected');
				
				$(selector).each(function(i, element) {
					$($(element).attr('href')).hide();
				});
				
				$(this).addClass('selected');
				
				$($(this).attr('href')).show();
				
				return false;
			});
		});
	
		$(this).show();
		
		$(this).first().click();
	};
	</script>

	<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } elseif ($success) {  ?>
		<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } ?>
	
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	     <input type="hidden" value="<?php echo $popup_id_module; ?>" class="popup_id_module" name="popup_id_module">
		<div class="set-size" id="popup">
			<div class="content">
				<div>
					<div class="tabs clearfix">
						<!-- Tabs module -->
						<div id="tabs" class="htabs main-tabs">
							<?php $module_row = 1; ?>
							<?php foreach ($modules as $module) { ?>
							<a href="#tab-module-<?php echo $module_row; ?>" id="module-<?php echo $module_row; ?>">Module <?php echo $module_row; ?> &nbsp;<img src="view/image/module_template/delete-slider.png"  alt="" onclick="$('.vtabs a:first').trigger('click'); $('#module-<?php echo $module_row; ?>').remove(); $('#tab-module-<?php echo $module_row; ?>').remove(); return false;" /></a>
							<?php $module_row++; ?>
							<?php } ?>
							<span id="module-add">Add Module &nbsp;<img src="view/image/module_template/add.png" alt="" onclick="addModule();" /></span>
						</div>
						
						<?php $module_row = 1; ?>
						<?php foreach ($modules as $module) { ?>
						<div id="tab-module-<?php echo $module_row; ?>" class="tab-content">
							<table class="form" style="margin-bottom:5px">
							  <tr>
							    <td style="border:none;padding-top:7px">Type:</td>
							    <td style="border:none;padding-top:7px"><select name="popup_module[<?php echo $module_row; ?>][type]" class="select-type" id="<?php echo $module_row; ?>">
							    	<?php if (1 == $module['type']) { ?>
							    	<option value="1" selected="selected">Newsletter</option>
							    	<?php } else { ?>
							    	<option value="1">Newsletter</option>
							    	<?php } ?>
							    	<?php if (2 == $module['type']) { ?>
							    	<option value="2" selected="selected">Custom</option>
							    	<?php } else { ?>
							    	<option value="2">Custom</option>
							    	<?php } ?>
							    		<?php if (3 == $module['type']) { ?>
							    		<option value="3" selected="selected">Contact Form</option>
							    		<?php } else { ?>
							    		<option value="3">Contact Form</option>
							    		<?php } ?>
							      </select></td>
							  </tr>
							</table>
							
							<div id="language-<?php echo $module_row; ?>" class="htabs">
							  <?php foreach ($languages as $language) { ?>
							  <a href="#tab-language-<?php echo $module_row; ?>-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
							  <?php } ?>
							</div>
							<?php foreach ($languages as $language) { ?>
							<div id="tab-language-<?php echo $module_row; ?>-<?php echo $language['language_id']; ?>">
							
							  <div class="newsletter<?php echo $module_row; ?>" <?php if (1 != $module['type']) { echo 'style="display:none"'; } ?>>
								  <table class="form">
								    <tr>
								      <td>Newsletter Popup Title:</td>
								      <td><input type="text" value="<?php echo isset($module['newsletter_popup_title'][$language['language_id']]) ? $module['newsletter_popup_title'][$language['language_id']] : ''; ?>" name="popup_module[<?php echo $module_row; ?>][newsletter_popup_title][<?php echo $language['language_id']; ?>]" style="width:250px"></td>
								    </tr>
								    <tr>
								      <td>Newsletter Popup Text:</td>
								      <td><textarea name="popup_module[<?php echo $module_row; ?>][newsletter_popup_text][<?php echo $language['language_id']; ?>]"><?php echo isset($module['newsletter_popup_text'][$language['language_id']]) ? $module['newsletter_popup_text'][$language['language_id']] : ''; ?></textarea></td>
								    </tr>
								    <tr>
								      <td>Newsletter Input Placeholder:</td>
								      <td><input type="text" value="<?php echo isset($module['newsletter_input_placeholder'][$language['language_id']]) ? $module['newsletter_input_placeholder'][$language['language_id']] : ''; ?>" name="popup_module[<?php echo $module_row; ?>][newsletter_input_placeholder][<?php echo $language['language_id']; ?>]" style="width:250px"></td>
								    </tr>
								    <tr>
								      <td>Newsletter Subscribe Button Text:</td>
								      <td><input type="text" value="<?php echo isset($module['newsletter_subscribe_button_text'][$language['language_id']]) ? $module['newsletter_subscribe_button_text'][$language['language_id']] : ''; ?>" name="popup_module[<?php echo $module_row; ?>][newsletter_subscribe_button_text][<?php echo $language['language_id']; ?>]" style="width:250px"></td>
								    </tr>
								  </table>	
							  </div>
							  
							  <div class="custom<?php echo $module_row; ?>" <?php if (2 != $module['type']) { echo 'style="display:none"'; } ?>>
								  <table class="form">
								    <tr>
								      <td>Custom Popup Title:</td>
								      <td><input type="text" value="<?php echo isset($module['custom_popup_title'][$language['language_id']]) ? $module['custom_popup_title'][$language['language_id']] : ''; ?>" name="popup_module[<?php echo $module_row; ?>][custom_popup_title][<?php echo $language['language_id']; ?>]" style="width:250px"></td>
								    </tr>
								    <tr>
								      <td>Custom Popup Text:</td>
								      <td><textarea name="popup_module[<?php echo $module_row; ?>][custom_popup_text][<?php echo $language['language_id']; ?>]"><?php echo isset($module['custom_popup_text'][$language['language_id']]) ? $module['custom_popup_text'][$language['language_id']] : ''; ?></textarea></td>
								    </tr>
								  </table>
							  </div>
							  
							  <div class="contact_form<?php echo $module_row; ?>" <?php if (3 != $module['type']) { echo 'style="display:none"'; } ?>>
							  	  <table class="form">
							  	    <tr>
							  	      <td>Contact Form Popup Title:</td>
							  	      <td><input type="text" value="<?php echo isset($module['contact_form_popup_title'][$language['language_id']]) ? $module['contact_form_popup_title'][$language['language_id']] : ''; ?>" name="popup_module[<?php echo $module_row; ?>][contact_form_popup_title][<?php echo $language['language_id']; ?>]" style="width:250px"></td>
							  	    </tr>
							  	  </table>
							  </div>
							  
							</div>
							<?php } ?>
							
							<input type="hidden" name="popup_module[<?php echo $module_row; ?>][module_id]" value="<?php echo $module['module_id']; ?>" />
							
							<table class="form">
							  <tr>
							       <td>Show only once:</td>
							       <td><select name="popup_module[<?php echo $module_row; ?>][show_only_once]">
							            <option value="0"<?php if($module['show_only_once'] == 0) { echo ' selected="selected"'; } ?>>yes</option>
							            <option value="1"<?php if($module['show_only_once'] == 1) { echo ' selected="selected"'; } ?>>no</option>
							       </select></td>
							  </tr>
							  <tr>
							       <td>Display text don't show again:</td>
							       <td><select name="popup_module[<?php echo $module_row; ?>][display_text_dont_show_again]">
							            <option value="0"<?php if($module['display_text_dont_show_again'] == 0) { echo ' selected="selected"'; } ?>>yes</option>
							            <option value="1"<?php if($module['display_text_dont_show_again'] == 1) { echo ' selected="selected"'; } ?>>no</option>
							       </select></td>
							  </tr>
							  <tr>
							       <td>Translate text don't show again:</td>
							       <td><div class="list-language">
							            <?php foreach ($languages as $language) { ?>
							            <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="popup_module[<?php echo $module_row; ?>][text_dont_show_again][<?php echo $language['language_id']; ?>]" value="<?php echo isset($module['text_dont_show_again'][$language['language_id']]) ? $module['text_dont_show_again'][$language['language_id']] : ''; ?>"></div>
							            <?php } ?>
							       </div></td>
							  </tr>
							  <tr>
							       <td>Display buttons yes/no:</td>
							       <td><select name="popup_module[<?php echo $module_row; ?>][display_buttons_yes_no]">
							            <option value="0"<?php if($module['display_buttons_yes_no'] == 0) { echo ' selected="selected"'; } ?>>yes</option>
							            <option value="1"<?php if($module['display_buttons_yes_no'] == 1) { echo ' selected="selected"'; } ?>>no</option>
							       </select></td>
							  </tr>
							  <tr>
							       <td>Translate text no:</td>
							       <td><div class="list-language">
							            <?php foreach ($languages as $language) { ?>
							            <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="popup_module[<?php echo $module_row; ?>][no][<?php echo $language['language_id']; ?>]" value="<?php echo isset($module['no'][$language['language_id']]) ? $module['no'][$language['language_id']] : ''; ?>"></div>
							            <?php } ?>
							       </div></td>
							  </tr>
							  <tr>
							       <td>Translate text yes:</td>
							       <td><div class="list-language">
							            <?php foreach ($languages as $language) { ?>
							            <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="popup_module[<?php echo $module_row; ?>][yes][<?php echo $language['language_id']; ?>]" value="<?php echo isset($module['yes'][$language['language_id']]) ? $module['yes'][$language['language_id']] : ''; ?>"></div>
							            <?php } ?>
							       </div></td>
							  </tr>
							  <tr>
							       <td>Content width (px):</td>
							       <td><input type="text" name="popup_module[<?php echo $module_row; ?>][content_width]" value="<?php echo $module['content_width']; ?>" size="3" /></td>
							  </tr>
							  <tr>
							       <td>Custom URL to open popup:</td>
							       <td><input type="text" value="javascript:openPopup(<?php echo $module['module_id']; ?>)" style="width: 167px" /></td>
							  </tr>
							  <tr>
							       <td>Background color:</td>
							       <td><input type="text" name="popup_module[<?php echo $module_row; ?>][background_color]" class="colorpicker-input" value="<?php echo $module['background_color']; ?>" <?php if($module['background_color'] != '') { echo 'style="border-right: 20px solid ' . $module['background_color'] . '"'; } ?> /></td>
							  </tr>
							  <tr>
							       <td>Background image:</td>
							       <td>
							            <?php if ($module['background_image']) { ?>
							            <a href="" id="thumb-<?php echo $module_row; ?>" class="img-thumbnail img-edit" data-toggle="image"><img src="../image/<?php echo $module['background_image']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
							            <?php } else { ?>
							            <a href="" id="thumb-<?php echo $module_row; ?>" class="img-thumbnail img-edit" data-toggle="image"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
							            <?php } ?>
							            <input type="hidden" name="popup_module[<?php echo $module_row; ?>][background_image]" value="<?php echo $module['background_image']; ?>" id="input-<?php echo $module_row; ?>" />
							       </td>
							  </tr>
							  <tr>
							       <td>Background image position:</td>
							       <td><select name="popup_module[<?php echo $module_row; ?>][background_image_position]">
							            <option value="top left"<?php if($module['background_image_position'] == 'top left') { echo ' selected="selected"'; } ?>>Top left</option>
							            <option value="top center"<?php if($module['background_image_position'] == 'top center') { echo ' selected="selected"'; } ?>>Top center</option>
							            <option value="top right"<?php if($module['background_image_position'] == 'top right') { echo ' selected="selected"'; } ?>>Top right</option>
							            <option value="bottom left"<?php if($module['background_image_position'] == 'bottom left') { echo ' selected="selected"'; } ?>>Bottom left</option>
							            <option value="bottom center"<?php if($module['background_image_position'] == 'bottom center') { echo ' selected="selected"'; } ?>>Bottom center</option>
							            <option value="bottom right"<?php if($module['background_image_position'] == 'bottom right') { echo ' selected="selected"'; } ?>>Bottom right</option>
							       </select></td>
							  </tr>
							  <tr>
							       <td>Background image repeat:</td>
							       <td><select name="popup_module[<?php echo $module_row; ?>][background_image_repeat]">
							            <option value="no-repeat"<?php if($module['background_image_repeat'] == 'no-repeat') { echo ' selected="selected"'; } ?>>no-repeat</option>
							            <option value="repeat-x"<?php if($module['background_image_repeat'] == 'repeat-x') { echo ' selected="selected"'; } ?>>repeat-x</option>
							            <option value="repeat-y"<?php if($module['background_image_repeat'] == 'repeat-y') { echo ' selected="selected"'; } ?>>repeat-y</option>
							            <option value="repeat"<?php if($module['background_image_repeat'] == 'repeat') { echo ' selected="selected"'; } ?>>repeat</option>
							       </select></td>
							  </tr>
							  <tr>
							       <td>Show after:<br><span style="font-size: 11px;color: #888">(in milliseconds)</span></td>
							       <td><input type="text" name="popup_module[<?php echo $module_row; ?>][show_after]" value="<?php echo $module['show_after']; ?>" /></td>
							  </tr>
							  <tr>
							       <td>Auto close after:<br><span style="font-size: 11px;color: #888">(in milliseconds)</span></td>
							       <td><input type="text" name="popup_module[<?php echo $module_row; ?>][autoclose_after]" value="<?php echo $module['autoclose_after']; ?>" /></td>
							  </tr>
							  <tr>
							       <td>Disable on mobile:</td>
							       <td><select name="popup_module[<?php echo $module_row; ?>][disable_on_desktop]">
							            <option value="0"<?php if($module['disable_on_desktop'] == '0') { echo ' selected="selected"'; } ?>>yes</option>
							            <option value="1"<?php if($module['disable_on_desktop'] == '1') { echo ' selected="selected"'; } ?>>no</option>
							       </select></td>
							  </tr>
							  <tr>
							    <td>Layout:</td>
							    <td><select name="popup_module[<?php echo $module_row; ?>][layout_id]">
							    	<?php if (99999 == $module['layout_id']) { ?>
							    	<option value="99999" selected="selected">All pages</option>
							    	<?php } else { ?>
							    	<option value="99999">All pages</option>
							    	<?php } ?>
							    	
							    	<?php foreach($stores as $store) { ?>
							    	<option value="99999<?php echo $store['store_id']; ?>" <?php if('99999' . $store['store_id'] == $module['layout_id']) { echo 'selected="selected"'; } ?>>All pages - Store <?php echo $store['name']; ?></option>
							    	<?php } ?>
							    	
							        <?php foreach ($layouts as $layout) { ?>
							        <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
							        <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
							        <?php } else { ?>
							        <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
							        <?php } ?>
							        <?php } ?>
							      </select></td>
							  </tr>
							  <tr style="display: none">
							    <td>Position:</td>
							    <td><select name="popup_module[<?php echo $module_row; ?>][position]">
						     	<option value="popup" selected="selected">Popup</option>
							      </select></td>
							  </tr>
							  <tr>
							    <td>Status:</td>
							    <td><select name="popup_module[<?php echo $module_row; ?>][status]">
							        <?php if ($module['status']) { ?>
							        <option value="1" selected="selected">Enabled</option>
							        <option value="0">Disabled</option>
							        <?php } else { ?>
							        <option value="1">Enabled</option>
							        <option value="0" selected="selected">Disabled</option>
							        <?php } ?>
							      </select></td>
							  </tr>
							  <tr style="display: none">
							    <td>Sort Order:</td>
							    <td><input type="text" name="popup_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
							  </tr>
							</table>
						</div>
						<?php $module_row++; ?>
						<?php } ?>
					</div>
					
					<!-- Buttons -->
					<div class="buttons"><input type="submit" name="button-save" class="button-save" value=""></div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript"><!--
$('.main-tabs a').tabs();
//--></script> 

<script type="text/javascript"><!--
<?php $module_row = 1; ?>
<?php foreach ($modules as $module) { ?>
$('#language-<?php echo $module_row; ?> a').tabs();
<?php $module_row++; ?>
<?php } ?> 
//--></script> 

<script type="text/javascript"><!--
<?php $module_row = 1; ?>
<?php foreach ($modules as $module) { ?>
<?php $module_row++; ?>
<?php } ?>
//--></script> 

<script type="text/javascript">
$(document).ready(function() {
	
	$('#popup').on('change', 'select.select-type', function () {
		var id_module = $(this).attr("id");
		$("#" + id_module +" option:selected").each(function() {
			if($(this).val() == 1) {
				$(".custom" + id_module + "").hide();
				$(".newsletter" + id_module + "").show();
				$(".contact_form" + id_module + "").hide();
			} else if($(this).val() == 2) {
				$(".custom" + id_module + "").show();
				$(".newsletter" + id_module + "").hide();
				$(".contact_form" + id_module + "").hide();
			} else {
			     $(".custom" + id_module + "").hide();
			     $(".newsletter" + id_module + "").hide();
				$(".contact_form" + id_module + "").show();
			}
		});
	});
	
});
</script>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;
var popup_id_module = <?php echo $popup_id_module; ?>;

function addModule() {	
	html  = '<div id="tab-module-' + module_row + '" class="tab-content">';

		html += '	<table class="form" style="margin-bottom:5px">';
		html += '		<tr>';
		html += '			<td style="border:none;padding-top:7px">Type:</td>';
		html += '			<td style="border:none;padding-top:7px">';
		html += '				<select name="popup_module[' + module_row + '][type]" class="select-type" id="' + module_row + '">';
		html += '					<option value="1" selected="selected">Newsletter</option>';
		html += '					<option value="2">Custom</option>';
		html += '					<option value="3">Contact Form</option>';
		html += '				</select>';
		html += '			</td>';
		html += '		</tr>';
		html += '   </table>';
		
		html += '  <div id="language-' + module_row + '" class="htabs">';
	    <?php foreach ($languages as $language) { ?>
	    html += '    <a href="#tab-language-'+ module_row + '-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>';
	    <?php } ?>
		html += '  </div>';
	
		<?php foreach ($languages as $language) { ?>
		html += '    <div id="tab-language-'+ module_row + '-<?php echo $language['language_id']; ?>">';
		
		html += '	 <div class="newsletter' + module_row + '">';
		html += '	   <table class="form">';
		html += '			<tr>';
		html += '				<td>Newsletter Popup Title:</td>';
		html += '				<td><input type="text" value="" name="popup_module[' + module_row + '][newsletter_popup_title][<?php echo $language['language_id']; ?>]" style="width:250px"></td>';
		html += '			</tr>';
		html += '			<tr>';
		html += '				<td>Newsletter Popup Text:</td>';
		html += '				<td><textarea name="popup_module[' + module_row + '][newsletter_popup_text][<?php echo $language['language_id']; ?>]"></textarea></td>';
		html += '			</tr>';
		html += '			<tr>';
		html += '				<td>Newsletter Input Placeholder:</td>';
		html += '				<td><input type="text" value="" name="popup_module[' + module_row + '][newsletter_input_placeholder][<?php echo $language['language_id']; ?>]" style="width:250px"></td>';
		html += '			</tr>';
		html += '			<tr>';
		html += '				<td>Newsletter Subscribe Button Text:</td>';
		html += '				<td><input type="text" value="" name="popup_module[' + module_row + '][newsletter_subscribe_button_text][<?php echo $language['language_id']; ?>]" style="width:250px"></td>';
		html += '			</tr>';
		html += '	   </table>';
		html += '	 </div>';
		
		html += '	 <div class="custom' + module_row + '" style="display:none">';
		html += '      <table class="form">';
		html += '        <tr>';
		html += '          <td>Custom Popup Title:</td>';
		html += '			<td><input type="text" value="" name="popup_module[' + module_row + '][custom_popup_title][<?php echo $language['language_id']; ?>]" style="width:250px"></td>';
		html += '        </tr>';
		html += '        <tr>';
		html += '          <td>Custom Popup Text:</td>';
		html += '          <td><textarea name="popup_module[' + module_row + '][custom_popup_text][<?php echo $language['language_id']; ?>]"></textarea></td>';
		html += '        </tr>';
		html += '      </table>';
		html += '	  </div>';
		
		html += '	 <div class="contact_form' + module_row + '" style="display:none">';
		html += '      <table class="form">';
		html += '        <tr>';
		html += '          <td>Contact Form Popup Title:</td>';
		html += '			<td><input type="text" value="" name="popup_module[' + module_row + '][contact_form_popup_title][<?php echo $language['language_id']; ?>]" style="width:250px"></td>';
		html += '        </tr>';
		html += '      </table>';
		html += '	  </div>';
		
		html += '    </div>';
		<?php } ?>
		
		html += '  <input type="hidden" name="popup_module[' + module_row + '][module_id]" value="' + popup_id_module + '" />';
	
		html += '  <table class="form">';
		html += '    <tr>';
		html += '      <td>Show only once:</td>';
		html += '      <td><select name="popup_module[' + module_row + '][show_only_once]">';
		html += '       		<option value="0">yes</option>';
		html += '       		<option value="1">no</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Display text don\'t show again:</td>';
		html += '      <td><select name="popup_module[' + module_row + '][display_text_dont_show_again]">';
		html += '       		<option value="0">yes</option>';
		html += '       		<option value="1">no</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Translate text don\'t show again:</td>';
		html += '      <td><div class="list-language">';
		<?php foreach ($languages as $language) { ?>
		html += '               <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="popup_module['+ module_row +'][text_dont_show_again][<?php echo $language['language_id']; ?>]" value=""></div>';
		<?php } ?>
		html += '      </div></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Display buttons yes/no:</td>';
		html += '      <td><select name="popup_module[' + module_row + '][display_buttons_yes_no]">';
		html += '       		<option value="0">yes</option>';
		html += '       		<option value="1">no</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Translate text no:</td>';
		html += '      <td><div class="list-language">';
		<?php foreach ($languages as $language) { ?>
		html += '               <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="popup_module['+ module_row +'][no][<?php echo $language['language_id']; ?>]" value=""></div>';
		<?php } ?>
		html += '      </div></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Translate text yes:</td>';
		html += '      <td><div class="list-language">';
		<?php foreach ($languages as $language) { ?>
		html += '               <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="popup_module['+ module_row +'][yes][<?php echo $language['language_id']; ?>]" value=""></div>';
		<?php } ?>
		html += '      </div></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Content width (px):</td>';
		html += '      <td><input type="text" name="popup_module[' + module_row + '][content_width]" value="750" size="3" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Custom URL to open popup:</td>';
		html += '      <td><input type="text" value="javascript:openPopup(' + popup_id_module + ')" style="width: 167px" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Background color:</td>';
		html += '      <td><input type="text" name="popup_module[' + module_row + '][background_color]" class="colorpicker-input" value="" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '           <td>Background image:</td>';
		html += '			<td>';
		html += '				<a href="" id="thumb-' + module_row + '" class="img-thumbnail img-edit" data-toggle="image"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>';
		html += '				<input type="hidden" name="popup_module[' + module_row + '][background_image]" value="" id="input-'+ module_row +'" />';
		html += '			</td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '           <td>Background image position:</td>';
		html += '      	<td><select name="popup_module[' + module_row + '][background_image_position]">';
		html += '        		<option value="top left">Top left</option>';
		html += '        		<option value="top center">Top center</option>';
		html += '        		<option value="top right">Top right</option>';
		html += '        		<option value="bottom left">Bottom left</option>';
		html += '        		<option value="bottom center">Bottom center</option>';
		html += '        		<option value="bottom right">Bottom right</option>';
		html += '      	</select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '           <td>Background image repeat:</td>';
		html += '      	<td><select name="popup_module[' + module_row + '][background_image_repeat]">';
		html += '        	     <option value="no-repeat">no-repeat</option>';
		html += '        		<option value="repeat-x">repeat-x</option>';
		html += '        		<option value="repeat-y">repeat-y</option>';
		html += '        		<option value="repeat">repeat</option>';
		html += '      	</select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Show after:<br><span style="font-size: 11px;color: #888">(in milliseconds)</span></td>';
		html += '      <td><input type="text" name="popup_module[' + module_row + '][show_after]" value="" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Auto close after:<br><span style="font-size: 11px;color: #888">(in milliseconds)</span></td>';
		html += '      <td><input type="text" name="popup_module[' + module_row + '][autoclose_after]" value="" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Disable on mobile:</td>';
		html += '      <td><select name="popup_module[' + module_row + '][disable_on_desktop]">';
		html += '       		<option value="0">yes</option>';
		html += '       		<option value="1">no</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Layout:</td>';
		html += '      <td><select name="popup_module[' + module_row + '][layout_id]">';
		html += '           <option value="99999">All pages</option>';
		
		<?php foreach($stores as $store) { ?>
		html += '           <option value="99999<?php echo $store['store_id']; ?>">All pages - Store <?php echo $store['name']; ?></option>';
		<?php } ?>
		          
		<?php foreach ($layouts as $layout) { ?>
		html += '           <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
		<?php } ?>
		
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr style="display: none">';
		html += '      <td>Position:</td>';
		html += '      <td><select name="popup_module[' + module_row + '][position]">';
		html += '       		<option value="popup" selected="selected">Popup</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Status:</td>';
		html += '      <td><select name="popup_module[' + module_row + '][status]">';
		html += '        <option value="1">Enabled</option>';
		html += '        <option value="0">Disabled</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr style="display: none">';
		html += '      <td>Sort Order:</td>';
		html += '      <td><input type="text" name="popup_module[' + module_row + '][sort_order]" value="0" size="3" /></td>';
		html += '    </tr>';
		html += '  </table>'; 
	html += '</div>';
	
	$('.tabs').append(html);
	
	$('#language-' + module_row + ' a').tabs();

	$('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '">Module ' + module_row + ' &nbsp;<img src="view/image/module_template/delete-slider.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); return false;" /></a>');
	
	$('.main-tabs a').tabs();
	
	$('#module-' + module_row).trigger('click');
	
	$('.colorpicker-input').ColorPicker({
		onChange: function (hsb, hex, rgb, el) {
			$(el).val("#" +hex);
			$(el).css("border-right", "20px solid #" + hex);
		},
		onShow: function (colpkr) {
			$(colpkr).show();
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).hide();
			return false;
		}
	});
	
	module_row++;
	popup_id_module++;
	$(".popup_id_module").val(popup_id_module);
}
//--></script> 
<?php echo $footer; ?>