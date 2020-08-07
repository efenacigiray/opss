<?php

class ControllerExtensionModuleB5bQoreEngine extends Controller{
	private $error = array();

	public function index(){
		$this->load->language('extension/module/b5b_qore_engine');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['b5b_qore_engine']['language']['heading_title'] = $this->language->get('heading_title');

		$data['b5b_qore_engine']['language']['text_edit'] = $this->language->get('text_edit');
		$data['b5b_qore_engine']['language']['text_enable'] = $this->language->get('text_enable');
		$data['b5b_qore_engine']['language']['text_enabled'] = $this->language->get('text_enabled');
		$data['b5b_qore_engine']['language']['text_disabled'] = $this->language->get('text_disabled');
		$data['b5b_qore_engine']['language']['text_version'] = $this->language->get('text_version');
		$data['b5b_qore_engine']['language']['text_creator'] = $this->language->get('text_creator');
		$data['b5b_qore_engine']['language']['text_website'] = $this->language->get('text_website');
		$data['b5b_qore_engine']['language']['text_about'] = $this->language->get('text_about');
		$data['b5b_qore_engine']['language']['text_default_theme'] = $this->language->get('text_default_theme');
		$data['b5b_qore_engine']['language']['text_settings'] = $this->language->get('text_settings');
		$data['b5b_qore_engine']['language']['text_enable_theme_first'] = $this->language->get('text_enable_theme_first');
		$data['b5b_qore_engine']['language']['text_default_theme_desc'] = $this->language->get('text_default_theme_desc');
		$data['b5b_qore_engine']['language']['text_default_theme_creator'] = $this->language->get('text_default_theme_creator');
		$data['b5b_qore_engine']['language']['text_default_theme_website'] = $this->language->get('text_default_theme_website');
		$data['b5b_qore_engine']['language']['text_qoreengine_desc'] = $this->language->get('text_qoreengine_desc');
		$data['b5b_qore_engine']['language']['text_more'] = $this->language->get('text_more');

		$data['b5b_qore_engine']['language']['entry_status'] = $this->language->get('entry_status');

		$data['b5b_qore_engine']['language']['button_save'] = $this->language->get('button_save');
		$data['b5b_qore_engine']['language']['button_cancel'] = $this->language->get('button_cancel');
		$data['b5b_qore_engine']['language']['button_done'] = $this->language->get('button_done');
		$data['b5b_qore_engine']['language']['button_newsletter_signup'] = $this->language->get('button_newsletter_signup');
		$data['b5b_qore_engine']['language']['button_try_demo'] = $this->language->get('button_try_demo');
		$data['b5b_qore_engine']['language']['text_premium_theme_promo_text'] = $this->language->get('text_premium_theme_promo_text');
		$data['b5b_qore_engine']['language']['text_compatible_with'] = $this->language->get('text_compatible_with');

		// Add CSS Styles
		$data['b5b_qore_engine']['css_styles'][] = 'view/template/b5b_qore_engine/assets/plugins/unslider/css/unslider.css';
		$data['b5b_qore_engine']['css_styles'][] = 'view/template/b5b_qore_engine/assets/plugins/unslider/css/unslider-dots.css';
		$data['b5b_qore_engine']['css_styles'][] = 'view/template/b5b_qore_engine/assets/plugins/unslider/css/custom-unslider.css';

		// Add JS Scripts
        $data['b5b_qore_engine']['js_scripts'][] = 'view/template/b5b_qore_engine/assets/plugins/unslider/js/unslider-min.js';
		$data['b5b_qore_engine']['js_scripts'][] = 'view/template/b5b_qore_engine/assets/js/script.js';

		// Get the themes in the theme directory
		$count = 0;
		$theme_info = array();
		$path = DIR_TEMPLATE . 'b5b_qore_engine/themes/';
		$dir = new DirectoryIterator($path);

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

		foreach($dir as $fileinfo){
			if($fileinfo->isDir() && !$fileinfo->isDot()){

				if(file_exists($path . $fileinfo->getFilename() . '/info.xml')){
					$theme_info[$count]['info'] = $fileinfo->getFilename() . '/info.xml';
					$theme_info[$count]['folder_name'] = $fileinfo->getFilename();
					$theme_info[$count]['thumb'] = 'view/template/b5b_qore_engine/themes/' . $fileinfo->getFilename() . '/thumb.jpg';

					$xml = simplexml_load_file($path . $theme_info[$count]['info']);

					$theme_info[$count]['name'] = (string)$xml->name;
					$theme_info[$count]['cleanname'] = (string)$xml->cleanname;
					$theme_info[$count]['version'] = (string)$xml->version;
					$theme_info[$count]['developer'] = (string)$xml->developer;
					$theme_info[$count]['website'] = (string)$xml->website;
					$theme_info[$count]['description'] = (string)$xml->description;
					$theme_info[$count]['status'] = 0;

					if(isset($xml->settings)){
						$theme_info[$count]['has_settings'] = 1;
					}else{
						$theme_info[$count]['has_settings'] = 0;
					}

					// $theme_info[$count]['has_settings'] = strtolower((string)$xml->settings);
					$theme_info[$count]['settings_link'] = $this->url->link('b5b_qore_engine/theme_settings&theme=' . $theme_info[$count]['cleanname'], 'user_token=' . $this->session->data['user_token'], true);

					if($data['active_theme'] == $theme_info[$count]['cleanname']){
						$theme_info[$count]['status'] = 1;
					}
				}
			}
			$count++;
		}

		$data['show_external_themes'] = FALSE;

		if(count($theme_info) === 1){
			foreach($theme_info as $info_1){
				if($info_1['cleanname'] === 'impulsepro_2_lite'){
					$data['show_external_themes'] = TRUE;
				}
				break;
			}
		}

		if($data['show_external_themes']){

			$products_url = 'https://base5builder.com/index.php?route=marketing/landing/qore_engine/external_theme_list';

			$external_themes_info = (array)json_decode($this->url_get_contents($products_url));

			foreach($external_themes_info as $external_theme){
				$data['external_themes_info'][] = (array)$external_theme;
			}

			if(!$data['external_themes_info']){
				$data['external_themes_info'][] = array(
					'theme_name' => 'Energize',
					'theme_desc' => 'Energize gives you the power to completely rebrand your admin. You also get lots more more widgets and a cleaner interface.',
					'theme_creator' => 'Base5Builder',
					'theme_creator_website' => 'https://base5builder.com',
					'theme_img' => 'view/template/b5b_qore_engine/assets/images/energize.png',
					'theme_product_id' => '68',
					'theme_compatibility' => '2.0.3.1, 2.1.0.2, 2.2.0.0, 2.3.0.2',
					'theme_demo_link' => 'https://base5builder.com/index.php?route=product/product&product_id=68&click_source=qore_engine_admin_theme_list_product_link_energize_oc_' . VERSION,
					);
			}
		}

		$data['theme_info'] = $theme_info;

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/b5b_qore_engine', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/b5b_qore_engine', 'user_token=' . $this->session->data['user_token'], true);

		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/b5b_qore_engine', $data));
	}

	private function url_get_contents($url){
		if(function_exists('curl_exec')){
			$conn = curl_init($url);
			curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
			curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
			$url_get_contents_data = (curl_exec($conn));
			curl_close($conn);
		}elseif(function_exists('file_get_contents')){
			$url_get_contents_data = file_get_contents($url);
		}elseif(function_exists('fopen') && function_exists('stream_get_contents')){
			$handle = fopen ($url, "r");
			$url_get_contents_data = stream_get_contents($handle);
		}else{
			$url_get_contents_data = false;
		}
		return $url_get_contents_data;
	} 

	/**
	 * enableTheme		Enabled the selected theme
	 * @param  [type] $theme_name 	[description]
	 * @param  [type] $user_token 		[description]
	 * @return [json] $json 		[description]
	 */
	public function enableTheme(){
		// First checks if QoreEngine is installed
		// The $theme_name is first cleaned then checked against the existing info.xml files in the theme folder. 
		// If it exists, then it updates the 'active_theme' value to the name of the current theme then returns TRUE and refreshes the page with JS.
		// If the theme does not exist then it returns false and displays an error message using JS.
		// The error message will be writting in the language file and passed to the JS script
		
		$this->load->language('extension/module/b5b_qore_engine');
		
		$json['success'] = FALSE;

		if($this->validate()){
			if(isset($this->request->get['user_token']) && isset($this->request->get['theme_name'])){
				$user_token = $this->alphanumeric_only(urldecode($this->request->get['user_token']));
				$theme_name = $this->alphanumeric_underscore(urldecode($this->request->get['theme_name']));

				if($user_token == $this->session->data['user_token']){

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
				
					$active_theme = $this->model_b5b_qore_engine_general_settings->getSettings('active_theme');

					// Used to check if the settings table exists.
					// Since and entry exists it mean the table exists.
					if($active_theme){

						$info_path = DIR_TEMPLATE . 'b5b_qore_engine/themes/' . $theme_name . '/info.xml';

						if(file_exists($info_path)){
							$xml = simplexml_load_file($info_path);
							$xml_theme_name = (string)$xml->cleanname;

							if(isset($xml->settings->colorpresets)){
								$color_presets = (array)$xml->settings->colorpresets->colorpreset;
							}

							if($theme_name == $xml_theme_name){
								// Update the table
								$this->load->model("extension/module/b5b_qore_engine");

								if(isset($color_presets)){
									$this->model_extension_module_b5b_qore_engine->enableTheme($theme_name, $color_presets[0]);
								}else{
									$this->model_extension_module_b5b_qore_engine->enableTheme($theme_name);
									
								}

								$json['success'] = TRUE;

								$this->enableThemeXml($theme_name);
							}else{
								$json['error_message'] = $this->language->get('error_theme_not_exist');
							}
						}else if($theme_name == 'default_opencart_theme'){
							// Update the table
							$this->load->model("extension/module/b5b_qore_engine");
							$this->model_extension_module_b5b_qore_engine->enableTheme($theme_name);

							$this->enableThemeXml($theme_name);

							$json['success'] = TRUE;
						}else{
							$json['error_message'] = $this->language->get('error_info_not_exist');
						}
					}else{
						$json['error_message'] = $this->language->get('error_qore_engine_not_installed');
					}
				}else{
					$json['error_message'] = $this->language->get('error_invalid_user_token');
				}
			}else{
				$json['error_message'] = $this->language->get('error_invalid_user_token_invalid_theme_name');
			}
		}else{
			$json['error_message'] = $this->language->get('error_permission');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function enableThemeXml($theme_name){
		// Enable all necessary XML files
		$vqmod_folder = substr(DIR_SYSTEM, 0, -7) . 'vqmod/xml/';

		// First disable ALL themes and theme specific fixes & extensions
		$theme_related_files = glob($vqmod_folder . 'b5b_qore_engine_theme_*.xml');
		$theme_related_files_2 = glob($vqmod_folder . 'zzzzzzzzzz_b5b_qore_engine_themefix_*.xml');
		$theme_related_files_3 = glob($vqmod_folder . 'zzzzzzzzzz_b5b_qore_engine_themeext_*.xml');

		$files = array_merge($theme_related_files, $theme_related_files_2, $theme_related_files_3);

		foreach($files as $file){
			rename($file, $file . '_');
		}

		// Only enable the related XML file if it's not the default OpenCart Theme
		// Because the default theme doesn't have XML files
		if($theme_name != 'default_opencart_theme'){
			// Then enable the selected theme
			$theme_related_files = glob($vqmod_folder . 'b5b_qore_engine_theme_' . $theme_name . '*.xml_');

			foreach($theme_related_files as $file){
				rename($file, substr($file, 0, -1));
			}
		}
	}

	protected function validate(){
		if(!$this->user->hasPermission('modify', 'extension/module/b5b_qore_engine')){
			return FALSE;
		}

		return TRUE;
	}

	private function alphanumeric_only($string){
		return preg_replace("/[^A-Za-z0-9]/", '', $string);
	}

	private function alphanumeric_underscore($string){
		return preg_replace("/[^A-Za-z0-9_]/", '', $string);
	}

	public function install(){

		// First enable default OpenCart theme, then rename relevant XML files.
		// Finally delete table from DB
		
		$this->enableThemeXml('default_opencart_theme');

		$this->load->model("extension/module/b5b_qore_engine");
		$this->model_extension_module_b5b_qore_engine->createSchema();

		// TODO: Once the table is created above, then all the correspongins XML files for QoreEngine and all themes will be disabled as a precaution, THEN the XML files for JUST QoreEngine will be enabled.

		// Enable all necessary XML files
		$vqmod_folder = substr(DIR_SYSTEM, 0, -7) . 'vqmod/xml/';

		// Get all QoreEngine and related files
		$qore_engine_files = array(
			// Add more files as QoreEngine grows
			$vqmod_folder . 'b5b_qore_engine.xml_'
			);

		foreach($qore_engine_files as $file){
			rename($file, substr($file, 0, -1));
		}
	}

	public function uninstall(){
		$this->load->model("extension/module/b5b_qore_engine");
		$this->model_extension_module_b5b_qore_engine->deleteSchema();

		// Disable all necessary XML files
		$vqmod_folder = substr(DIR_SYSTEM, 0, -7) . 'vqmod/xml/';

		// Get all QoreEngine and related files
		// $qore_engine_files = array(
		// 	// Add more files as QoreEngine grows
		// 	$vqmod_folder . 'b5b_qore_engine.xml'
		// 	);
		$qore_engine_files = glob($vqmod_folder . 'b5b_qore_engine*.xml');
		$qore_engine_additional_files = glob($vqmod_folder . 'zzzzzzzzzz_b5b_qore_engine*.xml');

		$files = array_merge($qore_engine_additional_files, $qore_engine_files);

		foreach($files as $file){
			rename($file, $file . '_');
		}
	}
}
