<?php echo $header; ?><?php echo $column_left; ?>
<div id="content"><div class="container-fluid">
	<div class="page-header">
	    <h1>Cookie</h1>
	    <ul class="breadcrumb">
		     <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		      <?php } ?>
	    </ul>
	  </div>
	  
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:600,500,400' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="view/stylesheet/css/colorpicker.css" />
	<script type="text/javascript" src="view/javascript/jquery/colorpicker.js"></script>    
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:600,500,400' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
	<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
	<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>  
	
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
		<div class="set-size" id="cookie">
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

							<div id="language-<?php echo $module_row; ?>" class="htabs">
							  <?php foreach ($languages as $language) { ?>
							  <a href="#tab-language-<?php echo $module_row; ?>-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
							  <?php } ?>
							</div>
							<?php foreach ($languages as $language) { ?>
							<div id="tab-language-<?php echo $module_row; ?>-<?php echo $language['language_id']; ?>">
							  <div class="html<?php echo $module_row; ?>">
								  <table class="form">
								    <tr>
								      <td>Cookie text:</td>
								      <td><textarea name="cookie_module[<?php echo $module_row; ?>][text_cookie][<?php echo $language['language_id']; ?>]" class="html" id="block-content-<?php echo $module_row; ?>-<?php echo $language['language_id']; ?>"><?php echo isset($module['text_cookie'][$language['language_id']]) ? $module['text_cookie'][$language['language_id']] : ''; ?></textarea></td>
								    </tr>
								  </table>	
							  </div>
							</div>
						
							<?php } ?>
                            
                            <input type="hidden" name="cookie_module[<?php echo $module_row; ?>][module_id]" value="<?php echo $module['module_id']; ?>" />
							<table class="form">
							  <tr>
							       <td>Text color:</td>
							       <td><input type="text" name="cookie_module[<?php echo $module_row; ?>][text_color]" class="colorpicker-input" value="<?php echo $module['text_color']; ?>" <?php if($module['text_color'] != '') { echo 'style="border-right: 20px solid ' . $module['text_color'] . '"'; } ?> /></td>
							  </tr>
							  <tr>
							       <td>Border color:</td>
							       <td><input type="text" name="cookie_module[<?php echo $module_row; ?>][border_color]" class="colorpicker-input" value="<?php echo $module['border_color']; ?>" <?php if($module['border_color'] != '') { echo 'style="border-right: 20px solid ' . $module['border_color'] . '"'; } ?> /></td>
							  </tr>
							  <tr>
							       <td>Background color:</td>
							       <td><input type="text" name="cookie_module[<?php echo $module_row; ?>][background_color]" class="colorpicker-input" value="<?php echo $module['background_color']; ?>" <?php if($module['background_color'] != '') { echo 'style="border-right: 20px solid ' . $module['background_color'] . '"'; } ?> /></td>
							  </tr>
							  <tr>
							       <td>Background image:</td>
							       <td>
							            <?php if ($module['background_image']) { ?>
							            <a href="" id="thumb-<?php echo $module_row; ?>" class="img-thumbnail img-edit" data-toggle="image"><img src="../image/<?php echo $module['background_image']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
							            <?php } else { ?>
							            <a href="" id="thumb-<?php echo $module_row; ?>" class="img-thumbnail img-edit" data-toggle="image"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
							            <?php } ?>
							            <input type="hidden" name="cookie_module[<?php echo $module_row; ?>][background_image]" value="<?php echo $module['background_image']; ?>" id="input-<?php echo $module_row; ?>" />
							       </td>
							  </tr>
							  <tr>
							       <td>Background image position:</td>
							       <td><select name="cookie_module[<?php echo $module_row; ?>][background_image_position]">
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
							       <td><select name="cookie_module[<?php echo $module_row; ?>][background_image_repeat]">
							            <option value="no-repeat"<?php if($module['background_image_repeat'] == 'no-repeat') { echo ' selected="selected"'; } ?>>no-repeat</option>
							            <option value="repeat-x"<?php if($module['background_image_repeat'] == 'repeat-x') { echo ' selected="selected"'; } ?>>repeat-x</option>
							            <option value="repeat-y"<?php if($module['background_image_repeat'] == 'repeat-y') { echo ' selected="selected"'; } ?>>repeat-y</option>
							            <option value="repeat"<?php if($module['background_image_repeat'] == 'repeat') { echo ' selected="selected"'; } ?>>repeat</option>
							       </select></td>
							  </tr>
							  <tr>
							       <td>Display text don't show again:</td>
							       <td><select name="cookie_module[<?php echo $module_row; ?>][display_text_dont_show_again]">
							            <option value="0"<?php if($module['display_text_dont_show_again'] == 0) { echo ' selected="selected"'; } ?>>yes</option>
							            <option value="1"<?php if($module['display_text_dont_show_again'] == 1) { echo ' selected="selected"'; } ?>>no</option>
							       </select></td>
							  </tr>
							  <tr>
							       <td>Translate text don't show again:</td>
							       <td><div class="list-language">
							            <?php foreach ($languages as $language) { ?>
							            <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="cookie_module[<?php echo $module_row; ?>][text_dont_show_again][<?php echo $language['language_id']; ?>]" value="<?php echo isset($module['text_dont_show_again'][$language['language_id']]) ? $module['text_dont_show_again'][$language['language_id']] : ''; ?>"></div>
							            <?php } ?>
							       </div></td>
							  </tr>
                                <tr>
							       <td>Text don't show again color:</td>
							       <td><input type="text" name="cookie_module[<?php echo $module_row; ?>][text_dont_show_again_color]" class="colorpicker-input" value="<?php echo $module['text_dont_show_again_color']; ?>" <?php if($module['text_dont_show_again_color'] != '') { echo 'style="border-right: 20px solid ' . $module['text_dont_show_again_color'] . '"'; } ?> /></td>
							  </tr>
							  <tr>
							       <td>Display button:</td>
							       <td><select name="cookie_module[<?php echo $module_row; ?>][display_button]">
							            <option value="0"<?php if($module['display_button'] == 0) { echo ' selected="selected"'; } ?>>yes</option>
							            <option value="1"<?php if($module['display_button'] == 1) { echo ' selected="selected"'; } ?>>no</option>
							       </select></td>
							  </tr>
							  <tr>
							       <td>Translate text button:</td>
							       <td><div class="list-language">
							            <?php foreach ($languages as $language) { ?>
							            <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="cookie_module[<?php echo $module_row; ?>][text_button][<?php echo $language['language_id']; ?>]" value="<?php echo isset($module['text_button'][$language['language_id']]) ? $module['text_button'][$language['language_id']] : ''; ?>"></div>
							            <?php } ?>
							       </div></td>
							  </tr>
                                <tr>
                                    <td>Layout:</td>
                                    <td><select name="cookie_module[<?php echo $module_row; ?>][layout_id]">
                                <?php if (99999 == $module['layout_id']) { ?>
                                <option value="99999" selected="selected">All pages</option>
                                <?php } else { ?>
                                <option value="99999">All pages</option>
                                <?php } ?>

                                <?php foreach($stores as $store) { ?>
                                     <?php if ('99999' . $store['store_id'] == $module['layout_id']) { ?>
                                     <option value="99999<?php echo $store['store_id']; ?>" selected="selected">All pages - Store <?php echo $store['name']; ?></option>
                                     <?php } else { ?>
                                     <option value="99999<?php echo $store['store_id']; ?>">All pages - Store <?php echo $store['name']; ?></option>
                                     <?php } ?>
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
							    <td><select name="cookie_module[<?php echo $module_row; ?>][position]">
						     	<option value="cookie" selected="selected">Cookie</option>
							      </select></td>
							  </tr>
							  <tr>
							    <td>Display position:</td>
							    <td><select name="cookie_module[<?php echo $module_row; ?>][display_position]">
						     	<option value="top" <?php echo ('top' == $module['display_position'] ? 'selected="selected"' : "") ?>>Top</option>
						     	<option value="bottom" <?php echo ('bottom' == $module['display_position'] ? 'selected="selected"' : "") ?>>Bottom</option>
							      </select></td>
							  </tr>
							  <tr>
							    <td>Status:</td>
							    <td><select name="cookie_module[<?php echo $module_row; ?>][status]">
							        <?php if ($module['status']) { ?>
							        <option value="1" selected="selected">Enabled</option>
							        <option value="0">Disabled</option>
							        <?php } else { ?>
							        <option value="1">Enabled</option>
							        <option value="0" selected="selected">Disabled</option>
							        <?php } ?>
							      </select></td>
							  </tr>
							  <tr>
							    <td>Sort Order:</td>
							    <td><input type="text" name="cookie_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
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
	
	$('#cookie').on('change', 'select.select-type', function () {
		var id_module = $(this).attr("id");
		$("#" + id_module +" option:selected").each(function() {
			if($(this).val() == 1) {
				$(".html" + id_module + "").hide();
				$(".block" + id_module + "").show();
			} else {
				$(".html" + id_module + "").show();
				$(".block" + id_module + "").hide();
			}
		});
	});
	
});
</script>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<div id="tab-module-' + module_row + '" class="tab-content">';

		
		html += '  <div id="language-' + module_row + '" class="htabs">';
	    <?php foreach ($languages as $language) { ?>
	    html += '    <a href="#tab-language-'+ module_row + '-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>';
	    <?php } ?>
		html += '  </div>';
            
		<?php foreach ($languages as $language) { ?>
		html += '    <div id="tab-language-'+ module_row + '-<?php echo $language['language_id']; ?>">';
		
		html += '	 <div class="html' + module_row + '">';
		html += '	   <table class="form">';
		html += '			<tr>';
		html += '				<td>Cookie text</td>';
		html += '				<td><textarea name="cookie_module[' + module_row + '][text_cookie][<?php echo $language['language_id']; ?>]" class="html" id="block-content-' + module_row + '-<?php echo $language['language_id']; ?>"></textarea></td>';
		html += '			</tr>';
		html += '	   </table>';
		html += '	 </div>';

		
		html += '    </div>';
		<?php } ?>
	
		
		html += '  <input type="hidden" name="cookie_module[' + module_row + '][module_id]" value="' + module_row + '" />';
    
		html += '  <table class="form">';
        html += '    <tr>';
		html += '      <td>Text color:</td>';
		html += '      <td><input type="text" name="cookie_module[' + module_row + '][text_color]" class="colorpicker-input" value="" /></td>';
		html += '    </tr>';
        html += '    <tr>';
		html += '      <td>Border color:</td>';
		html += '      <td><input type="text" name="cookie_module[' + module_row + '][border_color]" class="colorpicker-input" value="" /></td>';
		html += '    </tr>';
        html += '    <tr>';
		html += '      <td>Background color:</td>';
		html += '      <td><input type="text" name="cookie_module[' + module_row + '][background_color]" class="colorpicker-input" value="" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '           <td>Background image:</td>';
		html += '			<td>';
		html += '				<a href="" id="thumb-' + module_row + '" class="img-thumbnail img-edit" data-toggle="image"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>';
		html += '				<input type="hidden" name="cookie_module[' + module_row + '][background_image]" value="" id="input-'+ module_row +'" />';
		html += '			</td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '           <td>Background image position:</td>';
		html += '      	<td><select name="cookie_module[' + module_row + '][background_image_position]">';
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
		html += '      	<td><select name="cookie_module[' + module_row + '][background_image_repeat]">';
		html += '        	     <option value="no-repeat">no-repeat</option>';
		html += '        		<option value="repeat-x">repeat-x</option>';
		html += '        		<option value="repeat-y">repeat-y</option>';
		html += '        		<option value="repeat">repeat</option>';
		html += '      	</select></td>';
		html += '    </tr>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Display button:</td>';
		html += '      <td><select name="cookie_module[' + module_row + '][display_button]">';
		html += '       		<option value="0">yes</option>';
		html += '       		<option value="1">no</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Translate text button:</td>';
		html += '      <td><div class="list-language">';
		<?php foreach ($languages as $language) { ?>
		html += '               <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="cookie_module['+ module_row +'][text_button][<?php echo $language['language_id']; ?>]" value=""></div>';
		<?php } ?>
		html += '      </div></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Display text don\'t show again:</td>';
		html += '      <td><select name="cookie_module[' + module_row + '][display_text_dont_show_again]">';
		html += '       		<option value="0">yes</option>';
		html += '       		<option value="1">no</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Translate text don\'t show again:</td>';
		html += '      <td><div class="list-language">';
		<?php foreach ($languages as $language) { ?>
		html += '               <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="cookie_module['+ module_row +'][text_dont_show_again][<?php echo $language['language_id']; ?>]" value=""></div>';
		<?php } ?>
		html += '      </div></td>';
		html += '    </tr>';
        html += '    <tr>';
		html += '      <td>Text don\'t show again color:</td>';
		html += '      <td><input type="text" name="cookie_module[' + module_row + '][text_dont_show_again_color]" class="colorpicker-input" value="" /></td>';
		html += '    </tr>';
        html += '    		<tr>';
        html += '     		 	<td>Layout:</td>';
        html += '      			<td><select name="cookie_module[' + module_row + '][layout_id]">';
        html += '           		<option value="99999">All pages</option>';

                  <?php foreach($stores as $store) { ?>
        html += '           		<option value="99999<?php echo $store['store_id']; ?>">All pages - Store <?php echo $store['name']; ?></option>';
                  <?php } ?>

                <?php foreach ($layouts as $layout) { ?>
        html += '           		<option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
                <?php } ?>
        html += '      			</select></td>';
        html += '   		 </tr>';
		html += '    <tr>';
		html += '    <tr style="display: none">';
		html += '      <td>Position:</td>';
		html += '      <td><select name="cookie_module[' + module_row + '][position]">';
		html += '       		<option value="cookie" selected="selected">Cookie</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '      <td>Display Position:</td>';
		html += '      <td><select name="cookie_module[' + module_row + '][display_position]">';
		html += '       		<option value="top">Top</option>';
		html += '       		<option value="bottom">Bottom</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '      <td>Status:</td>';
		html += '      <td><select name="cookie_module[' + module_row + '][status]">';
		html += '        <option value="1">Enabled</option>';
		html += '        <option value="0">Disabled</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Sort Order:</td>';
		html += '      <td><input type="text" name="cookie_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
		html += '    </tr>';
		html += '  </table>'; 
	html += '</div>';
	
	$('.tabs').append(html);
	
	$('#language-' + module_row + ' a').tabs();

	$('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '">Module ' + module_row + ' &nbsp;<img src="view/image/module_template/delete-slider.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); return false;" /></a>');
	
	$('.main-tabs a').tabs();
	
	
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
    
	$('#module-' + module_row).trigger('click');
	
	
	module_row++;
}
//--></script> 
<?php echo $footer; ?>