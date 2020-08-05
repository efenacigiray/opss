<?php echo $header; ?><?php echo $column_left; ?>
<div id="content"><div class="container-fluid">
	<div class="page-header">
	    <h1>Advanced Grid</h1>
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
		<div class="set-size" id="advanced_grid">
			<div class="content">
				<div>
					<div class="tabs clearfix">
						<!-- Tabs module -->
						<div id="tabs" class="htabs main-tabs">
							<?php $module_row = 1; ?>
							<?php foreach ($modules as $module) { ?>
							<a href="#tab-module-<?php echo $module_row; ?>" id="module-<?php echo $module_row; ?>">Module <?php echo $module_row; ?> &nbsp;<img src="view/image/module_template/delete-slider.png"  alt="" onclick="$('#module-<?php echo $module_row; ?>').remove(); $('#tab-module-<?php echo $module_row; ?>').remove(); $('.main-tabs a:first').trigger('click'); return false;" /></a>
							<?php $module_row++; ?>
							<?php } ?>
							<span id="module-add">Add Module &nbsp;<img src="view/image/module_template/add.png" alt="" onclick="addModule();" /></span>
						</div>
						
						<?php $module_row = 1; $modules_count = 1; $columns_count = 1; $links = 1; $products_tabs = 1; ?>
						<?php foreach ($modules as $module) { $column_count = $columns_count; ?>
						  <div id="tab-module-<?php echo $module_row; ?>" class="tab-content">
						   	<div id="tab-module-<?php echo $module_row; ?>-tabs" class="module-tabs">
						   		<a href="#tab-module-<?php echo $module_row; ?>-settings">Settings</a>
						   		<?php if(isset($module['column'])) { foreach($module['column'] as $column) { ?>
						   		<a href="#tab-module-<?php echo $module_row; ?>-column-<?php echo $column_count; ?>" id="column-<?php echo $column_count; ?>">Column &nbsp;<img src="view/image/module_template/delete-slider.png" alt="" onclick="$('#tab-module-<?php echo $module_row; ?>-column-<?php echo $column_count; ?>').remove(); $('#column-<?php echo $column_count; ?>').remove(); return false;" /></a>
						   		<?php $column_count++; } } ?>
						   		<span class="column-add">Add Column &nbsp;<img src="view/image/module_template/add.png" alt="" onclick="addcolumn(<?php echo $module_row; ?>);" /></span>
						   	</div>
						
						   	<div id="tab-module-<?php echo $module_row; ?>-settings" class="tab-content3">
                              		<h4>Design settings</h4>
                              		<table class="form">
                                		<tr>
                                  			<td>Add custom class:</td>
                                  			<td><input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][custom_class]" value="<?php echo $module['custom_class']; ?>" /></td>
                                		</tr>
                                		<tr>
                                  			<td>Margins (px):<br><small style="color:#a3a3a3;font-size: 10px">(Top - right - bottom - left)</small></td>
                                  			<td><input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][margin_top]" style="display: inline-block;margin-right:10px;" size="2" value="<?php echo $module['margin_top']; ?>" /> - <input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][margin_right]" size="2" style="display: inline-block;margin-right:10px;margin-left: 10px" value="<?php echo $module['margin_right']; ?>" /> - <input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][margin_bottom]" size="2" style="display: inline-block;margin-right:10px;margin-left: 10px" value="<?php echo $module['margin_bottom']; ?>" /> - <input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][margin_left]" style="display: inline-block;margin-right:10px;margin-left: 10px" size="2" value="<?php echo $module['margin_left']; ?>" /></td>
                                		</tr>
                                		<tr>
                                  			<td>Paddings (px):<br><small style="color:#a3a3a3;font-size: 10px">(Top - right - bottom - left)</small></td>
                                  			<td><input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][padding_top]" style="display: inline-block;margin-right:10px;" size="2" value="<?php echo $module['padding_top']; ?>" /> - <input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][padding_right]" size="2" style="display: inline-block;margin-right:10px;margin-left: 10px" value="<?php echo $module['padding_right']; ?>" /> - <input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][padding_bottom]" size="2" style="display: inline-block;margin-right:10px;margin-left: 10px" value="<?php echo $module['padding_bottom']; ?>" /> - <input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][padding_left]" style="display: inline-block;margin-right:10px;margin-left: 10px" size="2" value="<?php echo $module['padding_left']; ?>" /></td>
                                		</tr>
                                		<tr>
                                  			<td>Force full width:</td>
                                  			<td><select name="advanced_grid_module[<?php echo $module_row; ?>][force_full_width]">
                                    		<option value="0"<?php if($module['force_full_width'] == 0) echo ' selected="selected"'; ?>>No</option>
                                    		<option value="1"<?php if($module['force_full_width'] == 1) echo ' selected="selected"'; ?>>Yes</option>
                                  			</select></td>
                                		</tr>
                                		<tr>
                                  			<td>Background color:</td>
                                  			<td><input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][background_color]" class="colorpicker-input" value="<?php echo $module['background_color']; ?>" <?php if($module['background_color'] != '') echo 'style="border-right: 20px solid ' . $module['background_color'] . '"'; ?> /></td>
                                		</tr>
                                		<tr>
                                  			<td>Background image type:</td>
                                  			<td><select name="advanced_grid_module[<?php echo $module_row; ?>][background_image_type]">
                                    		<option value="0"<?php if($module['background_image_type'] == 0) echo ' selected="selected"'; ?>>None</option>
                                    		<option value="1"<?php if($module['background_image_type'] == 1) echo ' selected="selected"'; ?>>Standard</option>
                                    		<option value="2"<?php if($module['background_image_type'] == 2) echo ' selected="selected"'; ?>>Parallax</option>
                                  			</select></td>
                                		</tr>
                            		     <tr>
                            			     <td>Background image:</td>
                            			     <td>
                            			          <?php if ($module['background_image']) { ?>
                            			          <a href="" id="thumb-<?php echo $module_row; ?>" class="img-thumbnail img-edit" data-toggle="image"><img src="../image/<?php echo $module['background_image']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                            			          <?php } else { ?>
                            			          <a href="" id="thumb-<?php echo $module_row; ?>" class="img-thumbnail img-edit" data-toggle="image"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                            			          <?php } ?>
                            				     <input type="hidden" name="advanced_grid_module[<?php echo $module_row; ?>][background_image]" value="<?php echo $module['background_image']; ?>" id="input-<?php echo $module_row; ?>" />
                            			     </td>
                            			</tr>
                                		<tr>
                                  			<td>Position:</td>
                                  			<td><select name="advanced_grid_module[<?php echo $module_row; ?>][background_image_position]">
                                    		<option value="top left"<?php if($module['background_image_position'] == 'top left') echo ' selected="selected"'; ?>>Top left</option>
                                    		<option value="top center"<?php if($module['background_image_position'] == 'top center') echo ' selected="selected"'; ?>>Top center</option>
                                    		<option value="top right"<?php if($module['background_image_position'] == 'top right') echo ' selected="selected"'; ?>>Top right</option>
                                    		<option value="bottom left"<?php if($module['background_image_position'] == 'bottom left') echo ' selected="selected"'; ?>>Bottom left</option>
                                    		<option value="bottom center"<?php if($module['background_image_position'] == 'bottom center') echo ' selected="selected"'; ?>>Bottom center</option>
                                    		<option value="bottom right"<?php if($module['background_image_position'] == 'bottom right') echo ' selected="selected"'; ?>>Bottom right</option>
                                    		<option value="50% 0"<?php if($module['background_image_position'] == '50% 0') echo ' selected="selected"'; ?>>50% 0</option>
                                  			</select></td>
                                		</tr>
                                		<tr>
                                  			<td>Repeat:</td>
                                  			<td><select name="advanced_grid_module[<?php echo $module_row; ?>][background_image_repeat]">
                                    		<option value="no-repeat"<?php if($module['background_image_repeat'] == 'no-repeat') echo ' selected="selected"'; ?>>no-repeat</option>
                                    		<option value="repeat-x"<?php if($module['background_image_repeat'] == 'repeat-x') echo ' selected="selected"'; ?>>repeat-x</option>
                                    		<option value="repeat-y"<?php if($module['background_image_repeat'] == 'repeat-y') echo ' selected="selected"'; ?>>repeat-y</option>
                                    		<option value="repeat"<?php if($module['background_image_repeat'] == 'repeat') echo ' selected="selected"'; ?>>repeat</option>
                                  			</select></td>
                                		</tr>
                                		<tr>
                                		     <td>Attachment:</td>
                                		     <td><select name="advanced_grid_module[<?php echo $module_row; ?>][background_image_attachment]">
                                		          <option value="scroll"<?php if($module['background_image_attachment'] == 'scroll') echo ' selected="selected"'; ?>>scroll</option>
                                		          <option value="fixed"<?php if($module['background_image_attachment'] == 'fixed') echo ' selected="selected"'; ?>>fixed</option>
                                		     </select></td>
                                		</tr>
                              		</table> 
                         
                              		<h4 style="padding-top: 30px">Layout settings</h4>
                              		<table class="form">
                                		<tr>
                                 		 	<td>Layout:</td>
                                  			<td><select name="advanced_grid_module[<?php echo $module_row; ?>][layout_id]">
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
                                		<tr>
                                  			<td>Position:</td>
                                  			<td><select name="advanced_grid_module[<?php echo $module_row; ?>][position]">
                                  			        <?php if ($module['position'] == 'header_notice') { ?>
                                  			        <option value="header_notice" selected="selected">Header notice</option>
                                  			        <?php } else { ?>
                                  			        <option value="header_notice">Header notice</option>
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
                            				             <?php if ($module['position'] == 'product_custom_block') { ?>
                            				             <option value="product_custom_block" selected="selected">Product Custom Block</option>
                            				             <?php } else { ?>
                            				             <option value="product_custom_block">Product Custom Block</option>
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
                            				          
                            				          <?php if ($module['position'] == 'customfooter') { ?>
                            				             <option value="customfooter" selected="selected">CustomFooter</option>
                            				             <?php } else { ?>
                            				             <option value="customfooter">CustomFooter</option>
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
                            				          <?php if ($module['position'] == 'footer') { ?>
                            				          <option value="footer" selected="selected">Footer</option>
                            				          <?php } else { ?>
                            				          <option value="footer">Footer</option>
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
                                  			<td><select name="advanced_grid_module[<?php echo $module_row; ?>][status]">
                                    		<option value="1"<?php if($module['status'] == 1) echo ' selected="selected"'; ?>>Enabled</option>
                                    		<option value="0"<?php if($module['status'] == 0) echo ' selected="selected"'; ?>>Disabled</option>
                                  			</select></td>
                                		</tr>
                                		<tr>
                                  			<td>Sort Order:</td>
                                  			<td><input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
                                		</tr>
                                		<tr>
                                  			<td>Disable on mobile:</td>
                                  			<td><select name="advanced_grid_module[<?php echo $module_row; ?>][disable_on_mobile]">
                                    		<option value="0"<?php if($module['disable_on_mobile'] == 0) echo ' selected="selected"'; ?>>No</option>
                                    		<option value="1"<?php if($module['disable_on_mobile'] == 1) echo ' selected="selected"'; ?>>Yes</option>
                                  			</select></td>
                                		</tr>
                              		</table> 
                            	</div>
                            	
                            	<?php if(isset($module['column'])) { foreach($module['column'] as $column) { ?>
                            	<div id="tab-module-<?php echo $module_row; ?>-column-<?php echo $columns_count; ?>" class="tab-content3">
                            	          <?php if($column['status'] == 1) { echo '<div class="status status-on" title="1" rel="module_' . $module_row . '_column_' . $columns_count . '_status"></div>'; } else { echo '<div class="status status-off" title="0" rel="module_' . $module_row . '_column_' . $columns_count . '_status"></div>'; } ?>
                            			<input name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][status]" value="<?php echo $column['status']; ?>" id="module_<?php echo $module_row; ?>_column_<?php echo $columns_count; ?>_status" type="hidden" />
                            	
                            			<div class="input clearfix">
                            				<p>Column width:</p>
                            				<select name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][width]" class="change-column-width" id="module-<?php echo $module_row; ?>-column-<?php echo $columns_count; ?>">
                            					<option value="1"<?php if($column['width'] == 1) echo ' selected="selected"'; ?>>1/12</option>
                            					<option value="2"<?php if($column['width'] == 2) echo ' selected="selected"'; ?>>2/12</option>
                            					<option value="3"<?php if($column['width'] == 3) echo ' selected="selected"'; ?>>3/12</option>
                            					<option value="4"<?php if($column['width'] == 4) echo ' selected="selected"'; ?>>4/12</option>
                            					<option value="5"<?php if($column['width'] == 5) echo ' selected="selected"'; ?>>5/12</option>
                            					<option value="6"<?php if($column['width'] == 6) echo ' selected="selected"'; ?>>6/12</option>
                            					<option value="7"<?php if($column['width'] == 7) echo ' selected="selected"'; ?>>7/12</option>
                            					<option value="8"<?php if($column['width'] == 8) echo ' selected="selected"'; ?>>8/12</option>
                            					<option value="9"<?php if($column['width'] == 9) echo ' selected="selected"'; ?>>9/12</option>
                            					<option value="10"<?php if($column['width'] == 10) echo ' selected="selected"'; ?>>10/12</option>
                            					<option value="11"<?php if($column['width'] == 11) echo ' selected="selected"'; ?>>11/12</option>
                            					<option value="12"<?php if($column['width'] == 12) echo ' selected="selected"'; ?>>12/12</option>
                            					<option value="advanced"<?php if($column['width'] == 'advanced') echo ' selected="selected"'; ?>>Advanced</option>
                            				</select>
                            			</div>
                            	
                            			<div class="input clearfix simple-width"<?php if($column['width'] == 'advanced') echo ' style="display: none"'; ?>>
                            				<p>Disable on mobile:</p>
                            				<select name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][disable_on_mobile]">
                            					<option value="0"<?php if($column['disable_on_mobile'] == 0) echo ' selected="selected"'; ?>>No</option>
                            					<option value="1"<?php if($column['disable_on_mobile'] == 1) echo ' selected="selected"'; ?>>Yes</option>
                            				</select>
                            			</div>
                            	
                            			<div class="input clearfix advanced-width"<?php if($column['width'] != 'advanced') echo ' style="display: none"'; ?>>
                            				<p>Column width on extra small devices (<768px):</p>
                            				<select name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][width_xs]">
                            					<option value="1"<?php if($column['width_xs'] == 1) echo ' selected="selected"'; ?>>1/12</option>
                            					<option value="2"<?php if($column['width_xs'] == 2) echo ' selected="selected"'; ?>>2/12</option>
                            					<option value="3"<?php if($column['width_xs'] == 3) echo ' selected="selected"'; ?>>3/12</option>
                            					<option value="4"<?php if($column['width_xs'] == 4) echo ' selected="selected"'; ?>>4/12</option>
                            					<option value="5"<?php if($column['width_xs'] == 5) echo ' selected="selected"'; ?>>5/12</option>
                            					<option value="6"<?php if($column['width_xs'] == 6) echo ' selected="selected"'; ?>>6/12</option>
                            					<option value="7"<?php if($column['width_xs'] == 7) echo ' selected="selected"'; ?>>7/12</option>
                            					<option value="8"<?php if($column['width_xs'] == 8) echo ' selected="selected"'; ?>>8/12</option>
                            					<option value="9"<?php if($column['width_xs'] == 9) echo ' selected="selected"'; ?>>9/12</option>
                            					<option value="10"<?php if($column['width_xs'] == 10) echo ' selected="selected"'; ?>>10/12</option>
                            					<option value="11"<?php if($column['width_xs'] == 11) echo ' selected="selected"'; ?>>11/12</option>
                            					<option value="12"<?php if($column['width_xs'] == 12) echo ' selected="selected"'; ?>>12/12</option>
                            					<option value="hidden"<?php if($column['width_xs'] == 'hidden') echo ' selected="selected"'; ?>>hidden</option>
                            				</select>
                            			</div>
                            	
                            			<div class="input clearfix advanced-width"<?php if($column['width'] != 'advanced') echo ' style="display: none"'; ?>>
                            				<p>Column width on small devices (≥768px):</p>
                            				<select name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][width_sm]">
                            					<option value="1"<?php if($column['width_sm'] == 1) echo ' selected="selected"'; ?>>1/12</option>
                            					<option value="2"<?php if($column['width_sm'] == 2) echo ' selected="selected"'; ?>>2/12</option>
                            					<option value="3"<?php if($column['width_sm'] == 3) echo ' selected="selected"'; ?>>3/12</option>
                            					<option value="4"<?php if($column['width_sm'] == 4) echo ' selected="selected"'; ?>>4/12</option>
                            					<option value="5"<?php if($column['width_sm'] == 5) echo ' selected="selected"'; ?>>5/12</option>
                            					<option value="6"<?php if($column['width_sm'] == 6) echo ' selected="selected"'; ?>>6/12</option>
                            					<option value="7"<?php if($column['width_sm'] == 7) echo ' selected="selected"'; ?>>7/12</option>
                            					<option value="8"<?php if($column['width_sm'] == 8) echo ' selected="selected"'; ?>>8/12</option>
                            					<option value="9"<?php if($column['width_sm'] == 9) echo ' selected="selected"'; ?>>9/12</option>
                            					<option value="10"<?php if($column['width_sm'] == 10) echo ' selected="selected"'; ?>>10/12</option>
                            					<option value="11"<?php if($column['width_sm'] == 11) echo ' selected="selected"'; ?>>11/12</option>
                            					<option value="12"<?php if($column['width_sm'] == 12) echo ' selected="selected"'; ?>>12/12</option>
                            					<option value="hidden"<?php if($column['width_sm'] == 'hidden') echo ' selected="selected"'; ?>>hidden</option>
                            				</select>
                            			</div>
                            	
                            			<div class="input clearfix advanced-width"<?php if($column['width'] != 'advanced') echo ' style="display: none"'; ?>>
                            				<p>Column width on medium devices (≥992px):</p>
                            				<select name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][width_md]">
                            					<option value="1"<?php if($column['width_md'] == 1) echo ' selected="selected"'; ?>>1/12</option>
                            					<option value="2"<?php if($column['width_md'] == 2) echo ' selected="selected"'; ?>>2/12</option>
                            					<option value="3"<?php if($column['width_md'] == 3) echo ' selected="selected"'; ?>>3/12</option>
                            					<option value="4"<?php if($column['width_md'] == 4) echo ' selected="selected"'; ?>>4/12</option>
                            					<option value="5"<?php if($column['width_md'] == 5) echo ' selected="selected"'; ?>>5/12</option>
                            					<option value="6"<?php if($column['width_md'] == 6) echo ' selected="selected"'; ?>>6/12</option>
                            					<option value="7"<?php if($column['width_md'] == 7) echo ' selected="selected"'; ?>>7/12</option>
                            					<option value="8"<?php if($column['width_md'] == 8) echo ' selected="selected"'; ?>>8/12</option>
                            					<option value="9"<?php if($column['width_md'] == 9) echo ' selected="selected"'; ?>>9/12</option>
                            					<option value="10"<?php if($column['width_md'] == 10) echo ' selected="selected"'; ?>>10/12</option>
                            					<option value="11"<?php if($column['width_md'] == 11) echo ' selected="selected"'; ?>>11/12</option>
                            					<option value="12"<?php if($column['width_md'] == 12) echo ' selected="selected"'; ?>>12/12</option>
                            					<option value="hidden"<?php if($column['width_md'] == 'hidden') echo ' selected="selected"'; ?>>hidden</option>
                            				</select>
                            			</div>
                            	
                            			<div class="input clearfix advanced-width"<?php if($column['width'] != 'advanced') echo ' style="display: none"'; ?>>
                            				<p>Column width on large devices (≥1200px):</p>
                            				<select name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][width_lg]">
                            					<option value="1"<?php if($column['width_lg'] == 1) echo ' selected="selected"'; ?>>1/12</option>
                            					<option value="2"<?php if($column['width_lg'] == 2) echo ' selected="selected"'; ?>>2/12</option>
                            					<option value="3"<?php if($column['width_lg'] == 3) echo ' selected="selected"'; ?>>3/12</option>
                            					<option value="4"<?php if($column['width_lg'] == 4) echo ' selected="selected"'; ?>>4/12</option>
                            					<option value="5"<?php if($column['width_lg'] == 5) echo ' selected="selected"'; ?>>5/12</option>
                            					<option value="6"<?php if($column['width_lg'] == 6) echo ' selected="selected"'; ?>>6/12</option>
                            					<option value="7"<?php if($column['width_lg'] == 7) echo ' selected="selected"'; ?>>7/12</option>
                            					<option value="8"<?php if($column['width_lg'] == 8) echo ' selected="selected"'; ?>>8/12</option>
                            					<option value="9"<?php if($column['width_lg'] == 9) echo ' selected="selected"'; ?>>9/12</option>
                            					<option value="10"<?php if($column['width_lg'] == 10) echo ' selected="selected"'; ?>>10/12</option>
                            					<option value="11"<?php if($column['width_lg'] == 11) echo ' selected="selected"'; ?>>11/12</option>
                            					<option value="12"<?php if($column['width_lg'] == 12) echo ' selected="selected"'; ?>>12/12</option>
                            					<option value="hidden"<?php if($column['width_lg'] == 'hidden') echo ' selected="selected"'; ?>>hidden</option>
                            				</select>
                            			</div>
                            	
                            			<div class="input clearfix">
                            				<p>Sort:</p>
                            				<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][sort]" value="<?php echo $column['sort']; ?>">
                            			</div>
						   	
						   		<h4 style="margin-top: 20px">Add modules to the column</h4>
						   	
						   			<div id="module_<?php echo $module_row; ?>_column_<?php echo $columns_count; ?>_modules" class="tabs_add_element clearfix">
						   			     <?php if(isset($column['module'])) { $s = 1; foreach($column['module'] as $column_module) { ?>
						   			     <a href="#module-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-module-<?php echo $s; ?>" id="element-<?php echo $modules_count; ?>"><?php echo $s; ?> &nbsp;<img src="view/image/module_template/delete-slider.png" alt="" onclick="$('#element-<?php echo $modules_count; ?>').remove(); $('#module-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-module-<?php echo $s; ?>').remove(); return false;" /></a>
						   			     <?php $s++; $modules_count++; } } ?>
						   				<img src="view/image/module_template/add.png" alt="" onclick="addModuleToColumn(<?php echo $module_row; ?>, <?php echo $columns_count; ?>);">
						   			</div>
						   	          
						   	          <?php if(isset($column['module'])) { $s = 1; foreach($column['module'] as $column_module) { ?>
						   	          <div id="module-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-module-<?php echo $s; ?>" style="padding-top: 20px">
						   	               <?php if($column_module['status'] == 1) { echo '<div class="status status-on" title="1" rel="module_' . $module_row . '_column_' . $columns_count . '_module_' . $s . '_status"></div>'; } else { echo '<div class="status status-off" title="0" rel="module_' . $module_row . '_column_' . $columns_count . '_module_' . $s . '_status"></div>'; } ?>
						   	               <input name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][status]" value="<?php echo $column_module['status']; ?>" id="module_<?php echo $module_row; ?>_column_<?php echo $columns_count; ?>_module_<?php echo $s; ?>_status" type="hidden" />
						   	               							   	          							   	          
						   	          		<div class="input clearfix">
						   	          			<p>Sort:</p>
						   	          			<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][sort]" value="<?php echo $column_module['sort']; ?>">
						   	          		</div>
						   	          		<div class="input clearfix">
						   	          			<p>Type column:</p>
						   	          			<select name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][type]" class="type-column" id="<?php echo $module_row; ?>-<?php echo $columns_count; ?>-module-<?php echo $s; ?>">
						   	          				<option value="html"<?php if($column_module['type'] == 'html') echo ' selected="selected"'; ?>>HTML</option>
						   	          				<option value="box"<?php if($column_module['type'] == 'box') echo ' selected="selected"'; ?>>Box</option>
						   	          				<option value="links"<?php if($column_module['type'] == 'links') echo ' selected="selected"'; ?>>Links</option>
						   	          				<option value="products"<?php if($column_module['type'] == 'products') echo ' selected="selected"'; ?>>Products</option>
						   	          				<option value="products_tabs"<?php if($column_module['type'] == 'products_tabs') echo ' selected="selected"'; ?>>Products Tabs</option>
						   	          				<option value="newsletter"<?php if($column_module['type'] == 'newsletter') echo ' selected="selected"'; ?>>Newsletter</option>
						   	          				<option value="latest_blogs"<?php if($column_module['type'] == 'latest_blogs') echo ' selected="selected"'; ?>>Latest blogs</option>
						   	          				<option value="load_module"<?php if($column_module['type'] == 'load_module') echo ' selected="selected"'; ?>>Load module</option>
						   	          			</select>
						   	          		</div>
						   	          
						   	          		<div class="type-column">
						   	          
						   	          			<div class="html"<?php if($column_module['type'] != 'html') echo ' style="display: none"'; ?>>
						   	            				<div id="language-html-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>" class="htabs">
						   	          <?php foreach ($languages as $language) { ?>
						   	              				<a href="#tab-language-html-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
						   	          <?php } ?>
						   	            				</div>
						   	          
						   	          <?php foreach ($languages as $language) { ?>
						   	          				<div id="tab-language-html-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $language['language_id']; ?>">
						   	          					<div class="input clearfix">
						   	          						<p>HTML:</p>
						   	          						<textarea name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][html][<?php echo $language['language_id']; ?>]" <?php if($column_module['type'] != 'html') echo 'disabled="disabled"'; ?>><?php $language_id = $language['language_id']; if(isset($column_module['html'][$language_id])) echo $column_module['html'][$language_id]; ?></textarea>
						   	          					</div>
						   	          				</div>
						   	          <?php } ?>
						   	          			</div>
						   	          
						   	          			<div class="box"<?php if($column_module['type'] != 'box') echo ' style="display: none"'; ?>>
						   	            				<div id="language-box-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>" class="htabs">
						   	          <?php foreach ($languages as $language) { ?>
						   	              				<a href="#tab-language-box-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
						   	          <?php } ?>
						   	            				</div>
						   	          
						   	          <?php foreach ($languages as $language) { ?>
						   	          				<div id="tab-language-box-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $language['language_id']; ?>">
						   	          					<div class="input clearfix">
						   	          						<p>Module Title:</p>
						   	          						<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][module][title][<?php echo $language['language_id']; ?>]" value="<?php $language_id = $language['language_id']; if(isset($column_module['module']['title'][$language_id])) echo $column_module['module']['title'][$language_id]; ?>" <?php if($column_module['type'] != 'box') echo 'disabled="disabled"'; ?>>
						   	          					</div>
						   	          
						   	          					<div class="input clearfix">
						   	          						<p>Module Text:</p>
						   	          						<textarea name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][module][text][<?php echo $language['language_id']; ?>]" <?php if($column_module['type'] != 'box') echo 'disabled="disabled"'; ?>><?php $language_id = $language['language_id']; if(isset($column_module['module']['text'][$language_id])) echo $column_module['module']['text'][$language_id]; ?></textarea>
						   	          					</div>
						   	          				</div>
						   	          <?php } ?>
						   	          			</div>
						   	          
						   	          			<div class="links"<?php if($column_module['type'] != 'links') echo ' style="display: none"'; ?>>
						   	          
						   	          				<div class="input clearfix" style="padding-top:30px">
						   	          					<p>Module Template:</p>
						   	          					<div class="module-layouts">
						   	          <?php foreach($templates as $template) {
						   	               if(isset($links_templates[$template])) {
						   	                    $i = 0;
						   	                    echo '<div class="module-layout-title">' . $template . '</div>';
						   	                    if(!isset($column_module['links']['module_layout'])) $column_module['links']['module_layout'] = false;
						   	                    foreach($links_templates[$template] as $file_template) { ?>
						   	                                                  <div class="module-layout clearfix">
						   	                                                       <input type="radio" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][links][module_layout]" value="<?php echo $file_template; ?>" <?php if($column_module['links']['module_layout'] == $file_template) echo 'checked="checked"'; ?> class="input-module-layout" <?php if($column_module['type'] != 'links') echo 'disabled="disabled"'; ?>>
						   	                                                       <p><?php echo $file_template; ?></p>
						   	                                                  </div>
						   	                    <?php $i++; }
						   	               }
						   	          } ?>
						   	          					</div>
						   	          				</div>
						   	          
						   	          				<div class="input clearfix">
						   	          					<p>Module Title:</p>
						   	          					<div class="list-language">
						   	          <?php foreach ($languages as $language) { ?>
						   	          						<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][links][title][<?php echo $language['language_id']; ?>]" value="<?php $language_id = $language['language_id']; if(isset($column_module['links']['title'][$language_id])) echo $column_module['links']['title'][$language_id]; ?>" <?php if($column_module['type'] != 'links') echo 'disabled="disabled"'; ?>></div>
						   	          <?php } ?>
						   	          					</div>
						   	          				</div>
						   	          				
						   	          				<div class="input clearfix" style="border:none">
						   	          				     <p>Max links in one column:</p>
						   	          				     <input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][links][limit]" value="<?php if(isset($column_module['links']['limit'])) echo $column_module['links']['limit']; ?>" style="width: 50px" <?php if($column_module['type'] != 'links') echo 'disabled="disabled"'; ?>>
						   	          				</div>
						   	     
						   	          				<table id="links-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>">
						   	          					<thead>
						   	          						<tr>
						   	          							<td class="first">Name</td>
						   	          							<td>Link</td>
						   	          							<td>Sort</td>
						   	          							<td>Delete</td>
						   	          						</tr>
						   	          					</thead>
						   	          					<?php if(isset($column_module['links']['array'])) { foreach ($column_module['links']['array'] as $link) { ?>
						   	          					<tbody id="link-<?php echo $links; ?>">
						   	          					     <tr>
						   	          					          <td class="first"><div class="list-language">
						   	          					          <?php foreach ($languages as $language) { ?>
						   	          					               <div class="language">
						   	          					                    <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
						   	          					                    <input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][links][array][<?php echo $links; ?>][name][<?php echo $language['language_id']; ?>]" value="<?php $language_id = $language['language_id']; if(isset($link['name'][$language_id])) echo $link['name'][$language_id]; ?>">
						   	          					               </div>
						   	          					          <?php } ?>
						   	          					          </div></td>
						   	          					          <td><input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][links][array][<?php echo $links; ?>][url]" value="<?php echo $link['url']; ?>" <?php if($column_module['type'] != 'links') echo 'disabled="disabled"'; ?>></td>
						   	          					          <td><input type="text" class="sort" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][links][array][<?php echo $links; ?>][sort]" value="<?php echo $link['sort']; ?>" <?php if($column_module['type'] != 'links') echo 'disabled="disabled"'; ?>></td>
						   	          					          <td><a onclick="$('#link-<?php echo $links; ?>').remove();" class="remove-link">Remove</a></td>
						   	          					     </tr>
						   	          					</tbody>
						   	          					<?php $links++; } } ?>
						   	          					<tfoot></tfoot>
						   	          				</table>
						   	          				<a onclick="addLink(<?php echo $module_row; ?>, <?php echo $columns_count; ?>, <?php echo $s; ?>);" class="add-link">Add item</a>
						   	          			</div>
						   	          
						   	          			<div class="products"<?php if($column_module['type'] != 'products') echo ' style="display: none"'; ?>>
						   	          
						   	          				<div class="input clearfix" style="padding-top:30px">
						   	          					<p>Module Template:</p>
						   	          					<div class="module-layouts">
						   	          <?php foreach($templates as $template) {
						   	               if(isset($products_templates[$template])) {
						   	                    $i = 0;
						   	                    echo '<div class="module-layout-title">' . $template . '</div>';
						   	                    if(!isset($column_module['products']['module_layout'])) $column_module['products']['module_layout'] = false;
						   	                    foreach($products_templates[$template] as $file_template) { ?>
						   	                                                  <div class="module-layout clearfix">
						   	                                                       <input type="radio" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][module_layout]" value="<?php echo $file_template; ?>" <?php if($column_module['products']['module_layout'] == $file_template) echo 'checked="checked"'; ?> class="input-module-layout" <?php if($column_module['type'] != 'products') echo 'disabled="disabled"'; ?>>
						   	                                                       <p><?php echo $file_template; ?></p>
						   	                                                  </div>
						   	                    <?php $i++; }
						   	               }
						   	          } ?>
						   	          					</div>
						   	          				</div>
						   	          
						   	          				<div class="input clearfix">
						   	          					<p>Module Title:</p>
						   	          					<div class="list-language">
						   	          <?php foreach ($languages as $language) { ?>
						   	          						<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][title][<?php echo $language['language_id']; ?>]" value="<?php $language_id = $language['language_id']; if(isset($column_module['products']['title'][$language_id])) echo $column_module['products']['title'][$language_id]; ?>" <?php if($column_module['type'] != 'products') echo 'disabled="disabled"'; ?>></div>
						   	          <?php } ?>
						   	          					</div>
						   	          				</div>
						   	          
						   	          				<div class="input clearfix">
						   	          					<p>Get products from:</p>
						   	          					<div style="float:left;width:425px">
						   	          						<select name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][get_products_from]" class="get-product" id="<?php echo $module_row; ?>-<?php echo $columns_count; ?>-module-<?php echo $s; ?>" <?php if($column_module['type'] != 'products') echo 'disabled="disabled"'; ?>>
						   	          						<?php if(!isset($column_module['products']['get_products_from'])) $column_module['products']['get_products_from'] = false; ?>
						   	          							<option value="latest"<?php if($column_module['products']['get_products_from'] == 'latest') echo ' selected="selected"'; ?>>Latest Products</option>
						   	          							<option value="special"<?php if($column_module['products']['get_products_from'] == 'special') echo ' selected="selected"'; ?>>Special Products</option>
						   	          							<option value="bestsellers"<?php if($column_module['products']['get_products_from'] == 'bestsellers') echo ' selected="selected"'; ?>>Bestsellers Products</option>
						   	          							<option value="products"<?php if($column_module['products']['get_products_from'] == 'products') echo ' selected="selected"'; ?>>Choose a products</option>
						   	          							<option value="category"<?php if($column_module['products']['get_products_from'] == 'category') echo ' selected="selected"'; ?>>Choose a category</option>
						   	          							<option value="random"<?php if($column_module['products']['get_products_from'] == 'random') echo ' selected="selected"'; ?>>Random products</option>
						   	          							<option value="people_also_bought"<?php if($column_module['products']['get_products_from'] == 'people_also_bought') echo ' selected="selected"'; ?>>People also bought</option>
						   	          							<option value="related"<?php if($column_module['products']['get_products_from'] == 'related') echo ' selected="selected"'; ?>>Related products</option>
						   	          							<option value="most_viewed"<?php if($column_module['products']['get_products_from'] == 'most_viewed') echo ' selected="selected"'; ?>>Most viewed</option>
						   	          						</select>
						   	          
						   	          						<div class="filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_products panel-products-autocomplete"<?php if($column_module['products']['get_products_from'] != 'products') echo ' style="display: none"'; ?>>
						   	          							<div class="products-autocomplete clearfix">
						   	          								<p>Products:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>
						   	          									<div><input type="text" alt="<?php echo $module_row; ?>" title="<?php echo $columns_count; ?>" id="<?php echo $s; ?>" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][product]" value="" <?php if($column_module['type'] != 'products') echo 'disabled="disabled"'; ?> /></div>
						   	          							</div>
						   	          							<div class="scrollbox products">
						   	          							     <?php if(!isset($column_module['products']['products'])) $column_module['products']['products'] = false; ?>
						   	          							     <?php $products = explode(',', $column_module['products']['products']); ?>
						   	          							     <?php $class = 'odd'; ?>
						   	          							     <?php foreach ($products as $product) { if($product > 0) { ?>
						   	          							     <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
						   	          							     <?php 
						   	          							     	$model_catalog_product = $registry->get('model_catalog_product');
						   	          							     	$product_info = $model_catalog_product->getProduct($product); 
						   	          							     	$product_name = false;
						   	          							     	if($product_info) { 
						   	          							     		$product_name = $product_info['name'];
						   	          							     	} 
						   	          							     ?>
						   	          							     <div id="product-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $product; ?>" class="<?php echo $class; ?>"><?php echo $product_name; ?> <img src="view/image/module_template/delete-slider.png" alt="<?php echo $module_row; ?>" title="<?php echo $columns_count; ?>" id="<?php echo $s; ?>" class="<?php echo $product; ?>" />
						   	          							       <input type="hidden" value="<?php echo $product; ?>" />
						   	          							     </div>
						   	          							     <?php } } ?>
						   	          							</div>
						   	          							<input type="hidden" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][products]" value="<?php if(isset($column_module['products']['products'])) echo $column_module['products']['products']; ?>" <?php if($column_module['type'] != 'products') echo 'disabled="disabled"'; ?> />
						   	          						</div>
						   	          
						   	          						<div class="filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_categories panel-categories-autocomplete"<?php if($column_module['products']['get_products_from'] != 'category') echo ' style="display: none"'; ?>>
						   	          							<div class="products-autocomplete clearfix">
						   	          								<p>Categories:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>
						   	          								<div><input type="text" alt="<?php echo $module_row; ?>" title="<?php echo $columns_count; ?>" id="<?php echo $s; ?>" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][category]" <?php if($column_module['type'] != 'products') echo 'disabled="disabled"'; ?> value="" /></div>
						   	          							</div>
						   	          							<div class="scrollbox categories">
						   	          							     <?php if(!isset($column_module['products']['categories'])) $column_module['products']['categories'] = false; ?>
						   	          							     <?php $categories = explode(',', $column_module['products']['categories']); ?>
						   	          							     <?php $class = 'odd'; ?>
						   	          							     <?php foreach ($categories as $category) { if($category > 0) { ?>
						   	          							     <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
						   	          							     <?php 
						   	          							     	$model_catalog_category = $registry->get('model_catalog_category');
						   	          							     	$category_info = $model_catalog_category->getCategory($category); 
						   	          							     	$category_name = false;
						   	          							     	if($category_info) { 
						   	          							     		$category_name = $category_info['name'];
						   	          							     	}
						   	          							     ?>
						   	          							     <div id="category-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $category; ?>" class="<?php echo $class; ?>"><?php echo $category_name; ?> <img src="view/image/module_template/delete-slider.png" alt="<?php echo $module_row; ?>" title="<?php echo $columns_count; ?>" id="<?php echo $s; ?>" class="<?php echo $category; ?>" />
						   	          							       <input type="hidden" value="<?php echo $category; ?>" />
						   	          							     </div>
						   	          							     <?php } } ?>
						   	          							</div>
						   	          							<input type="hidden" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][categories]" value="<?php if(isset($column_module['products']['categories'])) echo $column_module['products']['categories']; ?>" <?php if($column_module['type'] != 'products') echo 'disabled="disabled"'; ?> />
						   	          						</div>
						   	          					</div>
						   	          				</div>
						   	          
						   	          				<div class="input clearfix">
						   	          					<p>Image dimension (W x H) and Resize Type:</p>
						   	          					<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][width]" value="<?php if(isset($column_module['products']['width'])) echo $column_module['products']['width']; ?>" style="width:50px;margin-right: 5px" <?php if($column_module['type'] != 'products') echo 'disabled="disabled"'; ?>>
						   	          					<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][height]" value="<?php if(isset($column_module['products']['height'])) echo $column_module['products']['height']; ?>" style="width: 50px" <?php if($column_module['type'] != 'products') echo 'disabled="disabled"'; ?>>
						   	          				</div>
						   	          
						   	          				<div class="input clearfix">
						   	          					<p>Limit products:</p>
						   	          					<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][limit]" value="<?php if(isset($column_module['products']['limit'])) echo $column_module['products']['limit']; ?>" style="width: 50px" <?php if($column_module['type'] != 'products') echo 'disabled="disabled"'; ?>>
						   	          				</div>
						   	          			</div>
						   	          			
						   	          			<div class="products_tabs"<?php if($column_module['type'] != 'products_tabs') echo ' style="display: none"'; ?>>
						   	             				<div class="input clearfix" style="padding-top:30px">
						   	             					<p>Module Template:</p>
						   	             					<div class="module-layouts">
						   	             <?php foreach($templates as $template) {
						   	                  if(isset($products_tabs_templates[$template])) {
						   	                       $i = 0;
						   	                       echo '<div class="module-layout-title">' . $template . '</div>';
						   	                       if(!isset($column_module['products_tabs']['module_layout'])) $column_module['products_tabs']['module_layout'] = false;
						   	                       foreach($products_tabs_templates[$template] as $file_template) { ?>
						   	                                                     <div class="module-layout clearfix">
						   	                                                          <input type="radio" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][module_layout]" value="<?php echo $file_template; ?>" <?php if($column_module['products_tabs']['module_layout'] == $file_template) echo 'checked="checked"'; ?> class="input-module-layout" <?php if($column_module['type'] != 'products_tabs') echo 'disabled="disabled"'; ?>>
						   	                                                          <p><?php echo $file_template; ?></p>
						   	                                                     </div>
						   	                       <?php $i++; }
						   	                  }
						   	             } ?>
						   	             					</div>
						   	             				</div>
						   	             				
						   	           				<div class="input clearfix">
						   	           					<p>Module Title:</p>
						   	           					<div class="list-language">
						   	           <?php foreach ($languages as $language) { ?>
						   	           						<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][title][<?php echo $language['language_id']; ?>]" value="<?php $language_id = $language['language_id']; if(isset($column_module['products_tabs']['title'][$language_id])) echo $column_module['products_tabs']['title'][$language_id]; ?>" <?php if($column_module['type'] != 'products_tabs') echo 'disabled="disabled"'; ?>></div>
						   	           <?php } ?>
						   	           					</div>
						   	           				</div>
						   	           				
						   	              				<div class="input clearfix">
						   	              					<p>Module Description:</p>
						   	              					<div class="list-language">
						   	              <?php foreach ($languages as $language) { ?>
						   	              						<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][description][<?php echo $language['language_id']; ?>]" value="<?php $language_id = $language['language_id']; if(isset($column_module['products_tabs']['description'][$language_id])) echo $column_module['products_tabs']['description'][$language_id]; ?>" <?php if($column_module['type'] != 'products_tabs') echo 'disabled="disabled"'; ?>></div>
						   	              <?php } ?>
						   	              					</div>
						   	              				</div>
						   	              				
						   	            				<div class="input clearfix">
						   	            					<p>Image dimension (W x H) and Resize Type:</p>
						   	            					<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][width]" value="<?php if(isset($column_module['products_tabs']['width'])) echo $column_module['products_tabs']['width']; ?>" style="width:50px;margin-right: 5px" <?php if($column_module['type'] != 'products_tabs') echo 'disabled="disabled"'; ?>>
						   	            					<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][height]" value="<?php if(isset($column_module['products_tabs']['height'])) echo $column_module['products_tabs']['height']; ?>" style="width: 50px" <?php if($column_module['type'] != 'products_tabs') echo 'disabled="disabled"'; ?>>
						   	            				</div>
						   	            
						   	            				<div class="input clearfix">
						   	            					<p>Limit products:</p>
						   	            					<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][limit]" value="<?php if(isset($column_module['products_tabs']['limit'])) echo $column_module['products_tabs']['limit']; ?>" style="width: 50px" <?php if($column_module['type'] != 'products_tabs') echo 'disabled="disabled"'; ?>>
						   	            				</div>
						   	            				
						   	            				<table id="products-tabs-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>">
						   	            				     <thead>
						   	            				          <tr>
						   	            				               <td class="first">Title</td>
						   	            				               <td>Get product from</td>
						   	            				               <td>Delete</td>
						   	            				          </tr>
						   	            				     </thead>
						   	            					<?php if(isset($column_module['products_tabs']['products'])) { foreach ($column_module['products_tabs']['products'] as $product) { ?>
						   	            				     	<tbody id="product-tab-<?php echo $products_tabs; ?>">
						   	            					     <tr>
						   	            					          <td class="first"><div class="list-language">
						   	            					          <?php foreach ($languages as $language) { ?>
						   	            					               <div class="language">
						   	            					                    <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
						   	            					                    <input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][products][<?php echo $products_tabs; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php $language_id = $language['language_id']; if(isset($product['title'][$language_id])) echo $product['title'][$language_id]; ?>" <?php if($column_module['type'] != 'products_tabs') echo 'disabled="disabled"'; ?>>
						   	            					               </div>
						   	            					          <?php } ?>
						   	            					          </div></td>
						   	            					          
						   	            					          <td id="module-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-module-<?php echo $s; ?>-<?php echo $products_tabs; ?>">
						   	            				                    <div class="input clearfix">
						   	            				                         <p>Get products from:</p>
						   	            				                         <div style="float:left;width:425px">
						   	            				                              <select name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][products][<?php echo $products_tabs; ?>][get_products_from]" class="get-product" id="<?php echo $module_row; ?>-<?php echo $columns_count; ?>-module-<?php echo $s; ?>-<?php echo $products_tabs; ?>" <?php if($column_module['type'] != 'products_tabs') echo 'disabled="disabled"'; ?>>
						   	            				                              <?php if(!isset($product['get_products_from'])) $product['get_products_from'] = false; ?>
						   	            				                              	<option value="latest"<?php if($product['get_products_from'] == 'latest') echo ' selected="selected"'; ?>>Latest Products</option>
						   	            				                              	<option value="special"<?php if($product['get_products_from'] == 'special') echo ' selected="selected"'; ?>>Special Products</option>
						   	            				                              	<option value="bestsellers"<?php if($product['get_products_from'] == 'bestsellers') echo ' selected="selected"'; ?>>Bestsellers Products</option>
						   	            				                              	<option value="products"<?php if($product['get_products_from'] == 'products') echo ' selected="selected"'; ?>>Choose a products</option>
						   	            				                              	<option value="category"<?php if($product['get_products_from'] == 'category') echo ' selected="selected"'; ?>>Choose a category</option>
						   	            				                              	<option value="random"<?php if($product['get_products_from'] == 'random') echo ' selected="selected"'; ?>>Random products</option>
						   	            				                              	<option value="people_also_bought"<?php if($product['get_products_from'] == 'people_also_bought') echo ' selected="selected"'; ?>>People also bought</option>
						   	            				                              	<option value="related"<?php if($product['get_products_from'] == 'related') echo ' selected="selected"'; ?>>Related products</option>
						   	            				                              	<option value="most_viewed"<?php if($product['get_products_from'] == 'most_viewed') echo ' selected="selected"'; ?>>Most viewed</option>
						   	            				                              </select>
						   	            				                         
						   	            				                              <div class="filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_<?php echo $products_tabs; ?>_products panel-products-autocomplete"<?php if($product['get_products_from'] != 'products') echo ' style="display: none"'; ?>>
						   	            				                                   <div class="products-autocomplete clearfix">
						   	            				                                        <p>Products:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>
						   	            				                                        <div><input type="text" alt="<?php echo $module_row; ?>" title="<?php echo $columns_count; ?>" id="<?php echo $s; ?>-<?php echo $products_tabs; ?>" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][products][<?php echo $products_tabs; ?>][product]" value="" <?php if($column_module['type'] != 'products_tabs') echo 'disabled="disabled"'; ?> /></div>
						   	            				                                   </div>
						   	            				                              	<div class="scrollbox products2">
						   	            				                              	     <?php if(!isset($product['products'])) $product['products'] = false; ?>
						   	            				                              	     <?php $products = explode(',', $product['products']); ?>
						   	            				                              	     <?php $class = 'odd'; ?>
						   	            				                              	     <?php foreach ($products as $production) { if($production > 0) { ?>
						   	            				                              	     <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
						   	            				                              	     <?php 
						   	            				                              	     	$model_catalog_product = $registry->get('model_catalog_product');
						   	            				                              	     	$product_info = $model_catalog_product->getProduct($production); 
						   	            				                              	     	$product_name = false;
						   	            				                              	     	if($product_info) { 
						   	            				                              	     		$product_name = $product_info['name'];
						   	            				                              	     	} 
						   	            				                              	     ?>
						   	            				                              	     <div id="product-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $products_tabs; ?>-<?php echo $production; ?>" class="<?php echo $class; ?>"><?php echo $product_name; ?> <img src="view/image/module_template/delete-slider.png" alt="<?php echo $module_row; ?>" title="<?php echo $columns_count; ?>" id="<?php echo $s; ?>" value="<?php echo $products_tabs; ?>" class="<?php echo $production; ?>" />
						   	            				                              	       <input type="hidden" value="<?php echo $production; ?>" />
						   	            				                              	     </div>
						   	            				                              	     <?php } } ?>
						   	            				                              	</div>
						   	            				                                   <input type="hidden" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][products][<?php echo $products_tabs; ?>][products]" value="<?php if(isset($product['products'])) echo $product['products']; ?>" <?php if($column_module['type'] != 'products_tabs') echo 'disabled="disabled"'; ?> />
						   	            				                              </div>
						   	            				                         
						   	            				                              <div class="filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_<?php echo $products_tabs; ?>_categories panel-categories-autocomplete" <?php if($product['get_products_from'] != 'category') echo ' style="display: none"'; ?>>
						   	            				                                   <div class="products-autocomplete clearfix">
						   	            				                                        <p>Categories:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>
						   	            				                                        <div><input type="text" alt="<?php echo $module_row; ?>" title="<?php echo $columns_count; ?>" id="<?php echo $s; ?>-<?php echo $products_tabs; ?>" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][products][<?php echo $products_tabs; ?>][category]" value="" <?php if($column_module['type'] != 'products_tabs') echo 'disabled="disabled"'; ?> /></div>
						   	            				                                   </div>
						   	            				                              	<div class="scrollbox categories2">
						   	            				                              	     <?php if(!isset($product['categories'])) $product['categories'] = false; ?>
						   	            				                              	     <?php $categories = explode(',', $product['categories']); ?>
						   	            				                              	     <?php $class = 'odd'; ?>
						   	            				                              	     <?php foreach ($categories as $category) { if($category > 0) { ?>
						   	            				                              	     <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
						   	            				                              	     <?php 
						   	            				                              	     	$model_catalog_category = $registry->get('model_catalog_category');
						   	            				                              	     	$category_info = $model_catalog_category->getCategory($category); 
						   	            				                              	     	$category_name = false;
						   	            				                              	     	if($category_info) { 
						   	            				                              	     		$category_name = $category_info['name'];
						   	            				                              	     	}
						   	            				                              	     ?>
						   	            				                              	     <div id="category-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $products_tabs; ?>-<?php echo $category; ?>" class="<?php echo $class; ?>"><?php echo $category_name; ?> <img src="view/image/module_template/delete-slider.png" alt="<?php echo $module_row; ?>" title="<?php echo $columns_count; ?>" value="<?php echo $products_tabs; ?>" id="<?php echo $s; ?>" class="<?php echo $category; ?>" />
						   	            				                              	       <input type="hidden" value="<?php echo $category; ?>" />
						   	            				                              	     </div>
						   	            				                              	     <?php } } ?>
						   	            				                              	</div>
						   	            				                                   <input type="hidden" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][products][<?php echo $products_tabs; ?>][categories]" value="<?php if(isset($product['categories'])) echo $product['categories']; ?>" <?php if($column_module['type'] != 'products_tabs') echo 'disabled="disabled"'; ?> />
						   	            				                              </div>
						   	            				                         </div>
						   	            				                    </div>
						   	            				               </td>
						   	            				
						   	            					          <td><a onclick="$('#product-tab-<?php echo $products_tabs; ?>').remove();" class="remove-link">Remove</a></td>
						   	            					     </tr>
						   	            					</tbody>
						   	            					
						   	            					<script type="text/javascript">
						   	            					     $('input[name=\'advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][products][<?php echo $products_tabs; ?>][category]\']').autocomplete({
						   	            					     	delay: 500,
						   	            					     	source: function(request, response) {
						   	            					     		$.ajax({
						   	            					     			url: 'index.php?route=catalog/category/autocomplete&user_token=<?php echo $user_token; ?>&filter_name=' +  encodeURIComponent(request),
						   	            					     			dataType: 'json',
						   	            					     			success: function(json) {		
						   	            					     				response($.map(json, function(item) {
						   	            					     					return {
						   	            					     						label: item['name'],
						   	            					     						value: item['category_id']
						   	            					     					}
						   	            					     				}));
						   	            					     			}
						   	            					     		});
						   	            					     	}, 
						   	            					     	select: function(item) {
						   	            					     		$('#category-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $products_tabs; ?>-' + item['value']).remove();
						   	            					     		
						   	            					     		$('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_<?php echo $products_tabs; ?>_categories .scrollbox').append('<div id="category-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $products_tabs; ?>-' + item['value'] + '">' + item['label'] + '<img src="view/image/module_template/delete-slider.png" alt="<?php echo $module_row; ?>" title="<?php echo $columns_count; ?>" id="<?php echo $s; ?>" value="<?php echo $products_tabs; ?>" class="' + item['value'] + '" /><input type="hidden" value="' + item['value'] + '" /></div>');
						   	            					     
						   	            					     		$('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_<?php echo $products_tabs; ?>_categories .scrollbox div:odd').attr('class', 'odd');
						   	            					     		$('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_<?php echo $products_tabs; ?>_categories .scrollbox div:even').attr('class', 'even');
						   	            					     		
						   	            					     		data = $.map($('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_<?php echo $products_tabs; ?>_categories .scrollbox input'), function(element){
						   	            					     			return $(element).attr('value');
						   	            					     		});
						   	            					     						
						   	            					     		$('input[name=\'advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][products][<?php echo $products_tabs; ?>][categories]\']').attr('value', data.join());
						   	            					     					
						   	            					     		return false;
						   	            					     	},
						   	            					     	focus: function(event, ui) {
						   	            					           	return false;
						   	            					        	}
						   	            					     });
						   	            					     	
						   	            					     $('input[name=\'advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][products][<?php echo $products_tabs; ?>][product]\']').autocomplete({
						   	            					     	delay: 500,
						   	            					     	source: function(request, response) {
						   	            					     		$.ajax({
						   	            					     			url: 'index.php?route=catalog/product/autocomplete&user_token=<?php echo $user_token; ?>&filter_name=' +  encodeURIComponent(request),
						   	            					     			dataType: 'json',
						   	            					     			success: function(json) {		
						   	            					     				response($.map(json, function(item) {
						   	            					     					return {
						   	            					     						label: item['name'],
						   	            					     						value: item['product_id']
						   	            					     					}
						   	            					     				}));
						   	            					     			}
						   	            					     		});
						   	            					     	}, 
						   	            					     	select: function(item) {
						   	            					     		$('#product-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $products_tabs; ?>-' + item['value']).remove();
						   	            					     		
						   	            					     		$('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_<?php echo $products_tabs; ?>_products .scrollbox').append('<div id="product-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $products_tabs; ?>-' + item['value'] + '">' + item['label'] + '<img src="view/image/module_template/delete-slider.png" alt="<?php echo $module_row; ?>" title="<?php echo $columns_count; ?>" value="<?php echo $products_tabs; ?>" id="<?php echo $s; ?>" class="' + item['value'] + '" /><input type="hidden" value="' + item['value'] + '" /></div>');
						   	            					     
						   	            					     		$('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_<?php echo $products_tabs; ?>_products .scrollbox div:odd').attr('class', 'odd');
						   	            					     		$('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_<?php echo $products_tabs; ?>_products .scrollbox div:even').attr('class', 'even');
						   	            					     		
						   	            					     		data = $.map($('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_<?php echo $products_tabs; ?>_products .scrollbox input'), function(element){
						   	            					     			return $(element).attr('value');
						   	            					     		});
						   	            					     						
						   	            					     		$('input[name=\'advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products_tabs][products][<?php echo $products_tabs; ?>][products]\']').attr('value', data.join());
						   	            					     					
						   	            					     		return false;
						   	            					     	},
						   	            					     	focus: function(event, ui) {
						   	            					           	return false;
						   	            					        	}
						   	            					     });
						   	            					</script>
						   	            					<?php $products_tabs++; } } ?>
						   	            				     <tfoot></tfoot>
						   	            				</table>
						   	            				<a onclick="addProductTab(<?php echo $module_row; ?>, <?php echo $columns_count; ?>, <?php echo $s; ?>);" class="add-link">Add item</a>
						   	          			</div>
						   	          
						   	          			<div class="newsletter"<?php if($column_module['type'] != 'newsletter') echo ' style="display: none"'; ?>>
						   	          				<div class="input clearfix" style="padding-top:30px">
						   	          					<p>Module Template:</p>
						   	          					<div class="module-layouts">
						   	          <?php foreach($templates as $template) {
						   	               if(isset($newsletter_templates[$template])) {
						   	                    $i = 0;
						   	                    echo '<div class="module-layout-title">' . $template . '</div>';
						   	                    if(!isset($column_module['newsletter']['module_layout'])) $column_module['newsletter']['module_layout'] = false;
						   	                    foreach($newsletter_templates[$template] as $file_template) { ?>
						   	                                                  <div class="module-layout clearfix">
						   	                                                       <input type="radio" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][newsletter][module_layout]" value="<?php echo $file_template; ?>" <?php if($column_module['newsletter']['module_layout'] == $file_template) echo 'checked="checked"'; ?> class="input-module-layout" <?php if($column_module['type'] != 'newsletter') echo 'disabled="disabled"'; ?>>
						   	                                                       <p><?php echo $file_template; ?></p>
						   	                                                  </div>
						   	                    <?php $i++; }
						   	               }
						   	          } ?>
						   	          					</div>
						   	          				</div>
						   	          
						   	            			<div id="language-newsletter-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>" class="htabs">
						   	          <?php foreach ($languages as $language) { ?>
						   	              				<a href="#tab-language-newsletter-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
						   	          <?php } ?>
						   	            			</div>
						   	          
						   	          <?php foreach ($languages as $language) { ?>
						   	          				<div id="tab-language-newsletter-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-<?php echo $language['language_id']; ?>">
						   	          					<div class="input clearfix">
						   	          						<p>Module Title:</p>
						   	          						<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][newsletter][title][<?php echo $language['language_id']; ?>]" value="<?php $language_id = $language['language_id']; if(isset($column_module['newsletter']['title'][$language_id])) echo $column_module['newsletter']['title'][$language_id]; ?>" <?php if($column_module['type'] != 'newsletter') echo 'disabled="disabled"'; ?>>
						   	          					</div>
						   	          
						   	          					<div class="input clearfix">
						   	          						<p>Module Text:</p>
						   	          						<textarea name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][newsletter][text][<?php echo $language['language_id']; ?>]" style="height: 100px" <?php if($column_module['type'] != 'newsletter') echo 'disabled="disabled"'; ?>><?php $language_id = $language['language_id']; if(isset($column_module['newsletter']['text'][$language_id])) echo $column_module['newsletter']['text'][$language_id]; ?></textarea>
						   	          					</div>
						   	          
						   	          					<div class="input clearfix">
						   	          						<p>Input Placeholder:</p>
						   	          						<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][newsletter][input_placeholder][<?php echo $language['language_id']; ?>]" value="<?php $language_id = $language['language_id']; if(isset($column_module['newsletter']['input_placeholder'][$language_id])) echo $column_module['newsletter']['input_placeholder'][$language_id]; ?>" <?php if($column_module['type'] != 'newsletter') echo 'disabled="disabled"'; ?>>
						   	          					</div>
						   	          
						   	          					<div class="input clearfix">
						   	          						<p>Subscribe button text:</p>
						   	          						<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][newsletter][subscribe_text][<?php echo $language['language_id']; ?>]" value="<?php $language_id = $language['language_id']; if(isset($column_module['newsletter']['subscribe_text'][$language_id])) echo $column_module['newsletter']['subscribe_text'][$language_id]; ?>" <?php if($column_module['type'] != 'newsletter') echo 'disabled="disabled"'; ?>>
						   	          					</div>
						   	          
						   	          					<div class="input clearfix">
						   	          						<p>Unsubscribe button text:</p>
						   	          						<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][newsletter][unsubscribe_text][<?php echo $language['language_id']; ?>]" value="<?php $language_id = $language['language_id']; if(isset($column_module['newsletter']['unsubscribe_text'][$language_id])) echo $column_module['newsletter']['unsubscribe_text'][$language_id]; ?>" <?php if($column_module['type'] != 'newsletter') echo 'disabled="disabled"'; ?>>
						   	          					</div>
						   	          				</div>
						   	          <?php } ?>
						   	          			</div>
						   	          
						   	          			<div class="latest_blogs"<?php if($column_module['type'] != 'latest_blogs') echo ' style="display: none"'; ?>>
						   	          
						   	          				<div class="input clearfix" style="padding-top:30px">
						   	          					<p>Module Template:</p>
						   	          					<div class="module-layouts">
						   	          <?php foreach($templates as $template) {
						   	               if(isset($latest_blogs_templates[$template])) {
						   	                    $i = 0;
						   	                    echo '<div class="module-layout-title">' . $template . '</div>';
						   	                    if(!isset($column_module['latest_blogs']['module_layout'])) $column_module['latest_blogs']['module_layout'] = false;
						   	                    foreach($latest_blogs_templates[$template] as $file_template) { ?>
						   	                                                  <div class="module-layout clearfix">
						   	                                                       <input type="radio" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][latest_blogs][module_layout]" value="<?php echo $file_template; ?>" <?php if($column_module['latest_blogs']['module_layout'] == $file_template) echo 'checked="checked"'; ?> class="input-module-layout" <?php if($column_module['type'] != 'latest_blogs') echo 'disabled="disabled"'; ?>>
						   	                                                       <p><?php echo $file_template; ?></p>
						   	                                                  </div>
						   	                    <?php $i++; }
						   	               }
						   	          } ?>
						   	          					</div>
						   	          				</div>
						   	          
						   	          				<div class="input clearfix">
						   	          					<p>Module Title:</p>
						   	          					<div class="list-language">
						   	          <?php foreach ($languages as $language) { ?>
						   	          						<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][latest_blogs][title][<?php echo $language['language_id']; ?>]" value="<?php $language_id = $language['language_id']; if(isset($column_module['latest_blogs']['title'][$language_id])) echo $column_module['latest_blogs']['title'][$language_id]; ?>" <?php if($column_module['type'] != 'latest_blogs') echo 'disabled="disabled"'; ?>></div>
						   	          <?php } ?>
						   	          					</div>
						   	          				</div>
						   	          
						   	          				<div class="input clearfix">
						   	          					<p>Image dimension (W x H) and Resize Type:</p>
						   	          					<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][latest_blogs][width]" value="<?php if(isset($column_module['latest_blogs']['width'])) echo $column_module['latest_blogs']['width']; ?>" style="width:50px;margin-right: 5px" <?php if($column_module['type'] != 'latest_blogs') echo 'disabled="disabled"'; ?>>
						   	          					<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][latest_blogs][height]" value="<?php if(isset($column_module['latest_blogs']['height'])) echo $column_module['latest_blogs']['height']; ?>" style="width: 50px" <?php if($column_module['type'] != 'latest_blogs') echo 'disabled="disabled"'; ?>>
						   	          				</div>
						   	          
						   	          				<div class="input clearfix">
						   	          					<p>Limit blogs:</p>
						   	          					<input type="text" name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][latest_blogs][limit]" value="<?php if(isset($column_module['latest_blogs']['limit'])) echo $column_module['latest_blogs']['limit']; ?>" style="width: 50px" <?php if($column_module['type'] != 'latest_blogs') echo 'disabled="disabled"'; ?>>
						   	          				</div>
						   	          			</div>
						   	          			
						   	          			<div class="load_module"<?php if($column_module['type'] != 'load_module') echo ' style="display: none"'; ?>>
						   	          			     <div class="input clearfix">
						   	          			          <p>Load module:</p>
						   	          			          <select name="advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][load_module][module]" style="width: 400px" <?php if($column_module['type'] != 'load_module') echo 'disabled="disabled"'; ?>>
						   	          			               <?php if(!isset($column_module['load_module']['module'])) $column_module['load_module']['module'] = false; ?>
						   	          			               <?php foreach ($load_modules as $module) { ?>
						   	          			                    <optgroup label="<?php echo $module['name']; ?>">
						   	          			                    <?php foreach ($module['module'] as $module) { ?>
						   	          			                         <option value="<?php echo $module['code']; ?>"<?php if(isset($column_module['load_module']['module'])) { if($module['code'] == $column_module['load_module']['module']) { echo ' selected="selected"'; } } ?>><?php echo $module['name']; ?></option>
						   	          			                    <?php } ?>
						   	          			                    </optgroup>
						   	          			               <?php } ?>
						   	          			          </select>
						   	          			     </div>
						   	          			</div>
						   	          
						   	          		</div>
						   	          </div>
						   	          
						   	          <script type="text/javascript">
						   	               $('#language-html-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?> a').tabs();	
						   	               $('#language-box-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?> a').tabs();	
						   	               $('#language-newsletter-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?> a').tabs();
						   	                                                                 
                                                  $('input[name=\'advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][category]\']').autocomplete({
                                                  	delay: 500,
                                                  	source: function(request, response) {
                                                  		$.ajax({
                                                  			url: 'index.php?route=catalog/category/autocomplete&user_token=<?php echo $user_token; ?>&filter_name=' +  encodeURIComponent(request),
                                                  			dataType: 'json',
                                                  			success: function(json) {		
                                                  				response($.map(json, function(item) {
                                                  					return {
                                                  						label: item['name'],
                                                  						value: item['category_id']
                                                  					}
                                                  				}));
                                                  			}
                                                  		});
                                                  	}, 
                                                  	select: function(item) {
                                                  		$('#category-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-' + item['value']).remove();
                                                  		
                                                  		$('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_categories .scrollbox').append('<div id="category-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-' + item['value'] + '">' + item['label'] + '<img src="view/image/module_template/delete-slider.png" alt="<?php echo $module_row; ?>" title="<?php echo $columns_count; ?>" id="<?php echo $s; ?>" class="' + item['value'] + '" /><input type="hidden" value="' + item['value'] + '" /></div>');
                                                  
                                                  		$('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_categories .scrollbox div:odd').attr('class', 'odd');
                                                  		$('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_categories .scrollbox div:even').attr('class', 'even');
                                                  		
                                                  		data = $.map($('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_categories .scrollbox input'), function(element){
                                                  			return $(element).attr('value');
                                                  		});
                                                  						
                                                  		$('input[name=\'advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][categories]\']').attr('value', data.join());
                                                  					
                                                  		return false;
                                                  	},
                                                  	focus: function(event, ui) {
                                                        	return false;
                                                     	}
                                                  });
                                                  	
                                                  $('input[name=\'advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][product]\']').autocomplete({
                                                  	delay: 500,
                                                  	source: function(request, response) {
                                                  		$.ajax({
                                                  			url: 'index.php?route=catalog/product/autocomplete&user_token=<?php echo $user_token; ?>&filter_name=' +  encodeURIComponent(request),
                                                  			dataType: 'json',
                                                  			success: function(json) {		
                                                  				response($.map(json, function(item) {
                                                  					return {
                                                  						label: item['name'],
                                                  						value: item['product_id']
                                                  					}
                                                  				}));
                                                  			}
                                                  		});
                                                  	}, 
                                                  	select: function(item) {
                                                  		$('#product-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-' + item['value']).remove();
                                                  		
                                                  		$('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_products .scrollbox').append('<div id="product-<?php echo $module_row; ?>-<?php echo $columns_count; ?>-<?php echo $s; ?>-' + item['value'] + '">' + item['label'] + '<img src="view/image/module_template/delete-slider.png" alt="<?php echo $module_row; ?>" title="<?php echo $columns_count; ?>" id="<?php echo $s; ?>" class="' + item['value'] + '" /><input type="hidden" value="' + item['value'] + '" /></div>');
                                                  
                                                  		$('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_products .scrollbox div:odd').attr('class', 'odd');
                                                  		$('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_products .scrollbox div:even').attr('class', 'even');
                                                  		
                                                  		data = $.map($('.filter_<?php echo $module_row; ?>_<?php echo $columns_count; ?>_<?php echo $s; ?>_products .scrollbox input'), function(element){
                                                  			return $(element).attr('value');
                                                  		});
                                                  						
                                                  		$('input[name=\'advanced_grid_module[<?php echo $module_row; ?>][column][<?php echo $columns_count; ?>][module][<?php echo $s; ?>][products][products]\']').attr('value', data.join());
                                                  					
                                                  		return false;
                                                  	},
                                                  	focus: function(event, ui) {
                                                        	return false;
                                                     	}
                                                  });
						   	          </script>
						   	          <?php $s++; } } ?>
						   	          
						   			<div id="module_<?php echo $module_row; ?>_column_<?php echo $columns_count; ?>_modules_add"></div>
						   			
						   			<script type="text/javascript">
						   			     $('#module_<?php echo $module_row; ?>_column_<?php echo $columns_count; ?>_modules a').tabs();	
						   			</script>
						   	
						   	</div>
						   	<?php $columns_count++; } } ?>
					
						   </div>
						   
						   <script type="text/javascript">
						        $('#tab-module-<?php echo $module_row; ?>-tabs a').tabs();
						   </script>
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

