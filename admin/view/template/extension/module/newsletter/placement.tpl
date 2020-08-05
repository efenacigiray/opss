<?php echo $header; ?><?php echo $column_left; ?>
<div id="content"><div class="container-fluid">
	<div class="page-header">
	    <h1>Newsletter</h1>
	    <ul class="breadcrumb">
		     <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		      <?php } ?>
	    </ul>
	  </div>
    
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,600,500,400' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
	<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
	<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>  
	
	<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } elseif ($success) {  ?>
		<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } ?>
	  
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

	<!-- Newsletter -->
	<div class="set-size" id="newsletter">		
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<!-- Content -->
			<div class="content">
				<div>
					<div class="bg-tabs clearfix">
						<div id="tabs">
							<a href="<?php echo $placement; ?>" id="placement" class="active"><span>Module placement</span></a>
							<a href="<?php echo $settings; ?>" id="existing"><span>Translation text</span></a>
							<a href="<?php echo $list_subscribed; ?>" id="subscribed"><span>List subscribers</span></a>
							<a href="<?php echo $send_mail; ?>" id="existing"><span>Send mail</span></a>
						</div>

						<div class="tab-content2">
							<h4>Add Newsletter</h4>
							<div id="newsletter_modules" class="tabs_add_element clearfix">
								<?php $i = 1; ?>
								<?php foreach($modules as $module) { ?>
									<a href="#newsletter_module_<?php echo $i; ?>" id="element_<?php echo $i; ?>"><?php echo $i; ?> &nbsp;<img src="view/image/module_template/delete-slider.png" alt="" onclick="$('#element_<?php echo $i; ?>').remove(); $('#newsletter_modules a:first').trigger('click'); $('#newsletter_module_<?php echo $i; ?>').remove(); return false;" /></a>
								<?php $i++; ?>
								<?php } ?>
								<img src="view/image/module_template/add.png" alt="" onclick="addModule();">
							</div>
							
							<?php $i = 1; ?>
							<?php foreach($modules as $module) { ?>
							<div id="newsletter_module_<?php echo $i; ?>" style="padding-top:20px">
								<div id="language_<?php echo $i; ?>" class="htabs">
									<?php foreach ($languages as $language) { ?>
									<a href="#tab_language_<?php echo $i; ?>_<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
									<?php } ?>
								</div>
								
								<?php foreach ($languages as $language) { ?>
								<div id="tab_language_<?php echo $i; ?>_<?php echo $language['language_id']; ?>">
									<div class="input clearfix">
										<p>Module Title:</p>
										<input type="text" name="newsletter_module[<?php echo $i; ?>][<?php echo $language['language_id']; ?>][module_title]" value="<?php echo isset($module[$language['language_id']]['module_title']) ? $module[$language['language_id']]['module_title'] : ''; ?>" />
									</div>
								
									<div class="input clearfix">
										<p>Module Text:</p>
										<div style="width: 608px;float: left"><textarea rows="0" cols="0" id="newsletter_module_<?php echo $i; ?>_<?php echo $language['language_id']; ?>_html" name="newsletter_module[<?php echo $i; ?>][<?php echo $language['language_id']; ?>][module_text]"><?php echo isset($module[$language['language_id']]['module_text']) ? $module[$language['language_id']]['module_text'] : ''; ?></textarea></div>
									</div>
								
									<div class="input clearfix">
										<p>Input Placeholder:</p>
										<input type="text" name="newsletter_module[<?php echo $i; ?>][<?php echo $language['language_id']; ?>][input_placeholder]" value="<?php echo isset($module[$language['language_id']]['input_placeholder']) ? $module[$language['language_id']]['input_placeholder'] : ''; ?>" />
									</div>
								
									<div class="input clearfix">
										<p>Subscribe text:</p>
										<input type="text" name="newsletter_module[<?php echo $i; ?>][<?php echo $language['language_id']; ?>][subscribe_text]" value="<?php echo isset($module[$language['language_id']]['subscribe_text']) ? $module[$language['language_id']]['subscribe_text'] : ''; ?>" />
									</div>
									
									<div class="input clearfix">
										<p>Unsubscribe text:</p>
										<input type="text" name="newsletter_module[<?php echo $i; ?>][<?php echo $language['language_id']; ?>][unsubscribe_text]" value="<?php echo isset($module[$language['language_id']]['unsubscribe_text']) ? $module[$language['language_id']]['unsubscribe_text'] : ''; ?>" />
									</div>
								</div>
								<?php } ?>
								
								<script type="text/javascript">
								     $('#language_<?php echo $i; ?> a').tabs();
								</script>
								
								<table class="form">
									<tr>
									  <td>Button unsubscribe:</td>
									  <td><select name="newsletter_module[<?php echo $i; ?>][button_unsubscribe]">
										    <?php if ($module['button_unsubscribe']) { ?>
										    <option value="1" selected="selected">Enabled</option>
										    <option value="0">Disabled</option>
										    <?php } else { ?>
										    <option value="1">Enabled</option>
										    <option value="0" selected="selected">Disabled</option>
										    <?php } ?>
									    </select>
									  </td>
									</tr>
								  <tr>
								    <td>Layout:</td>
								    <td><select name="newsletter_module[<?php echo $i; ?>][layout_id]">
								    	<?php if (99999 == $module['layout_id']) { ?>
								    	<option value="99999" selected="selected">All pages</option>
								    	<?php } else { ?>
								    	<option value="99999">All pages</option>
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
								  <tr>
								    <td>Position:</td>
								    <td><select name="newsletter_module[<?php echo $i; ?>][position]">
								    	<?php if ($module['position'] == 'menu') { ?>
								    	<option value="menu" selected="selected">Menu</option>
								    	<?php } else { ?>
								    	<option value="menu">Menu</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'slideshow') { ?>
								    	<option value="slideshow" selected="selected">Slideshow</option>
								    	<?php } else { ?>
								    	<option value="slideshow">Slideshow</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'preface_left') { ?>
								    	<option value="preface_left" selected="selected">Preface left</option>
								    	<?php } else { ?>
								    	<option value="preface_left">Preface left</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'preface_right') { ?>
								    	<option value="preface_right" selected="selected">Preface right</option>
								    	<?php } else { ?>
								    	<option value="preface_right">Preface right</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'preface_fullwidth') { ?>
								    	<option value="preface_fullwidth" selected="selected">Preface fullwidth</option>
								    	<?php } else { ?>
								    	<option value="preface_fullwidth">Preface fullwidth</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'column_left') { ?>
								    	<option value="column_left" selected="selected">Column left</option>
								    	<?php } else { ?>
								    	<option value="column_left">Column left</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'content_big_column') { ?>
								    	<option value="content_big_column" selected="selected">Content big column</option>
								    	<?php } else { ?>
								    	<option value="content_big_column">Content big column</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'content_top') { ?>
								    	<option value="content_top" selected="selected">Content top</option>
								    	<?php } else { ?>
								    	<option value="content_top">Content top</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'column_right') { ?>
								    	<option value="column_right" selected="selected">Column right</option>
								    	<?php } else { ?>
								    	<option value="column_right">Column right</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'content_bottom') { ?>
								    	<option value="content_bottom" selected="selected">Content bottom</option>
								    	<?php } else { ?>
								    	<option value="content_bottom">Content bottom</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'customfooter_top') { ?>
								    	<option value="customfooter_top" selected="selected">CustomFooter Top</option>
								    	<?php } else { ?>
								    	<option value="customfooter_top">CustomFooter Top</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'customfooter_bottom') { ?>
								    	<option value="customfooter_bottom" selected="selected">CustomFooter Bottom</option>
								    	<?php } else { ?>
								    	<option value="customfooter_bottom">CustomFooter Bottom</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'footer_top') { ?>
								    	<option value="footer_top" selected="selected">Footer top</option>
								    	<?php } else { ?>
								    	<option value="footer_top">Footer top</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'footer_left') { ?>
								    	<option value="footer_left" selected="selected">Footer left</option>
								    	<?php } else { ?>
								    	<option value="footer_left">Footer left</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'footer_right') { ?>
								    	<option value="footer_right" selected="selected">Footer right</option>
								    	<?php } else { ?>
								    	<option value="footer_right">Footer right</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'footer_bottom') { ?>
								    	<option value="footer_bottom" selected="selected">Footer bottom</option>
								    	<?php } else { ?>
								    	<option value="footer_bottom">Footer bottom</option>
								    	<?php } ?>
								    	<?php if ($module['position'] == 'bottom') { ?>
								    	<option value="bottom" selected="selected">Bottom</option>
								    	<?php } else { ?>
								    	<option value="bottom">Bottom</option>
								    	<?php } ?>
								      </select></td>
								  </tr>
								  <tr>
								    <td>Status:</td>
								    <td><select name="newsletter_module[<?php echo $i; ?>][status]">
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
								    <td><input type="text" name="newsletter_module[<?php echo $i; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
								  </tr>
								</table>
							</div>
							<?php $i++; ?>
							<?php } ?>
							
							<div id="newsletter_modules_add"></div>
							
							<script type="text/javascript">
								var module = <?php echo $i; ?>;
								function addModule() {
									html = '<div id="newsletter_module_' + module + '" style="padding-top:20px">';
									html += '  <div id="language_' + module + '" class="htabs">';
									<?php foreach ($languages as $language) { ?>
									html += '    <a href="#tab_language_'+ module + '_<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>';
									<?php } ?>
									html += '  </div>';
									
									<?php foreach ($languages as $language) { ?>
									html += '    <div id="tab_language_'+ module + '_<?php echo $language['language_id']; ?>">';
									html += '		<div class="input clearfix">';
									html += '			<p>Module Title:</p>';
									html += '			<input type="text" name="newsletter_module[' + module + '][<?php echo $language['language_id']; ?>][module_title]" value="" />';
									html += '		</div>';
									
									html += '		<div class="input clearfix">';
									html += '			<p>Module Text:</p>';
									html += '			<div style="width: 608px;float: left"><textarea rows="0" cols="0" id="newsletter_module_' + module + '_<?php echo $language['language_id']; ?>_html" name="newsletter_module[' + module + '][<?php echo $language['language_id']; ?>][module_text]"></textarea></div>';
									html += '		</div>';
									
									html += '		<div class="input clearfix">';
									html += '			<p>Input Placeholder:</p>';
									html += '			<input type="text" name="newsletter_module[' + module + '][<?php echo $language['language_id']; ?>][input_placeholder]" value="" />';
									html += '		</div>';
									
									html += '		<div class="input clearfix">';
									html += '			<p>Subscribe text:</p>';
									html += '			<input type="text" name="newsletter_module[' + module + '][<?php echo $language['language_id']; ?>][subscribe_text]" value="" />';
									html += '		</div>';
									
									html += '		<div class="input clearfix">';
									html += '			<p>Unsubscribe text:</p>';
									html += '			<input type="text" name="newsletter_module[' + module + '][<?php echo $language['language_id']; ?>][unsubscribe_text]" value="" />';
									html += '		</div>';
									html += '    </div>';
									<?php } ?>
									html += '  <table class="form">';
									html += '	<tr>';
									html += '		<td>Button unsubscribe:</td>';
									html += '      <td><select name="newsletter_module[' + module + '][button_unsubscribe]">';
									html += '        <option value="1">Enabled</option>';
									html += '        <option value="0" selected="selected=">Disabled</option>';
									html += '      </select></td>';
									html += '	</tr>';
									html += '    <tr>';
									html += '      <td>Layout:</td>';
									html += '      <td><select name="newsletter_module[' + module + '][layout_id]">';
									html += '           <option value="99999">All pages</option>';
									<?php foreach ($layouts as $layout) { ?>
									html += '           <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
									<?php } ?>
									html += '      </select></td>';
									html += '    </tr>';
									html += '    <tr>';
									html += '      <td>Position:</td>';
									html += '      <td><select name="newsletter_module[' + module + '][position]">';
									html += '       		<option value="menu">Menu</option>';
									html += '				<option value="slideshow">Slideshow</option>';
									html += '				<option value="preface_left">Preface left</option>';
									html += '				<option value="preface_right">Preface right</option>';
									html += '				<option value="preface_fullwidth">Preface fullwidth</option>';
									html += '				<option value="column_left">Column left</option>';
									html += '				<option value="content_big_column">Content big column</option>';
									html += '				<option value="content_top">Content top</option>';
									html += '				<option value="column_right">Column right</option>';
									html += '				<option value="content_bottom">Content bottom</option>';
									html += '				<option value="customfooter_top">CustomFooter Top</option>';
									html += '				<option value="customfooter_bottom">CustomFooter Bottom</option>';
									html += '				<option value="footer_top">Footer top</option>';
									html += '				<option value="footer_left">Footer left</option>';
									html += '				<option value="footer_right">Footer right</option>';
									html += '				<option value="footer_bottom">Footer bottom</option>';
									html += '				<option value="bottom">Bottom</option>';
									html += '      </select></td>';
									html += '    </tr>';
									html += '    <tr>';
									html += '      <td>Status:</td>';
									html += '      <td><select name="newsletter_module[' + module + '][status]">';
									html += '        <option value="1">Enabled</option>';
									html += '        <option value="0">Disabled</option>';
									html += '      </select></td>';
									html += '    </tr>';
									html += '    <tr>';
									html += '      <td>Sort Order:</td>';
									html += '      <td><input type="text" name="newsletter_module[' + module + '][sort_order]" value="" size="3" /></td>';
									html += '    </tr>';
									html += '  </table>'; 
									html += '</div>';
										
									$('#newsletter_modules > img').before('<a href="#newsletter_module_' + module + '" id="element_' + module + '">' + module + ' &nbsp;<img src="view/image/module_template/delete-slider.png" alt="" onclick="$(\'#element_' + module + '\').remove(); $(\'#newsletter_modules a:first\').trigger(\'click\'); $(\'#newsletter_module_' + module + '\').remove(); return false;" /></a>');
									
									$('#newsletter_modules a').tabs();	
									
									$('#newsletter_modules_add').before(html);
									$('#element_' + module).trigger('click');
									
									$('#language_' + module + ' a').tabs();
									
									module++;
								}
							</script>
							
							<script type="text/javascript"> 
								$('#newsletter_modules a').tabs();	
							</script>
						</div>
					</div>
					
					<div>
						<!-- Buttons -->
						<div class="buttons"><input type="submit" name="button-save" class="button-save" value=""></div>
					</div>
				</div>
			</div>		
		</form>
	</div>
</div>
<?php echo $footer; ?>