<?php echo $header; ?><?php echo $column_left; ?>
<div id="content"><div class="container-fluid">
	<div class="page-header">
	    <h1>Header Notice</h1>
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
		<div class="set-size" id="header_notice">
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
								      <td>Text:</td>
								      <td><textarea name="header_notice_module[<?php echo $module_row; ?>][html][<?php echo $language['language_id']; ?>]" class="html"><?php echo isset($module['html'][$language['language_id']]) ? $module['html'][$language['language_id']] : ''; ?></textarea></td>
								    </tr>
								  </table>
							  </div>
							</div>
							<?php } ?>
							
							<table class="form">
							  <tr>
							       <td>Background color:</td>
							       <td><input type="text" class="colorpicker-input" name="header_notice_module[<?php echo $module_row; ?>][background_color]" <?php if($module['background_color'] != '') { echo 'style="border-right: 20px solid ' . $module['background_color'] . '"'; } ?> value="<?php echo $module['background_color']; ?>" /></td>
							  </tr>
							  <tr>
							       <td>Text link color:</td>
							       <td><input type="text" class="colorpicker-input" name="header_notice_module[<?php echo $module_row; ?>][text_color]" <?php if($module['text_color'] != '') { echo 'style="border-right: 20px solid ' . $module['text_color'] . '"'; } ?> value="<?php echo $module['text_color']; ?>" /></td>
							  </tr>
							  <tr>
							       <td>Text link hover color:</td>
							       <td><input type="text" class="colorpicker-input" name="header_notice_module[<?php echo $module_row; ?>][text_link_hover_color]" <?php if($module['text_link_hover_color'] != '') { echo 'style="border-right: 20px solid ' . $module['text_link_hover_color'] . '"'; } ?> value="<?php echo $module['text_link_hover_color']; ?>" /></td>
							  </tr>
							  <tr>
							       <td>Close button background color:</td>
							       <td><input type="text" class="colorpicker-input" name="header_notice_module[<?php echo $module_row; ?>][close_button_background_color]" <?php if($module['close_button_background_color'] != '') { echo 'style="border-right: 20px solid ' . $module['close_button_background_color'] . '"'; } ?> value="<?php echo $module['close_button_background_color']; ?>" /></td>
							  </tr>
							  <tr>
							       <td>Close button text color:</td>
							       <td><input type="text" class="colorpicker-input" name="header_notice_module[<?php echo $module_row; ?>][close_button_text_color]" <?php if($module['close_button_text_color'] != '') { echo 'style="border-right: 20px solid ' . $module['close_button_text_color'] . '"'; } ?> value="<?php echo $module['close_button_text_color']; ?>" /></td>
							  </tr>
							  <tr>
							       <td>Close button hover background color:</td>
							       <td><input type="text" class="colorpicker-input" name="header_notice_module[<?php echo $module_row; ?>][close_button_hover_background_color]" <?php if($module['close_button_hover_background_color'] != '') { echo 'style="border-right: 20px solid ' . $module['close_button_hover_background_color'] . '"'; } ?> value="<?php echo $module['close_button_hover_background_color']; ?>" /></td>
							  </tr>
							  <tr>
							       <td>Close button hover text color:</td>
							       <td><input type="text" class="colorpicker-input" name="header_notice_module[<?php echo $module_row; ?>][close_button_hover_text_color]" <?php if($module['close_button_hover_text_color'] != '') { echo 'style="border-right: 20px solid ' . $module['close_button_hover_text_color'] . '"'; } ?> value="<?php echo $module['close_button_hover_text_color']; ?>" /></td>
							  </tr>
							  <tr>
							    <td>Show only once:</td>
							    <td><select name="header_notice_module[<?php echo $module_row; ?>][show_only_once]">
     							    	<?php if (0 == $module['show_only_once']) { ?>
     							    	<option value="0" selected="selected">No</option>
     							    	<?php } else { ?>
     							    	<option value="0">No</option>
     							    	<?php } ?>
							    		<?php if (1 == $module['show_only_once']) { ?>
							    		<option value="1" selected="selected">Yes</option>
							    		<?php } else { ?>
							    		<option value="1">Yes</option>
							    		<?php } ?>
							      </select></td>
							  </tr>
							  <tr>
							    <td>Disable on desktop:</td>
							    <td><select name="header_notice_module[<?php echo $module_row; ?>][disable_on_desktop]">
							  	    	<?php if (0 == $module['disable_on_desktop']) { ?>
							  	    	<option value="0" selected="selected">No</option>
							  	    	<?php } else { ?>
							  	    	<option value="0">No</option>
							  	    	<?php } ?>
							    		<?php if (1 == $module['disable_on_desktop']) { ?>
							    		<option value="1" selected="selected">Yes</option>
							    		<?php } else { ?>
							    		<option value="1">Yes</option>
							    		<?php } ?>
							      </select></td>
							  </tr>
							  <tr>
							    <td>Disable on mobile:</td>
							    <td><select name="header_notice_module[<?php echo $module_row; ?>][disable_on_mobile]">
							  	    	<?php if (0 == $module['disable_on_mobile']) { ?>
							  	    	<option value="0" selected="selected">No</option>
							  	    	<?php } else { ?>
							  	    	<option value="0">No</option>
							  	    	<?php } ?>
							    		<?php if (1 == $module['disable_on_mobile']) { ?>
							    		<option value="1" selected="selected">Yes</option>
							    		<?php } else { ?>
							    		<option value="1">Yes</option>
							    		<?php } ?>
							      </select></td>
							  </tr>
							  <tr>
							    <td>Layout:</td>
							    <td><select name="header_notice_module[<?php echo $module_row; ?>][layout_id]">
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
							    <td><select name="header_notice_module[<?php echo $module_row; ?>][position]">
							    	<option value="header_notice" selected="selected">Header notice</option>
							      </select></td>
							  </tr>
							  <tr>
							    <td>Status:</td>
							    <td><select name="header_notice_module[<?php echo $module_row; ?>][status]">
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
							    <td><input type="text" name="header_notice_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
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
		html += '      <table class="form">';
		html += '        <tr>';
		html += '          <td>Text:</td>';
		html += '          <td><textarea name="header_notice_module[' + module_row + '][html][<?php echo $language['language_id']; ?>]" class="html"></textarea></td>';
		html += '        </tr>';
		html += '      </table>';
		html += '	  </div>';
		
		html += '    </div>';
		<?php } ?>

		html += '  <table class="form">';
		html += '    <tr>';
		html += '      <td>Background color:</td>';
		html += '      <td><input type="text" class="colorpicker-input" name="header_notice_module[' + module_row + '][background_color]" value="" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Text link color:</td>';
		html += '      <td><input type="text" class="colorpicker-input" name="header_notice_module[' + module_row + '][text_color]" value="" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Text link hover color:</td>';
		html += '      <td><input type="text" class="colorpicker-input" name="header_notice_module[' + module_row + '][text_link_hover_color]" value="" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Close button background color:</td>';
		html += '      <td><input type="text" class="colorpicker-input" name="header_notice_module[' + module_row + '][close_button_background_color]" value="" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Close button text color:</td>';
		html += '      <td><input type="text" class="colorpicker-input" name="header_notice_module[' + module_row + '][close_button_text_color]" value="" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Close button hover background color:</td>';
		html += '      <td><input type="text" class="colorpicker-input" name="header_notice_module[' + module_row + '][close_button_hover_background_color]" value="" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Close button hover text color:</td>';
		html += '      <td><input type="text" class="colorpicker-input" name="header_notice_module[' + module_row + '][close_button_hover_text_color]" value="" /></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Show only once:</td>';
		html += '      <td><select name="header_notice_module[' + module_row + '][show_only_once]">';
		html += '        <option value="0">No</option>';
		html += '        <option value="1">Yes</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Disable on desktop:</td>';
		html += '      <td><select name="header_notice_module[' + module_row + '][disable_on_desktop]">';
		html += '        <option value="0">No</option>';
		html += '        <option value="1">Yes</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Disable on mobile:</td>';
		html += '      <td><select name="header_notice_module[' + module_row + '][disable_on_mobile]">';
		html += '        <option value="0">No</option>';
		html += '        <option value="1">Yes</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Layout:</td>';
		html += '      <td><select name="header_notice_module[' + module_row + '][layout_id]">';
		html += '           <option value="99999">All pages</option>';
		
		<?php foreach($stores as $store) { ?>
		html += '           <option value="99999<?php echo $store['store_id']; ?>">All pages - Store <?php echo $store['name']; ?></option>';
		<?php } ?>
		          
		<?php foreach ($layouts as $layout) { ?>
		html += '           <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
		<?php } ?>
		
		<?php foreach ($layouts as $layout) { ?>
		html += '           <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
		<?php } ?>
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr style="display: none">';
		html += '      <td>Position:</td>';
		html += '      <td><select name="header_notice_module[' + module_row + '][position]">';
		html += '       		<option value="header_notice">Header notice</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Status:</td>';
		html += '      <td><select name="header_notice_module[' + module_row + '][status]">';
		html += '        <option value="1">Enabled</option>';
		html += '        <option value="0">Disabled</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Sort Order:</td>';
		html += '      <td><input type="text" name="header_notice_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
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
}
//--></script> 
<?php echo $footer; ?>