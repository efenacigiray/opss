<!-- start tab view -->


<!-- end tab view -->
<?php
	$exampleID = '"slider1"';
	if(!empty($arrSliders))
		$exampleID = '"'.$arrSliders[0]->getAlias().'"';
	$outputTemplates = false;
?>
<div class='content wrap'>

		<div class="bootstrap">
		<?php UniteBaseAdminClassRev::sds_init_error_warning();?>
		</div>
		<div class="clear_both"></div> 
		<div class="title_line m_bottom_10">
		<div id="icon-options-general" class="icon32"></div>
		<div class="view_title">
		<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Revolution_Sliders']?>
		</div>
		<a href="<?php echo GlobalsRevSlider::LINK_HELP_SLIDERS?>" class="button-secondary float_right mtop_10 mleft_10" target="_blank"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['help']?></a>	
		
		</div>

<div id="tab-general">
	<?php if(empty($arrSliders)): ?>
	<?php echo ControllerExtensionModulerevslideropencart::$lang_var['No_Sliders_Found']?>
	<br>
	<?php endif;
	require self::getPathTemplate("sliders_list");	
	// endif
	?>
	<p>
	<a class='button-primary revblue' href='<?php echo $addNewLink?>'><?php echo ControllerExtensionModulerevslideropencart::$lang_var['New_Slider']?> </a>
	<a id="button_import_slider" class='button-primary float_right revgreen' href='javascript:void(0)'><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Import_Slider']?> </a>
	</p>
</div>
<div id="tab-template" class="clearfix m_bottom_30">
	<?php
		$no_sliders = false;
		if(empty($arrSlidersTemplates)){
			echo ControllerExtensionModulerevslideropencart::$lang_var['No_Template_Found'];
			$no_sliders = true;
			?><br><?php
		}
		$outputTemplates = true;
		require self::getPathTemplate("sliders_list");	 		
		?>
		<div class="f_left m_top_15">
			<a class='button-primary revblue' href='<?php echo $addNewTemplateLink?>'><?php echo ControllerExtensionModulerevslideropencart::$lang_var['New_Template_Slider']?> </a>	
		</div>	
</div>
<!-- <div id="tab-data"> -->
<?php
// if(!empty($arrSliders)):
// 	require self::getPathTemplate("oc_layout");
// endif; 	
?>
<!-- </div> -->
<div id="tab-design" class="clearfix m_bottom_30">
<?php
if(!empty($arrSliders)):
	require self::getPathTemplate("themepunch-google-fonts");	
endif; 	
?>
</div>
	</div>

	<!-- Import slider dialog -->
	<div id="dialog_import_slider" title="<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Import_Slider']?>" class="dialog_import_slider" style="display:none">
		<form action="<?php echo UniteBaseClassRev::$url_ajax_actions?>" enctype="multipart/form-data" method="post">
		    <br>
		    <input type="hidden" name="action" value="revslider_ajax_action">
		    <input type="hidden" name="client_action" value="import_slider_slidersview">
		    <?php echo ControllerExtensionModulerevslideropencart::$lang_var['Choose_import_file']?>:   
		    <br>
			<input type="file" size="60" name="import_file" class="input_import_slider">
			<br><br>
			<span style="font-weight: 700;"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['CUSTOM_STYLES']?></span><br><br>
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
			<br><br>
			<input type="submit" class='button-primary' value="<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Import_Slider']?>">
		</form>		
	</div>

<script type="text/javascript">
	jQuery(document).ready(function(){
		RevSliderAdmin.initSlidersListView();
	});
</script>
