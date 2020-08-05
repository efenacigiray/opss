<?php
class ControllerExtensionModuleBulkSpecial extends Controller {
	private $error = array();
	private $extension_id = 'bulk_special';
	private $route = 'extension/module';

	public function index() {
		if(version_compare(VERSION, '2.3.0.0') < 0 ) {
			$this->route = 'module';
		}

		$this->language->load($this->route.'/'.$this->extension_id);
		$this->load->model($this->extension_id.'/'.$this->extension_id);


		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = $this->language->get('heading_title');
		
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['text_all'] = $this->language->get('text_all');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_discount_type'] = $this->language->get('entry_discount_type');
		$data['text_pecentage'] = $this->language->get('text_pecentage');
		$data['text_minus'] = $this->language->get('text_minus');
		$data['entry_product_name'] = $this->language->get('entry_product_name');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_dicount_value'] = $this->language->get('entry_dicount_value');
		$data['button_special_add'] = $this->language->get('button_special_add');
		$data['text_add_individual'] = $this->language->get('text_add_individual');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['text_help_delete'] = $this->language->get('text_help_delete');
		$data['text_help_autocomplete'] = $this->language->get('text_help_autocomplete');
		$data['entry_price_start'] = $this->language->get('entry_price_start');
		$data['entry_price_end'] = $this->language->get('entry_price_end');
		$data['text_price_range'] = $this->language->get('text_price_range');
		$data['text_help_price_range'] = $this->language->get('text_help_price_range');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['entry_discount_previous'] = $this->language->get('entry_discount_previous');


		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if ($this->request->server['REQUEST_METHOD'] == 'POST' AND $this->validate()) {
			
			$this->model_bulk_special_bulk_special->addSpecial($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if(version_compare(VERSION, '2.3.0.0') < 0 ) {
				$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'] , 'SSL'));
			} else {
				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token']. '&type=module' , 'SSL'));
			}
			
		}
	
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['bulk_special_price'])) {
			$data['error_bulk_special_price'] = $this->error['bulk_special_price'];
		} else {
			$data['error_bulk_special_price'] = '';
		}
		

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/'.$this->extension_id, 'user_token=' . $this->session->data['user_token'] , 'SSL')
		);

		$data['action'] = $this->url->link($this->route.'/'.$this->extension_id, 'user_token=' . $this->session->data['user_token'] , 'SSL');
		
		if(version_compare(VERSION, '2.3.0.0') < 0 ) {
			$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'] , 'SSL');
			$data['action_individual'] = $this->url->link('extension/bulk_special/add_individual', 'token=' . $this->session->data['token'] , 'SSL');
		} else {
			$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
			$data['action_individual'] = $this->url->link($this->route.'/'.$this->extension_id.'/add_individual', 'user_token=' . $this->session->data['user_token'] , 'SSL');
		}

		$data['categories'] = array();
		$data['manufacturers'] = array();

		$data['categories'] = $this->model_bulk_special_bulk_special->getCategories();
		$data['manufacturers'] = $this->model_bulk_special_bulk_special->getManufacturers();
		
		
		if (isset($this->request->post['bulk_special_cutomer_group'])) {
			$data['bulk_special_cutomer_group'] = $this->request->post['bulk_special_cutomer_group'];
		}  else {
			$data['bulk_special_cutomer_group'] = 1;
		}

		if (isset($this->request->post['bulk_special_category'])) {
			$data['bulk_special_category'] = $this->request->post['bulk_special_category'];
		}  else {
			$data['bulk_special_category'] = 0;
		}

		if (isset($this->request->post['bulk_special_manufacturer'])) {
			$data['bulk_special_manufacturer'] = $this->request->post['bulk_special_manufacturer'];
		}  else {
			$data['bulk_special_manufacturer'] = 0;
		}

		if (isset($this->request->post['bulk_special_price'])) {
			$data['bulk_special_price'] = $this->request->post['bulk_special_price'];
		}  else {
			$data['bulk_special_price'] = '';
		}

		if (isset($this->request->post['bulk_special_date_end'])) {
			$data['bulk_special_date_end'] = $this->request->post['bulk_special_date_end'];
		}  else {
			$data['bulk_special_date_end'] = '';
		}

		if (isset($this->request->post['bulk_special_date_start'])) {
			$data['bulk_special_date_start'] = $this->request->post['bulk_special_date_start'];
		}  else {
			$data['bulk_special_date_start'] = '';
		}

		if (isset($this->request->post['bulk_special_discount_type'])) {
			$data['bulk_special_discount_type'] = $this->request->post['bulk_special_discount_type'];
		}  else {
			$data['bulk_special_discount_type'] = '';
		}

		if (isset($this->request->post['bulk_special_price_start'])) {
			$data['bulk_special_price_start'] = $this->request->post['bulk_special_price_start'];
		}  else {
			$data['bulk_special_price_start'] = '';
		}

		if (isset($this->request->post['bulk_special_price_end'])) {
			$data['bulk_special_price_end'] = $this->request->post['bulk_special_price_end'];
		}  else {
			$data['bulk_special_price_end'] = '';
		}

		if (isset($this->request->post['bulk_special_discount_previous'])) {
			$data['bulk_special_discount_previous'] = $this->request->post['bulk_special_discount_previous'];
		}  else {
			$data['bulk_special_discount_previous'] = '';
		}
		
		$data['token'] = $this->session->data['user_token'];

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (VERSION < 2.1) {
			$this->load->model('sale/customer_group');

			$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		} else {
			$this->load->model('customer/customer_group');

			$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		}


		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

      if (version_compare(VERSION, '3', '>=')) {
        $this->config->set('template_engine', 'template');
        $this->response->setOutput($this->load->view($this->route.'/'.$this->extension_id, $data));
      } else {
		$this->response->setOutput($this->load->view($this->route.'/'.$this->extension_id.'tpl', $data));
      }		

	}

	public function autocomplete() {
		$json = array();
		$this->load->model('bulk_special/bulk_special');
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('catalog/product');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
			);

			$results = $this->model_bulk_special_bulk_special->getProducts($filter_data);
		
			foreach ($results as $result) {
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'price'      => $result['price']
				);
			}

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function add_individual() {
		if(version_compare(VERSION, '2.3.0.0') < 0 ) {
			$this->route = 'module';
		}

		$this->load->model($this->extension_id.'/'.$this->extension_id);
		$this->language->load($this->route.'/'.$this->extension_id);
		$json = array();
		
		if($this->request->server['REQUEST_METHOD'] != 'POST' OR  empty($this->request->post)) {
			$json['error'] = $this->language->get('error_form_empty');
		}
		
		if (!$this->validate()) {
			if (isset($this->error['warning'])) {
				$json['error'] = $this->error['warning'];
			}	
			if(isset($this->error['delete_empty_products'])) {
				$json['error'] = $this->error['delete_empty_products'];
			}
			if(isset($this->error['bulk_special_price'])) {
				$json['error'] = $this->error['bulk_special_price'];
			}
		}

		if ( !$json ) {
			$this->model_bulk_special_bulk_special->addIndividualSpecial($this->request->post);
			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', $this->route.'/'.$this->extension_id)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		if(isset($this->request->post['bulk_special_price'])) {
			if ((utf8_strlen($this->request->post['bulk_special_price']) < 1) || (utf8_strlen($this->request->post['bulk_special_price']) > 64) || !is_numeric($this->request->post['bulk_special_price'])) {
				$this->error['bulk_special_price'] = $this->language->get('error_bulk_special_price');
			}
		}

		if(isset($this->request->post['product_special'])) {
			foreach ($this->request->post['product_special'] as $key => $product_special) {
				if ((utf8_strlen($product_special['product_name']) < 1) || (utf8_strlen($product_special['product_name']) > 64)) {
					$this->error['delete_empty_products'] = $this->language->get('error_delete_empty_products');
					break;
				}
				if ((utf8_strlen($product_special['bulk_special_price']) < 1) || (utf8_strlen($product_special['bulk_special_price']) > 64) || !is_numeric($product_special['bulk_special_price'])) {
					$this->error['bulk_special_price'] = $this->language->get('error_bulk_special_price');
					break;
				}
			}
		}
		

		return !$this->error;
	}

	public function install() {
		// This field is creating for SAFEFY PURPOSE. In any case of fault, we can check which Special price is added using this exention.
		$db_check = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_special` LIKE 'bulk_special'");
        if (!$db_check->num_rows) {
            $this->db->query("ALTER TABLE  `".DB_PREFIX."product_special` ADD  `bulk_special` TINYINT NOT NULL");
        }
	}

	public function uninstall() {

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE bulk_special = 1");

		$db_check = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "product_special` LIKE 'bulk_special'");
		if ($db_check->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_special` DROP `bulk_special`") ;
		}
	}
}