<script type="text/javascript">
var links = <?php echo $links; ?>;
function addLink(module_row, column, modules) {
	html = '<tbody id="link-' + links + '">';
	html += '	<tr>';
	html += '		<td class="first"><div class="list-language">';
	<?php foreach ($languages as $language) { ?>
	html += '			<div class="language">';
	html += '				<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />';
	html += '				<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][links][array][' + links + '][name][<?php echo $language['language_id']; ?>]">';
	html += '			</div>';
	<?php } ?>
	html += '		</div></td>';
	html += '		<td><input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][links][array][' + links + '][url]"></td>';
	html += '		<td><input type="text" class="sort" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][links][array][' + links + '][sort]"></td>';
	html += '		<td><a onclick="$(\'#link-' + links + '\').remove();" class="remove-link">Remove</a></td>';
	html += '	</tr>';
	html += '</tbody>';
	
	$('#links-' + module_row + '-' + column + '-' + modules + ' tfoot').before(html);
	links++;
}

var products_tabs = <?php echo $products_tabs; ?>;
function addProductTab(module_row, column, modules) {
	html = '<tbody id="product-tab-' + products_tabs + '">';
	html += '	<tr>';
	html += '		<td class="first"><div class="list-language">';
	<?php foreach ($languages as $language) { ?>
	html += '			<div class="language">';
	html += '				<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />';
	html += '				<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products_tabs][products][' + products_tabs + '][title][<?php echo $language['language_id']; ?>]">';
	html += '			</div>';
	<?php } ?>
	html += '		</div></td>';
	html += '		<td id="module-' + module_row + '-' + column + '-module-' + modules + '-' + products_tabs + '">';
     
     html += '				<div class="input clearfix">';
     html += '					<p>Get products from:</p>';
     html += '					<div style="float:left;width:425px">';
     html += '						<select name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products_tabs][products][' + products_tabs + '][get_products_from]" class="get-product" id="' + module_row + '-' + column + '-module-' + modules + '-' + products_tabs + '">';
     html += '							<option value="latest">Latest Products</option>';
     html += '							<option value="special">Special Products</option>';
     html += '							<option value="bestsellers">Bestsellers Products</option>';
     html += '							<option value="products">Choose a products</option>';
     html += '							<option value="category">Choose a category</option>';
     html += '							<option value="random">Random products</option>';
     html += '							<option value="people_also_bought">People also bought</option>';
     html += '							<option value="related">Related products</option>';
     html += '							<option value="most_viewed">Most viewed</option>';
     html += '						</select>';
     
     html += '						<div class="filter_' + module_row + '_' + column + '_' + modules + '_' + products_tabs + '_products panel-products-autocomplete" style="display: none">';
     html += '							<div class="products-autocomplete clearfix">';
     html += '								<p>Products:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>';
     html += '									<div><input type="text" alt="' + module_row + '" title="' + column + '" id="' + modules + '-' + products_tabs + '" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products_tabs][products][' + products_tabs + '][product]" value="" /></div>';
     html += '							</div>';
     html += '							<div class="scrollbox products2"></div>';
     html += '							<input type="hidden" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products_tabs][products][' + products_tabs + '][products]" value="" />';
     html += '						</div>';
     
     html += '						<div class="filter_' + module_row + '_' + column + '_' + modules + '_' + products_tabs + '_categories panel-categories-autocomplete" style="display: none">';
     html += '							<div class="products-autocomplete clearfix">';
     html += '								<p>Categories:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>';
     html += '								<div><input type="text" alt="' + module_row + '" title="' + column + '" id="' + modules + '-' + products_tabs + '" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products_tabs][products][' + products_tabs + '][category]" value="" /></div>';
     html += '							</div>';
     html += '							<div class="scrollbox categories2"></div>';
     html += '							<input type="hidden" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products_tabs][products][' + products_tabs + '][categories]" value="" />';
     html += '						</div>';
     html += '					</div>';
     html += '				</div>';
     
	html += '     </td>';
	html += '		<td><a onclick="$(\'#product-tab-' + products_tabs + '\').remove();" class="remove-link">Remove</a></td>';
	html += '	</tr>';
	html += '</tbody>';
	
	$('#products-tabs-' + module_row + '-' + column + '-' + modules + ' tfoot').before(html);
	
	var modules3 = products_tabs;
	
	$('input[name=\'advanced_grid_module[' + module_row + '][column][' + column + '][module][' + modules + '][products_tabs][products][' + modules3 + '][category]\']').autocomplete({
		delay: 500,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/category/autocomplete&user_token=<?php echo $user_token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						return {
							label: item['name'],
							value: item['category_id']
						}
					}));
				}
			});
		}, 
		select: function(item) {
			$('#category-' + module_row + '-' + column + '-' + modules + '-' + modules3 + '-' + item['value']).remove();
			
			$('.filter_' + module_row + '_' + column + '_' + modules + '_' + modules3 + '_categories .scrollbox').append('<div id="category-' + module_row + '-' + column + '-' + modules + '-' + modules3 + '-' + item['value'] + '">' + item['label'] + '<img src="view/image/module_template/delete-slider.png" alt="' + module_row + '" title="' + column + '" id="' + modules + '" value="' + modules3 + '" class="' + item['value'] + '" /><input type="hidden" value="' + item['value'] + '" /></div>');
	
			$('.filter_' + module_row + '_' + column + '_' + modules + '_' + modules3 + '_categories .scrollbox div:odd').attr('class', 'odd');
			$('.filter_' + module_row + '_' + column + '_' + modules + '_' + modules3 + '_categories .scrollbox div:even').attr('class', 'even');
			
			data = $.map($('.filter_' + module_row + '_' + column + '_' + modules + '_' + modules3 + '_categories .scrollbox input'), function(element){
				return $(element).attr('value');
			});
							
			$('input[name=\'advanced_grid_module[' + module_row + '][column][' + column + '][module][' + modules + '][products_tabs][products][' + modules3 + '][categories]\']').attr('value', data.join());
						
			return false;
		},
		focus: function(event, ui) {
	      	return false;
	   	}
	});
		
	$('input[name=\'advanced_grid_module[' + module_row + '][column][' + column + '][module][' + modules + '][products_tabs][products][' + modules3 + '][product]\']').autocomplete({
		delay: 500,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/product/autocomplete&user_token=<?php echo $user_token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						return {
							label: item['name'],
							value: item['product_id']
						}
					}));
				}
			});
		}, 
		select: function(item) {
			$('#product-' + module_row + '-' + column + '-' + modules + '-' + modules3 + '-' + item['value']).remove();
			
			$('.filter_' + module_row + '_' + column + '_' + modules + '_' + modules3 + '_products .scrollbox').append('<div id="product-' + module_row + '-' + column + '-' + modules + '-' + modules3 + '-' + item['value'] + '">' + item['label'] + '<img src="view/image/module_template/delete-slider.png" alt="' + module_row + '" title="' + column + '" value="' + modules3 + '" id="' + modules + '" class="' + item['value'] + '" /><input type="hidden" value="' + item['value'] + '" /></div>');
	
			$('.filter_' + module_row + '_' + column + '_' + modules + '_' + modules3 + '_products .scrollbox div:odd').attr('class', 'odd');
			$('.filter_' + module_row + '_' + column + '_' + modules + '_' + modules3 + '_products .scrollbox div:even').attr('class', 'even');
			
			data = $.map($('.filter_' + module_row + '_' + column + '_' + modules + '_' + modules3 + '_products .scrollbox input'), function(element){
				return $(element).attr('value');
			});
							
			$('input[name=\'advanced_grid_module[' + module_row + '][column][' + column + '][module][' + modules + '][products_tabs][products][' + modules3 + '][products]\']').attr('value', data.join());
						
			return false;
		},
		focus: function(event, ui) {
	      	return false;
	   	}
	});
	
	products_tabs++;
}
</script>

