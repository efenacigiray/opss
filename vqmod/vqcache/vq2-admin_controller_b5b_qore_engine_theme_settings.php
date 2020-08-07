<?php
class ControllerB5bQoreEngineThemeSettings extends Controller{
	private $error = array();

	public function index() {
		if($this->user->hasPermission('modify', 'b5b_qore_engine/theme_settings')){
			$data = array();

			$this->load->language('b5b_qore_engine/settings/settings');
			$this->load->language('b5b_qore_engine/general/general');

			$this->load->model('b5b_qore_engine/general/settings');


				/* B5B - BETA FEATURE - START */
				// Check if page has been added to compatibility list

				$data['custom_page_is_compatible'] = FALSE;

				if(isset($this->request->get['route'])){;
					/*
					// Temporarily disabled. Will be enabled once feature is completed
					$custom_compatible_pages = unserialize($this->model_b5b_qore_engine_general_settings->getSettings('compatible_page_route_circloid'));

					if($custom_compatible_pages && in_array($this->request->get['route'], $custom_compatible_pages)){
						$data['custom_page_is_compatible'] = TRUE;
					}
					*/
					$custom_compatible_pages = "";
				}

				/* B5B - BETA FEATURE - END */
				

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['b5b_qore_engine']['language']['button_done'] = $this->language->get('button_done');
			$data['b5b_qore_engine']['language']['button_browse'] = $this->language->get('button_browse');
			$data['b5b_qore_engine']['language']['button_upload'] = $this->language->get('button_upload');

			$data['b5b_qore_engine']['language']['text_edit_settings'] = $this->language->get('text_edit_settings');
			$data['b5b_qore_engine']['language']['text_theme_settings'] = $this->language->get('text_theme_settings');
			$data['b5b_qore_engine']['language']['text_theme_extensions'] = $this->language->get('text_theme_extensions');
			$data['b5b_qore_engine']['language']['text_qore_engine_extensions'] = $this->language->get('text_qore_engine_extensions');
			$data['b5b_qore_engine']['language']['text_color_presets'] = $this->language->get('text_color_presets');
			$data['b5b_qore_engine']['language']['text_miscellaneous_features'] = $this->language->get('text_miscellaneous_features');
			$data['b5b_qore_engine']['language']['text_generate_compatibility_fix'] = $this->language->get('text_generate_compatibility_fix');
			$data['b5b_qore_engine']['language']['help_generate_compatibility_fix'] = $this->language->get('help_generate_compatibility_fix');
			$data['b5b_qore_engine']['language']['text_date_generated'] = $this->language->get('text_date_generated');
			$data['b5b_qore_engine']['language']['text_generate'] = $this->language->get('text_generate');
			$data['b5b_qore_engine']['language']['text_extension_compatibility_qore_engine'] = $this->language->get('text_extension_compatibility_qore_engine');
			$data['b5b_qore_engine']['language']['text_no_extension_fixes'] = $this->language->get('text_no_extension_fixes');

			$data['b5b_qore_engine']['language']['text_white_label'] = $this->language->get('text_white_label');
			$data['b5b_qore_engine']['language']['text_enable_white_label'] = $this->language->get('text_enable_white_label');
			$data['b5b_qore_engine']['language']['text_use_own_logo'] = $this->language->get('text_use_own_logo');
			$data['b5b_qore_engine']['language']['text_upload_own_logo_light_bg'] = $this->language->get('text_upload_own_logo_light_bg');
			$data['b5b_qore_engine']['language']['text_upload_own_logo_dark_bg'] = $this->language->get('text_upload_own_logo_dark_bg');
			$data['b5b_qore_engine']['language']['text_show_theme_name_footer'] = $this->language->get('text_show_theme_name_footer');
			$data['b5b_qore_engine']['language']['text_show_opencart_footer'] = $this->language->get('text_show_opencart_footer');
			$data['b5b_qore_engine']['language']['text_show_copyright_footer'] = $this->language->get('text_show_copyright_footer');
			$data['b5b_qore_engine']['language']['text_show_company_name_footer'] = $this->language->get('text_show_company_name_footer');
			$data['b5b_qore_engine']['language']['text_powered_by'] = $this->language->get('text_powered_by');
			$data['b5b_qore_engine']['language']['text_enter_company_name'] = $this->language->get('text_enter_company_name');
			$data['b5b_qore_engine']['language']['help_powered_by'] = $this->language->get('help_powered_by');
			$data['b5b_qore_engine']['language']['text_show_b5b_support_header'] = $this->language->get('text_show_b5b_support_header');
			$data['b5b_qore_engine']['language']['help_upload_own_logo_light_bg'] = $this->language->get('help_upload_own_logo_light_bg');
			$data['b5b_qore_engine']['language']['help_upload_own_logo_dark_bg'] = $this->language->get('help_upload_own_logo_dark_bg');
			$data['b5b_qore_engine']['language']['help_show_copyright_footer'] = $this->language->get('help_show_copyright_footer');
			$data['b5b_qore_engine']['language']['help_show_company_name_footer'] = $this->language->get('help_show_company_name_footer');
			$data['b5b_qore_engine']['language']['help_powered_by'] = $this->language->get('help_powered_by');
			$data['b5b_qore_engine']['language']['help_show_b5b_support_header'] = $this->language->get('help_show_b5b_support_header');
			$data['b5b_qore_engine']['language']['text_browse_then_click_upload'] = $this->language->get('text_browse_then_click_upload');
			$data['b5b_qore_engine']['language']['text_drop_files_here'] = $this->language->get('text_drop_files_here');
			$data['b5b_qore_engine']['language']['text_install_white_label'] = $this->language->get('text_install_white_label');
			$data['button_setting'] = $this->language->get('button_setting');

			$data['active_theme'] = $this->model_b5b_qore_engine_general_settings->getSettings('active_theme');

			if($data['active_theme'] == 'impulsepro_2_lite'){
				$this->response->redirect($this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'], true));
			}

			$data['b5b_qore_engine']['language']['text_extension_compatibility_theme_specific'] = sprintf($this->language->get('text_extension_compatibility_theme_specific'), ucfirst($data['active_theme']));

			// Check if White Labeling has been installed
			$white_label = 'white_label_' . $data['active_theme'] . '_settings';
			$data['white_label_settings'] = unserialize($this->model_b5b_qore_engine_general_settings->getSettings($white_label));

			if(!$data['white_label_settings']){
				$this->model_b5b_qore_engine_general_settings->install_white_labelling($data['active_theme']);

				$data['white_label_settings'] = $this->model_b5b_qore_engine_general_settings->getSettings($white_label);
			}

			// Get the themes in the theme directory
			$theme_info = array();
			$path = DIR_TEMPLATE . 'b5b_qore_engine/themes/';

			// Load Switchery: Switchery is loaded here ALONE since it isn't needed anywhere else on the site
			$data['b5b_qore_engine']['css_styles'][] = 'view/template/b5b_qore_engine/themes/' . $data['active_theme'] . '/default/plugins/switchery/switchery.min.css';
			$data['b5b_qore_engine']['css_styles'][] = 'view/template/b5b_qore_engine/themes/' . $data['active_theme'] . '/default/plugins/dropzone/dropzone.css';

			$data['b5b_qore_engine']['js_scripts'][] = 'view/template/b5b_qore_engine/themes/' . $data['active_theme'] . '/default/plugins/switchery/switchery.min.js';
			$data['b5b_qore_engine']['js_scripts'][] = 'view/template/b5b_qore_engine/themes/' . $data['active_theme'] . '/default/plugins/dropzone/dropzone.min.js';
			$data['b5b_qore_engine']['js_scripts'][] = 'view/template/b5b_qore_engine/themes/' . $data['active_theme'] . '/default/plugins/dropzone/form-file-upload.js';

			$current_theme_info = $path . $this->request->get['theme'] . '/info.xml';

			if(isset($this->request->get['theme']) && file_exists($current_theme_info)){

				$theme_info['info'] = $current_theme_info;

				$xml = simplexml_load_file($theme_info['info']);

				$theme_info['theme_name'] = (string)$xml->name;
				$theme_info['cleanname'] = (string)$xml->cleanname;
				$theme_info['thumb'] = 'view/template/b5b_qore_engine/themes/' . $theme_info['cleanname'] . '/thumb.jpg';

				if(isset($xml->settings->colorpresets)){
					$data['color_presets'] = (array)$xml->settings->colorpresets->colorpreset;
				}
			}else{
				$data['text_theme_does_not_exist'] = $this->language->get('text_theme_does_not_exist');
			}

			$data['theme_info'] = $theme_info;

			// Get the date the Compatibility Fix was generated
			if(file_exists(dirname(DIR_APPLICATION) . '/vqmod/xml/zzzzzzzzzz_b5b_qore_engine_themefix_' . $data['active_theme'] . '_autogenerated.xml')){

				$file_time = filemtime(dirname(DIR_APPLICATION) . '/vqmod/xml/zzzzzzzzzz_b5b_qore_engine_themefix_' . $data['active_theme'] . '_autogenerated.xml');

				$data['compatibility_fix_generated_date'] = $data['b5b_qore_engine']['language']['text_date_generated'] . ": " . date('F d Y H:i:s', $file_time);
			}else{
				$data['compatibility_fix_generated_date'] = $data['b5b_qore_engine']['language']['text_date_generated'] . ": --";
			}

			// Get list of Theme-Specific XML fixes
			$data['theme_specific_extension_fixes'] = $this->get_xml_files("zzzzzzzzzz_b5b_qore_engine_themefix_" . $data['active_theme']);

			// Get list of QoreEngine XML fixes (Global fixes also works on ImpulsePRo)
			$data['qore_engine_extension_fixes'] = $this->get_xml_files("zzzzzzzzzz_b5b_qore_engine_globalfix_");

			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}

			$data['b5b_qore_engine']['user_token'] = $this->session->data['user_token'];

			$data['back'] = $this->url->link('extension/module/b5b_qore_engine', 'user_token=' . $this->session->data['user_token'], true);

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
				);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module', 'user_token=' . $this->session->data['user_token'], true)
				);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/b5b_qore_engine', 'user_token=' . $this->session->data['user_token'], true)
				);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');


				/* B5B - QoreEngine - Start */
				$this->load->language('b5b_qore_engine/general/general');

				$data['b5b_qore_engine']['language']['error_incompatible_version'] = $this->language->get('error_incompatible_version');
				$data['b5b_qore_engine']['language']['text_base5builder'] = $this->language->get('text_base5builder');
				$data['b5b_qore_engine']['language']['text_base5builder_support'] = $this->language->get('text_base5builder_support');
				$data['b5b_qore_engine']['language']['error_error_occured'] = $this->language->get('error_error_occured');
				$data['b5b_qore_engine']['language']['text_refreshing_page'] = $this->language->get('text_refreshing_page');
				$data['b5b_qore_engine']['language']['text_powered_by'] = $this->language->get('text_powered_by');

				$this->load->model('b5b_qore_engine/general/settings');


				/* B5B - BETA FEATURE - START */
				// Check if page has been added to compatibility list

				$data['custom_page_is_compatible'] = FALSE;

				if(isset($this->request->get['route'])){;
					/*
					// Temporarily disabled. Will be enabled once feature is completed
					$custom_compatible_pages = unserialize($this->model_b5b_qore_engine_general_settings->getSettings('compatible_page_route_circloid'));

					if($custom_compatible_pages && in_array($this->request->get['route'], $custom_compatible_pages)){
						$data['custom_page_is_compatible'] = TRUE;
					}
					*/
					$custom_compatible_pages = "";
				}

				/* B5B - BETA FEATURE - END */
				

				$table_exists = $this->model_b5b_qore_engine_general_settings->tableExsits('b5b_qore_engine_settings');

				if($table_exists){
					if(isset($this->request->get['route'])){
						$data['b5b_qore_engine_route'] = $this->request->get['route'];
					}else{
						$data['b5b_qore_engine_route'] = '';
					}

					$data['b5b_qore_engine_is_admin'] = 1;
					$data['b5b_qore_engine_active_theme'] = $this->model_b5b_qore_engine_general_settings->getSettings('active_theme');

					$info_path = DIR_TEMPLATE . 'b5b_qore_engine/themes/' . $data['b5b_qore_engine_active_theme'] . '/info.xml';

					if(file_exists($info_path)){
						$xml = simplexml_load_file($info_path);
						$data['b5b_qore_engine_active_theme_version'] = (string)$xml->version;
					}else{
						$data['b5b_qore_engine_active_theme_version'] = "";
					}

					$data['b5b_qore_engine_color_preset'] = $this->model_b5b_qore_engine_general_settings->getSettings('color_preset_' . $data['b5b_qore_engine_active_theme']);

					$data['b5b_qore_engine_white_label'] = unserialize($this->model_b5b_qore_engine_general_settings->getSettings('white_label_' . $data['b5b_qore_engine_active_theme'] . '_settings'));
				}

				/* B5B - QoreEngine - End */
				
			$this->response->setOutput($this->load->view('settings/settings', $data));

		}else{
			$this->response->redirect($this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'], true));
		}
	}

	public function change_color_profile(){

		$json = array();
		$json['success'] = 0;

		if($this->session->data['user_token'] == $this->request->get['user_token']){

			$this->load->language('b5b_qore_engine/settings/settings');
			$this->load->language('b5b_qore_engine/dashboard/general');
			$this->load->language('b5b_qore_engine/general/general');

			if(isset($this->request->get['theme'])){
				$theme_name = $this->clean_string(urldecode($this->request->get['theme']));
			}

			if(isset($this->request->get['color_preset'])){
				$color_preset = $this->clean_string(urldecode($this->request->get['color_preset']));
			}

			if(isset($this->request->get['status'])){
				$status = $this->clean_string(urldecode($this->request->get['status']));
			}

			// Get the themes in the theme directory
			$theme_info = array();
			$path = DIR_TEMPLATE . 'b5b_qore_engine/themes/';

			$current_theme_info = $path . $theme_name . '/info.xml';

			if(file_exists($current_theme_info)){

				$xml = simplexml_load_file($current_theme_info);

				if(isset($xml->settings->colorpresets)){
					$info_color_presets = (array)$xml->settings->colorpresets->colorpreset;

					if(in_array($color_preset, $info_color_presets)){
						// Enable it in the DB
						$this->load->model('b5b_qore_engine/general/settings');


				/* B5B - BETA FEATURE - START */
				// Check if page has been added to compatibility list

				$data['custom_page_is_compatible'] = FALSE;

				if(isset($this->request->get['route'])){;
					/*
					// Temporarily disabled. Will be enabled once feature is completed
					$custom_compatible_pages = unserialize($this->model_b5b_qore_engine_general_settings->getSettings('compatible_page_route_circloid'));

					if($custom_compatible_pages && in_array($this->request->get['route'], $custom_compatible_pages)){
						$data['custom_page_is_compatible'] = TRUE;
					}
					*/
					$custom_compatible_pages = "";
				}

				/* B5B - BETA FEATURE - END */
				
						$this->model_b5b_qore_engine_general_settings->changeColorPreset($theme_name, $color_preset);

						$json['language']['success_message'] = $this->language->get('text_refreshing_page');

						$json['success'] = 1;
						
					}else{
						$json['language']['error_message'] = $this->language->get('error_color_preset_does_not_exist');
					}
				}
			}else{
				$json['language']['error_message'] = $this->language->get('error_theme_does_not_exist');
			}

		}else{
			$json['language']['error_message'] = $this->language->get('error_please_login');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function save_custom_admin_page(){
		$json = array();

		if(($this->session->data['user_token'] == $this->request->get['user_token']) && (isset($this->request->get['adminpage']))){

			$this->load->language('b5b_qore_engine/general/general');

			$json['language']['text_refreshing_page'] = $this->language->get('text_refreshing_page');
			$json['language']['error_error_occured'] = $this->language->get('error_error_occured');

			$data['admin_page'] = $this->request->get['adminpage'];

			// Call the model
			$this->load->model('b5b_qore_engine/general/settings');


				/* B5B - BETA FEATURE - START */
				// Check if page has been added to compatibility list

				$data['custom_page_is_compatible'] = FALSE;

				if(isset($this->request->get['route'])){;
					/*
					// Temporarily disabled. Will be enabled once feature is completed
					$custom_compatible_pages = unserialize($this->model_b5b_qore_engine_general_settings->getSettings('compatible_page_route_circloid'));

					if($custom_compatible_pages && in_array($this->request->get['route'], $custom_compatible_pages)){
						$data['custom_page_is_compatible'] = TRUE;
					}
					*/
					$custom_compatible_pages = "";
				}

				/* B5B - BETA FEATURE - END */
				
			$data['active_theme'] = $this->model_b5b_qore_engine_general_settings->getSettings('active_theme');

			$json['saved_custom_admin_page'] = $this->model_b5b_qore_engine_general_settings->save_custom_admin_page($data);
		}else{
			$data['saved_custom_admin_page'] = 0;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove_custom_admin_page(){
		$json = array();

		if(($this->session->data['user_token'] == $this->request->get['user_token']) && (isset($this->request->get['adminpage']))){

			$this->load->language('b5b_qore_engine/general/general');

			$json['language']['text_refreshing_page'] = $this->language->get('text_refreshing_page');
			$json['language']['error_error_occured'] = $this->language->get('error_error_occured');

			$data['admin_page'] = $this->request->get['adminpage'];

			// Call the model
			$this->load->model('b5b_qore_engine/general/settings');


				/* B5B - BETA FEATURE - START */
				// Check if page has been added to compatibility list

				$data['custom_page_is_compatible'] = FALSE;

				if(isset($this->request->get['route'])){;
					/*
					// Temporarily disabled. Will be enabled once feature is completed
					$custom_compatible_pages = unserialize($this->model_b5b_qore_engine_general_settings->getSettings('compatible_page_route_circloid'));

					if($custom_compatible_pages && in_array($this->request->get['route'], $custom_compatible_pages)){
						$data['custom_page_is_compatible'] = TRUE;
					}
					*/
					$custom_compatible_pages = "";
				}

				/* B5B - BETA FEATURE - END */
				
			$data['active_theme'] = $this->model_b5b_qore_engine_general_settings->getSettings('active_theme');
			
			$json['removed_custom_admin_page'] = $this->model_b5b_qore_engine_general_settings->remove_custom_admin_page($data);
		}else{
			$data['saved_custom_admin_page'] = 0;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function generate_compatibility_fix(){
		$json = array();

		$this->load->model('b5b_qore_engine/general/settings');


				/* B5B - BETA FEATURE - START */
				// Check if page has been added to compatibility list

				$data['custom_page_is_compatible'] = FALSE;

				if(isset($this->request->get['route'])){;
					/*
					// Temporarily disabled. Will be enabled once feature is completed
					$custom_compatible_pages = unserialize($this->model_b5b_qore_engine_general_settings->getSettings('compatible_page_route_circloid'));

					if($custom_compatible_pages && in_array($this->request->get['route'], $custom_compatible_pages)){
						$data['custom_page_is_compatible'] = TRUE;
					}
					*/
					$custom_compatible_pages = "";
				}

				/* B5B - BETA FEATURE - END */
				
		$data['active_theme'] = $this->model_b5b_qore_engine_general_settings->getSettings('active_theme');

		$vqmod_path = substr_replace(DIR_SYSTEM, '/vqmod/xml/', -8); // '-8' to remove the system path

		$output_file = $vqmod_path . "zzzzzzzzzz_b5b_qore_engine_themefix_" . $data['active_theme'] . "_autogenerated.xml";

		// $restricted_files = array(
		// 	$vqmod_path . "b5b_admintheme_circloid.xml",
		// 	$vqmod_path . "b5b_qore_engine.xml",
		// 	$vqmod_path . "b5b_qore_engine_theme_" . $data['active_theme'] . ".xml",
		// 	$vqmod_path . "b5b_qore_engine_theme_" . $data['active_theme'] . "_language_en_gb.xml",
		// 	$vqmod_path . "zzzzzzzzzz_b5b_qore_engine_*.xml",
		// 	);

		$restricted_files = glob($vqmod_path . '*b5b_qore_engine*.{xml}', GLOB_BRACE);

		// TODO URGENT B5B: Must also be able to get a list of the extensions that has already been fixed so it doesn't crete a conflict.
		// Need a place to store the xml file names of all compatible extensions... until it's no longer necessary
		
		$files = glob($vqmod_path . '*.{xml}', GLOB_BRACE);

		$xml_rebuild = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml_rebuild .= "\n";
		$xml_rebuild .= '<modification>';
		$xml_rebuild .= "\n";
		$xml_rebuild .= '	<id>Bas5Builder - ' . $data['active_theme'] . ' (Auto-Generated)</id>';
		$xml_rebuild .= "\n";
		$xml_rebuild .= '	<version>1.0.0.0</version>';
		$xml_rebuild .= "\n";
		$xml_rebuild .= '	<vqmver>2.6.0</vqmver>';
		$xml_rebuild .= "\n";
		$xml_rebuild .= '	<author>base5builder.com</author>';
		$xml_rebuild .= "\n";
		$xml_rebuild .= '	<file name="admin/view/template/b5b_qore_engine/themes/' . $data['active_theme'] . '/*/template/common/header.tpl">';
		$xml_rebuild .= "\n";

		foreach($files as $filename) {
			if(!in_array($filename, $restricted_files)){
				$xml_file = simplexml_load_file($filename);

				$extension_name = $xml_file->id;

				foreach ($xml_file as $xml) {
					if($xml->attributes()->name == "admin/view/template/common/header.tpl"){


						foreach($xml->operation as $operation_block){

							$operation_attributes = '';
							foreach ($operation_block->attributes() as $key1 => $value1) {
								if($key1 == "error"){
									$operation_attributes .= ' error="skip"';
								}else{
									$operation_attributes .= " " . $key1 . '="' . $value1 . '"';
								}
							}

							$xml_rebuild .= '		<!-- ' . $extension_name . ' -->';
							$xml_rebuild .= "\n";
							$xml_rebuild .= '		<operation' . $operation_attributes . '>';
							$xml_rebuild .= "\n";

							$search_attributes = '';

							foreach ($operation_block->search->attributes() as $key2 => $value2) {
								$search_attributes .= " " . $key2 . '="' . $value2 . '"';
							}

							$xml_rebuild .= '			<search' . $search_attributes . '><![CDATA[';
							$xml_rebuild .= (string)$operation_block->search;
							$xml_rebuild .= ']]></search>';
							$xml_rebuild .= "\n";

							$xml_rebuild .= '			<add><![CDATA[';
							$xml_rebuild .= (string)$operation_block->add;
							$xml_rebuild .= ']]></add>';
							$xml_rebuild .= "\n";

							$xml_rebuild .= '		</operation>';
							$xml_rebuild .= "\n";
						}
					}
				}
			}
		}

		$xml_rebuild .= '	</file>';
		$xml_rebuild .= "\n";
		$xml_rebuild .= '</modification>';
		file_put_contents($output_file, $xml_rebuild);

		$json['success'] = TRUE;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function enable_extension(){
		$json = array();

		$json['success'] = FALSE;

		$this->load->language('b5b_qore_engine/general/general');
		$json['language']['error_error_occured'] = $this->language->get('error_error_occured');

		$filename = $this->request->get['filename'];

		$vqmod_path = substr_replace(DIR_SYSTEM, '/vqmod/xml/', -8);

		$file = $vqmod_path . $filename;

		if(rename($file, substr($file,0, -1))){
			$json['success'] = TRUE;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function disable_extension(){
		$json = array();

		$json['success'] = FALSE;

		$this->load->language('b5b_qore_engine/general/general');
		$json['language']['error_error_occured'] = $this->language->get('error_error_occured');

		$filename = $this->request->get['filename'];

		$vqmod_path = substr_replace(DIR_SYSTEM, '/vqmod/xml/', -8);

		$file = $vqmod_path . $filename;

		if(rename($file, $file . '_')){
			$json['success'] = TRUE;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function white_label_settings(){
		$json = array();

		$json['success'] = FALSE;

		$this->load->language('b5b_qore_engine/general/general');

		if(isset($this->request->get['theme_name'])){
			$theme_name = $this->request->get['theme_name'];

			$this->load->model('b5b_qore_engine/general/settings');


				/* B5B - BETA FEATURE - START */
				// Check if page has been added to compatibility list

				$data['custom_page_is_compatible'] = FALSE;

				if(isset($this->request->get['route'])){;
					/*
					// Temporarily disabled. Will be enabled once feature is completed
					$custom_compatible_pages = unserialize($this->model_b5b_qore_engine_general_settings->getSettings('compatible_page_route_circloid'));

					if($custom_compatible_pages && in_array($this->request->get['route'], $custom_compatible_pages)){
						$data['custom_page_is_compatible'] = TRUE;
					}
					*/
					$custom_compatible_pages = "";
				}

				/* B5B - BETA FEATURE - END */
				

			if(isset($this->request->get['white_label_setting_name']) && isset($this->request->get['white_label_setting_value'])){

				$white_label_setting_name = $this->clean_string(urldecode($this->request->get['white_label_setting_name']));

				if($white_label_setting_name == 'powered_by'){
					$white_label_setting_value = (string)$this->request->get['white_label_setting_value'];
				}else{
					$white_label_setting_value = (int)$this->request->get['white_label_setting_value'];
				}

				$setting_updated = $this->model_b5b_qore_engine_general_settings->updateWhiteLabelSetting($theme_name, $white_label_setting_name, $white_label_setting_value);

				$json['language']['success_message'] = $this->language->get('text_refreshing_page');
				$json['success'] = TRUE;
			}else{
				$json['language']['error_error_occured'] = $this->language->get('error_error_occured');
			}
		}else{
			$json['language']['error_error_occured'] = $this->language->get('error_error_occured');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function upload_logo(){
		$json = array();

		$json['success'] = FALSE;

		$this->load->language('b5b_qore_engine/general/general');

		if(isset($this->request->get['active_theme'])){
			$active_theme = $this->request->get['active_theme'];

			$themes_path = DIR_TEMPLATE . 'b5b_qore_engine/themes/';

			$current_theme_info = $themes_path . $active_theme . '/info.xml';

			if(file_exists($current_theme_info)){

				$theme_info['info'] = $current_theme_info;

				$xml = simplexml_load_file($theme_info['info']);

				if(isset($xml->settings->colorpresets)){
					$color_presets = (array)$xml->settings->colorpresets->colorpreset;
				}

				$image_folders = array(
					'default' => $themes_path . $active_theme . '/default/images/user_upload/',
					'user_override' => $themes_path . $active_theme . '/user_override/images/user_upload/'
					);

				foreach($image_folders  as $image_folder){
					if(!file_exists($image_folder)){
						mkdir($image_folder, 0777, true);
					}
				}

				if(isset($this->request->get['logo_type'])){

					$logo_type = $this->request->get['logo_type'];

					// Handle the upload here
					if(!empty($_FILES)){

						if($logo_type == 'light_bg'){
							$tempFile = $_FILES['file']['tmp_name'];

							foreach($image_folders  as $image_folder){

								foreach($color_presets as $color_preset){
									$targetFile =  $image_folder . 'logo-' . $color_preset . '.' . substr($_FILES['file']['type'], 6);

									copy($tempFile, $targetFile);
								}
							}

							move_uploaded_file($tempFile, $targetFile);

							$json['success'] = TRUE;
						}else{

							$tempFile = $_FILES['file']['tmp_name'];

							foreach($image_folders  as $image_folder){

								foreach($color_presets as $color_preset){
									$targetFile =  $image_folder . 'logo-white-' . $color_preset . '.' . substr($_FILES['file']['type'], 6);

									copy($tempFile, $targetFile);
								}
							}

							move_uploaded_file($tempFile, $targetFile);

							$json['success'] = TRUE;
						}
					}else{
						$json['errorr_uploading_file'] = $this->language->get('errorr_uploading_file');
					}
				}else{
					$json['errorr_uploading_file'] = $this->language->get('errorr_uploading_file');
				}
			}else{
				$json['errorr_uploading_file'] = $this->language->get('errorr_uploading_file');
			}
		}else{
			$json['errorr_uploading_file'] = $this->language->get('errorr_uploading_file');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function get_xml_files($file_name){

		$data = array();

		$vqmod_path = substr_replace(DIR_SYSTEM, '/vqmod/xml/', -8); // '-8' to remove the system path

		// Enabled Files
		$enabled_files = glob($vqmod_path . $file_name . '*.{xml}', GLOB_BRACE);

		foreach($enabled_files as $key => $file){
			$xml = simplexml_load_file($file);

			$data['enabled_files'][$key]['title'] = (string)$xml->id;
			$exploded_filename = explode('/', $file);
			$data['enabled_files'][$key]['filename'] = end($exploded_filename);
		}

		// Disabled Files
		$disabled_files = glob($vqmod_path . $file_name . '*.{xml_}', GLOB_BRACE);

		foreach($disabled_files as $key => $file){
			$xml = simplexml_load_file($file);

			$data['disabled_files'][$key]['title'] = (string)$xml->id;
			$exploded_filename = explode('/', $file);
			$data['disabled_files'][$key]['filename'] = end($exploded_filename);
		}

		return $data;
	}

	private function clean_string($string){
		return preg_replace("/[^A-Za-z0-9_]/", '', $string);
	}
}