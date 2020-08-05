<?php
	class RevSliderAdmin extends UniteBaseAdminClassRev{

		const DEFAULT_VIEW = "sliders";

		const VIEW_SLIDER = "slider";

		const VIEW_SLIDER_TEMPLATE = "slider_template";

		const VIEW_SLIDERS = "sliders";

		const VIEW_SLIDES = "slides";

		const VIEW_SLIDE = "slide";

		public function __construct($mainFilepath,$view = true){

			self::addMenuPage('Revolution Slider', "adminPages");
                        
                        if($view)
                            parent::__construct($mainFilepath,$this,self::DEFAULT_VIEW);
                        else{
                            parent::__construct($mainFilepath,$this,'');
                        }

            GlobalsRevSlider::$table_sliders = self::$table_prefix.GlobalsRevSlider::TABLE_SLIDERS_NAME;

			GlobalsRevSlider::$table_slides = self::$table_prefix.GlobalsRevSlider::TABLE_SLIDES_NAME;

			GlobalsRevSlider::$table_static_slides = self::$table_prefix.GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME;

			GlobalsRevSlider::$table_settings = self::$table_prefix.GlobalsRevSlider::TABLE_SETTINGS_NAME;

			GlobalsRevSlider::$table_css = self::$table_prefix.GlobalsRevSlider::TABLE_CSS_NAME;

			GlobalsRevSlider::$table_layer_anims = self::$table_prefix.GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME;

			GlobalsRevSlider::$filepath_backup = self::$path_plugin."backup/";

			GlobalsRevSlider::$filepath_captions = self::$path_plugin."rs-plugin/css/captions.css";
			$captionscssurl = rev_site_admin_url()."?route=extension/module/revslideropencart/getcaptionscss&user_token=".sds_get_oc_user_token();
		
			GlobalsRevSlider::$urlCaptionsCSS = $captionscssurl;

			GlobalsRevSlider::$urlStaticCaptionsCSS = self::$url_plugin."rs-plugin/css/static-captions.css";

			GlobalsRevSlider::$filepath_dynamic_captions = self::$path_plugin."rs-plugin/css/dynamic-captions.css";

			GlobalsRevSlider::$filepath_static_captions = self::$path_plugin."rs-plugin/css/static-captions.css";

			GlobalsRevSlider::$filepath_captions_original = self::$path_plugin."rs-plugin/css/captions-original.css";

			GlobalsRevSlider::$urlExportZip = self::$path_plugin."export.zip";

			GlobalsRevSlider::$urlExportZipurl = self::$url_plugin."export.zip";

			$this->init();

		}


		private function init(){

			self::requireSettings("general_settings");

			$generalSettings = self::getSettings("general");

			$role = $generalSettings->getSettingValue("role",UniteBaseAdminClassRev::ROLE_ADMIN);


			self::setMenuRole($role);

            $action = self::getPostGetVar("client_action");

			$data = self::getPostGetVar("data");

            $ajax_action = self::getPostGetVar("action");

            if(!empty($action) or !empty($data)){                                                        
                self::onAjaxAction();                            

            }

            elseif(!empty($ajax_action)){

                if(isset(self::$actions['wp_ajax_'.$ajax_action]) && 

                        !empty(self::$actions['wp_ajax_'.$ajax_action]))

                    foreach(self::$actions['wp_ajax_'.$ajax_action] as $callback){
                    	
                         call_user_func(array(__CLASS__,$callback));                                     
                    }

                        }else{

                            if(!empty(self::$view)){

                                if(self::$view === 'fileupload'){

                                    self::enqueue_file_uploader_scripts();                                
                                }else{

                                    if(isset(self::$actions['admin_enqueue_scripts']) && !empty(self::$actions['admin_enqueue_scripts']))

                                        foreach(self::$actions['admin_enqueue_scripts'] as $callback)

                                            call_user_func(array(__CLASS__,$callback));


                                }


                                if(isset(self::$actions['admin_menu']) && !empty(self::$actions['admin_menu']))

                                    foreach(self::$actions['admin_menu'] as $admin_menu_actions)

                                        call_user_func(array(__CLASS__,$admin_menu_actions));

                            

                            }

                        }

		}

		private function addSliderMetaBox($postTypes = null){ //null = all, post = only posts

			try{

				$settings = RevOperations::getWildcardsSettings();

				self::addMetaBox("Revolution Slider Options",$settings,array("RevSliderAdmin","customPostFieldsOutput"),$postTypes);

			}catch(Exception $e){

			}

		}

		public static function customPostFieldsOutput(UniteSettingsProductSidebarRev $output){

			//$settings = $output->getArrSettingNames();

			?>

				<ul class="revslider_settings">

				<?php

					$output->drawSettingsByNames("slide_template");

				?>

				</ul>

			<?php 

		}


		public static function onActivate(){
                        
                        return self::createDBTables();			

		}


		public static function createDBTables(){

			$res = self::createTable(GlobalsRevSlider::TABLE_SLIDERS_NAME);

			$res &= self::createTable(GlobalsRevSlider::TABLE_SLIDES_NAME);
                        
			$res &= self::createTable(GlobalsRevSlider::TABLE_SETTINGS_NAME);
			
			$res &= self::createTable(GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME);
                        
			$res &= self::createTable(GlobalsRevSlider::TABLE_CSS_NAME);

			$res &= self::createTable(GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME);

			$res &= self::createTable(GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES);

			

                        return $res;

		}

		public static function deleteDBTables(){

                    $res = self::deleteDBTable(GlobalsRevSlider::TABLE_SLIDERS_NAME);

                    $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_SLIDES_NAME);

                    $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME);
                    
                    $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_SETTINGS_NAME);

                    $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_CSS_NAME);

                    $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME);

                    $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES);

                    return $res;

                }


		public static function checkCopyCaptionsCSS(){

                    

			if(file_exists(GlobalsRevSlider::$filepath_captions) == false)

				copy(GlobalsRevSlider::$filepath_captions_original,GlobalsRevSlider::$filepath_captions);

				

			if(!file_exists(GlobalsRevSlider::$filepath_captions) == true){

				self::setStartupError("Can't copy <b>captions-original.css </b> to <b>captions.css</b> in <b> plugins/revslider/rs-plugin/css </b> folder. Please try to copy the file by hand or turn to support.");

			}

			

		}

		/*

                 * File uploader css and js

                 */

                public static function enqueue_file_uploader_scripts(){

                    

                    self::addStyle("jquery-ui-1.10.3.custom","jquery-ui-css","css/jui/new");

                    

                    wp_enqueue_style('jquery-uploadify-css' , self::$url_plugin ."/rs-plugin/fileuploader/uploadify.css");                    

                    wp_enqueue_style('bootstrap-css' , self::$url_plugin ."/css/bootstrap.min.css");                    

                                      

                    wp_enqueue_script('bootstrap-min-js',self::$url_plugin .'js/bootstrap.min.js',array('jquery'));                    

                    wp_enqueue_script('jquery-uploadify',self::$url_plugin .'rs-plugin/fileuploader/jquery.uploadify.min.js');

                    //wp_enqueue_script('jquery-ui-custom-js',self::$url_plugin .'js/jquery-ui/jquery-ui-1.10.3.custom.js');

                    wp_enqueue_script('admin-js',self::$url_plugin .'js/admin.js');

                }

		



		public static function onAddScripts(){

			self::addStyle("edit_layers","edit_layers");

			self::addScriptCommon("edit_layers","unite_layers");

			self::addScriptCommon("css_editor","unite_css_editor");

			self::addScript("rev_admin");

			self::addMediaUploadIncludes();

			self::addStyle("settings","rs-plugin-settings","rs-plugin/css");

			self::addDynamicStyle("captions","rs-plugin-captions","rs-plugin/css");

			self::addStyle("static-captions","rs-plugin-static","rs-plugin/css");

		}

		public static function adminPages(){


			parent::adminPages();

            rev_head();


			switch(self::$view){

				case self::VIEW_SLIDERS:

				case self::VIEW_SLIDER:

				case self::VIEW_SLIDER_TEMPLATE:

                                        

                                    self::requireSettings("slider_settings");

                                    

				break;

				case self::VIEW_SLIDES:					

				break;

				case self::VIEW_SLIDE:

				break;

			}

                        

                        

			self::setMasterView("master_view");

			self::requireView(self::$view);

                        rev_footer();

		}       



		/*

                 * Remove Tables

                 * 

                 * 

                 */

                public static function deleteDBTable($tableName){

                    if(!isset(self::$wpdb))

                        $wpdb = rev_db_class::rev_db_instance();

                    else

                        $wpdb = self::$wpdb;

                    

                    $tableName = $wpdb->prefix.$tableName;                    

                    $sql = "DROP TABLE IF EXISTS {$tableName}";

                    $q = $wpdb->query($sql);

                    if($q)
                        return true;

                    

                }

		



		public static function createTable($tableName){

			

			$parseCssToDb = false;


                        if(!isset(self::$wpdb))

                            $wpdb = rev_db_class::rev_db_instance();

                        else

                            $wpdb = self::$wpdb;

                    

                        $tableRealName = $wpdb->prefix.$tableName;

			switch($tableName){

                                case GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES:

                                    

                                    $sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}(

                                                ID INT(10) NOT NULL AUTO_INCREMENT,

                                                file_name VARCHAR(100) NOT NULL,                                                

                                                PRIMARY KEY (ID)

                                            )DEFAULT CHARSET=utf8;";

                                    

                                    break;

                            

				case GlobalsRevSlider::TABLE_SLIDERS_NAME:					

				$sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}(

							  id int(9) NOT NULL AUTO_INCREMENT,

							  title tinytext NOT NULL,

							  alias tinytext,

							  params text NOT NULL,

							  PRIMARY KEY (id)

							)DEFAULT CHARSET=utf8;";

				break;
				case GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME:
					$sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}(
								  id int(9) NOT NULL AUTO_INCREMENT,
								  slider_id int(9) NOT NULL,
								  params text NOT NULL,
								  layers text NOT NULL,
								  PRIMARY KEY (id)
								)DEFAULT CHARSET=utf8;";
				break;
				case GlobalsRevSlider::TABLE_SLIDES_NAME:

					$sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}(

								  id int(9) NOT NULL AUTO_INCREMENT,

								  slider_id int(9) NOT NULL,

								  slide_order int not NULL,	

								  params text NOT NULL,

								  layers text NOT NULL,

								  PRIMARY KEY (id)

								)DEFAULT CHARSET=utf8;";

				break;

				case GlobalsRevSlider::TABLE_SETTINGS_NAME:

					$sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}(

								  id int(9) NOT NULL AUTO_INCREMENT,

								  general TEXT NOT NULL,

								  params TEXT NOT NULL,

								  PRIMARY KEY (id)

								)DEFAULT CHARSET=utf8;";

				break;

				case GlobalsRevSlider::TABLE_CSS_NAME:

					$sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}(

								  id int(9) NOT NULL AUTO_INCREMENT,

								  handle TEXT NOT NULL,

								  settings TEXT,

								  hover TEXT,

								  params TEXT NOT NULL,

								  PRIMARY KEY (id)

								)DEFAULT CHARSET=utf8;";

					$parseCssToDb = true;

				break;

				case GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME:

					$sql = "CREATE TABLE IF NOT EXISTS " .$tableRealName ." (

								  id int(9) NOT NULL AUTO_INCREMENT,

								  handle TEXT NOT NULL,

								  params TEXT NOT NULL,

								  PRIMARY KEY (id)

								)DEFAULT CHARSET=utf8;";

				break;

				

				default:

					UniteFunctionsRev::throwError("table: $tableName not found");

				break;

			}

                        $q = $wpdb->query($sql);                        
                        
                        return $q;		

		}

		
                
                public static function sds_caption_css_init($parseCssToDb){
                    
                    if((bool)$parseCssToDb === true){
    
				$revOperations = new RevOperations();

				$revOperations->importCaptionsCssContentArray();

				$revOperations->moveOldCaptionsCss();

				

				$revOperations->updateDynamicCaptions(true);
                                return TRUE;
			}
                }

		/**
		 * 
		 * import slideer handle (not ajax response)
		 */

		private static function importSliderHandle($viewBack = null, $updateAnim = true, $updateStatic = true){

			

			dmp(__("importing slider setings and data...",REVSLIDER_TEXTDOMAIN));

			

			$slider = new RevSlider();

			$response = $slider->importSliderFromPost($updateAnim, $updateStatic);

			$sliderID = $response["sliderID"];

			

			if(empty($viewBack)){

				$viewBack = self::getViewUrl(self::VIEW_SLIDER,"id=".$sliderID);

				if(empty($sliderID))

					$viewBack = self::getViewUrl(self::VIEW_SLIDERS);

			}

			

			//handle error

			if($response["success"] == false){

				$message = $response["error"];

				dmp("<b>Error: ".$message."</b>");

				echo UniteFunctionsRev::getHtmlLink($viewBack, __("Go Back",REVSLIDER_TEXTDOMAIN));

			}

			else{	//handle success, js redirect.

				dmp(__("Slider Import Success, redirecting...",REVSLIDER_TEXTDOMAIN));
				sdsconfig::getgeneratecssfile();
				echo "<script>location.href='$viewBack'</script>"; 

			}

			exit();

		}

		

		


		public static function onAjaxAction(){

			

			$slider = new RevSlider();

			$slide = new RevSlide();

			$operations = new RevOperations();

			

			$action = self::getPostGetVar("client_action");

			$data = self::getPostGetVar("data");

			//$nonce = self::getPostGetVar("nonce");			

			try{



				//verify the nonce

//				$isVerified = wp_verify_nonce($nonce, "revslider_actions");

//				

//				if($isVerified == false)

//					UniteFunctionsRev::throwError("Wrong request");	

				

				switch($action){
					//start font
					case 'add_google_fonts':
						$f = new ThemePunch_Fonts();

						$result = $f->add_new_font($data);

						if($result === true){
							self::ajaxResponseSuccessRedirect(

						            __("Font successfully created!",REVSLIDER_TEXTDOMAIN), 

									self::getViewUrl("sliders"));
						}else{
							self::ajaxResponseError($result, false);
						}
					break;
					case 'remove_google_fonts':
						if(!isset($data['handle'])) self::ajaxResponseError(__('Font not found', REVSLIDER_TEXTDOMAIN), false);

						$f = new ThemePunch_Fonts();

						$result = $f->remove_font_by_handle($data['handle']);

						if($result === true){
							self::ajaxResponseSuccess(__("Font successfully removed!", REVSLIDER_TEXTDOMAIN), array('data' => $result));
						}else{
							self::ajaxResponseError($result, false);
						}
					break;
					case 'edit_google_fonts':
						if(!isset($data['handle'])) self::ajaxResponseError(__('No handle given', REVSLIDER_TEXTDOMAIN), false);
						if(!isset($data['url'])) self::ajaxResponseError(__('No parameters given', REVSLIDER_TEXTDOMAIN), false);

						$f = new ThemePunch_Fonts();

						$result = $f->edit_font_by_handle($data);

						if($result === true){
							self::ajaxResponseSuccess(__("Font successfully changed!", REVSLIDER_TEXTDOMAIN), array('data' => $result));
						}else{
							self::ajaxResponseError($result, false);
						}
					break;
					//end font
					case "export_slider":

						$sliderID = self::getGetVar("sliderid");

						$dummy = self::getGetVar("dummy");

						$slider->initByID($sliderID);

						$slider->exportSlider($dummy);

					break;

					case "import_slider":

						$updateAnim = self::getPostGetVar("update_animations");

						$updateStatic = self::getPostGetVar("update_static_captions");

						self::importSliderHandle(null, $updateAnim, $updateStatic);

					break;

					case "import_slider_slidersview":

						$viewBack = self::getViewUrl(self::VIEW_SLIDERS);

						$updateAnim = self::getPostGetVar("update_animations");

						$updateStatic = self::getPostGetVar("update_static_captions");

						self::importSliderHandle($viewBack, $updateAnim, $updateStatic);

					break;

					case "create_slider":


						self::requireSettings("slider_settings");

						$settingsMain = self::getSettings("slider_main");

						$settingsParams = self::getSettings("slider_params");

						

						$data = $operations->modifyCustomSliderParams($data);

						

                                                //var_dump($settingsMain);

                                                

                                                

						$newSliderID = $slider->createSliderFromOptions($data,$settingsMain,$settingsParams);

						if($newSliderID > 0)

						self::ajaxResponseSuccessRedirect(

						            __("The slider successfully created",REVSLIDER_TEXTDOMAIN), 

									self::getViewUrl("sliders"));

						

					break;

					case "update_slider":
						

						self::requireSettings("slider_settings");

						$settingsMain = self::getSettings("slider_main");

						$settingsParams = self::getSettings("slider_params");						

						$data = $operations->modifyCustomSliderParams($data);						

						$slider->updateSliderFromOptions($data,$settingsMain,$settingsParams);
						sdsconfig::getgeneratecssfile();
						self::ajaxResponseSuccess(__("Slider updated",REVSLIDER_TEXTDOMAIN));

					break;

					

					case "delete_slider":

						

						$isDeleted = $slider->deleteSliderFromData($data);

						

						if(is_array($isDeleted)){

							$isDeleted = implode(', ', $isDeleted);

							self::ajaxResponseError("Template can't be deleted, it is still being used by the following Sliders: ".$isDeleted);

						}else{

							self::ajaxResponseSuccessRedirect(

						            __("The slider deleted",REVSLIDER_TEXTDOMAIN), 

									self::getViewUrl(self::VIEW_SLIDERS));

						}

					break;

					case "duplicate_slider":

						

						$slider->duplicateSliderFromData($data);

						

						self::ajaxResponseSuccessRedirect(

						            __("The duplicate successfully, refreshing page...",REVSLIDER_TEXTDOMAIN), 

									self::getViewUrl(self::VIEW_SLIDERS));

					break;

					case "add_slide":
						
						$numSlides = $slider->createSlideFromData($data);

						$sliderID = $data["sliderid"];

						

						if($numSlides == 1){

							$responseText = __("Slide Created",REVSLIDER_TEXTDOMAIN);

						}

						else

							$responseText = $numSlides . " ".__("Slides Created",REVSLIDER_TEXTDOMAIN);

						

						$urlRedirect = self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID");													

						sdsconfig::getgeneratecssfile();
						
						self::ajaxResponseSuccessRedirect($responseText,$urlRedirect);

						

					break;

					case "add_slide_fromslideview":
						
						
						$slideID = $slider->createSlideFromData($data,true);

						$urlRedirect = self::getViewUrl(self::VIEW_SLIDE,"id=$slideID");

						$responseText = __("Slide Created, redirecting...",REVSLIDER_TEXTDOMAIN);																			

						sdsconfig::getgeneratecssfile();
						
						self::ajaxResponseSuccessRedirect($responseText,$urlRedirect);

					break;

					case "update_slide":
                 		
						
						require self::getSettingsFilePath("slide_settings");
						
						$slide->updateSlideFromData($data,$slideSettings);

						sdsconfig::getgeneratecssfile();
						
						self::ajaxResponseSuccess(__("Slide updated",REVSLIDER_TEXTDOMAIN));

					break;
					case "update_static_slide":
						
						
						$slide->updateStaticSlideFromData($data);
						
						sdsconfig::getgeneratecssfile();

						self::ajaxResponseSuccess(__("Static Layers updated",REVSLIDER_TEXTDOMAIN));
					break;
					case "delete_slide":

						$isPost = $slide->deleteSlideFromData($data);

						if($isPost)

							$message = __("Post Deleted Successfully",REVSLIDER_TEXTDOMAIN);

						else

							$message = __("Slide Deleted Successfully",REVSLIDER_TEXTDOMAIN);

						

						$sliderID = UniteFunctionsRev::getVal($data, "sliderID");

						self::ajaxResponseSuccessRedirect(

						            $message, self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID")); 

														

					break;

					case "duplicate_slide":

						$sliderID = $slider->duplicateSlideFromData($data);

						self::ajaxResponseSuccessRedirect(

						            __("Slide Duplicated Successfully",REVSLIDER_TEXTDOMAIN), 

									self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID"));

					break;

					case "copy_move_slide":

						$sliderID = $slider->copyMoveSlideFromData($data);

						

						self::ajaxResponseSuccessRedirect(

						            __("The operation successfully, refreshing page...",REVSLIDER_TEXTDOMAIN), 

									self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID"));

					break;

					case "get_static_css":
						sdsconfig::getgeneratecssfile();
						
						$contentCSS = $operations->getStaticCss();

						self::ajaxResponseData($contentCSS);

					break;

					case "get_dynamic_css":
						sdsconfig::getgeneratecssfile();
						
						$contentCSS = $operations->getDynamicCss();

						self::ajaxResponseData($contentCSS);

					break;

					case "insert_captions_css":
						
						
						$arrCaptions = $operations->insertCaptionsContentData($data);
						sdsconfig::getgeneratecssfile();
						self::ajaxResponseSuccess(__("CSS saved succesfully!",REVSLIDER_TEXTDOMAIN),array("arrCaptions"=>$arrCaptions));

					break;

					case "update_captions_css":
						
						$arrCaptions = $operations->updateCaptionsContentData($data);
						sdsconfig::getgeneratecssfile();
						
						self::ajaxResponseSuccess(__("CSS saved succesfully!",REVSLIDER_TEXTDOMAIN),array("arrCaptions"=>$arrCaptions));

					break;

					case "delete_captions_css":

						$arrCaptions = $operations->deleteCaptionsContentData($data);
						sdsconfig::getgeneratecssfile();
						self::ajaxResponseSuccess(__("Style deleted succesfully!",REVSLIDER_TEXTDOMAIN),array("arrCaptions"=>$arrCaptions));

					break;

					case "update_static_css":

						$staticCss = $operations->updateStaticCss($data);
						sdsconfig::getgeneratecssfile();
						self::ajaxResponseSuccess(__("CSS saved succesfully!",REVSLIDER_TEXTDOMAIN),array("css"=>$staticCss));

					break;

					case "insert_custom_anim":

						$arrAnims = $operations->insertCustomAnim($data); //$arrCaptions = 

						self::ajaxResponseSuccess(__("Animation saved succesfully!",REVSLIDER_TEXTDOMAIN), $arrAnims); //,array("arrCaptions"=>$arrCaptions)

					break;

					case "update_custom_anim":

						$arrAnims = $operations->updateCustomAnim($data);

						self::ajaxResponseSuccess(__("Animation saved succesfully!",REVSLIDER_TEXTDOMAIN), $arrAnims); //,array("arrCaptions"=>$arrCaptions)

					break;

					case "delete_custom_anim":

						$arrAnims = $operations->deleteCustomAnim($data);

						self::ajaxResponseSuccess(__("Animation saved succesfully!",REVSLIDER_TEXTDOMAIN), $arrAnims); //,array("arrCaptions"=>$arrCaptions)

					break;

					case "update_slides_order":

						$slider->updateSlidesOrderFromData($data);

						self::ajaxResponseSuccess(__("Order updated successfully",REVSLIDER_TEXTDOMAIN));

					break;

					case "change_slide_image":

						$slide->updateSlideImageFromData($data);

						$sliderID = UniteFunctionsRev::getVal($data, "slider_id");						

						self::ajaxResponseSuccessRedirect(

						            __("Slide Changed Successfully",REVSLIDER_TEXTDOMAIN), 

									self::getViewUrl(self::VIEW_SLIDES,"id=$sliderID"));

					break;	

					case "preview_slide":                                                
                                                
						$operations->putSlidePreviewByData($data);

					break;
					// case "preview_slider":
					// 	$sliderID = UniteFunctionsRev::getPostGetVariable("sliderid");
					// 	$operations->previewOutput($sliderID);
					// break;
					case "preview_slider":
						
						$sliderID = UniteFunctionsRev::getPostGetVariable("sliderid");
						$do_markup = UniteFunctionsRev::getPostGetVariable("only_markup");

						if($do_markup == 'true')
							$operations->previewOutputMarkup($sliderID);
						else
							$operations->previewOutput($sliderID);
					break;
					case "toggle_slide_state":

						$currentState = $slide->toggleSlideStatFromData($data);

						self::ajaxResponseData(array("state"=>$currentState));

					break;

					case "slide_lang_operation":

						$responseData = $slide->doSlideLangOperation($data);

						self::ajaxResponseData($responseData);

					break;

					case "update_plugin":

						self::updatePlugin(self::DEFAULT_VIEW);

					break;

					case "update_text":

						self::updateSettingsText();

						sdsconfig::getgeneratecssfile();

						self::ajaxResponseSuccess(__("All files successfully updated",REVSLIDER_TEXTDOMAIN));

					break;

					case "update_general_settings":
						$new_data = array();
						// print_r($data);
						foreach ($data as $key => $value) {
							$new_data[$key] = $value;
						}
						$operations->updateGeneralSettings($new_data);
						// sdsconfig::getgeneratecssfile();
						self::ajaxResponseSuccess(__("General settings updated",REVSLIDER_TEXTDOMAIN));
					break;

					case "update_posts_sortby":

						$slider->updatePostsSortbyFromData($data);

						self::ajaxResponseSuccess(__("Sortby updated",REVSLIDER_TEXTDOMAIN));

					break;

					case "replace_image_urls":

						$slider->replaceImageUrlsFromData($data);

						self::ajaxResponseSuccess(__("Image urls replaced",REVSLIDER_TEXTDOMAIN));

					break; 

					case "reset_slide_settings":

						$slider->resetSlideSettings($data);

						sdsconfig::getgeneratecssfile();
						
						self::ajaxResponseSuccess(__("Settings in all Slides changed",REVSLIDER_TEXTDOMAIN));

					break;

                                        

                                        case 'delete_uploaded_image':

                                            self::delete_uploaded_file($data);

                                            break;

											case 'get_uploaded_images':

											self::get_uploaded_files_json();

											break;
case 'add_slider_pos_val':
$newdata = array();
if(!empty($data)){
	$k = array_keys($data);
	$k = preg_replace_callback('/\[[0-9]+/', create_function('$match','return "";'), $k[0]);
	foreach($data as $key => $arr){
		$newdata[$k][] = $arr;
	}
	$data = $newdata;
}
sdsconfig::editSetting('revslideropencart',$data);
self::ajaxResponseSuccess(__("Slider Position Save SuccessFully",REVSLIDER_TEXTDOMAIN));
break;

					

					default:

						self::ajaxResponseError("wrong ajax action: $action ");

					break;

				}

				

			}

			catch(Exception $e){

				

				$message = $e->getMessage();

				if($action == "preview_slide" || $action == "preview_slider"){

					echo $message;

					exit();

				}

					

				self::ajaxResponseError($message);

			}

			

			//it's an ajax action, so exit

			//self::ajaxResponseError("No response output on <b> $action </b> action. please check with the developer.");

			exit();

		}

		

	}

	

	

?>