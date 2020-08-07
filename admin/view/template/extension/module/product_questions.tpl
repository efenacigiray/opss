<?php echo $header; ?><?php echo $column_left; ?>
<div id="content"><div class="container-fluid">
	<div class="page-header">
	    <h1>Product Questions</h1>
	    <ul class="breadcrumb">
		     <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		      <?php } ?>
	    </ul>
	  </div>
	  
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
		<div class="set-size" id="product_questions">
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
                            <input type="hidden" name="product_questions_module[<?php echo $module_row; ?>][module_id]" value="<?php echo $module['module_id']; ?>" />
							<table class="form">

							  <tr class="enquiry<?php echo $module_row; ?>">
							       <td style="padding-top: 13px">Button text:</td>
							       <td style="padding-top: 13px"><div class="list-language">
							            <?php foreach ($languages as $language) { ?>
							            <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="product_questions_module[<?php echo $module_row; ?>][button_text][<?php echo $language['language_id']; ?>]" value="<?php echo isset($module['button_text'][$language['language_id']]) ? $module['button_text'][$language['language_id']] : ''; ?>"></div>
							            <?php } ?>
							       </div></td>
							  </tr>
                              <tr class="enquiry<?php echo $module_row; ?>">
							       <td>Button icon:</td>
							       <td>
							               <?php if ($module['icon']) { ?>
							               <a href="" id="thumb-<?php echo $module_row; ?>" class="img-thumbnail img-edit" data-toggle="image"><img src="../image/<?php echo $module['icon']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
							               <?php } else { ?>
							               <a href="" id="thumb-<?php echo $module_row; ?>" class="img-thumbnail img-edit" data-toggle="image"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
							               <?php } ?>
							               <input type="hidden" name="product_questions_module[<?php echo $module_row; ?>][icon]" value="<?php echo $module['icon']; ?>" id="input-<?php echo $module_row; ?>" />
							       </td>
							  </tr>
							  <tr class="enquiry<?php echo $module_row; ?>" >
							       <td>Button Icon position:</td>
							       <td><select name="product_questions_module[<?php echo $module_row; ?>][icon_position]">
							            <option value="left"<?php if($module['icon_position'] == 'left') echo ' selected="selected"'; ?>>Left</option>
							            <option value="right"<?php if($module['icon_position'] == 'right') echo ' selected="selected"'; ?>>Right</option>
							       </select></td>
							  </tr>
							  <tr class="enquiry<?php echo $module_row; ?>">
							       <td style="padding-top: 13px">Block title:</td>
							       <td style="padding-top: 13px"><div class="list-language">
							            <?php foreach ($languages as $language) { ?>
							            <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="product_questions_module[<?php echo $module_row; ?>][block_title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($module['block_title'][$language['language_id']]) ? $module['block_title'][$language['language_id']] : ''; ?>"></div>
							            <?php } ?>
							       </div></td>
							  </tr>
							  
							</table>
							
							<table class="form">
							  <tr>
							       <td>Show on products from:</td>
							       <td><select name="product_questions_module[<?php echo $module_row; ?>][show_on_products_from]" class="get_product_from" title="<?php echo $module_row; ?>">
							            <option value="all" <?php if($module['show_on_products_from'] == 'all') { echo 'selected="selected"'; } ?>>All products</option>
							            <option value="products" <?php if($module['show_on_products_from'] == 'products') { echo 'selected="selected"'; } ?>>Choose products</option>
							            <option value="categories" <?php if($module['show_on_products_from'] == 'categories') { echo 'selected="selected"'; } ?>>Choose categories</option>
							       </select>
							  <tr class="block_<?php echo $module_row; ?>_products panel-products-autocomplete" <?php if($module['show_on_products_from'] != 'products') { echo 'style="display: none"'; } ?>>
							       <td>Products:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></td>
							       <td><div><input type="text" alt="<?php echo $module_row; ?>" name="product_questions_module[<?php echo $module_row; ?>][product]" value="" /></div>
							            <div class="scrollbox">
							            	<?php $products = explode(',', $module['products']); ?>
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
							            	<div id="product-<?php echo $module_row; ?>-<?php echo $product; ?>" class="<?php echo $class; ?>"><?php echo $product_name; ?> <img src="view/image/module_template/delete-slider.png" class="delete-product" alt="<?php echo $module_row; ?>" />
							            	  <input type="hidden" value="<?php echo $product; ?>" />
							            	</div>
							            	<?php } } ?>
							            </div>
							            <input type="hidden" name="product_questions_module[<?php echo $module_row; ?>][products]" value="<?php echo $module['products']; ?>" />
							       </td>
							  </tr>
							  <tr class="block_<?php echo $module_row; ?>_categories panel-categories-autocomplete" <?php if($module['show_on_products_from'] != 'categories') { echo 'style="display: none"'; } ?>>
							       <td>Categories:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></td>
							       <td><div><input type="text" alt="<?php echo $module_row; ?>" name="product_questions_module[<?php echo $module_row; ?>][category]" value="" /></div>
							            <div class="scrollbox">
							            	<?php $categories = explode(',', $module['categories']); ?>
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
							            	<div id="category-<?php echo $module_row; ?>-<?php echo $category; ?>" class="<?php echo $class; ?>"><?php echo $category_name; ?> <img src="view/image/module_template/delete-slider.png" class="delete-category" alt="<?php echo $module_row; ?>" />
							            	  <input type="hidden" value="<?php echo $category; ?>" />
							            	</div>
							            	<?php } } ?>
							            </div>
							            <input type="hidden" name="product_questions_module[<?php echo $module_row; ?>][categories]" value="<?php echo $module['categories']; ?>" />
							       </td>
							  </tr>

							  <tr>
							    <td>Store:</td>
							    <td><select name="product_questions_module[<?php echo $module_row; ?>][layout_id]">
							    	<?php if (99999 == $module['layout_id']) { ?>
							    	<option value="99999" selected="selected">All stories</option>
							    	<?php } else { ?>
							    	<option value="99999">All stories</option>
							    	<?php } ?>
							    	<?php foreach($stores as $store) { ?>
							    	<option value="99999<?php echo $store['store_id']; ?>" <?php if ('99999' . $store['store_id'] == $module['layout_id']) { echo 'selected="selected"'; } ?>>Store <?php echo $store['name']; ?></option>
							    	<?php } ?>
							      </select></td>
							  </tr>
                              
							  <tr class="html<?php echo $module_row; ?>" style="display: none">
							    <td>Position:</td>
							    <td><select name="product_questions_module[<?php echo $module_row; ?>][position]" class="position">
							         <option value="product_question" selected="selected">Product Question</option>
							      </select></td>
							  </tr>
							  
							  <tr>
							    <td>Status:</td>
							    <td><select name="product_questions_module[<?php echo $module_row; ?>][status]">
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
							    <td style="border: none;padding-bottom: 0px">Sort Order:</td>
							    <td style="border: none;padding-bottom: 0px"><input type="text" name="product_questions_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
							  </tr>
							</table>
						</div>
						
						<script type="text/javascript">
						     $('input[name=\'product_questions_module[<?php echo $module_row; ?>][category]\']').autocomplete({
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
						     		$('#category-<?php echo $module_row; ?>-' + item['value']).remove();
						     		
						     		$('.block_<?php echo $module_row; ?>_categories .scrollbox').append('<div id="category-<?php echo $module_row; ?>-' + item['value'] + '">' + item['label'] + '<img src="view/image/module_template/delete-slider.png" alt="<?php echo $module_row; ?>" class="delete-category" /><input type="hidden" value="' + item['value'] + '" /></div>');
						     
						     		$('.block_<?php echo $module_row; ?>_categories .scrollbox div:odd').attr('class', 'odd');
						     		$('.block_<?php echo $module_row; ?>_categories .scrollbox div:even').attr('class', 'even');
						     		
						     		data = $.map($('.block_<?php echo $module_row; ?>_categories .scrollbox input'), function(element){
						     			return $(element).attr('value');
						     		});
						     						
						     		$('input[name=\'product_questions_module[<?php echo $module_row; ?>][categories]\']').attr('value', data.join());
						     					
						     		return false;
						     	}
						     });
						     
						     $('input[name=\'product_questions_module[<?php echo $module_row; ?>][product]\']').autocomplete({
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
						     		$('#product-<?php echo $module_row; ?>-' + item['value']).remove();
						     		
						     		$('.block_<?php echo $module_row; ?>_products .scrollbox').append('<div id="product-<?php echo $module_row; ?>-' + item['value'] + '">' + item['label'] + '<img src="view/image/module_template/delete-slider.png" alt="<?php echo $module_row; ?>" class="delete-product" /><input type="hidden" value="' + item['value'] + '" /></div>');
						     
						     		$('.block_<?php echo $module_row; ?>_products .scrollbox div:odd').attr('class', 'odd');
						     		$('.block_<?php echo $module_row; ?>_products .scrollbox div:even').attr('class', 'even');
						     		
						     		data = $.map($('.block_<?php echo $module_row; ?>_products .scrollbox input'), function(element){
						     			return $(element).attr('value');
						     		});
						     						
						     		$('input[name=\'product_questions_module[<?php echo $module_row; ?>][products]\']').attr('value', data.join());
						     					
						     		return false;
						     	},
						     	focus: function(event, ui) {
						           	return false;
						        	}
						     });
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
        html += '  <input type="hidden" name="product_questions_module[' + module_row + '][module_id]" value="' + module_row + '" />';
		html += '	<table class="form">';
		html += '    <tr class="enquiry' + module_row + '">';
		html += '      <td style="padding-top: 13px">Button text:</td>';
		html += '      <td style="padding-top: 13px"><div class="list-language">';
		<?php foreach ($languages as $language) { ?>
		html += '               <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="product_questions_module['+ module_row +'][button_text][<?php echo $language['language_id']; ?>]" value=""></div>';
	     <?php } ?>
		html += '      </div></td>';
		html += '    </tr>';
		html += '    <tr class="enquiry' + module_row + '">';
		html += '      <td>Button icon:</td>';
		html += '      <td>';
		html += '        <a href="" id="thumb-'+ module_row +'" class="img-thumbnail img-edit" data-toggle="image"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>';
		html += '        <input type="hidden" name="product_questions_module['+ module_row +'][icon]" value="" id="input-'+ module_row +'" />';
		html += '      </td>';
		html += '    </tr>';
		html += '    <tr class="enquiry' + module_row + '" >';
		html += '      <td>Button icon position:</td>';
		html += '      <td><select name="product_questions_module[' + module_row + '][icon_position]">';
		html += '       		<option value="left">Left</option>';
		html += '       		<option value="right">Right</option>';
		html += '      </select></td>';
		html += '    </tr>';    
        html += '    <tr class="enquiry' + module_row + '">';
		html += '      <td style="padding-top: 13px">Block title:</td>';
		html += '      <td style="padding-top: 13px"><div class="list-language">';
		<?php foreach ($languages as $language) { ?>
		html += '               <div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><input type="text" name="product_questions_module['+ module_row +'][block_title][<?php echo $language['language_id']; ?>]" value=""></div>';
	     <?php } ?>
		html += '      </div></td>';
		html += '    </tr>';
		html += '   </table>';

	
		html += '  <table class="form">';
		html += '    <tr>';
		html += '      <td>Show on products from:</td>';
		html += '      <td><select name="product_questions_module[' + module_row + '][show_on_products_from]" class="get_product_from" title="' + module_row + '">';
		html += '       		<option value="all">All products</option>';
		html += '       		<option value="products">Choose products</option>';
		html += '       		<option value="categories">Choose categories</option>';
		html += '      </select>';
		
		html += '	     <tr class="block_' + module_row + '_products panel-products-autocomplete" style="display: none">';
		html += '			<td>Products:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></td>';
		html += '			<td><div><input type="text" alt="' + module_row + '" name="product_questions_module['+ module_row +'][product]" value="" /></div>';
		html += '				<div class="scrollbox products"></div>';
		html += '			     <input type="hidden" name="product_questions_module['+ module_row +'][products] value="" />';
		html += '		     </td>';
		html += '		</tr>';
		
		html += '		<tr class="block_' + module_row + '_categories panel-categories-autocomplete" style="display: none">';
		html += '			<td>Categories:<br><span style="font-size:11px;color:#808080">(Autocomplete)</span></td>';
		html += '			<td><div><input type="text" alt="' + module_row + '" name="product_questions_module['+ module_row +'][category]" value="" /></div>';
		html += '			    <div class="scrollbox categories"></div>';
		html += '			     <input type="hidden" name="product_questions_module['+ module_row +'][categories]" value="" />';
		html += '		     </td>';
		html += '		</tr>';

		html += '    <tr>';
		html += '      <td>Store:</td>';
		html += '      <td><select name="product_questions_module[' + module_row + '][layout_id]">';
		html += '           <option value="99999">All stories</option>';
		<?php foreach($stores as $store) { ?>
		html += '           <option value="99999<?php echo $store['store_id']; ?>">Store <?php echo $store['name']; ?></option>';
		<?php } ?>
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr class="html' + module_row + '" style="display: none">';
		html += '      <td>Position:</td>';
		html += '      <td><select name="product_questions_module[' + module_row + '][position]" class="position">';
        html += '       		 <option value="product_question" selected="selected">Product Question</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td>Status:</td>';
		html += '      <td><select name="product_questions_module[' + module_row + '][status]">';
		html += '        <option value="1">Enabled</option>';
		html += '        <option value="0">Disabled</option>';
		html += '      </select></td>';
		html += '    </tr>';
		html += '    <tr>';
		html += '      <td style="border: none;padding-bottom: 0px">Sort Order:</td>';
		html += '      <td style="border: none;padding-bottom: 0px"><input type="text" name="product_questions_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
		html += '    </tr>';
		html += '  </table>'; 
	html += '</div>';
	
	$('.tabs').append(html);
	
	$('#language-' + module_row + ' a').tabs();

	$('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '">Module ' + module_row + ' &nbsp;<img src="view/image/module_template/delete-slider.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); return false;" /></a>');
	
	$('.main-tabs a').tabs();
	
	$('#module-' + module_row).trigger('click');
	
	var module = module_row;
	
	$('input[name=\'product_questions_module[' + module + '][category]\']').autocomplete({
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
			$('#category-' + module + '-' + item['value']).remove();
			
			$('.block_' + module + '_categories .scrollbox').append('<div id="category-' + module + '-' + item['value'] + '">' + item['label'] + '<img src="view/image/module_template/delete-slider.png" alt="' + module + '" class="delete-category" /><input type="hidden" value="' + item['value'] + '" /></div>');
	
			$('.block_' + module + '_categories .scrollbox div:odd').attr('class', 'odd');
			$('.block_' + module + '_categories .scrollbox div:even').attr('class', 'even');
			
			data = $.map($('.block_' + module + '_categories .scrollbox input'), function(element){
				return $(element).attr('value');
			});
							
			$('input[name=\'product_questions_module[' + module + '][categories]\']').attr('value', data.join());
						
			return false;
		}
	});
	
	$('input[name=\'product_questions_module[' + module + '][product]\']').autocomplete({
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
			$('#product-' + module + '-' + item['value']).remove();
			
			$('.block_' + module + '_products .scrollbox').append('<div id="product-' + module + '-' + item['value'] + '">' + item['label'] + '<img src="view/image/module_template/delete-slider.png" alt="' + module + '" class="delete-product" /><input type="hidden" value="' + item['value'] + '" /></div>');
	
			$('.block_' + module + '_products .scrollbox div:odd').attr('class', 'odd');
			$('.block_' + module + '_products .scrollbox div:even').attr('class', 'even');
			
			data = $.map($('.block_' + module + '_products .scrollbox input'), function(element){
				return $(element).attr('value');
			});
							
			$('input[name=\'product_questions_module[' +module + '][products]\']').attr('value', data.join());
						
			return false;
		},
		focus: function(event, ui) {
	      	return false;
	   	}
	});
	
	module_row++;
}