<script type="text/javascript">
var modules = <?php echo $modules_count; ?>;
function addModuleToColumn(module_row, column) {
	html = '<div id="module-' + module_row + '-' + column + '-module-' + modules + '" style="padding-top: 20px">';
	html += '	<div class="status status-off" title="0" rel="module_' + module_row + '_column_' + column + '_module_' + modules + '_status"></div><input name="advanced_grid_module[' + module_row + '][column][' + column + '][module][' + modules + '][status]" value="0" id="module_' + module_row + '_column_' + column + '_module_' + modules + '_status" type="hidden" />';
	
	html += '		<div class="input clearfix">';
	html += '			<p>Sort:</p>';
	html += '			<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][sort]" value="">';
	html += '		</div>';
	html += '		<div class="input clearfix">';
	html += '			<p>Type column:</p>';
	html += '			<select name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][type]" class="type-column" id="' + module_row + '-' + column + '-module-' + modules + '">';
	html += '				<option value="html">HTML</option>';
	html += '				<option value="box">Box</option>';
	html += '				<option value="links">Links</option>';
	html += '				<option value="products">Products</option>';
	html += '				<option value="products_tabs">Products tabs</option>';
	html += '				<option value="newsletter">Newsletter</option>';
	html += '				<option value="latest_blogs">Latest blogs</option>';
	html += '				<option value="load_module">Load module</option>';
	html += '			</select>';
	html += '		</div>';
	
	html += '		<div class="type-column">';
	
	html += '			<div class="html">';
	html += '  				<div id="language-html-' + module_row + '-' + column + '-' + modules + '" class="htabs">';
	<?php foreach ($languages as $language) { ?>
	html += '    				<a href="#tab-language-html-'+ module_row + '-' + column +'-' + modules + '-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>';
	<?php } ?>
	html += '  				</div>';
	
	<?php foreach ($languages as $language) { ?>
	html += '				<div id="tab-language-html-' + module_row + '-' + column + '-' + modules + '-<?php echo $language['language_id']; ?>">';
	html += '					<div class="input clearfix">';
	html += '						<p>HTML:</p>';
	html += '						<textarea name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][html][<?php echo $language['language_id']; ?>]"></textarea>';
	html += '					</div>';
	html += '				</div>';
	<?php } ?>
	html += '			</div>';
	
	html += '			<div class="box" style="display: none">';
	html += '  				<div id="language-box-' + module_row + '-' + column + '-' + modules + '" class="htabs">';
	<?php foreach ($languages as $language) { ?>
	html += '    				<a href="#tab-language-box-'+ module_row + '-' + column +'-' + modules + '-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>';
	<?php } ?>
	html += '  				</div>';
	
	<?php foreach ($languages as $language) { ?>
	html += '				<div id="tab-language-box-' + module_row + '-' + column + '-' + modules + '-<?php echo $language['language_id']; ?>">';
	html += '					<div class="input clearfix">';
	html += '						<p>Module Title:</p>';
	html += '						<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][module][title][<?php echo $language['language_id']; ?>]" value="">';
	html += '					</div>';
	
	html += '					<div class="input clearfix">';
	html += '						<p>Module Text:</p>';
	html += '						<textarea name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][module][text][<?php echo $language['language_id']; ?>]"></textarea>';
	html += '					</div>';
	html += '				</div>';
	<?php } ?>
	html += '			</div>';
	
	html += '			<div class="links" style="display: none">';
	
	html += '				<div class="input clearfix" style="padding-top:30px">';
	html += '					<p>Module Template:</p>';
	html += '					<div class="module-layouts">';
	<?php foreach($templates as $template) {
	     if(isset($links_templates[$template])) {
	          $i = 0;
	          echo 'html += \'<div class="module-layout-title">' . $template . '</div>\';';
	          foreach($links_templates[$template] as $file_template) { ?>
	               html += '                         <div class="module-layout clearfix">';
	               html += '                              <input type="radio" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][links][module_layout]" value="<?php echo $file_template; ?>" <?php if($i == 0) echo 'checked="checked"'; ?> class="input-module-layout">';
	               html += '                              <p><?php echo $file_template; ?></p>';
	               html += '                         </div>';
	          <?php $i++; }
	     }
	} ?>
	html += '					</div>';
	html += '				</div>';
	
	html += '				<div class="input clearfix">';
	html += '					<p>Module Title:</p>';
	html += '					<div class="list-language">';
	<?php foreach ($languages as $language) { ?>
	html += '						<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][links][title][<?php echo $language['language_id']; ?>]" value=""></div>';
	<?php } ?>
	html += '					</div>';
	html += '				</div>';
	
	html += '				<div class="input clearfix" style="border:none">';
	html += '					<p>Max links in one column:</p>';
	html += '					<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][links][limit]" value="5" style="width: 50px">';
	html += '				</div>';
	
	html += '				<table id="links-' + module_row + '-' + column + '-' + modules + '">';
	html += '					<thead>';
	html += '						<tr>';
	html += '							<td class="first">Name</td>';
	html += '							<td>Link</td>';
	html += '							<td>Sort</td>';
	html += '							<td>Delete</td>';
	html += '						</tr>';
	html += '					</thead>';
	html += '					<tfoot></tfoot>';
	html += '				</table>';
	html += '				<a onclick="addLink(' + module_row + ', ' + column + ', ' + modules + ');" class="add-link">Add item</a>';
	html += '			</div>';
	
	html += '			<div class="products" style="display: none">';
	
	html += '				<div class="input clearfix" style="padding-top:30px">';
	html += '					<p>Module Template:</p>';
	html += '					<div class="module-layouts">';
	<?php foreach($templates as $template) {
	     if(isset($products_templates[$template])) {
	          $i = 0;
	          echo 'html += \'<div class="module-layout-title">' . $template . '</div>\';';
	          foreach($products_templates[$template] as $file_template) { ?>
	               html += '                         <div class="module-layout clearfix">';
	               html += '                              <input type="radio" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products][module_layout]" value="<?php echo $file_template; ?>" <?php if($i == 0) echo 'checked="checked"'; ?> class="input-module-layout">';
	               html += '                              <p><?php echo $file_template; ?></p>';
	               html += '                         </div>';
	          <?php $i++; }
	     }
	} ?>
	html += '					</div>';
	html += '				</div>';
	
	html += '				<div class="input clearfix">';
	html += '					<p>Module Title:</p>';
	html += '					<div class="list-language">';
	<?php foreach ($languages as $language) { ?>
	html += '						<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products][title][<?php echo $language['language_id']; ?>]" value=""></div>';
	<?php } ?>
	html += '					</div>';
	html += '				</div>';
	
	html += '				<div class="input clearfix">';
	html += '					<p>Get products from:</p>';
	html += '					<div style="float:left;width:425px">';
	html += '						<select name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products][get_products_from]" class="get-product" id="' + module_row + '-' + column + '-module-' + modules + '">';
	html += '							<option value="latest">Latest Products</option>';
	html += '							<option value="special">Special Products</option>';
	html += '							<option value="bestsellers">Bestsellers Products</option>';
	html += '							<option value="products">Choose a products</option>';
	html += '							<option value="category">Choose a category</option>';
	html += '							<option value="random">Random products</option>';
	html += '							<option value="people_also_bought">People also bought</option>';
	html += '							<option value="related">Related products</option>';
	html += '							<option value="most_viewed">Most viewed</option>';
	html += '						</select>';
	
	html += '						<div class="filter_' + module_row + '_' + column + '_' + modules + '_products panel-products-autocomplete" style="display: none">';
	html += '							<div class="products-autocomplete clearfix">';
	html += '								<p>Products:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>';
	html += '									<div><input type="text" alt="' + module_row + '" title="' + column + '" id="' + modules + '" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products][product]" value="" /></div>';
	html += '							</div>';
	html += '							<div class="scrollbox products"></div>';
	html += '							<input type="hidden" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products][products]" value="" />';
	html += '						</div>';
	
	html += '						<div class="filter_' + module_row + '_' + column + '_' + modules + '_categories panel-categories-autocomplete" style="display: none">';
	html += '							<div class="products-autocomplete clearfix">';
	html += '								<p>Categories:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></p>';
	html += '								<div><input type="text" alt="' + module_row + '" title="' + column + '" id="' + modules + '" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products][category]" value="" /></div>';
	html += '							</div>';
	html += '							<div class="scrollbox categories"></div>';
	html += '							<input type="hidden" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products][categories]" value="" />';
	html += '						</div>';
	html += '					</div>';
	html += '				</div>';
	
	html += '				<div class="input clearfix">';
	html += '					<p>Image dimension (W x H) and Resize Type:</p>';
	html += '					<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products][width]" value="80" style="width:50px;margin-right: 5px">';
	html += '					<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products][height]" value="80" style="width: 50px">';
	html += '				</div>';
	
	html += '				<div class="input clearfix">';
	html += '					<p>Limit products:</p>';
	html += '					<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products][limit]" value="3" style="width: 50px">';
	html += '				</div>';
	html += '			</div>';
	
	html += '			<div class="products_tabs" style="display: none">';
	
	html += '				<div class="input clearfix" style="padding-top:30px">';
	html += '					<p>Module Template:</p>';
	html += '					<div class="module-layouts">';
	<?php foreach($templates as $template) {
	     if(isset($products_tabs_templates[$template])) {
	          $i = 0;
	          echo 'html += \'<div class="module-layout-title">' . $template . '</div>\';';
	          foreach($products_tabs_templates[$template] as $file_template) { ?>
	               html += '                         <div class="module-layout clearfix">';
	               html += '                              <input type="radio" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products_tabs][module_layout]" value="<?php echo $file_template; ?>" <?php if($i == 0) echo 'checked="checked"'; ?> class="input-module-layout">';
	               html += '                              <p><?php echo $file_template; ?></p>';
	               html += '                         </div>';
	          <?php $i++; }
	     }
	} ?>
	html += '					</div>';
	html += '				</div>';
	
	html += '				<div class="input clearfix">';
	html += '					<p>Module Title:</p>';
	html += '					<div class="list-language">';
	<?php foreach ($languages as $language) { ?>
	html += '						<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products_tabs][title][<?php echo $language['language_id']; ?>]" value=""></div>';
	<?php } ?>
	html += '					</div>';
	html += '				</div>';
	
	html += '				<div class="input clearfix">';
	html += '					<p>Module Description:</p>';
	html += '					<div class="list-language">';
	<?php foreach ($languages as $language) { ?>
	html += '						<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products_tabs][description][<?php echo $language['language_id']; ?>]" value=""></div>';
	<?php } ?>
	html += '					</div>';
	html += '				</div>';
	
	html += '				<div class="input clearfix">';
	html += '					<p>Image dimension (W x H) and Resize Type:</p>';
	html += '					<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products_tabs][width]" value="80" style="width:50px;margin-right: 5px">';
	html += '					<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products_tabs][height]" value="80" style="width: 50px">';
	html += '				</div>';
	
	html += '				<div class="input clearfix">';
	html += '					<p>Limit products:</p>';
	html += '					<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][products_tabs][limit]" value="3" style="width: 50px">';
	html += '				</div>';
	
	html += '				<table id="products-tabs-' + module_row + '-' + column + '-' + modules + '">';
	html += '					<thead>';
	html += '						<tr>';
	html += '							<td class="first">Title</td>';
	html += '							<td>Get product from</td>';
	html += '							<td>Delete</td>';
	html += '						</tr>';
	html += '					</thead>';
	html += '					<tfoot></tfoot>';
	html += '				</table>';
	html += '				<a onclick="addProductTab(' + module_row + ', ' + column + ', ' + modules + ');" class="add-link">Add item</a>';
	
	html += '			</div>';
	
	html += '			<div class="newsletter" style="display: none">';
	html += '				<div class="input clearfix" style="padding-top:30px">';
	html += '					<p>Module Template:</p>';
	html += '					<div class="module-layouts">';
	<?php foreach($templates as $template) {
	     if(isset($newsletter_templates[$template])) {
	          $i = 0;
	          echo 'html += \'<div class="module-layout-title">' . $template . '</div>\';';
	          foreach($newsletter_templates[$template] as $file_template) { ?>
	               html += '                         <div class="module-layout clearfix">';
	               html += '                              <input type="radio" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][newsletter][module_layout]" value="<?php echo $file_template; ?>" <?php if($i == 0) echo 'checked="checked"'; ?> class="input-module-layout">';
	               html += '                              <p><?php echo $file_template; ?></p>';
	               html += '                         </div>';
	          <?php $i++; }
	     }
	} ?>
	html += '					</div>';
	html += '				</div>';
	
	html += '  			<div id="language-newsletter-' + module_row + '-' + column + '-' + modules + '" class="htabs">';
	<?php foreach ($languages as $language) { ?>
	html += '    				<a href="#tab-language-newsletter-'+ module_row + '-' + column +'-' + modules + '-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>';
	<?php } ?>
	html += '  			</div>';
	
	<?php foreach ($languages as $language) { ?>
	html += '				<div id="tab-language-newsletter-' + module_row + '-' + column + '-' + modules + '-<?php echo $language['language_id']; ?>">';
	html += '					<div class="input clearfix">';
	html += '						<p>Module Title:</p>';
	html += '						<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][newsletter][title][<?php echo $language['language_id']; ?>]" value="">';
	html += '					</div>';
	
	html += '					<div class="input clearfix">';
	html += '						<p>Module Text:</p>';
	html += '						<textarea name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][newsletter][text][<?php echo $language['language_id']; ?>]" style="height: 100px"></textarea>';
	html += '					</div>';
	
	html += '					<div class="input clearfix">';
	html += '						<p>Input Placeholder:</p>';
	html += '						<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][newsletter][input_placeholder][<?php echo $language['language_id']; ?>]" value="">';
	html += '					</div>';
	
	html += '					<div class="input clearfix">';
	html += '						<p>Subscribe button text:</p>';
	html += '						<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][newsletter][subscribe_text][<?php echo $language['language_id']; ?>]" value="">';
	html += '					</div>';
	
	html += '					<div class="input clearfix">';
	html += '						<p>Unsubscribe button text:</p>';
	html += '						<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][newsletter][unsubscribe_text][<?php echo $language['language_id']; ?>]" value="">';
	html += '					</div>';
	html += '				</div>';
	<?php } ?>
	html += '			</div>';
	
	html += '			<div class="latest_blogs" style="display: none">';

	html += '				<div class="input clearfix" style="padding-top:30px">';
	html += '					<p>Module Template:</p>';
	html += '					<div class="module-layouts">';
	<?php foreach($templates as $template) {
	     if(isset($latest_blogs_templates[$template])) {
	          $i = 0;
	          echo 'html += \'<div class="module-layout-title">' . $template . '</div>\';';
	          foreach($latest_blogs_templates[$template] as $file_template) { ?>
	               html += '                         <div class="module-layout clearfix">';
	               html += '                              <input type="radio" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][latest_blogs][module_layout]" value="<?php echo $file_template; ?>" <?php if($i == 0) echo 'checked="checked"'; ?> class="input-module-layout">';
	               html += '                              <p><?php echo $file_template; ?></p>';
	               html += '                         </div>';
	          <?php $i++; }
	     }
	} ?>
	html += '					</div>';
	html += '				</div>';
	
	html += '				<div class="input clearfix">';
	html += '					<p>Module Title:</p>';
	html += '					<div class="list-language">';
	<?php foreach ($languages as $language) { ?>
	html += '						<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][latest_blogs][title][<?php echo $language['language_id']; ?>]" value=""></div>';
	<?php } ?>
	html += '					</div>';
	html += '				</div>';
	
	html += '				<div class="input clearfix">';
	html += '					<p>Image dimension (W x H) and Resize Type:</p>';
	html += '					<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][latest_blogs][width]" value="80" style="width:50px;margin-right: 5px">';
	html += '					<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][latest_blogs][height]" value="80" style="width: 50px">';
	html += '				</div>';
	
	html += '				<div class="input clearfix">';
	html += '					<p>Limit blogs:</p>';
	html += '					<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][latest_blogs][limit]" value="3" style="width: 50px">';
	html += '				</div>';
	html += '			</div>';
	
	html += '			<div class="load_module" style="display: none">';
	html += '		          <div class="input clearfix">';
	html += '			          <p>Load module:</p>';
	html += '			          <select name="advanced_grid_module['+ module_row +'][column][' + column + '][module][' + modules + '][load_module][module]" style="width: 400px">';
	
	<?php foreach ($load_modules as $module) { ?>
	html += '                         <optgroup label="<?php echo $module['name']; ?>">';
	     <?php foreach ($module['module'] as $module) { ?>
	html += '                              <option value="<?php echo $module['code']; ?>"><?php echo $module['name']; ?></option>';
	     <?php } ?>
	html += '                         </optgroup>';
	<?php } ?>

	html += '			          </select>';
	html += '		          </div>';
	html += '			</div>';
	
	html += '		</div>';
	html += '</div>';
	
	$('#module_' + module_row + '_column_' + column + '_modules > img').before('<a href="#module-' + module_row + '-' + column + '-module-' + modules + '" id="element-' + modules + '">' + modules + ' &nbsp;<img src="view/image/module_template/delete-slider.png" alt="" onclick="$(\'#element-' + modules + '\').remove(); $(\'#module-' + module_row + '-' + column + '-module-' + modules + '\').remove(); return false;" /></a>');
	
	$('#module_' + module_row + '_column_' + column + '_modules_add').before(html);
	$('#module_' + module_row + '_column_' + column + '_modules a').tabs();	
	$('#language-html-' + module_row + '-' + column + '-' + modules + ' a').tabs();	
	$('#language-box-' + module_row + '-' + column + '-' + modules + ' a').tabs();	
	$('#language-newsletter-' + module_row + '-' + column + '-' + modules + ' a').tabs();	
	$('#element-' + modules).trigger('click');
	
	var modules2 = modules;
	
	$('input[name=\'advanced_grid_module[' + module_row + '][column][' + column + '][module][' + modules2 + '][products][category]\']').autocomplete({
		delay: 500,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/category/autocomplete&user_token=<?php echo $user_token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						return {
							label: item['name'],
							value: item['category_id']
						}
					}));
				}
			});
		}, 
		select: function(item) {
			$('#category-' + module_row + '-' + column + '-' + modules2 + '-' + item['value']).remove();
			
			$('.filter_' + module_row + '_' + column + '_' + modules2 + '_categories .scrollbox').append('<div id="category-' + module_row + '-' + column + '-' + modules2 + '-' + item['value'] + '">' + item['label'] + '<img src="view/image/module_template/delete-slider.png" alt="' + module_row + '" title="' + column + '" id="' + modules2 + '" class="' + item['value'] + '" /><input type="hidden" value="' + item['value'] + '" /></div>');
	
			$('.filter_' + module_row + '_' + column + '_' + modules2 + '_categories .scrollbox div:odd').attr('class', 'odd');
			$('.filter_' + module_row + '_' + column + '_' + modules2 + '_categories .scrollbox div:even').attr('class', 'even');
			
			data = $.map($('.filter_' + module_row + '_' + column + '_' + modules2 + '_categories .scrollbox input'), function(element){
				return $(element).attr('value');
			});
							
			$('input[name=\'advanced_grid_module[' + module_row + '][column][' + column + '][module][' + modules2 + '][products][categories]\']').attr('value', data.join());
						
			return false;
		},
		focus: function(event, ui) {
	      	return false;
	   	}
	});
		
	$('input[name=\'advanced_grid_module[' + module_row + '][column][' + column + '][module][' + modules2 + '][products][product]\']').autocomplete({
		delay: 500,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/product/autocomplete&user_token=<?php echo $user_token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						return {
							label: item['name'],
							value: item['product_id']
						}
					}));
				}
			});
		}, 
		select: function(item) {
			$('#product-' + module_row + '-' + column + '-' + modules2 + '-' + item['value']).remove();
			
			$('.filter_' + module_row + '_' + column + '_' + modules2 + '_products .scrollbox').append('<div id="product-' + module_row + '-' + column + '-' + modules2 + '-' + item['value'] + '">' + item['label'] + '<img src="view/image/module_template/delete-slider.png" alt="' + module_row + '" title="' + column + '" id="' + modules2 + '" class="' + item['value'] + '" /><input type="hidden" value="' + item['value'] + '" /></div>');
	
			$('.filter_' + module_row + '_' + column + '_' + modules2 + '_products .scrollbox div:odd').attr('class', 'odd');
			$('.filter_' + module_row + '_' + column + '_' + modules2 + '_products .scrollbox div:even').attr('class', 'even');
			
			data = $.map($('.filter_' + module_row + '_' + column + '_' + modules2 + '_products .scrollbox input'), function(element){
				return $(element).attr('value');
			});
							
			$('input[name=\'advanced_grid_module[' + module_row + '][column][' + column + '][module][' + modules2 + '][products][products]\']').attr('value', data.join());
						
			return false;
		},
		focus: function(event, ui) {
	      	return false;
	   	}
	});
	
	modules++;
}
</script>

