

	<table class='wp-list-table widefat fixed unite_table_items'>

		<thead>

			<tr>

				<th width='20px'><?php echo ControllerExtensionModulerevslideropencart::$lang_var['ID']?></th>

				<th width='25%'><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Name']?></th>

				<?php

				if(!$outputTemplates){

				?>

				<!-- <th width='120px'><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Display_Hook']?> </th> -->

				<?php }else{

				?><th width='120px'></th><?php

				} ?>

				<th width='100'><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Source']?></th>

				<th width='70px'><?php echo ControllerExtensionModulerevslideropencart::$lang_var['N_Slides']?></th>						

				<th width='50%'><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Actions']?> </th>

			</tr>

		</thead>
<?php if(!empty($arrSliders)): ?>
		<tbody>

			<?php

			if($outputTemplates)

				$useSliders = $arrSlidersTemplates;

			else

				$useSliders = $arrSliders;

			

			

			foreach($useSliders as $slider):

				try{

					$id = $slider->getID();

					$showTitle = $slider->getShowTitle();

					$title = $slider->getTitle();

					$alias = $slider->getAlias();

					$isFromPosts = $slider->isSlidesFromPosts();

					$strSource = ControllerExtensionModulerevslideropencart::$lang_var

['Gallery'];

					$preicon = "revicon-picture-1";

					

					if($outputTemplates) $strSource = "Template";

					if ($strSource=="Template") $preicon ="templateicon";

					

					$rowClass = "";					

					if($isFromPosts == true){

						$strSource = ControllerExtensionModulerevslideropencart::$lang_var

['Posts'];

						$preicon ="revicon-doc";

						$rowClass = "class='row_alt'";

					}

					

					if($outputTemplates){

						$editLink = self::getViewUrl(RevSliderAdmin::VIEW_SLIDER_TEMPLATE,"id=$id");

					}else{

						$editLink = self::getViewUrl(RevSliderAdmin::VIEW_SLIDER,"id=$id");

					}

					$editSlidesLink = self::getViewUrl(RevSliderAdmin::VIEW_SLIDES,"id=$id");

					

					$showTitle = UniteFunctionsRev::getHtmlLink($editLink, $showTitle);

					

					// $shortCode = $slider->getShortcode();

					$numSlides = $slider->getNumSlides();

					

					

				}catch(Exception $e){					

					$errorMessage = "ERROR: ".$e->getMessage();

					$strSource = "";

					$numSlides = "";

				}

				

			?>

				<tr <?php echo $rowClass?>>

					<td><?php echo $id?><span id="slider_title_<?php echo $id?>" class="hidden"><?php echo $title?></span></td>								

					<td>

						<?php echo $showTitle?>

						<?php if(!empty($errorMessage)):?>

							<div class='error_message'><?php echo $errorMessage?></div>

						<?php endif?>

					</td>

					<?php

					if(!$outputTemplates){

					?>

					<!-- <td><?php echo $slider->getParam('displayhook')?></td> -->

					<?php }else{ ?><td></td><?php } ?>

					<td><?php echo "<i class=".$preicon."></i>".$strSource?></td>

					<td><?php echo $numSlides?></td>

					<td>

						<a class="button-primary revgreen" href='<?php echo $editLink ?>' title=""><i class="revicon-cog"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['settings']?></a>

						<a class="button-primary revblue" href='<?php echo $editSlidesLink ?>' title=""><i class="revicon-pencil-1"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Edit_Slides']?></a>

						<a class="button-primary revcarrot export_slider_overview" id="export_slider_<?php echo $id?>" href="javascript:void(0);" title=""><i class="revicon-export"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Export_Slider']?></a>
<!-- start html export -->
<?php
$generalSettings = self::getSettings("general");
$show_dev_export = $generalSettings->getSettingValue("show_dev_export",'off');
// print '<pre>';
// print_r($generalSettings);
// print '</pre>';
if($show_dev_export == 'on'){
?>
<a class="button-primary revpurple export_slider_standalone" id="export_slider_standalone_<?php echo $id?>" href="javascript:void(0);" title=""><i class="revicon-export"></i><?php echo ControllerExtensionModulerevslideropencart::$lang_var['HTML']?></a>
<?php
}
?>
<!-- end html export -->
						<a class="button-primary revred button_delete_slider" id="button_delete_<?php echo $id?>" href='javascript:void(0)' title="<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Delete']?>"><i class="revicon-trash"></i></a>

						<a class="button-primary revyellow button_duplicate_slider" id="button_duplicate_<?php echo $id?>" href='javascript:void(0)' title="<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Duplicate']?>"><i class="revicon-picture"></i></a>

						<div id="button_preview_<?php echo $id?>" class="button_slider_preview button-primary revgray" title="<?php echo ControllerExtensionModulerevslideropencart::$lang_var['Preview']?>"><i class="revicon-search-1"></i></div>

					</td>

	

				</tr>							

			<?php endforeach;?>

			

		</tbody>		 
<?php endif; ?>
	</table>



	<?php require_once self::getPathTemplate("dialog_preview_slider");?>





	