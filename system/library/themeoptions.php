<?php
/* 
Version: 1.0
Author: Artur SuÅkowski
Website: http://artursulkowski.pl
*/

if(!defined('HTTP_CATALOG')) $config->set('product_tabs', unserialize(file_get_contents('admin/controller/extension/module/product_tabs.json')));

class ThemeOptions {
	private $data = array();
	private $registry = array();
	private $loader = array();
	
	public function __construct($registry, $loader) {
		$this->data['registry'] = $registry;
		$this->data['loader'] = $loader;
	}
	
  	public function get($key, $array1 = '', $array2 = '', $array3 = '') {
  	     if(empty($data)) {
  	            $registry = $this->data['registry'];
  	            $config = $registry->get('config');
  	            
  	            $template = $config->get('theme_' . $config->get('config_theme') . '_directory');
  	            $skin = $config->get( $config->get('theme_' . $config->get('config_theme') . '_directory') . '_skin'  );
  	            $store = 'default';
  	            if($config->get( 'config_store_id' ) == 0) { 
  	            	$store = 'default';
  	            } else {
  	            	$store = $config->get( 'config_store_id' );
  	            }
  	            
  	            if(file_exists(DIR_TEMPLATE.$template.'/skins/store_'.$store.'/'.$skin.'/settings.json')) {
  	            	$template = json_decode(file_get_contents(DIR_TEMPLATE.$template.'/skins/store_'.$store.'/'.$skin.'/settings.json'), true);
  	            	foreach ($template as $option => $value) { 
  	            		$this->data[$option] = $value;
  	            	}
  	            }
  	            $this->data['store'] = $store;
  	            $this->data['skin']  = $skin;
  	     }
  	     
  		if($key == 'payment') {
  			if(isset($this->data[$key])) {
				usort($this->data[$key], "cmp_by_optionNumber");
	  			return $this->data[$key];
  			}
  			return null;
  		} else {
	  		if($array1 != '' && $array2 != '' && $array3 != '') {
	  			return (isset($this->data[$key][$array1][$array2][$array3]) ? $this->data[$key][$array1][$array2][$array3] : null);
	  		} elseif($array1 != '' && $array2 != '') {
	    		return (isset($this->data[$key][$array1][$array2]) ? $this->data[$key][$array1][$array2] : null);
	    	} elseif($array1 != '') {
	    		return (isset($this->data[$key][$array1]) ? $this->data[$key][$array1] : null);
	    	} else {
	    		return (isset($this->data[$key]) ? $this->data[$key] : null);
	    	}
    	}
  	}
  	
  	public function compressorCodeCss($template, $files, $compressor_status, $http_server) {
		$output = '';
		foreach($files as $file) {
			$output .= '<link rel="stylesheet" type="text/css" href="' . $file . '" />';
			$output .= "\n";
		}
		
		return $output;
  	}
  	
  	public function compressorCodeJs($template, $files, $compressor_status, $http_server) {
		$output = '';
		foreach($files as $file) {
			$output .= '<script type="text/javascript" src="' . $file . '"></script>';
			$output .= "\n";
		}
		return $output;
  	}
  	
  	public function getDataProduct($product_id) {
  		$registry = $this->data['registry'];
  		
  		$output = array();
  		
  		// Registry
  		$product = $registry->get('model_catalog_product');
  		
  		// Pobranie danych produktu
  		$result = $product->getProduct($product_id);
  		if($result) {
  		     $date_end = false;
  		     $db = $registry->get('db');
  		     $query = $db->query("SELECT date_end FROM " . DB_PREFIX . "product_special WHERE product_id='" . $product_id . "'");
  		     if ($query->num_rows) {
  		          $date_end = $query->row['date_end'];
  		     }
  		     
  			$output = array(
  				'description' => strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')),
  				'price' => $result['price'],
  				'special' => $result['special'],
  				'date_end' => $date_end
  			);
  		}	
  		
  		return $output;
  	}	
  	
  	public function productImageSwap($product_id, $image_width, $image_height) {
  		$registry = $this->data['registry'];
  		
  		// Registry
  		$product = $registry->get('model_catalog_product');
  		$model_image = $registry->get('model_tool_image');
  		
  		// Pobranie danych produktu
  		$result = $product->getProductImages($product_id);
  		if($result && $image_width > 0 && $image_height > 0) {
  			foreach($result as $image) return $model_image->resize($image['image'], $image_width, $image_height);
  		}
  		
  		return false;
  	}
  	