$('#content').on('click', '.delete-product', function () {
	$(this).parent().remove();
	
	$('.block_' + $(this).attr("alt") + '_products .scrollbox div:odd').attr('class', 'odd');
	$('.block_' + $(this).attr("alt") + '_products .scrollbox div:even').attr('class', 'even');

	data = $.map($('.block_' + $(this).attr("alt") + '_products .scrollbox input'), function(element){
		return $(element).attr('value');
	});
					
	$('input[name=\'product_questions_module[' + $(this).attr("alt") + '][products]\']').attr('value', data.join());
});

$('#content').on('click', '.delete-category', function () {
	$(this).parent().remove();
	
	$('.block_' + $(this).attr("alt") + '_categories .scrollbox div:odd').attr('class', 'odd');
	$('.block_' + $(this).attr("alt") + '_categories .scrollbox div:even').attr('class', 'even');

	data = $.map($('.block_' + $(this).attr("alt") + '_categories .scrollbox input'), function(element){
		return $(element).attr('value');
	});
					
	$('input[name=\'product_questions_module[' + $(this).attr("alt") + '][categories]\']').attr('value', data.join());
});

$(document).ready(function() {
	$('#product_questions').on('change', 'select.get_product_from', function () {
		var modules = $(this).attr("title");
		$('.block_' + modules + '_products').hide();
		$('.block_' + modules + '_categories').hide();
		if($(this).find("option:selected").val() == 'products') {
			$('.block_' + modules + '_products').show();
		}
		if($(this).find("option:selected").val() == 'categories') {
			$('.block_' + modules + '_categories').show();
		}
	});
});
//--></script> 
<?php echo $footer; ?>