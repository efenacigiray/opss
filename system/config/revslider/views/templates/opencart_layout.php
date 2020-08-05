<?php
$layouts = sdsconfig::getLayouts();

?>
<script type="text/javascript">
	$(document).ready(function(){
		var sds_rev_slider_id = $("#sliderid").val();
		$("#sds_rev_slider_id").val(sds_rev_slider_id);
	});
</script> 
<div id="toolbox_wrapper" class="toolbox_wrapper postbox unite-postbox rs-cm-refresh">
	<h3 class="box_closed tp-accordion tpa-closed"><div class="postbox-arrow"></div><i style="float:left;margin-top:4px;font-size:14px;" class="eg-icon-magic"></i><span><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Layout'] ?></span></h3>
	<div class="toggled-content tp-closedatstart p20">
		<!--start layout -->
	 <form action="<?php //echo $action; ?>" method="post" enctype="multipart/form-data" id="sds_rev_mod_form">
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Layout']?></td>
              <td class="left"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Position']?></td>
              <td class="left"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Status']?></td>
              <td class="right"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Short_Order']?></td>
              <td></td>
            </tr>
          </thead>
         <?php $module_row = 0; ?>
         
          <tbody id="module-row<?php echo $module_row; ?>">
            <tr>
				<td class="left">
				<select name="revslideropencart_module[<?php echo $module_row; ?>][layout_id]">
				<?php foreach ($layouts as $layout) { ?>
				<option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>
				<?php } ?>
				</select>
				</td>
				<td class="left"><select name="revslideropencart_module[<?php echo $module_row; ?>][position]">
				<option value="content_top"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Content_Top']?></option>
				<option value="content_bottom"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Content_Bottom']?></option>
				<option value="column_left"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Content_Left']?></option>
				<option value="column_right"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Content_Right']?></option>
				</select>
				</td>
              <td class="left"><select name="revslideropencart_module[<?php echo $module_row; ?>][status]">
                  <option value="0"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Disabled']?></option>
                  <option value="1"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Enabled']?></option>
                </select>
                </td>
              <td class="right"><input type="text" name="revslideropencart_module[<?php echo $module_row; ?>][sort_order]" value="" size="3" />
              <input type="hidden" id="sds_rev_slider_id" name="revslideropencart_module[<?php echo $module_row; ?>][slider_id]" value="" size="3" />
              </td>
              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Remove']?></a></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3"></td>
              <td class="right"><a id="sds_rev_save_mod" href="javascript:void(0)" class="button"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Save_Position']?></a><span style="display:none;" class="loader_round" id="sds_rev_save_mod_loader">updating... </span><span id="sds_rev_save_mod_success" class="success_message"></span></td>
              <td class="left"><a onclick="addModule();" class="button"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Add_New']?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
		<!-- end layout -->
	</div>
</div>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row+1; ?>;
var sdsrevsliderid = $("#sliderid").val();
function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="revslideropencart_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="revslideropencart_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Content_Top']?></option>';
	html += '      <option value="content_bottom"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Content_Bottom']?></option>';
	html += '      <option value="column_left"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Content_Left']?></option>';
	html += '      <option value="column_right"><?php _echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Content_Right']?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="revslideropencart_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Enabled']?></option>';
    html += '      <option value="0"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Disabled']?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="hidden" name="revslideropencart_module[' + module_row + '][slider_id]" value="'+sdsrevsliderid+'" size="3" /><input type="text" name="revslideropencart_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Remove']?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script> 