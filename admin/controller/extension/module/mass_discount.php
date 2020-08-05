<?php
class ControllerExtensionModuleMassDiscount extends Controller {

	public function index() {   

		$this->load->language('extension/module/mass_discount');
		$this->load->model('mass_discount/mass_discount');
		$this->document->setTitle($this->language->get('heading_title_m'));
		$this->load->model('setting/setting');
		
		$this->load->model('customer/customer_group');
		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		
		$this->load->model('catalog/category');
				
		$data['categories'] = $this->model_catalog_category->getCategories(0);
		
		if (isset($this->request->post['product_category'])) {
			$data['product_category'] = $this->request->post['product_category'];
		} elseif (isset($product_info)) {
			$data['product_category'] = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		} else {
			$data['product_category'] = array();
		}		
			
		$this->load->model('catalog/manufacturer');
					
		$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers(0);
		
		if (isset($this->request->post['product_manufacturer'])) {
			$data['product_manufacturer'] = $this->request->post['product_manufacturer'];
		} elseif (isset($product_info)) {
			$data['product_manufacturer'] = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		} else {
			$data['product_manufacturer'] = array();
		}		
		
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
	
		
			$this->session->data['success'] = $this->language->get('text_success');		
			
			$cats = ((isset($this->request->post['product_category']))?implode(",",$this->request->post['product_category']):0);
            $manufacturers = ((isset($this->request->post['product_manufacturer']))?implode(",",$this->request->post['product_manufacturer']):0);
            
	
			$data = $this->model_mass_discount_mass_discount->updateDiscount($this->request->post['mass_discount_customer_group'],$this->request->post['mass_discount_rate'], $this->request->post['product_options'], $cats, $this->request->post['mass_discount_start_date'],$this->request->post['mass_discount_expires_date'],$manufacturers);
			
			$url='';
			
			if( isset( $this->request->post['mode'] ) && $this->request->post['mode'] == 'apply' ) {
				
				$this->response->redirect($this->url->link('extension/module/mass_discount', 'user_token=' . $this->session->data['user_token'] . $url, true));

			} else {
				
				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
	
			}
			
			
			
			
		}
		
		if( isset( $this->session->data['success'] ) ) {
			$data['success'] = $this->session->data['success'];
			unset( $this->session->data['success'] );
		}else{
			$data['success'] = '';
		}
		
		$text_strings = array(
				'heading_title',
				'heading_title_m',
				'text_enabled',
				'text_disabled',
				'entry_customer_group',
				'entry_status',
				'entry_discount_rate',
				'entry_discount_note',
				'entry_start_date',
				'entry_expires_date',
				'button_apply',
				'button_save',
				'button_cancel',
				'entry_category',
				'entry_manufacturer',
				'entry_options',
				'entry_options_evet',
				'entry_options_hayir',				
				'text_select_all',
				'text_unselect_all',
				'text_list'
		);

		
				
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}
				
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
			'text' => 'Modüller',
			'href' => $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/mass_discount', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['action'] = $this->url->link('extension/module/mass_discount', 'user_token=' . $this->session->data['user_token'], true);	
		$data['cancel'] = $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);



		$config_data = array(
				'mass_discount_customer_group',
				'mass_discount_status',
				'mass_discount_rate',
				'product_options',				
				'mass_discount_start_date',
				'mass_discount_expires_date'
		);
		
		foreach ($config_data as $conf) {
			if (isset($this->request->post[$conf])) {
				$data[$conf] = $this->request->post[$conf];
			} else {
				$data[$conf] = $this->config->get($conf);
			}
		}			
			$data['mass_discount_start_date'] = "0000-00-00";	
			$data['mass_discount_expires_date'] = "0000-00-00";	
			
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
	
        $this->config->set('template_engine', 'template');	
		$this->response->setOutput($this->load->view('module/mass_discount', $data));

	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/mass_discount')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>