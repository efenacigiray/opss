<?php  
/* 
Version: 1.0
Author: Artur Sułkowski
Website: http://artursulkowski.pl
*/

class ControllerExtensionModuleBreadcrumbBackgroundImage extends Controller {
	public function index($setting) {
		if(isset($setting['block_content'][$this->config->get('config_language_id')])) {
			$data['block_content'] = html_entity_decode($setting['block_content'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		} else {
			$data['block_content'] = 'You must set block heading in the module Breadcrumb background image!';
		}
		$data['background_color'] = $setting['background_color'];
		$data['background_image'] = $setting['background_image'];
		$data['background_image_position'] = $setting['background_image_position'];
		$data['background_image_repeat'] = $setting['background_image_repeat'];
		
		return $this->load->view('extension/module/breadcrumb_background_image', $data);
	}
}
?>