<script type="text/javascript">
var column = <?php echo $columns_count; ?>;
function addcolumn(module_row) {
	html = '<div id="tab-module-' + module_row + '-column-' + column + '" class="tab-content3">';
	html += '		<div class="status status-off" title="0" rel="module_' + module_row + '_column_' + column + '_status"></div><input name="advanced_grid_module[' + module_row + '][column][' + column + '][status]" value="0" id="module_' + module_row + '_column_' + column + '_status" type="hidden" />';
	
	html += '		<div class="input clearfix">';
	html += '			<p>Column width:</p>';
	html += '			<select name="advanced_grid_module['+ module_row +'][column][' + column + '][width]" class="change-column-width" id="module-' + module_row + '-column-' + column + '">';
	html += '				<option value="1">1/12</option>';
	html += '				<option value="2">2/12</option>';
	html += '				<option value="3">3/12</option>';
	html += '				<option value="4">4/12</option>';
	html += '				<option value="5">5/12</option>';
	html += '				<option value="6">6/12</option>';
	html += '				<option value="7">7/12</option>';
	html += '				<option value="8">8/12</option>';
	html += '				<option value="9">9/12</option>';
	html += '				<option value="10">10/12</option>';
	html += '				<option value="11">11/12</option>';
	html += '				<option value="12">12/12</option>';
	html += '				<option value="advanced">Advanced</option>';
	html += '			</select>';
	html += '		</div>';
	
	html += '		<div class="input clearfix simple-width">';
	html += '			<p>Disable on mobile:</p>';
	html += '			<select name="advanced_grid_module['+ module_row +'][column][' + column + '][disable_on_mobile]">';
	html += '				<option value="0">No</option>';
	html += '				<option value="1">Yes</option>';
	html += '			</select>';
	html += '		</div>';
	
	html += '		<div class="input clearfix advanced-width" style="display: none">';
	html += '			<p>Column width on extra small devices (<768px):</p>';
	html += '			<select name="advanced_grid_module['+ module_row +'][column][' + column + '][width_xs]">';
	html += '				<option value="1">1/12</option>';
	html += '				<option value="2">2/12</option>';
	html += '				<option value="3">3/12</option>';
	html += '				<option value="4">4/12</option>';
	html += '				<option value="5">5/12</option>';
	html += '				<option value="6">6/12</option>';
	html += '				<option value="7">7/12</option>';
	html += '				<option value="8">8/12</option>';
	html += '				<option value="9">9/12</option>';
	html += '				<option value="10">10/12</option>';
	html += '				<option value="11">11/12</option>';
	html += '				<option value="12">12/12</option>';
	html += '				<option value="hidden">hidden</option>';
	html += '			</select>';
	html += '		</div>';
	
	html += '		<div class="input clearfix advanced-width" style="display: none">';
	html += '			<p>Column width on small devices (≥768px):</p>';
	html += '			<select name="advanced_grid_module['+ module_row +'][column][' + column + '][width_sm]">';
	html += '				<option value="1">1/12</option>';
	html += '				<option value="2">2/12</option>';
	html += '				<option value="3">3/12</option>';
	html += '				<option value="4">4/12</option>';
	html += '				<option value="5">5/12</option>';
	html += '				<option value="6">6/12</option>';
	html += '				<option value="7">7/12</option>';
	html += '				<option value="8">8/12</option>';
	html += '				<option value="9">9/12</option>';
	html += '				<option value="10">10/12</option>';
	html += '				<option value="11">11/12</option>';
	html += '				<option value="12">12/12</option>';
	html += '				<option value="hidden">hidden</option>';
	html += '			</select>';
	html += '		</div>';
	
	html += '		<div class="input clearfix advanced-width" style="display: none">';
	html += '			<p>Column width on medium devices (≥992px):</p>';
	html += '			<select name="advanced_grid_module['+ module_row +'][column][' + column + '][width_md]">';
	html += '				<option value="1">1/12</option>';
	html += '				<option value="2">2/12</option>';
	html += '				<option value="3">3/12</option>';
	html += '				<option value="4">4/12</option>';
	html += '				<option value="5">5/12</option>';
	html += '				<option value="6">6/12</option>';
	html += '				<option value="7">7/12</option>';
	html += '				<option value="8">8/12</option>';
	html += '				<option value="9">9/12</option>';
	html += '				<option value="10">10/12</option>';
	html += '				<option value="11">11/12</option>';
	html += '				<option value="12">12/12</option>';
	html += '				<option value="hidden">hidden</option>';
	html += '			</select>';
	html += '		</div>';
	
	html += '		<div class="input clearfix advanced-width" style="display: none">';
	html += '			<p>Column width on large devices (≥1200px):</p>';
	html += '			<select name="advanced_grid_module['+ module_row +'][column][' + column + '][width_lg]">';
	html += '				<option value="1">1/12</option>';
	html += '				<option value="2">2/12</option>';
	html += '				<option value="3">3/12</option>';
	html += '				<option value="4">4/12</option>';
	html += '				<option value="5">5/12</option>';
	html += '				<option value="6">6/12</option>';
	html += '				<option value="7">7/12</option>';
	html += '				<option value="8">8/12</option>';
	html += '				<option value="9">9/12</option>';
	html += '				<option value="10">10/12</option>';
	html += '				<option value="11">11/12</option>';
	html += '				<option value="12">12/12</option>';
	html += '				<option value="hidden">hidden</option>';
	html += '			</select>';
	html += '		</div>';
	
	html += '		<div class="input clearfix">';
	html += '			<p>Sort:</p>';
	html += '			<input type="text" name="advanced_grid_module['+ module_row +'][column][' + column + '][sort]" value="">';
	html += '		</div>';
	
	html += '	<h4 style="margin-top: 20px">Add modules to the column</h4>';
	
	html += '		<div id="module_' + module_row + '_column_' + column + '_modules" class="tabs_add_element clearfix">';
	html += '			<img src="view/image/module_template/add.png" alt="" onclick="addModuleToColumn(' + module_row + ', ' + column + ');">';
	html += '		</div>';
	
	html += '		<div id="module_' + module_row + '_column_' + column + '_modules_add"></div>';
	
	html += '</div>';
	
	$('#tab-module-' + module_row + '').append(html);
	
	$('#tab-module-' + module_row + '-tabs .column-add').before('<a href="#tab-module-' + module_row + '-column-' + column + '" id="column-' + column + '">Column &nbsp;<img src="view/image/module_template/delete-slider.png" alt="" onclick="$(\'#column-' + column + '\').remove(); $(\'#tab-module-' + module_row + '-column-' + column + '\').remove(); return false;" /></a>');
	
	$('#tab-module-' + module_row + '-tabs a').tabs();
	
	$('#column-' + column).trigger('click');
	column++;
}
</script>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<div id="tab-module-' + module_row + '" class="tab-content">';

	html += '	<div id="tab-module-' + module_row + '-tabs" class="module-tabs">';
	html += '		<a href="#tab-module-' + module_row + '-settings">Settings</a>';
	html += '		<span class="column-add">Add Column &nbsp;<img src="view/image/module_template/add.png" alt="" onclick="addcolumn(' + module_row + ');" /></span>';
	html += '	</div>';
	
	html += '	<div id="tab-module-' + module_row + '-settings" class="tab-content3">';
	html += '  		<h4>Design settings</h4>';
	html += '  		<table class="form">';
	html += '    		<tr>';
	html += '      			<td>Add custom class:</td>';
	html += '      			<td><input type="text" name="advanced_grid_module[' + module_row + '][custom_class]" value="" /></td>';
	html += '    		</tr>';
	html += '    		<tr>';
	html += '      			<td>Margins (px):<br><small style="color:#a3a3a3;font-size: 10px">(Top - right - bottom - left)</small></td>';
	html += '      			<td><input type="text" name="advanced_grid_module[' + module_row + '][margin_top]" style="display: inline-block;margin-right:10px;" size="2" value="0" /> - <input type="text" name="advanced_grid_module[' + module_row + '][margin_right]" size="2" style="display: inline-block;margin-right:10px;margin-left: 10px" value="0" /> - <input type="text" name="advanced_grid_module[' + module_row + '][margin_bottom]" size="2" style="display: inline-block;margin-right:10px;margin-left: 10px" value="0" /> - <input type="text" name="advanced_grid_module[' + module_row + '][margin_left]" style="display: inline-block;margin-right:10px;margin-left: 10px" size="2" value="0" /></td>';
	html += '    		</tr>';
	html += '    		<tr>';
	html += '      			<td>Paddings (px):<br><small style="color:#a3a3a3;font-size: 10px">(Top - right - bottom - left)</small></td>';
	html += '      			<td><input type="text" name="advanced_grid_module[' + module_row + '][padding_top]" style="display: inline-block;margin-right:10px;" size="2" value="0" /> - <input type="text" name="advanced_grid_module[' + module_row + '][padding_right]" size="2" style="display: inline-block;margin-right:10px;margin-left: 10px" value="0" /> - <input type="text" name="advanced_grid_module[' + module_row + '][padding_bottom]" size="2" style="display: inline-block;margin-right:10px;margin-left: 10px" value="0" /> - <input type="text" name="advanced_grid_module[' + module_row + '][padding_left]" style="display: inline-block;margin-right:10px;margin-left: 10px" size="2" value="0" /></td>';
	html += '    		</tr>';
	html += '    		<tr>';
	html += '      			<td>Force full width:</td>';
	html += '      			<td><select name="advanced_grid_module[' + module_row + '][force_full_width]">';
	html += '        		<option value="0">No</option>';
	html += '        		<option value="1">Yes</option>';
	html += '      			</select></td>';
	html += '    		</tr>';
	html += '    		<tr>';
	html += '      			<td>Background color:</td>';
	html += '      			<td><input type="text" name="advanced_grid_module[' + module_row + '][background_color]" class="colorpicker-input" value="" /></td>';
	html += '    		</tr>';
	html += '    		<tr>';
	html += '      			<td>Background image type:</td>';
	html += '      			<td><select name="advanced_grid_module[' + module_row + '][background_image_type]">';
	html += '        		<option value="0">None</option>';
	html += '        		<option value="1">Standard</option>';
	html += '        		<option value="2">Parallax</option>';
	html += '      			</select></td>';
	html += '    		</tr>';
	html += '		     <tr>';
	html += '			     <td>Background image:</td>';
	html += '			     <td>';
	html += '				     <a href="" id="thumb-'+ module_row +'" class="img-thumbnail img-edit" data-toggle="image"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>';
	html += '				     <input type="hidden" name="advanced_grid_module['+ module_row +'][background_image]" value="" id="input-'+ module_row +'" />';
	html += '			     </td>';
	html += '			</tr>';
	html += '    		<tr>';
	html += '      			<td>Position:</td>';
	html += '      			<td><select name="advanced_grid_module[' + module_row + '][background_image_position]">';
	html += '        		<option value="top left">Top left</option>';
	html += '        		<option value="top center">Top center</option>';
	html += '        		<option value="top right">Top right</option>';
	html += '        		<option value="bottom left">Bottom left</option>';
	html += '        		<option value="bottom center">Bottom center</option>';
	html += '        		<option value="bottom right">Bottom right</option>';
	html += '        		<option value="50% 0">50% 0</option>';
	html += '      			</select></td>';
	html += '    		</tr>';
	html += '    		<tr>';
	html += '      			<td>Repeat:</td>';
	html += '      			<td><select name="advanced_grid_module[' + module_row + '][background_image_repeat]">';
	html += '        		<option value="no-repeat">no-repeat</option>';
	html += '        		<option value="repeat-x">repeat-x</option>';
	html += '        		<option value="repeat-y">repeat-y</option>';
	html += '        		<option value="repeat">repeat</option>';
	html += '      			</select></td>';
	html += '    		</tr>';
	html += '    		<tr>';
	html += '      			<td>Attachment:</td>';
	html += '      			<td><select name="advanced_grid_module[' + module_row + '][background_image_attachment]">';
	html += '        		<option value="scroll">scroll</option>';
	html += '        		<option value="fixed">fixed</option>';
	html += '      			</select></td>';
	html += '    		</tr>';
	html += '  		</table>'; 
	
	html += '  		<h4 style="padding-top: 30px">Layout settings</h4>';
	html += '  		<table class="form">';
	html += '    		<tr>';
	html += '     		 	<td>Layout:</td>';
	html += '      			<td><select name="advanced_grid_module[' + module_row + '][layout_id]">';
	html += '           		<option value="99999">All pages</option>';
	
	          <?php foreach($stores as $store) { ?>
	html += '           		<option value="99999<?php echo $store['store_id']; ?>">All pages - Store <?php echo $store['name']; ?></option>';
	          <?php } ?>
	          
			<?php foreach ($layouts as $layout) { ?>
	html += '           		<option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
			<?php } ?>
	html += '      			</select></td>';
	html += '   		 </tr>';
	html += '    		<tr>';
	html += '      			<td>Position:</td>';
	html += '      			<td><select name="advanced_grid_module[' + module_row + '][position]">';
	html += '				          <option value="header_notice">Header notice</option>';
	html += '				          <option value="slideshow">Slideshow</option>';
	html += '				          <option value="preface_left">Preface left</option>';
	html += '				          <option value="preface_right">Preface right</option>';
	html += '				          <option value="preface_fullwidth">Preface fullwidth</option>';
	html += '				          <option value="column_left">Column left</option>';
	html += '				          <option value="content_big_column">Content big column</option>';
	html += '				          <option value="content_top">Content top</option>';
	html += '				          <option value="product_custom_block">Product Custom Block</option>';
	html += '				          <option value="column_right">Column right</option>';
	html += '				          <option value="content_bottom">Content bottom</option>';
	html += '				          <option value="customfooter_top">CustomFooter Top</option>';
	html += '				          <option value="customfooter">CustomFooter</option>';
	html += '				          <option value="customfooter_bottom">CustomFooter Bottom</option>';
	html += '				          <option value="footer_top">Footer top</option>';
	html += '				          <option value="footer">Footer</option>';
	html += '				          <option value="footer_bottom">Footer bottom</option>';
	html += '				          <option value="bottom">Bottom</option>';
	html += '      			</select></td>';
	html += '    		</tr>';
	html += '    		<tr>';
	html += '      			<td>Status:</td>';
	html += '      			<td><select name="advanced_grid_module[' + module_row + '][status]">';
	html += '        		<option value="1">Enabled</option>';
	html += '        		<option value="0">Disabled</option>';
	html += '      			</select></td>';
	html += '    		</tr>';
	html += '    		<tr>';
	html += '      			<td>Sort Order:</td>';
	html += '      			<td><input type="text" name="advanced_grid_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    		</tr>';
	html += '    		<tr>';
	html += '      			<td>Disable on mobile:</td>';
	html += '      			<td><select name="advanced_grid_module[' + module_row + '][disable_on_mobile]">';
	html += '        		<option value="0">No</option>';
	html += '        		<option value="1">Yes</option>';
	html += '      			</select></td>';
	html += '    		</tr>';
	html += '  		</table>'; 
	html += '	</div>';

	html += '</div>';
	
	$('.tabs').append(html);
	
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
	
	$('#tab-module-' + module_row + '-tabs a').tabs();
	
	$('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '">Module ' + module_row + ' &nbsp;<img src="view/image/module_template/delete-slider.png" alt="" onclick="$(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); $(\'.main-tabs a:first\').trigger(\'click\'); return false;" /></a>');
	
	$('.main-tabs a').tabs();
	
	$('#module-' + module_row).trigger('click');
	
	module_row++;
}
//--></script> 
<script type="text/javascript">
jQuery(document).ready(function($) {
     $('body').on('click', '.scrollbox.products img', function () {
          $(this).parent().remove();
     	$('.filter_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_' + $(this).attr("id") + '_products .scrollbox div:odd').attr('class', 'odd');
     	$('.filter_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_' + $(this).attr("id") + '_products .scrollbox div:even').attr('class', 'even');
     
     	data = $.map($('.filter_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_' + $(this).attr("id") + '_products .scrollbox input'), function(element){
     		return $(element).attr('value');
     	});
     					
     	$('input[name=\'advanced_grid_module[' + $(this).attr("alt") + '][column][' + $(this).attr("title") + '][module][' + $(this).attr("id") + '][products][products]\']').attr('value', data.join());
     });
     
     $('body').on('click', '.scrollbox.categories img', function () {
          $(this).parent().remove();
     	$('.filter_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_' + $(this).attr("id") + '_categories .scrollbox div:odd').attr('class', 'odd');
     	$('.filter_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_' + $(this).attr("id") + '_categories .scrollbox div:even').attr('class', 'even');
     
     	data = $.map($('.filter_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_' + $(this).attr("id") + '_categories .scrollbox input'), function(element){
     		return $(element).attr('value');
     	});
     					
     	$('input[name=\'advanced_grid_module[' + $(this).attr("alt") + '][column][' + $(this).attr("title") + '][module][' + $(this).attr("id") + '][products][categories]\']').attr('value', data.join());
     });
     
     $('body').on('click', '.scrollbox.products2 img', function () {
          $(this).parent().remove();
     	$('.filter_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_' + $(this).attr("id") + '_' + $(this).attr("value") + '_products .scrollbox div:odd').attr('class', 'odd');
     	$('.filter_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_' + $(this).attr("id") + '_' + $(this).attr("value") + '_products .scrollbox div:even').attr('class', 'even');
     
     	data = $.map($('.filter_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_' + $(this).attr("id") + '_' + $(this).attr("value") + '_products .scrollbox input'), function(element){
     		return $(element).attr('value');
     	});
     					
     	$('input[name=\'advanced_grid_module[' + $(this).attr("alt") + '][column][' + $(this).attr("title") + '][module][' + $(this).attr("id") + '][products_tabs][products][' + $(this).attr("value") + '][products]\']').attr('value', data.join());
     });
     
     $('body').on('click', '.scrollbox.categories2 img', function () {
          $(this).parent().remove();
     	$('.filter_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_' + $(this).attr("id") + '_' + $(this).attr("value") + '_categories .scrollbox div:odd').attr('class', 'odd');
     	$('.filter_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_' + $(this).attr("id") + '_' + $(this).attr("value") + '_categories .scrollbox div:even').attr('class', 'even');
     
     	data = $.map($('.filter_' + $(this).attr("alt") + '_' + $(this).attr("title") + '_' + $(this).attr("id") + '_' + $(this).attr("value") + '_categories .scrollbox input'), function(element){
     		return $(element).attr('value');
     	});
     					
     	$('input[name=\'advanced_grid_module[' + $(this).attr("alt") + '][column][' + $(this).attr("title") + '][module][' + $(this).attr("id") + '][products_tabs][products][' + $(this).attr("value") + '][categories]\']').attr('value', data.join());
     });
	
	$('#advanced_grid').on('change', '.type-column', function () {
		var id_module = $(this).attr("id");
		$("#" + id_module +".type-column option:selected").each(function() {
			$("#module-" + id_module + " .type-column > div").css("display", "none");
			$("#module-" + id_module + " .type-column > div input, #module-" + id_module + " .type-column > div textarea, #module-" + id_module + " .type-column > div select").attr("disabled", "disabled");
			$("#module-" + id_module + " .type-column > div." + $(this).val()).css("display", "block");
			$("#module-" + id_module + " .type-column > div." + $(this).val() + " input, #module-" + id_module + " .type-column > div." + $(this).val() + " textarea, #module-" + id_module + " .type-column > div." + $(this).val() + " select").removeAttr("disabled");
		});
		
	});
	
	$('#advanced_grid').on('change', '.change-column-width', function () {
		var id_module = $(this).attr("id");
		$("#" +  id_module + " option:selected").each(function() {
			if($(this).val() == 'advanced') {
			     $("#tab-" + id_module + " .advanced-width").show();
			     $("#tab-" + id_module + " .simple-width").hide();
			} else {
			     $("#tab-" + id_module + " .advanced-width").hide();
			     $("#tab-" + id_module + " .simple-width").show();
			}
		});
		
	});
	
	$('#advanced_grid').on('change', '.get-product', function () {
		var id_module = $(this).attr("id");
		$("#module-" + id_module + " .panel-products-autocomplete").hide();
		$("#module-" + id_module + " .panel-categories-autocomplete").hide();
		$("#" + id_module +".get-product option:selected").each(function() {
			if($(this).val() == 'products') {
				$("#module-" + id_module + " .panel-products-autocomplete").show();
			} else if($(this).val() == 'category') {
				$("#module-" + id_module + " .panel-categories-autocomplete").show();
			}
		});
		
	});
	
	$('#advanced_grid').on('click', '.status', function () {
		
		var styl = $(this).attr("rel");
		var co = $(this).attr("title");
		
		if(co == 1) {
		
			$(this).removeClass('status-on');
			$(this).addClass('status-off');
			$(this).attr("title", "0");

			$("#"+styl+"").val(0);
		
		}
		
		if(co == 0) {
		
			$(this).addClass('status-on');
			$(this).removeClass('status-off');
			$(this).attr("title", "1");

			$("#"+styl+"").val(1);
		
		}
		
	});

});	
</script>
<?php echo $footer; ?>