	public function productImageThumb($product_id, $image_width, $image_height) {
		$registry = $this->data['registry'];
		
		// Registry
		$product = $registry->get('model_catalog_product');
		$model_image = $registry->get('model_tool_image');
		
		// Pobranie danych produktu
		$result = $product->getProduct($product_id);
		if($result && $image_width > 0 && $image_height > 0) return $model_image->resize($result['image'], $image_width, $image_height);
		
		return false;
	}
  	
  	
  	public function refineSearch() {
  		$registry = $this->data['registry'];
  		$loader = $this->data['loader'];
  		
  		$output = array();
  		
  		// Load model
  		$loader->model('catalog/category');
  		
  		// Registry
  		$model = $registry->get('model_catalog_category');
  		$product = $registry->get('model_catalog_product');
  		$get = $registry->get('request');
  		$link = $registry->get('url');
  		$config = $registry->get('config');
  		
  		// Pobranie id kategorii
  		$parts = explode('_', (string)$get->get['path']);
  		$category_id = (int)array_pop($parts);
  		
  		$url = '';
  		if (isset($get->get['filter'])) {
  			$url .= '&filter=' . $get->get['filter'];
  		}	
  								
  		if (isset($get->get['sort'])) {
  			$url .= '&sort=' . $get->get['sort'];
  		}	
  		
  		if (isset($get->get['order'])) {
  			$url .= '&order=' . $get->get['order'];
  		}	
  					
  		if (isset($get->get['limit'])) {
  			$url .= '&limit=' . $get->get['limit'];
  		}
  		
  		// Pobranie Refine Search  		
  		$results = $model->getCategories($category_id);
  		foreach ($results as $result) {
  			$data = array(
  				'filter_category_id'  => $result['category_id'],
  				'filter_sub_category' => true
  			);
  			
  			$product_total = $product->getTotalProducts($data);		
  			
  			$output[] = array(
  				'thumb' => $result['image'],
  				'name'  => $result['name'] . ($config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
  				'href'  => $link->link('product/category', 'path=' . $get->get['path'] . '_' . $result['category_id'] . $url)
  			);
  		}
  		
  		return $output;
  	}
  	
  	public function getCategories($category_id) {
  		$registry = $this->data['registry'];
  		
  		$config = $registry->get('config');
  		$link = $registry->get('url');
  		$get = $registry->get('request');
  		$model_products = $registry->get('model_catalog_product');
  		$model_categories = $registry->get('model_catalog_category');
  		$get_categories = $model_categories->getCategories($category_id);
  		$categories = array();
  		
  		foreach ($get_categories as $category) {
			$filter_data = array('filter_category_id' => $category['category_id'], 'filter_sub_category' => true);

			$categories[] = array(
				'category_id' => $category['category_id'], 
				'name' => $category['name'] . ($config->get('config_product_count') ? ' (' . $model_products->getTotalProducts($filter_data) . ')' : ''), 
				'href' => $link->link('product/category', 'path=' . $category_id . '_' . $category['category_id'])
			);
  		}
  		
  		return $categories;
  	}
  	
  	public function getCart() {
  		$registry = $this->data['registry']; $loader = $this->data['loader'];
  		
  		$output = array();
  		  		
  		// Registry
  		$cart = $registry->get('cart');
  		$session = $registry->get('session');
  		$currency = $registry->get('currency');
  		$config = $registry->get('config');
  		$customer = $registry->get('customer');
  		$model_setting = $registry->get('model_setting_extension');
  		
		$totals = array();
		$taxes = $cart->getTaxes();
		$total = 0;

		// Because __call can not keep var references so we put them into an array.
		$total_data = array(
			'totals' => &$totals,
			'taxes'  => &$taxes,
			'total'  => &$total
		);
			
		// Display prices
		if ($customer->isLogged() || !$config->get('config_customer_price')) {
			$sort_order = array();

			$results = $model_setting->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				if ($config->get('total_' . $result['code'] . '_status')) {	
				     $modal = $registry->get('model_extension_total_' . $result['code']);

					// We have to put the totals in an array so that they pass by reference.
					$modal->getTotal($total_data);
				}
			}

			$sort_order = array();

			foreach ($totals as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $totals);
		}	
  		  		 
  		$output['total_item'] = $cart->countProducts() + (isset($session->data['vouchers']) ? count($session->data['vouchers']) : 0);
  		$output['total_price'] = $currency->format($total, $session->data['currency']);

  		return $output;
  	}
  	
