<?php

	$revSliderVersion = GlobalsRevSlider::SLIDER_REVISION;

	$wrapperClass = "";
	if(GlobalsRevSlider::$isNewVersion == false)
		 $wrapperClass = " oldwp";

?>



<script type="text/javascript">



    <?php 

    $sds_admin_url = admin_url();

    $sds_admin_upload_url = admin_url('?view=fileupload');

    

    ?>

        var rev_php_ver = '<?php echo phpversion()?>';

        var rev_module_ajaxurl = '<?php echo rev_module_ajaxurl()?>';
        var rev_site_admin_url = '<?php echo rev_site_admin_url(); ?>';


        var sds_rev_oc_user_token = '<?php echo sds_get_oc_user_token(); ?>';
        var sds_main_shop_url = '<?php echo main_shop_url(); ?>';
 		var sds_main_shop_up_url = '<?php echo main_shop_url("image/"); ?>';
	var g_uniteDirPlagin = "<?php echo self::$dir_plugin?>";

	//var g_urlContent = "<?php echo UniteFunctionsWPRev::getUrlContent(); ?>";
	var g_urlContent = "<?php echo rev_slider_url().'/'; ?>";

       

     // var ajaxurl = g_urlContent+'ajax.php?returnurl=<?php echo $sds_admin_url; ?>';
      //var ajaxurl = "<?php echo rev_site_admin_url(); ?>?route=extension/module/revslideropencart/ajaxexecute&user_token=eee5a3fd43e79be92be35b45b9db59e6&returnurl=<?php echo $sds_admin_url; ?>";
      var ajaxurl = "<?php echo rev_site_admin_url(); ?>?route=extension/module/revslideropencart/ajaxexecute&user_token=<?php echo sds_get_oc_user_token(); ?>&returnurl=<?php echo $sds_admin_url; ?>";
  //        ajaxurl += '&returnurl=<?php echo urlencode(htmlspecialchars_decode($sds_admin_url))?>';


        var uploadurl = '<?php echo htmlspecialchars_decode($sds_admin_upload_url)?>';



	var g_urlAjaxShowImage = "<?php echo htmlspecialchars_decode(UniteBaseClassRev::$url_ajax_showimage)?>";



	var g_urlAjaxActions = "<?php echo htmlspecialchars_decode(UniteBaseClassRev::$url_ajax_actions)?>";



	var g_settingsObj = {};

	

</script>



<div id="div_debug"></div>



<div class='unite_error_message' id="error_message" style="display:none;"></div>



<div class='unite_success_message' id="success_message" style="display:none;"></div>



<div id="viewWrapper" class="view_wrapper<?php echo $wrapperClass?>">



<?php

	self::requireView($view);

	

?>



</div>



<div id="divColorPicker" style="display:none;"></div>



<?php self::requireView("system/video_dialog")?>

<?php self::requireView("system/update_dialog")?>

<?php self::requireView("system/general_settings_dialog")?>



<div class="tp-plugin-version">&copy; All rights reserved, <a href="http://themepunch.com" target="_blank">Themepunch</a>  ver. <?php echo $revSliderVersion?>	

</div>



<?php if(GlobalsRevSlider::SHOW_DEBUG == true): ?>



	Debug Functions (for developer use only): 

	<br><br>

	

	<a id="button_update_text" class="button-primary revpurple" href="javascript:void(0)">Update Text</a>

	

<?php endif?>



