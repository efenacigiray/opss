<?php echo $header; ?><?php echo $column_left; ?>
<div id="content"><div class="container-fluid">
	<div class="page-header">
	    <h1>FAQ</h1>
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
	<div class="alert alert-info"><i class="fa fa-exclamation-circle"></i>
        The FAQ page is available at this <a target="_blank" href="<?php echo $front_url; ?>">link</a>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
	<?php $element = 1; ?>
	<?php $section = 1; ?>
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<div class="set-size" id="faq">
			<div class="content">
				<div>
					<div class="tabs clearfix">
						<!-- Tabs module -->
						<div id="tab-module" class="tab-content">
							<div id="tabs_faq" class="htabs tabs-product">
								<a href="#tab_faq_item" class="ttab"><span>Module items</span></a>
								<a href="#tab_faq_section" class="ttab"><span>Module sections</span></a>
								<a href="#tab_faq_setting" class="tsetting"><span>Module setting</span></a>
							</div>
							
							<div id="tab_faq_item" style="padding:20px">
								<table class="tabs-list">
									<thead>
										<tr>
											<td class="first">Question</td>
											<td>Answer</td>
											<td>Section</td>
											<td class="text-center">Sort</td>
											<td class="text-center">Remove</td>
										</tr>
									</thead>
									<?php if(isset($module['items'])):?>
                                    <?php foreach($module['items'] as $tab): ?>
									<tbody id="module-items-<?php echo $element; ?>">
										<tr>
											<td class="first">
												<?php foreach ($languages as $language) { $lang_id = $language['language_id']; ?>
												<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
                                                    <input type="text" name="faq_module[items][<?php echo $element; ?>][question][<?php echo $language['language_id']; ?>]" value="<?php if(isset($tab['question'][$lang_id])) { echo $tab['question'][$lang_id]; } ?>">
                                                </div>
												<?php } ?>
											</td>
											<td>
												<?php foreach ($languages as $language) { $lang_id = $language['language_id']; ?>
												<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" class="lang-img"/>
                                                    <textarea name="faq_module[items][<?php echo $element; ?>][answer][<?php echo $language['language_id']; ?>]" class="html"><?php if(isset($tab['answer'][$lang_id])) { echo $tab['answer'][$lang_id]; } ?></textarea>
                                                </div>
												<?php } ?>
											</td>
                                            <td>
                                                <select name="faq_module[items][<?php echo $element; ?>][section_id]">
                                                    <option value="">Not selected</option>
                                                <?php if(isset($module['sections'])): ?>
                                                <?php foreach($module['sections'] as $sec): ?>
                                                    <?php if(!isset($sec['title'][$current_lang_id])) continue; ?>
                                                    <option value="<?php echo $sec['id']?>" <?php echo ( isset($tab['section_id']) && $sec['id'] == $tab['section_id'] ? 'selected' : '') ?> >
                                                        <?php echo $sec['title'][$current_lang_id]?>
                                                    </option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <input type="text" name="faq_module[items][<?php echo $element; ?>][order]" value="<?php if(isset($tab['order'])) { echo $tab['order']; } ?>" class="sort">
                                            </td>
											<td class="text-center"><a onclick="$('#module-items-<?php echo $element; ?>').remove();">Remove</a></td>
										</tr>
									</tbody>
                                    <?php $element++; ?>
									<?php endforeach; ?>
                                    <?php endif; ?>
									<tfoot></tfoot>
								</table>
								<a onclick="addItems();" class="add-module">Add item</a>
							</div>
							
							<div id="tab_faq_section" style="padding:20px">
								<table class="tabs-list">
									<thead>
										<tr>
											<td class="first">Title</td>
											<td class="text-center">No display title</td>
											<td class="text-center">Sort</td>
											<td class="text-center">Remove</td>
										</tr>
									</thead>
									<?php if(isset($module['sections'])): ?>
                                    <?php foreach($module['sections'] as $tab): ?>
									<tbody id="module-sections-<?php echo $section; ?>">
										<tr>
											<td class="first">
                                                <input type="hidden" name="faq_module[sections][<?php echo $section; ?>][id]" value="<?php if(isset($tab['id'])) { echo $tab['id']; } ?>" >
												<?php foreach ($languages as $language) { $lang_id = $language['language_id']; ?>
												<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>"/>
                                                    <input type="text" name="faq_module[sections][<?php echo $section; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php if(isset($tab['title'][$lang_id])) { echo $tab['title'][$lang_id]; } ?>" >
                                                </div>
												<?php } ?>
											</td>
                                            <td class="text-center" style="width: 150px">
                                                <input type="checkbox" name="faq_module[sections][<?php echo $section; ?>][hidden]" value="1" <?php if(isset($tab['hidden'])) { echo "checked"; } ?>>
                                            </td>
                                            <td class="text-center">
                                                <input type="text" name="faq_module[sections][<?php echo $section; ?>][order]" value="<?php if(isset($tab['order'])) { echo $tab['order']; } ?>" class="sort">
                                            </td>
											<td class="text-center"><a onclick="$('#module-sections-<?php echo $section; ?>').remove();">Remove</a></td>
										</tr>
									</tbody>
									<?php $section++; ?>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
									<tfoot></tfoot>
								</table>
								<a onclick="addSections();" class="add-module">Add section</a>
							</div>
							
							<div id="tab_faq_setting" style="padding:20px">
                                <table class="form">
									<tr>
										<td>Collapse:</td>
										<td>
											<select name="faq_module[settings][collapse]">
												<?php if ($module['settings']['collapse']) { ?>
												<option value="1" selected="selected">Enabled</option>
												<option value="0">Disabled</option>
												<?php } else { ?>
												<option value="1">Enabled</option>
												<option value="0" selected="selected">Disabled</option>
												<?php } ?>
											</select>
										</td>
									</tr>
								</table>
							</div>
						</div>
						<script type="text/javascript">
						$('#tabs_faq a').tabs();
						</script>
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
$('#language a').tabs();
//--></script> 



