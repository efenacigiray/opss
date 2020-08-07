<?php
class ControllerModuleQuickStatusUpdater extends Controller {
  const MODULE = 'quick_status_updater';
  const PREFIX = 'qosu';
  const MOD_FILE = 'quick_status_updater';
  
	private $error = array(); 
	private $api_token;
  private $token;
	
	public function __construct($registry) {
		parent::__construct($registry);
    
    $this->token = isset($this->session->data['user_token']) ? 'user_token='.$this->session->data['user_token'] : 'token='.$this->session->data['token'];
    
    if (version_compare(VERSION, '3', '>=')) {
      $this->load->language('extension/module/quick_status_updater');
    } else {
      $this->load->language('module/quick_status_updater');
    }
	}
	
	public function index() {
		$asset_path = 'view/quick_status_updater/';
    if (defined('_JEXEC') && version_compare(VERSION, '2', '>=')) {
      $asset_path = 'admin/' . $asset_path;
    }
    
		$data['_language'] = $this->language;
    $data['_img_path'] = $asset_path . 'img/';
		$data['_config'] = $this->config;
		$data['_url'] = $this->url;
		$data['token'] = $this->token;
		$data['OC_V2'] = version_compare(VERSION, '2', '>=');
		
    // check tables
		if (version_compare(VERSION, '2.3', '>=') && !$this->config->has('qosu_bg_mode')) {
      $this->install('redir');
    } else {
      $this->db_tables();
    }
    
		if (!version_compare(VERSION, '2', '>=')) {
			$this->document->addStyle($asset_path . 'awesome/css/font-awesome.min.css');
			$this->document->addStyle($asset_path . 'bootstrap.min.css');
			$this->document->addStyle($asset_path . 'bootstrap-theme.min.css');
			$this->document->addScript($asset_path . 'bootstrap.min.js');
		}

		$this->document->addScript($asset_path . 'itoggle.js');
		$this->document->addScript($asset_path . 'spectrum.js');
		$this->document->addScript($asset_path . 'sortable.min.js');
		$this->document->addStyle($asset_path . 'spectrum.css');
		$this->document->addStyle($asset_path . 'style.css');
		
		$this->document->setTitle(strip_tags($this->language->get('heading_title')));
		$this->load->model('setting/setting');
		
    // module checks
    $modification_active = true;
    
    if (!$modification_active) {
      $this->session->data['error'] = 'Module modification are not applied<br/>- if you installed ocmod version, go to extensions > modifications and push refresh button<br/>- if you installed vqmod version, make sure vqmod is correctly installed and working';
    }
    
		// get languages 
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
    
    foreach ($data['languages'] as &$language) {
      if (version_compare(VERSION, '2.2', '>=')) {
        $language['image'] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $language['image'] = 'view/image/flags/'. $language['image'];
      }
    }
    
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
      foreach ($this->request->post['qosu_order_statuses'] as $k => $v) {
        if (isset($v['color'])) {
          $this->request->post['qosu_order_statuses'][$k]['color'] = '#' . ltrim($v['color'], '#');
        }
      }
      
			$this->model_setting_setting->editSetting('qosu', $this->request->post);		
			$this->cache->delete('order_status.' . (int)$this->config->get('config_language_id'));
			$this->session->data['success'] = $this->language->get('text_success');
			
			if (version_compare(VERSION, '2', '>=')) {
				$this->response->redirect($this->url->link('module/quick_status_updater', $this->token, 'SSL'));
			} else {
				$this->redirect($this->url->link('module/quick_status_updater', $this->token, 'SSL'));
			}
		}
		
    // version check
    $module_xml = 'quick_status_updater';
    
		if (is_file(DIR_SYSTEM.'../vqmod/xml/'.$module_xml.'.xml')) {
			$data['module_version'] = simplexml_load_file(DIR_SYSTEM.'../vqmod/xml/'.$module_xml.'.xml')->version;
      $data['module_type'] = 'vqmod';
		} else if (is_file(DIR_SYSTEM.'../system/'.$module_xml.'.ocmod.xml')) {
      $data['module_version'] = simplexml_load_file(DIR_SYSTEM.'../system/'.$module_xml.'.ocmod.xml')->version;
      $data['module_type'] = 'ocmod';
		} else {
			$data['module_version'] = 'not found';
      $data['module_type'] = '';
		}
    