  	public function productIsEnquiry($product_id) {
		 $registry = $this->data['registry'];
		 $loader = $this->data['loader'];
		 $output = false;
		 
		 $config = $registry->get('config');
		$modules = $config->get('product_blocks_module');
		
		foreach($modules as $module) {
		   if(($module['position'] == 'product_enquiry' && $module['status'] == 1) && ($module['layout_id'] == 99999 || $module['layout_id'] == '99999' . $config->get( 'config_store_id' ))) {
		        $status = false;
		        
		        if($module['show_on_products_from'] == 'all') $status = true;
		        		
		        if($module['show_on_products_from'] == 'products') {
		             $products = explode(',', $module['products']);
		             foreach ($products as $product) {
		                  if($product == $product_id) $status = true;
		             }
		        }
		        
		        if($module['show_on_products_from'] == 'categories') {
		             $loader->model('catalog/products');
		             $model_catalog_products = $registry->get('model_catalog_products');
		             $category_id = $model_catalog_products->getCategoryId($product_id);
		             
		             $categories = explode(',', $module['categories']);
		             foreach ($categories as $category) {
		                  if($category == $category_id['category_id']) $status = true;
		             }
		        }
		        
		        if($module['show_on_products_from'] == 'out') {
		               $loader->model('catalog/products');
		               $model_catalog_products = $registry->get('model_catalog_products');
		               $product_info = $model_catalog_products->getProduct($product_id);
		               if($product_info['quantity'] < 1) $status = true;
		        }
		          	                    
		        if($status) {
		             if(isset($module['block_name'][$config->get('config_language_id')])) {
		             	$block_name = html_entity_decode($module['block_name'][$config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		             } else {
		             	$block_name = 'Request a qoute!';
		             }
		             
		             if(!isset($module['popup_module'])) $module['popup_module'] = 0;
		             
		             $output = array(
		                  'block_name' => $block_name,
		                  'icon' => $module['icon'],
		                  'icon_position' => $module['icon_position'],
		                  'popup_module' => $module['popup_module']
		             );
		        }
		   }
		}
		
		return $output;
  	}
  	
   	
   	public function getNextPrevProduct($product_id) {
   	     $output = array();
   	     $output['prev'] = false;
   	     $output['next'] = false;
   	     
   	     $registry = $this->data['registry'];
   	     $loader = $this->data['loader'];
   	     
   	     $loader->model('catalog/products');
   	     $loader->model('tool/image');
   	     
   	     // Registry
   	     $product = $registry->get('model_catalog_product');
   	     $products = $registry->get('model_catalog_products');
   	     $tool_image = $registry->get('model_tool_image');
   	     $config = $registry->get('config');
   	     $customer = $registry->get('customer');
   	     $currency = $registry->get('currency');
   	     $tax = $registry->get('tax');
   	     $url = $registry->get('url');
   	     $request = $registry->get('request');
   	     $session = $registry->get('session');
   	     
   	     if(isset($request->get['path'])) {
   	          $parts = explode('_', (string)$request->get['path']);
   	          $category_id['category_id'] = (int)array_pop($parts);
   	     } else {
   	          $category_id = $products->getCategoryId($product_id);
   	          $request->get['path'] = $category_id['category_id'];
   	     }
   	     
   	     $filter_data = array(
   			'filter_category_id' => $category_id['category_id'],
   			'start'              => 0,
   			'limit'              => 1000
   	     );
   	       	 
   	     $results = $product->getProducts($filter_data);
   			
   		 $i = 0;
   	      foreach ($results as $result) {  
 			if ($result['image']) {
 				$image = $tool_image->resize($result['image'], 83, 83);
 			} else {
 				$image = $tool_image->resize('placeholder.png', 83, 83);
 			}
 
 			if (($config->get('config_customer_price') && $customer->isLogged()) || !$config->get('config_customer_price')) {
 				$price = $currency->format($tax->calculate($result['price'], $result['tax_class_id'], $config->get('config_tax')), $session->data['currency']);
 			} else {
 				$price = false;
 			}
 
 			if ((float)$result['special']) {
 				$special = $currency->format($tax->calculate($result['special'], $result['tax_class_id'], $config->get('config_tax')), $session->data['currency']);
 			} else {
 				$special = false;
 			}
 				
   	           if($result['product_id'] == $product_id) {
   	                $i = 1;
   	           } elseif($i == 1) {
   	                $output['next'] = array(
   	                     'product_id'  => $result['product_id'],
   	                     'thumb'       => $image,
   	                     'name'        => $result['name'],
   	                     'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $config->get('config_product_description_length')) . '..',
   	                     'price'       => $price,
   	                     'special'     => $special,
   	                     'tax'         => $tax,
   	                     'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
   	                     'rating'      => $result['rating'],
   	                     'href'        => $url->link('product/product', 'path=' . $request->get['path'] . '&product_id=' . $result['product_id'])
   	                );
   	                break;
   	           } else {
   	                $output['prev'] = array(
   	                  'product_id'  => $result['product_id'],
   	                  'thumb'       => $image,
   	                  'name'        => $result['name'],
   	                  'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $config->get('config_product_description_length')) . '..',
   	                  'price'       => $price,
   	                  'special'     => $special,
   	                  'tax'         => $tax,
   	                  'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
   	                  'rating'      => $result['rating'],
   	                  'href'        => $url->link('product/product', 'path=' . $request->get['path'] . '&product_id=' . $result['product_id'])
   	                );
   	           }
   	      }
   	     
   	     return $output;
   	}
  	
      private $latest_products = null;
      private $latest_limit = 3;    
  
      /**
       * Sprawdza czy produkt o podanym ID jest bestsellerem
       * @param int $product_id ID produktu
       * @return boolean Prawda jeśli jest, falsz w przeciwnym razie
       */
      public function isLatestProduct($product_id)
      {
          if(array_key_exists($product_id, $this->getLatestProducts($product_id))){
              return true;
          }
          return false;
      }
  
      /**
       * 
       * @param int $limit Limit produktów, określa zakres bestsellerów
       * @return void 
       */
      public function getLatestProducts()
      {
          $registry = $this->data['registry'];
          // Registry
          $product = $registry->get('model_catalog_product');
          
          if(null === $this->latest_products){
              $this->latest_products = $product->getLatestProducts($this->latest_limit);
          }
          
          return $this->latest_products;
      }
  	
  	
  	   public function getCurrentCategory() {
  	       $registry = $this->data['registry'];
  	      
  	       $get = $registry->get('request');
  	               if (isset($get->get['category_id'])) {
  	                       $category_id = $get->get['category_id'];
  	               } else {
  	                       $category_id = 0;
  	               }
  	       return $category_id;
  	   }
  	      
  	       public function getAllCategories() {
  	               $registry = $this->data['registry'];
  	              
  	               $model_categories = $registry->get('model_catalog_category');
  	      
  	      
  	               $data['categories'] = array();
  	
  	               $categories_1 = $model_categories->getCategories(0);
  	
  	               foreach ($categories_1 as $category_1) {
  	                       $level_2_data = array();
  	
  	                       $categories_2 = $model_categories->getCategories($category_1['category_id']);
  	
  	                       foreach ($categories_2 as $category_2) {
  	                               $level_3_data = array();
  	
  	                               $categories_3 = $model_categories->getCategories($category_2['category_id']);
  	
  	                               foreach ($categories_3 as $category_3) {
  	                                       $level_3_data[] = array(
  	                                               'category_id' => $category_3['category_id'],
  	                                               'name'        => $category_3['name'],
  	                                       );
  	                               }
  	
  	                               $level_2_data[] = array(
  	                                       'category_id' => $category_2['category_id'],
  	                                       'name'        => $category_2['name'],
  	                                       'children'    => $level_3_data
  	                               );
  	                       }
  	
  	                       $data['categories'][] = array(
  	                               'category_id' => $category_1['category_id'],
  	                               'name'        => $category_1['name'],
  	                               'children'    => $level_2_data
  	                       );
  	               }
  	              
  	               return $data['categories'];
  	       }
}

function cmp_by_optionNumber($a, $b) {
	return $a["sort"] - $b["sort"];
}

?>