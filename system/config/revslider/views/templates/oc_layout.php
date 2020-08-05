<?php
$layouts = sdsconfig::getLayouts();
$allslides = sdsconfig::getrevslide();
$store_id = (int)sdsconfig::get_current_store();
$pos_modules = sdsconfig::getval('revslideropencart_module',$store_id,'revslideropencart');
$modules_data = unserialize($pos_modules);

$getpositions = array();
require_once(dirname(__FILE__) . '/../../position/position.php');

?>

<div class="title_line">
	<div class="view_title">
		<?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Setup_Slider_Position']?>
	</div>
</div>

		<div class="postbox">
	 <form action="<?php //echo $action; ?>" method="post" enctype="multipart/form-data" id="sds_rev_mod_form">
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['SLIDER']?></td>
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
        <?php 
        if(isset($modules_data) && !empty($modules_data))
        foreach ($modules_data as $module_data) { ?>
          <tbody id="module-row<?php echo $module_row; ?>">
            <tr>
            	<td class="left">
					<select name="revslideropencart_module[<?php echo $module_row; ?>][slider_id]">
						<?php foreach ($allslides as $allslide) { ?>
						<?php if($allslide['id'] == $module_data['slider_id']){ ?>
							<option value="<?php echo $allslide['id']; ?>" selected="selected"><?php echo addslashes($allslide['title']); ?></option>
							<?php }else{ ?>
							<option value="<?php echo $allslide['id']; ?>"><?php echo addslashes($allslide['title']); ?></option>
						<?php  } } ?>
					</select>
				</td>
				<td class="left">
					<select name="revslideropencart_module[<?php echo $module_row; ?>][layout_id]">
							<?php foreach ($layouts as $layout) { ?>
							<?php if($layout['layout_id'] == $module_data['layout_id']){ ?>
								<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo addslashes($layout['name']); ?></option>
								<?php }else{ ?>
								<option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>
							<?php  } } ?>
					</select>
				</td>
				<td class="left"><select name="revslideropencart_module[<?php echo $module_row; ?>][position]">
					<?php
					if(isset($getpositions) && !empty($getpositions)){
						foreach ($getpositions as $getpos => $getposition) {
							if($module_data['position'] == $getpos){ ?>
								<option value="<?php echo $getpos; ?>" selected="selected"><?php echo $getposition; ?></option>
							<?php }else{  ?>
								<option value="<?php echo $getpos; ?>"><?php echo $getposition; ?></option>
						<?php	}
						}
					}
					?>
				</select>
				</td>
              <td class="left"><select name="revslideropencart_module[<?php echo $module_row; ?>][status]">
                
                <?php if($module_data['status'] == 0){ ?>
				<option value="0" selected="selected"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Disabled']?></option>
				<?php	}else{ ?>
				<option value="0"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Disabled']?></option>
				<?php } ?>

				<?php if($module_data['status'] == 1){ ?>
				<option value="1" selected="selected"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Enabled']?></option>
				<?php	}else{ ?>
				<option value="1"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Enabled']?></option>
				<?php } ?>

                </select>
                </td>
              <td class="right"><input type="text" name="revslideropencart_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module_data['sort_order'] ?>" size="3" />
              </td>
              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Remove']?></a></td>
            </tr>
          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="4"></td>
              <td class="right"><a id="sds_rev_save_mod" href="javascript:void(0)" class="button"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Save_Position']?></a><span style="display:none;" class="loader_round" id="sds_rev_save_mod_loader">updating... </span><span id="sds_rev_save_mod_success" class="success_message"></span></td>
              <td class="left"><a onclick="addModule();" class="button"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Add_New']?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
      </div>

<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;
function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';

	html += '    <td class="left"><select name="revslideropencart_module[' + module_row + '][slider_id]">';
	<?php foreach ($allslides as $allslide) { ?>
	html += '      <option value="<?php echo $allslide['id']; ?>"><?php echo addslashes($allslide['title']); ?></option>';
	<?php } ?>
	html += '    </select></td>';

	html += '    <td class="left"><select name="revslideropencart_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="revslideropencart_module[' + module_row + '][position]">';
<?php
if(isset($getpositions) && !empty($getpositions)){
foreach ($getpositions as $getpos => $getposition){
?>
html += '<option value="<?php echo $getpos; ?>"><?php echo $getposition; ?></option>';
<?php
}
}
?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="revslideropencart_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['sds_Enabled']?></option>';
    html += '      <option value="0"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Disabled']?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="revslideropencart_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo ControllerExtensionModulerevslideropencart::

$lang_var['Remove']?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script> 