    if (is_file(DIR_SYSTEM.'../vqmod/xml/'.$module_xml.'.xml') && is_file(DIR_SYSTEM.'../system/'.$module_xml.'.ocmod.xml')) {
      $this->error['warning'] = 'Warning : both vqmod and ocmod version are installed<br/>- delete /vqmod/xml/'.$module_xml.'.xml if you want to use ocmod version<br/>- or delete /system/'.$module_xml.'.ocmod.xml if you want to use vqmod version';
    }
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else $data['success'] = '';
		
		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else $data['error'] = '';
		
		$data['heading_title'] = $this->language->get('module_title');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['token'] = $this->token;
		
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
        'text'      => $this->language->get('text_home'),
        'href'      => $this->url->link('common/home', $this->token, 'SSL'),
        'separator' => false
   		);

      if (version_compare(VERSION, '3', '>=')) {
        $extension_link = $this->url->link('marketplace/extension', 'type=module&' . $this->token, 'SSL');
      } else if (version_compare(VERSION, '2.3', '>=')) {
        $extension_link = $this->url->link('extension/extension', 'type=module&' . $this->token, 'SSL');
			} else {
        $extension_link = $this->url->link('extension/module', $this->token, 'SSL');
			}
      
      $data['breadcrumbs'][] = array(
       	'text'      => $this->language->get('text_module'),
        'href'      => $extension_link,
      	'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
        'text'      => strip_tags($this->language->get('heading_title')),
        'href'      => $this->url->link('module/quick_status_updater', $this->token, 'SSL'),
        'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('module/quick_status_updater', $this->token, 'SSL');
		$data['cancel'] = $extension_link;
		
		// tab 0
    if (isset($this->request->post['qosu_method'])) {
			$data['qosu_method'] = $this->request->post['qosu_method'];
		} else { 
			$data['qosu_method'] = $this->config->get('qosu_method');
		}
    
		if (isset($this->request->post['qosu_bg_mode'])) {
			$data['qosu_bg_mode'] = $this->request->post['qosu_bg_mode'];
		} else { 
			$data['qosu_bg_mode'] = $this->config->get('qosu_bg_mode');
		}
    
    if (isset($this->request->post['qosu_message_mode'])) {
			$data['qosu_message_mode'] = $this->request->post['qosu_message_mode'];
		} else { 
			$data['qosu_message_mode'] = $this->config->get('qosu_message_mode');
		}
    
    if (isset($this->request->post['qosu_notify'])) {
			$data['qosu_notify'] = $this->request->post['qosu_notify'];
		} else { 
			$data['qosu_notify'] = $this->config->get('qosu_notify');
		}
    
    if (isset($this->request->post['qosu_barcode'])) {
			$data['qosu_barcode'] = $this->request->post['qosu_barcode'];
		} else { 
			$data['qosu_barcode'] = $this->config->get('qosu_barcode');
		}
    
    if (isset($this->request->post['qosu_barcode_enabled'])) {
			$data['qosu_barcode_enabled'] = $this->request->post['qosu_barcode_enabled'];
		} else { 
			$data['qosu_barcode_enabled'] = $this->config->get('qosu_barcode_enabled');
		}
    
    if (isset($this->request->post['qosu_fraud_coupon_off'])) {
			$data['qosu_fraud_coupon_off'] = $this->request->post['qosu_fraud_coupon_off'];
		} else { 
			$data['qosu_fraud_coupon_off'] = $this->config->get('qosu_fraud_coupon_off');
		}
    
    if (isset($this->request->post['qosu_extra_info'])) {
			$data['qosu_extra_info'] = $this->request->post['qosu_extra_info'];
		} else { 
			$data['qosu_extra_info'] = $this->config->get('qosu_extra_info');
		}
		
		// tab 1
		$data['qosu_shipping'] = array();

		if (isset($this->request->post['qosu_shipping'])) {
			$data['qosu_shipping'] = $this->request->post['qosu_shipping'];
		} elseif ($this->config->get('qosu_shipping')) { 
			$data['qosu_shipping'] = $this->config->get('qosu_shipping');
		}
		
		// tab 2
		$this->load->model('localisation/order_status');
		$order_statuses = $this->model_localisation_order_status->getOrderStatuses(1); // avoid cache
		/* handled directly in model_localisation_order_status
		$qosu_os = $this->config->get('qosu_order_statuses');
		
		if ($qosu_os) {
			$data['order_statuses'] = array();
			
			foreach($order_statuses as &$s) {
				if (isset($qosu_os[$s['order_status_id']])) {
					$s = $s + $qosu_os[$s['order_status_id']];
				}
			}
			
			usort($order_statuses, array($this, 'cmp'));
		}
		*/
		$data['order_statuses'] = $order_statuses;
		
		// tab 3
		$data['qosu_inputs'] = array();

		if (isset($this->request->post['qosu_inputs'])) {
			$data['qosu_inputs'] = $this->request->post['qosu_inputs'];
		} elseif ($this->config->get('qosu_inputs')) { 
			$data['qosu_inputs'] = $this->config->get('qosu_inputs');
		}
    
    foreach ((array) $data['qosu_inputs'] as $input) {
      if (!empty($input['tag'])) {
        if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order` LIKE 'qosu_".$this->db->escape($input['tag'])."'")->row) {
          $this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `qosu_".$this->db->escape($input['tag'])."` VARCHAR(255) NULL DEFAULT ''");
        }
      }
    }
		
		if (version_compare(VERSION, '2', '>=')) {
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
      if (version_compare(VERSION, '3', '>=')) {
        $this->config->set('template_engine', 'template');
        $this->response->setOutput($this->load->view('module/quick_status_updater', $data));
      } else {
        $this->response->setOutput($this->load->view('module/quick_status_updater.tpl', $data));
      }
		} else {
			$data['column_left'] = '';
			$this->data = &$data;
			$this->template = 'module/quick_status_updater.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);
					
			$this->response->setOutput($this->render());
		}
	}
	
	public function multiple_form() {
		$data['_language'] = &$this->language;
		$data['_config'] = &$this->config;
		$data['_url'] = &$this->url;
		$data['token'] = $this->token;
    $data['OC_V2'] = version_compare(VERSION, '2', '>=');
		
		$this->load->language('module/quick_status_updater');
		
    // add server ip to api
    /* done uppon login
    if (version_compare(VERSION, '2.1', '>=')) {
      $this->load->model('user/api');
      $api_ips = $this->model_user_api->getApiIps($this->config->get('config_api_id'));
      
      $add_ip = true;
      
      foreach ($api_ips as $api_ip) {
        if ($api_ip['ip'] == $_SERVER['SERVER_ADDR']) {
          $add_ip = false;
        }
      }
      
      if ($add_ip) {
        $this->model_user_api->addApiIp($this->config->get('config_api_id'), $_SERVER['SERVER_ADDR']);
      }
    }
    */
      
		$data['qosu_os'] = $qosu_os = $this->config->get('qosu_order_statuses');
		
		if (isset($this->request->get['selected'])) {
			$order_ids = array_unique($this->request->get['selected']);
		} else {
			$order_ids = array_unique($this->request->post['selected']);
		}
    
    $data['tracking_numbers'] = array();
    $data['tracking_carriers'] = array();
    
    // if (isset($this->request->post['tracking'])) {
			// $data['tracking_numbers'] = $this->request->post['tracking'];
		// }
		
		$this->load->model('sale/order');
    
    $data['order_ids'] = array();
    
		foreach ($order_ids as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);
      
			if ($order_info) {
        $order_info['total_rounded'] = (string) round($order_info['total']);
        $order_info['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);
        
        $data['tracking_numbers'][$order_id] = !empty($order_info['tracking_no']) ? $order_info['tracking_no'] : '';
        $data['tracking_carriers'][$order_id] = !empty($order_info['tracking_carrier']) ? $order_info['tracking_carrier'] : '';
        
        $data['order_ids'][] = $order_id;
        
				$data['order_langs'][$order_info['language_id']] = $order_info['language_id'];
				
				if (!isset($data['next_status'])) {
          if (isset($data['qosu_os'][ $order_info['order_status_id'] ])) {
            $data['next_status'] = $data['qosu_os'][ $order_info['order_status_id'] ]['next_status'];
          } else {
            $data['next_status'] = 0;
          }
				}
      
        if ($this->config->get('qosu_extra_info')) {
          $data['extra_info'][$order_id] = html_entity_decode($this->config->get('qosu_extra_info'));
          
          // get products
          if (strpos($data['extra_info'][$order_id], '{products}') !== false) {
             $products = $this->model_sale_order->getOrderProducts($order_id);
             $order_info['products'] = '<br/>';
             foreach ($products as $product) {
               $order_info['products'] .= $product['quantity'].'x '. $product['name'].'<br/>';
             }
          }
          
          // fill customer name in case of guest checkout
          if (empty($order_info['customer'])) {
            $order_info['customer'] = $order_info['firstname'] . ' ' . $order_info['lastname'];
          }
          
          foreach ($order_info as $k => $v) {
            $data['extra_info'][$order_id] = str_replace('{'.$k.'}', is_string($v) ? $v : '', $data['extra_info'][$order_id]);
          }
        }
        
        if ($this->config->get('qosu_inputs')) {
          foreach ($this->config->get('qosu_inputs') as $qosu_input) {
            $data['qosu_inputs_values'][$qosu_input['tag']] = (!empty($order_info['qosu_'.$qosu_input['tag']])) ? $order_info['qosu_'.$qosu_input['tag']] : '';
          }
        }
			}
		}
    
    if (!count($data['order_ids'])) {
      echo '<div class="modal-dialog"><div class="modal-content"><div class="modal-body" id="quick-status-dialog">' . $this->language->get('text_qosu_unknown') . implode(', ',  $order_ids) . '</div></div></div>';
      die;
    }
		
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		// language vars
		$data['text_qosu_add_history'] = $this->language->get('text_qosu_add_history');
		$data['text_qosu_dialog_title'] = $this->language->get('text_qosu_dialog_title');
		$data['text_qosu_tracking_number'] = $this->language->get('text_qosu_tracking_number');
		$data['text_qosu_select_checkbox'] = $this->language->get('text_qosu_select_checkbox');
		$data['text_qosu_order_status'] = $this->language->get('text_qosu_order_status');
		$data['text_qosu_order_id'] = $this->language->get('text_qosu_order_id');
		$data['text_qosu_notify'] = $this->language->get('text_qosu_notify');
		$data['text_qosu_comment'] = $this->language->get('text_qosu_comment');
			
    if (version_compare(VERSION, '3', '>=')) {
      $this->config->set('template_engine', 'template');
      $this->response->setOutput($this->load->view('module/quick_status_updater_form', $data));
		} else if (version_compare(VERSION, '2', '>=')) {
      $this->response->setOutput($this->load->view('module/quick_status_updater_form.tpl', $data));
		} else {
			$this->data = &$data;
			$this->template = 'module/quick_status_updater_form.tpl';
			
			$this->response->setOutput($this->render());
		}
	}
	
	public function update_status() {
		$this->language->load('sale/order');
		$this->load->model('sale/order');
		
    if ($this->config->get('config_maintenance') && version_compare(VERSION, '2.0.3', '<')) {
      echo json_encode(array('error' => '<div class="alert alert-warning"><i class="fa fa-danger"></i> Maintenance mode is active, order modification is not possible during maintenance</div>'));
      die;
    }
    
    $this->load->model('tool/quick_status_updater');
      
    $api_token = '';
    
    if ($this->config->get('qosu_method') == 'api' && version_compare(VERSION, '2', '>=')) {
      // API login
      if (true) {
      //if (!version_compare(VERSION, '2.1', '>=')) {
        $this->load->model('user/api');

        $api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

        if ($api_info) {
          $curl = curl_init();

          // Set SSL if required
          if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
            curl_setopt($curl, CURLOPT_PORT, 443);
          }

          curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_CACHE.'qosu_api');
          curl_setopt($curl, CURLOPT_HEADER, false);
          curl_setopt($curl, CURLINFO_HEADER_OUT, true);
          curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          if (defined('_JEXEC')) {
            curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG . 'index.php?option=com_mijoshop&format=raw&route=api/login');
          } else {
            curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG . 'index.php?route=api/login');
          }
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($api_info));

          $json = curl_exec($curl);
          
          if (!$json) {
            echo json_encode(array('error' => '<div class="alert alert-warning"><i class="fa fa-danger"></i> ' . sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl)) . '</div>'));
            die;
          } else {
            $response = json_decode($json, true);

            if (isset($response['error'])) {
              if (isset($response['error']['ip'])) {
                preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $response['error']['ip'], $ip_detect);
                
                // add server ip to api
                if (!empty($ip_detect[0])) {
                  $this->load->model('user/api');
                  $this->model_user_api->addApiIp($this->config->get('config_api_id'), $ip_detect[0]);
                  
                  echo json_encode(array('error' => '<div class="alert alert-success"><i class="fa fa-check"></i> First init: API is now initialized, please click again to proceed</div>')); die;
                }
              }
              
              if (is_array($response['error'])) {
                $errors = implode('<br/>', $response['error']);
              } else {
                $errors = $response['error'];
              }
              
              echo json_encode(array('error' => '<div class="alert alert-warning"><i class="fa fa-danger"></i> ' . $errors . '</div>')); die;
            }
            
            if (isset($response['cookie'])) {
              $api_token = $response['cookie'];
            }
            
            if (isset($response['token'])) {
              //$this->session->data['cookie'] = $response['token'];
              $api_token = $response['token'];
            }
            
            curl_close($curl);
          }
        }
        // end - API login
        /*
        if (!isset($this->session->data['cookie'])) {
          echo json_encode(array('error' => '<div class="alert alert-danger"><i class="fa fa-danger"></i> Error: API cookie not set, please make sure API is active (System > Users > API)</div>'));
          die;
        }
        */
      }
    }
    
		$data = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', 'sale/order') && $this->user->getUserName() !== 'demo') {
				$data['error'] = $this->language->get('error_permission');
			}

			if (!isset($data['error'])) {
				$post_data =  $this->request->post;
				
        if (!isset($post_data['override'])) {
          $post_data['override'] = '';
        }
        
				$data['order_id'] = $this->request->post['order_id'];
        
				foreach ($this->request->post['order_id'] as $order_id) {
					$order_info = $this->model_sale_order->getOrder($order_id);
					
          $order_info['total_rounded'] = (string) round($order_info['total']);
          $order_info['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);
          
					// handle multiple vars
					$post_data['comment'] = $this->request->post['comment'][$order_info['language_id']];
					if (isset($this->request->post['shipping_method'][$order_id])) {
						$post_data['shipping_method'] = $this->request->post['shipping_method'][$order_id];
					}
					if (isset($this->request->post['tracking_no'][$order_id])) {
						$post_data['tracking_no'] = $this->request->post['tracking_no'][$order_id];
					}
					
          // tag replacement
          if ($this->config->get('ordIdMan_rand_ord_num') && !empty($order_info['order_id_user'])) {
            $order_info['order_id'] = $order_info['order_id_user'];
          }
          
          $post_data['comment'] = str_replace('{store_phone}', $this->config->get('config_telephone'), $post_data['comment']);
          $post_data['comment'] = str_replace('{store_email}', $this->config->get('config_email'), $post_data['comment']);
          
					// custom inputs
					if (isset($post_data['custom_inputs'])) {
						foreach($post_data['custom_inputs'] as $k => $v) {              
              $post_data['comment'] = str_replace('{'.$k.'}', $v, $post_data['comment']);
              
              if ($v) {
                $post_data['comment'] = str_replace(array('{if_'.$k.'}', '{/if_'.$k.'}'), '', $post_data['comment']);
              } else {
                $post_data['comment'] = preg_replace('/{if_'.$k.'}(.*){\/if_'.$k.'}/isU', '', $post_data['comment']);
              }
              
              $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `qosu_".$this->db->escape($k)."` = '" . $this->db->escape($v) . "' WHERE order_id = '" . (int)$order_id . "'");
						}
					}
					
					// tracking number
					$qosu_shipping = $this->config->get('qosu_shipping');
          $tracking_url = '';
					if (isset($post_data['shipping_method']) && isset($qosu_shipping[$post_data['shipping_method']])) {
            $order_info['tracking_title'] = $qosu_shipping[$post_data['shipping_method']]['title'];
            $order_info['tracking_carrier'] = $qosu_shipping[$post_data['shipping_method']]['title'];
            $tracking_url = $qosu_shipping[$post_data['shipping_method']]['url'];
					}

					// fill customer name in case of guest checkout
          if (empty($order_info['customer'])) {
            $order_info['customer'] = $order_info['firstname'] . ' ' . $order_info['lastname'];
          }
					
          if (strpos($tracking_url, '{lang}') !== false || strpos($tracking_url, '{LANG}') !== false) {
            $this->load->model('localisation/language');
            $lang = $this->model_localisation_language->getLanguage($order_info['language_id']);
            
            $order_info['lang'] = strtolower($lang['code']);
            $order_info['LANG'] = strtoupper($lang['code']);
          }
          
          if (strpos($tracking_url.$post_data['comment'], '{shipping_postcode_uk}') !== false) {
            $ukpostcode = strtoupper(preg_replace("/[^A-Za-z0-9]/", '', $order_info['shipping_postcode']));
         
            if(strlen($ukpostcode) == 5) {
              $ukpostcode = substr($ukpostcode,0,2).' '.substr($ukpostcode,2,3);
            } elseif(strlen($ukpostcode) == 6) {
              $ukpostcode = substr($ukpostcode,0,3).' '.substr($ukpostcode,3,3);
            } elseif(strlen($ukpostcode) == 7) {
              $ukpostcode = substr($ukpostcode,0,4).' '.substr($ukpostcode,4,3);
            }
            
            $order_info['shipping_postcode_uk'] = $ukpostcode;
          }
          
          foreach ($order_info as $k => $v) {
            if (!in_array($k, array('tracking_no', 'tracking_url'))) {
              $post_data['comment'] = str_replace('{'.$k.'}', is_string($v) ? $v : '', $post_data['comment']);
              $tracking_url = str_replace('{'.$k.'}', is_string($v) ? $v : '', $tracking_url);
            }
          }
          
          
					if (isset($post_data['tracking_no']) && $post_data['tracking_no']) {
            $post_data['comment'] = str_replace(array('{if_tracking}', '{/if_tracking}'), '', $post_data['comment']);
						$post_data['comment'] = str_replace('{tracking_no}', $post_data['tracking_no'], $post_data['comment']);

            $tracking_url = str_replace('{tracking_no}', $post_data['tracking_no'], $tracking_url);
            
            $tracking_url = str_replace(array('&amp;', ' '), array('&', '%20'), $tracking_url);
            
            $post_data['comment'] = str_replace('{tracking_url}', $tracking_url, $post_data['comment']);
            
            // save tracking url
            /*
            if (strpos($tracking_url, '{tracking_no}') !== false) {
              $tracking_url = str_replace('{tracking_no}', $post_data['tracking_no'], $tracking_url);
            } else {
              $tracking_url .= $post_data['tracking_no'];
            }
            */
            
            if ($tracking_url) {
              $data['tracking_no'][$order_id] = '<a href="'.$tracking_url.'">' . $post_data['tracking_no'] . '</a>';
              $this->db->query("UPDATE `" . DB_PREFIX . "order` SET tracking_carrier = '" . $this->db->escape($order_info['tracking_carrier']) . "', tracking_no = '" . $this->db->escape($post_data['tracking_no']) . "', tracking_url = '" . $this->db->escape($tracking_url) . "' WHERE order_id = '" . (int)$order_id . "'");
            }
					} else {
            $post_data['comment'] = preg_replace('/{if_tracking}(.*){\/if_tracking}/isU', '', $post_data['comment']);
					}
          
          $post_data['comment'] = html_entity_decode($post_data['comment']);
          
          if (version_compare(VERSION, '2', '>=')) {
            if ($this->config->get('qosu_method') == 'api') {
              $res = $this->api('api/order/history&order_id='.$order_id.'&store_id='.$order_info['store_id'], $post_data, $api_token);
            } else {
              $this->model_tool_quick_status_updater->addOrderHistory($order_id, $post_data['order_status_id'], $post_data['comment'], $post_data['notify'], $post_data['override']);
            }
          } else {
            $this->model_sale_order->addOrderHistory($order_id, $post_data);
          }

					$data['success'] = $this->language->get('text_success');
				}
			
        $data['bg_mode'] = $this->config->get('qosu_bg_mode');
        $qosu_os = $this->config->get('qosu_order_statuses');
        if (isset($qosu_os[$post_data['order_status_id']]['color']) && $qosu_os[$post_data['order_status_id']]['color'] != '000000') {
          $data['color'] = $qosu_os[$post_data['order_status_id']]['color'];
        } else {
          $data['color'] = false;
        }
			}
		}
		
		echo json_encode($data);
		die;
	}
	
  public function getNotifyStatus() {
    $qosu_os = $this->config->get('qosu_order_statuses');
    
    echo !empty($qosu_os[$this->request->get['status_id']]['notify']) ? '1' : '';
    
    die;
	}
  
	public function getDefaultComment() {
		$qosu_os = $this->config->get('qosu_order_statuses');
    
    if (isset($qosu_os[$this->request->get['status_id']]['description'])) {
      if (is_array($qosu_os[$this->request->get['status_id']]['description'])) {
        foreach ($qosu_os[$this->request->get['status_id']]['description'] as $lang_id => $desc) {
          if (strpos($desc, '{user') !== false) {
            $replace = array();
            
            $this->load->model('user/user');
            
            $user_info = $this->model_user_user->getUser($this->user->getId());
            
            $replace['{user}'] = $user_info['firstname'] . ' ' . $user_info['lastname'];
            $replace['{user_firstname}'] = $user_info['firstname'];
            $replace['{user_lastname}'] = $user_info['lastname'];
            
            $qosu_os[$this->request->get['status_id']]['description'][$lang_id] = str_replace(array_keys($replace), $replace, $desc);
          }
        }
      }
      
      echo json_encode($qosu_os[$this->request->get['status_id']]['description']);
    }
		die;
		
		$this->load->model('sale/order');
		$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
		if ($order_info) {
			if (isset($qosu_os[$this->request->get['status_id']]['description'][$order_info['language_id']]))
				echo $qosu_os[$this->request->get['status_id']]['description'][$order_info['language_id']];
		} else {
			if (isset($qosu_os[$this->request->get['status_id']]['description'][$this->config->get('config_language_id')]))
				echo $qosu_os[$this->request->get['status_id']]['description'][$this->config->get('config_language_id')];
		}
		die;
	}
  
  public function api($url, $post_data = array(), $api_token = '') {
		$json = array();

		// Store
		if (isset($this->request->get['store_id'])) {
			$store_id = $this->request->get['store_id'];
		} else {
			$store_id = 0;
		}

		$this->load->model('setting/store');

		$store_info = $this->model_setting_store->getStore($store_id);

		if ($store_info) {
			$base_url = $store_info['ssl'];
		} else {
			$base_url = HTTPS_CATALOG;
		}

		if (!empty($this->request->get['api_key']) || !empty($api_token)) {
			// Include any URL perameters
			$curl = curl_init();

			if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
				curl_setopt($curl, CURLOPT_PORT, 443);
			}

			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLINFO_HEADER_OUT, true);
			curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      
      curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_CACHE.'qosu_api');
      
      if (!empty($this->request->get['api_key'])) {
        curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG . 'index.php?route=' . $url . '&api_key=' . $this->request->get['api_key']. '&token=' . $api_token);
      } else if (version_compare(VERSION, '2', '>=')) {
        curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG . 'index.php?route=' . $url. '&token=' . $api_token);
        
        /*
        if (defined('_JEXEC')) {
          curl_setopt($curl, CURLOPT_COOKIE, $this->session->data['cookie']['name'].'=' . $this->session->data['cookie']['id'] . ';');
        } else {
          curl_setopt($curl, CURLOPT_COOKIE, session_name() . '=' . $this->session->data['cookie'] . ';');
        }
        */
      }
      
			if ($post_data) {
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
			}
      
			$json = curl_exec($curl);
			curl_close($curl);
      
      if (!$json) {
        echo json_encode(array('error' => '<div class="alert alert-danger"><i class="fa fa-danger"></i> ' . sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl)) . '</div>'));
        die;
      }
      
      $res = json_decode($json);
      
      if (!$res) {
        echo json_encode(array('error' => '<div class="alert alert-danger"><i class="fa fa-danger"></i> ' . $json . '</div>'));
        die;
      }
      
      if (!empty($res->error)) {
        echo json_encode(array('error' => '<div class="alert alert-danger"><i class="fa fa-danger"></i> ' . $res->error . '</div>'));
        die;
      }

		} else {
      echo json_encode(array('error' => '<div class="alert alert-danger"><i class="fa fa-danger"></i> Error API key not found.</div>'));
      die;
    }

		return $json;
	}
	
	public function modal_info() {
    $item = $this->request->post['info'];
    
    $extra_class = $this->language->get('info_css_' . $item) != 'info_css_' . $item ? $this->language->get('info_css_' . $item) : 'modal-lg';
    $title = $this->language->get('info_title_' . $item) != 'info_title_' . $item ? $this->language->get('info_title_' . $item) : $this->language->get('info_title_default');
    $message = $this->language->get('info_msg_' . $item) != 'info_msg_' . $item? $this->language->get('info_msg_' . $item) : $this->language->get('info_msg_default');
    
    if ($item == 'tags_full') {
      $title = $this->language->get('info_title_tags');
      $message = $this->language->get('info_msg_tags_spec') . $this->language->get('info_msg_tags');
    } elseif ($item == 'extra_info') {
      $message .= $this->language->get('info_msg_tags');
    }
      
    echo '<div class="modal-dialog ' . $extra_class . '">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-info-circle"></i> ' . $title . '</h4>
        </div>
        <div class="modal-body">' . $message . '</div>
      </div>
    </div>';
    
    die;
	}
  
  public function edit_custom_field() {
    $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `qosu_".$this->db->escape($this->request->get['field'])."` = '" . $this->db->escape($this->request->get['val']) . "' WHERE order_id = '" . (int)$this->request->get['order_id'] . "'");
    exit;
  }
  
  private function cmp($a, $b) {
		if ($a['sort_order'] == $b['sort_order']) return 0;
		return ($a['sort_order'] < $b['sort_order']) ? -1 : 1;
	}
	
	public function install($redir = false) {
    // rights
    $this->load->model('user/user_group');

    $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'access', 'module/' . self::MODULE);
    $this->model_user_user_group->addPermission(version_compare(VERSION, '2.0.2', '>=') ? $this->user->getGroupId() : 1, 'modify', 'module/' . self::MODULE);
    
    // tables
		$this->db_tables();
    
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('qosu', array(
				'qosu_notify' => true,
				'qosu_bg_mode' => '',
			));

		$this->load->model('user/user_group');
		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'module/quick_status_updater');
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'module/quick_status_updater');
		
		if ($redir || !empty($this->request->get['redir'])) {
      if (version_compare(VERSION, '2', '>=')) {
				$this->response->redirect($this->url->link('module/'.self::MODULE, $this->token, 'SSL'));
			} else {
				$this->redirect($this->url->link('module/'.self::MODULE, $this->token, 'SSL'));
			}
    }
	}
	
	public function uninstall() {}
	
  private function db_tables() {
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order` LIKE 'tracking_carrier'")->row)
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `tracking_carrier` VARCHAR(48)");
		if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order` LIKE 'tracking_no'")->row)
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `tracking_no` VARCHAR(48)");
    if (!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order` LIKE 'tracking_url'")->row)
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `tracking_url` VARCHAR(256)");
	}
  
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/quick_status_updater')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error)
			return true;
		return false;
	}
}
?>