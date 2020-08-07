<?php
class ControllerCommonSecurity extends Controller {
	public function index() {
		$this->load->language('common/security');

		$data['text_instruction'] = $this->language->get('text_instruction');
	
		$data['user_token'] = $this->session->data['user_token'];
		
		$data['storage'] = DIR_SYSTEM . 'storage/';
		
		$path = '';
		
		$data['paths'] = array();
		
		$parts = explode('/', str_replace('\\', '/', rtrim(DIR_SYSTEM, '/')));	
		
		foreach ($parts as $part) {
			$path .= $part . '/';
			
			$data['paths'][] = $path;
		}
		
		rsort($data['paths']);	
			
		$data['document_root'] = str_replace('\\', '/', realpath($this->request->server['DOCUMENT_ROOT'] . '/../') . '/');


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
				
		return $this->load->view('common/security', $data);
	}
	
	public function move() {
		$this->load->language('common/security');

		$json = array();
		
		if ($this->request->post['path']) {
			$path = $this->request->post['path'];
		} else {
			$path = '';
		}
				
		if ($this->request->post['directory']) {
			$directory = $this->request->post['directory'];
		} else {
			$directory = '';
		}
		
		if (!$this->user->hasPermission('modify', 'common/developer')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			if (DIR_STORAGE != DIR_SYSTEM . 'storage/') {
				$data['error'] = $this->language->get('error_path');		
			}
			
			if (!$path || str_replace('\\', '/', realpath($path)) . '/' != str_replace('\\', '/', substr(DIR_SYSTEM, 0, strlen($path)))) {
				$json['error'] = $this->language->get('error_path');
			}
					
			if (!$directory || !preg_match('/^[a-zA-Z0-9_-]+$/', $directory)) {
				$json['error'] = $this->language->get('error_directory');
			}
						
			if (is_dir($path . $directory)) {
				$json['error'] = $this->language->get('error_exists');
			}
			
			if (!is_writable(realpath(DIR_APPLICATION . '/../') . '/config.php') || !is_writable(DIR_APPLICATION . 'config.php')) {
				$json['error'] = $this->language->get('error_writable');
			}
									
			if (!$json) {
				$files = array();
	
				// Make path into an array
				$source = array(DIR_SYSTEM . 'storage/');
	
				// While the path array is still populated keep looping through
				while (count($source) != 0) {
					$next = array_shift($source);
	
					foreach (glob($next) as $file) {
						// If directory add to path array
						if (is_dir($file)) {
							$source[] = $file . '/*';
						}
	
						// Add the file to the files to be deleted array
						$files[] = $file;
					}
				}
	
				// Create the new storage folder
				if (!is_dir($path . $directory)) {
					mkdir($path . $directory, 0777);
				}			
	
				// Copy the 
				foreach ($files as $file) {
					$destination = $path . $directory . substr($file, strlen(DIR_SYSTEM . 'storage/'));
					
					if (is_dir($file) && !is_dir($destination)) {
						mkdir($destination, 0777);
					}
									
					if (is_file($file)) {
						copy($file, $destination);
					}
				}
				
				// Modify the config files
				$files = array(
					DIR_APPLICATION . 'config.php',
					realpath(DIR_APPLICATION . '/../') . '/config.php'
				);
							
				foreach ($files as $file) {
					$output = '';
					
					$lines = file($file);
					
					foreach ($lines as $line_id => $line) {
						if (strpos($line, 'define(\'DIR_STORAGE') !== false) {
							$output .= 'define(\'DIR_STORAGE\', \'' . $path . $directory . '/\');' . "\n";
						} else {
							$output .= $line;
						}
					}
		
					$file = fopen($file, 'w');
		
					fwrite($file, $output);
		
					fclose($file);
				}
				
				$json['success'] = $this->language->get('text_success');
			}
		}
			
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));		
	}
}
