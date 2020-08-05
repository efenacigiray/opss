<?php
	$api =  "revapi".$sliderID;
?>
	
	<div id="api_wrapper" class="api_wrapper postbox unite-postbox ">
			<h3 class="box_closed tp-accordion tpa-closed"><div class="postbox-arrow"></div><i style="float:left;margin-top:4px;font-size:14px;" class="eg-icon-tools"></i><span><?php echo ControllerExtensionModulerevslideropencart::$lang_var['API_Functions'] ?></span></h3>
			<div class="toggled-content tp-closedatstart p20">
					<div class="api-caption"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['API_Methods']?>:</div>
					<div class="divide20"></div>
					<div class="api-desc"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['copy_paste_js']?>. </div>
					
					<table class="api-table">
						<tr>
							<td class="api-cell1"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Pause_Slider']?>:</td>
							<td class="api-cell2"><input type="text" readonly  class="api-input" value="<?php echo $api?>.revpause();"></td>
						</tr>
						<tr>
							<td class="api-cell1"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Resume_Slider']?>:</td>
							<td class="api-cell2"><input type="text" readonly class="api-input" value="<?php echo $api?>.revresume();"></td>
						</tr>
						<tr>
							<td class="api-cell1"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Previous_Slide']?>:</td>
							<td class="api-cell2"><input type="text" readonly class="api-input" value="<?php echo $api?>.revprev();"></td>
						</tr>
						<tr>
							<td class="api-cell1"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Next_Slide']?>:</td>
							<td class="api-cell2"><input type="text" readonly class="api-input" value="<?php echo $api?>.revnext();"></td>
						</tr>
						<tr>
							<td class="api-cell1"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Go_To_Slide']?>:</td>
							<td class="api-cell2"><input type="text" readonly class="api-input" value="<?php echo $api?>.revshowslide(2);"></td>
						</tr>
						<tr>
							<td class="api-cell1"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Num_Slides']?>:</td>
							<td class="api-cell2"><input type="text" readonly class="api-input" value="<?php echo $api?>.revmaxslide();"></td>
						</tr>
						<tr>
							<td class="api-cell1"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Slide_Number']?>:</td>
							<td class="api-cell2"><input type="text" readonly class="api-input" value="<?php echo $api?>.revcurrentslide();"></td>
						</tr>
						<tr>
							<td class="api-cell1"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Playing_Slide']?>:</td>
							<td class="api-cell2"><input type="text" readonly class="api-input" value="<?php echo $api?>.revlastslide();"></td>
						</tr>
						<tr>
							<td class="api-cell1"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['External_Scroll']?>:</td>
							<td class="api-cell2"><input type="text" readonly class="api-input" value="<?php echo $api?>.revscroll(offset);"></td>
						</tr>
						<tr>
							<td class="api-cell1"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['Redraw_Slider']?>:</td>
							<td class="api-cell2"><input type="text" readonly  class="api-input" value="<?php echo $api?>.revredraw();"></td>
						</tr>
						
					</table>
					<div class="divide20"></div>
					<hr>
					<div class="divide20"></div>					
					<div class="api-caption"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['API_Events']?>:</div>
					<div class="divide20"></div>
					<div class="api-desc"><?php echo ControllerExtensionModulerevslideropencart::$lang_var['jQuery_Functions']?>.</div>
					<textarea id="api_area" readonly>
					
<?php echo $api?>.bind("revolution.slide.onloaded",function (e) {
	//alert("slider loaded");
});
		
<?php echo $api?>.bind("revolution.slide.onchange",function (e,data) {
	//alert("slide changed to: "+data.slideIndex);
	//data.slideIndex <?php echo ControllerExtensionModulerevslideropencart::$lang_var['li_container']; ?>
	
	//data.slide <?php echo ControllerExtensionModulerevslideropencart::$lang_var['jQuery_object']; ?>
	
});

<?php echo $api?>.bind("revolution.slide.onpause",function (e,data) {
	//alert("timer paused");
});

<?php echo $api?>.bind("revolution.slide.onresume",function (e,data) {
	//alert("timer resume");
});

<?php echo $api?>.bind("revolution.slide.onvideoplay",function (e,data) {
	//alert("video play");
});

<?php echo $api?>.bind("revolution.slide.onvideostop",function (e,data) {
	//alert("video stopped");
});

<?php echo $api?>.bind("revolution.slide.onstop",function (e,data) {
	//alert("slider stopped");
});

<?php echo $api?>.bind("revolution.slide.onbeforeswap",function (e) {
	//alert("before swap");
});

<?php echo $api?>.bind("revolution.slide.onafterswap",function (e) {
	//alert("after swap");
});

<?php echo $api?>.bind("revolution.slide.slideatend",function (e) {
	//alert("slide at end");
});
			
			
			</textarea>
		</div>
	</div>
	
	<script type="text/javascript">
		jQuery(document).ready(function(){
			
			RevSliderAdmin.initEditSlideView();
		});
	</script>