<script type="text/javascript">
var element = <?php echo $element; ?>;
var section = <?php echo $section; ?>;
function addItems() {
	html  = '<tbody id="module-items-' + element + '">';
	html += '  <tr>';
	html += '    <td class="first">';
	<?php foreach ($languages as $language) { ?>
	html += '		<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><input type="text" name="faq_module[items][' + element + '][question][<?php echo $language['language_id']; ?>]" ></div>';
	<?php } ?>
	html += '    </td>';
	html += '	 <td>';
	<?php foreach ($languages as $language) { ?>
	html += '		<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" class="lang-img" /><textarea name="faq_module[items][' + element + '][answer][<?php echo $language['language_id']; ?>]" class="html"></textarea></div>';
	<?php } ?>
	html += '    </td>';
    html += '    <td>';
    html += '       <select name="faq_module[items][<?php echo $element; ?>][section_id]">';
    html += '           <option value="">Not selected</option>';
                <?php if(isset($module['sections'])): ?>
                <?php foreach($module['sections'] as $sec): ?>
                    <?php if(!isset($sec['title'][$current_lang_id])) continue; ?>
    html += '                <option value="<?php echo $sec['id']?>" >';
    html += '                    <?php echo $sec['title'][$current_lang_id]?>';
    html += '                </option>';
                <?php endforeach; ?>
                <?php endif; ?>
    html += '        </select>';
    html += '    </td>';
	html += '    <td class="text-center">';
	html += '		<input type="text" name="faq_module[items][' + element + '][order]" class="sort" >';
    html += '    </td>';
	html += '    <td class="text-center"><a onclick="$(\'#module-items-' + element + '\').remove();">Remove</a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#tab_faq_item .tabs-list tfoot').before(html);
    
    $('#module-items-' + element + ' textarea').summernote({
        toolbar: [
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['insert', ['link']],
      ],
    });
    
	element++;
    
}
function addSections() {
	html  = '<tbody id="module-sections-' + section + '">';
	html += '  <tr>';
	html += '    <td class="first">';
    html += '		<input type="hidden" name="faq_module[sections][' + section + '][id]" >';
	<?php foreach ($languages as $language) { ?>
	html += '		<div class="language"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><input type="text" name="faq_module[sections][' + section + '][title][<?php echo $language['language_id']; ?>]" ></div>';
	<?php } ?>
	html += '    </td>';
	html += '    <td class="text-center" style="width: 150px">';
	html += '		<input type="checkbox" value="1" name="faq_module[sections][' + section + '][hidden]" >';
    html += '    </td>';
	html += '    <td class="text-center">';
	html += '		<input type="text" name="faq_module[sections][' + section + '][order]" class="sort" >';
    html += '    </td>';
	html += '    <td class="text-center"><a onclick="$(\'#module-sections-' + section + '\').remove();">Remove</a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#tab_faq_section .tabs-list tfoot').before(html);

	section++;
    
}



$(document).ready(function() {
    $('textarea.html').summernote({
        toolbar: [
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['insert', ['link']],
      ],
    });
});
</script>
<?php echo $footer; ?>