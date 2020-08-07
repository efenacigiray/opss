<?php
class ControllerCheckoutConfirm extends Controller {
    public function index() {

                
    /////Mesafeli Satis Sözlesmesi Degisiklik Basla///////////////////////////////////////////////////////////////////////
    $this->load->model('setting/setting');

        $data['store_url'] = HTTP_SERVER;
        $data['entry_name'] = "Firma Adi";
        $data['entry_owner'] = "Yetkili / Sahibi:";
        $data['entry_address'] = "Adresi:";
        $data['entry_email'] = "E-mail:";
        $data['entry_telephone'] = "Telefon:";
        $data['entry_fax'] = "Fax:";
        
        
        $data['config_name'] = $this->config->get('config_name');
        $data['config_owner'] = $this->config->get('config_owner');
        $data['config_address'] = $this->config->get('config_address');
        $data['config_email'] = $this->config->get('config_email');
        $data['config_telephone'] = $this->config->get('config_telephone');
        $data['config_fax'] = $this->config->get('config_fax');
		
		if (!empty($_SERVER['HTTP_CLIENT_IP']))  
		{
		   $data['ip_adresi'] = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
		{
		  $data['ip_adresi'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $data['ip_adresi'] = $_SERVER['REMOTE_ADDR'];
		}	

		$data['tarih'] = date("d-m-Y");
                        
     ////////////////////Mesafeli Satis Sözlesmesi Degisiklik Bitis//////////////////////////////////////
    ////////////////////GUEST DÜZENLEMESİ BAŞLAR////////////////////////////////////////////////////////
    if($this->customer->isLogged()){
    $this->load->model('account/customer');
        $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
    
            $data['firstname'] = $customer_info['firstname'];
            $data['lastname'] = $customer_info['lastname'];
            $data['email'] = $customer_info['email'];
            $data['telephone'] = $customer_info['telephone'];
            $data['fax'] = $customer_info['fax'];
    
    $address_id = $this->customer->getAddressId();
    $this->load->model('account/address');
    $address = $this->model_account_address->getAddress($address_id); 
    
            $data['address_1']    =  $address['address_1'];
            $data['address_2']    =  $address['address_2'];
            $data['postcode']     =  $address['postcode'];
            $data['city']         =  $address['city'];
            $data['zone']         =  $address['zone'];
            $data['zone_code']    =  $address['zone_code'];
            $data['country_id']   =  $address['country_id'];
            $data['country']      =  $address['country'];
    }else {
    if (isset($this->session->data['guest']['firstname'])) {
                $data['firstname'] = $this->session->data['guest']['firstname'];
            } else {
                $data['firstname'] = '';
            }
    
            if (isset($this->session->data['guest']['lastname'])) {
                $data['lastname'] = $this->session->data['guest']['lastname'];
            } else {
                $data['lastname'] = '';
            }
            
            if (isset($this->session->data['guest']['email'])) {
                $data['email'] = $this->session->data['guest']['email'];
            } else {
                $data['email'] = '';
            }
            
            if (isset($this->session->data['guest']['telephone'])) {
                $data['telephone'] = $this->session->data['guest']['telephone'];      
            } else {
                $data['telephone'] = '';
            }
    
            if (isset($this->session->data['payment_address']['fax'])) {
                $data['fax'] = $this->session->data['payment_address']['fax'];               
            } else {
                $data['fax'] = '';
            }
    
            if (isset($this->session->data['payment_address']['company'])) {
                $data['company'] = $this->session->data['payment_address']['company'];           
            } else {
                $data['company'] = '';
            }
            
            if (isset($this->session->data['payment_address']['address_1'])) {
                $data['address_1'] =  $this->session->data['payment_address']['address_1'];  
                
            } else {
                $data['address_1'] = '';
            }
    
            if (isset($this->session->data['payment_address']['address_2'])) {
                $data['address_2'] = $this->session->data['payment_address']['address_2'];           
            } else {
                $data['address_2'] = '';
            }
    
            if (isset($this->session->data['payment_address']['postcode'])) {
                $data['postcode'] = $this->session->data['payment_address']['postcode'];                 
            } else {
                $data['postcode'] = '';
            }
            
            if (isset($this->session->data['payment_address']['city'])) {
                $data['city'] = $this->session->data['payment_address']['city'];         
            } else {
                $data['city'] = '';
            }
    
            if (isset($this->session->data['payment_address']['country_id'])) {
                $data['country_id'] = $this->session->data['payment_address']['country_id'];             
            } else {
                $data['country_id'] = $this->config->get('config_country_id');
            }
            
            $this->load->model('localisation/country');
            $country_info= $this->model_localisation_country->getCountry($data['country_id']);
            $data['country'] = $country_info['name']; 
    
            if (isset($this->session->data['payment_address']['zone_id'])) {
                $data['zone_id'] = $this->session->data['payment_address']['zone_id'];           
            } else {
                $data['zone_id'] = '';
            }
            $this->load->model('localisation/zone');
                                
            $zone_info = $this->model_localisation_zone->getZone($data['zone_id']);
            
            $data['zone'] = $zone_info['name'];
            
            
                             
    }           
    /////////////GUEST DÜZENLEMESİ BİTER//////////////////////////////////////////////////////////////      
		
                
            
        $redirect = '';

        if ($this->cart->hasShipping()) {
            // Validate if shipping address has been set.
            if (!isset($this->session->data['shipping_address'])) {
                $redirect = $this->url->link('checkout/checkout', '', true);
            }

            // Validate if shipping method has been set.
            if (!isset($this->session->data['shipping_method'])) {
                $redirect = $this->url->link('checkout/checkout', '', true);
            }
        } else {
            unset($this->session->data['shipping_address']);
            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
        }

        // Validate if payment address has been set.
        if (!isset($this->session->data['payment_address'])) {
            $redirect = $this->url->link('checkout/checkout', '', true);
        }

        // Validate if payment method has been set.
        if (!isset($this->session->data['payment_method'])) {
            $redirect = $this->url->link('checkout/checkout', '', true);
        }

        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $redirect = $this->url->link('checkout/cart');
        }

        // Validate minimum quantity requirements.
        $products = $this->cart->getProducts();

        foreach ($products as $product) {
            $product_total = 0;

            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total += $product_2['quantity'];
                }
            }

            if ($product['minimum'] > $product_total) {
                $redirect = $this->url->link('checkout/cart');

                break;
            }
        }

        if (!$redirect) {
            $order_data = array();

            $totals = array();
            $taxes = $this->cart->getTaxes();
            $total = 0;

            // Because __call can not keep var references so we put them into an array.
            $total_data = array(
                'totals' => &$totals,
                'taxes'  => &$taxes,
                'total'  => &$total,
                'store_id' => $this->config->get('config_store_id')
            );

            $this->load->model('setting/extension');

            $sort_order = array();

            $results = $this->model_setting_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get('total_' . $result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);

                    // We have to put the totals in an array so that they pass by reference.
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $sort_order = array();

            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $totals);

            $order_data['totals'] = $totals;

            $this->load->language('checkout/checkout');

            $order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
            $order_data['store_id'] = $this->config->get('config_store_id');
            $order_data['store_name'] = $this->config->get('config_name');

            if ($order_data['store_id']) {
                $order_data['store_url'] = $this->config->get('config_url');
            } else {
                if ($this->request->server['HTTPS']) {
                    $order_data['store_url'] = HTTPS_SERVER;
                } else {
                    $order_data['store_url'] = HTTP_SERVER;
                }
            }
            
            $this->load->model('account/customer');

            if ($this->customer->isLogged()) {
                $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

                $order_data['customer_id'] = $this->customer->getId();
                $order_data['customer_group_id'] = $customer_info['customer_group_id'];
                $order_data['firstname'] = $customer_info['firstname'];
                $order_data['lastname'] = $customer_info['lastname'];
                $order_data['email'] = $customer_info['email'];
                $order_data['telephone'] = $customer_info['telephone'];
                $order_data['custom_field'] = json_decode($customer_info['custom_field'], true);
            } elseif (isset($this->session->data['guest'])) {
                $order_data['customer_id'] = 0;
                $order_data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
                $order_data['firstname'] = $this->session->data['guest']['firstname'];
                $order_data['lastname'] = $this->session->data['guest']['lastname'];
                $order_data['email'] = $this->session->data['guest']['email'];
                $order_data['telephone'] = $this->session->data['guest']['telephone'];
                $order_data['custom_field'] = $this->session->data['guest']['custom_field'];
            }

            $order_data['payment_firstname'] = $this->session->data['payment_address']['firstname'];
            $order_data['payment_lastname'] = $this->session->data['payment_address']['lastname'];
            $order_data['payment_company'] = $this->session->data['payment_address']['company'];
            $order_data['payment_address_1'] = $this->session->data['payment_address']['address_1'];
            $order_data['payment_address_2'] = $this->session->data['payment_address']['address_2'];
            $order_data['payment_city'] = $this->session->data['payment_address']['city'];
            $order_data['payment_postcode'] = $this->session->data['payment_address']['postcode'];
            $order_data['payment_zone'] = $this->session->data['payment_address']['zone'];
            $order_data['payment_zone_id'] = $this->session->data['payment_address']['zone_id'];
            $order_data['payment_country'] = $this->session->data['payment_address']['country'];
            $order_data['payment_country_id'] = $this->session->data['payment_address']['country_id'];
            $order_data['payment_address_format'] = $this->session->data['payment_address']['address_format'];
            $order_data['payment_custom_field'] = (isset($this->session->data['payment_address']['custom_field']) ? $this->session->data['payment_address']['custom_field'] : array());

            if (isset($this->session->data['payment_method']['title'])) {
                $order_data['payment_method'] = $this->session->data['payment_method']['title'];
            } else {
                $order_data['payment_method'] = '';
            }

            if (isset($this->session->data['payment_method']['code'])) {
                $order_data['payment_code'] = $this->session->data['payment_method']['code'];
            } else {
                $order_data['payment_code'] = '';
            }

            if ($this->cart->hasShipping()) {
                $order_data['shipping_firstname'] = $this->session->data['shipping_address']['firstname'];
                $order_data['shipping_lastname'] = $this->session->data['shipping_address']['lastname'];
                $order_data['shipping_company'] = $this->session->data['shipping_address']['company'];
                $order_data['shipping_address_1'] = $this->session->data['shipping_address']['address_1'];
                $order_data['shipping_address_2'] = $this->session->data['shipping_address']['address_2'];
                $order_data['shipping_city'] = $this->session->data['shipping_address']['city'];
                $order_data['shipping_postcode'] = $this->session->data['shipping_address']['postcode'];
                $order_data['shipping_zone'] = $this->session->data['shipping_address']['zone'];
                $order_data['shipping_zone_id'] = $this->session->data['shipping_address']['zone_id'];
                $order_data['shipping_country'] = $this->session->data['shipping_address']['country'];
                $order_data['shipping_country_id'] = $this->session->data['shipping_address']['country_id'];
                $order_data['shipping_address_format'] = $this->session->data['shipping_address']['address_format'];
                $order_data['shipping_custom_field'] = (isset($this->session->data['shipping_address']['custom_field']) ? $this->session->data['shipping_address']['custom_field'] : array());

                if (isset($this->session->data['shipping_method']['title'])) {
                    $order_data['shipping_method'] = $this->session->data['shipping_method']['title'];
                } else {
                    $order_data['shipping_method'] = '';
                }

                if (isset($this->session->data['shipping_method']['code'])) {
                    $order_data['shipping_code'] = $this->session->data['shipping_method']['code'];
                } else {
                    $order_data['shipping_code'] = '';
                }
            } else {
                $order_data['shipping_firstname'] = '';
                $order_data['shipping_lastname'] = '';
                $order_data['shipping_company'] = '';
                $order_data['shipping_address_1'] = '';
                $order_data['shipping_address_2'] = '';
                $order_data['shipping_city'] = '';
                $order_data['shipping_postcode'] = '';
                $order_data['shipping_zone'] = '';
                $order_data['shipping_zone_id'] = '';
                $order_data['shipping_country'] = '';
                $order_data['shipping_country_id'] = '';
                $order_data['shipping_address_format'] = '';
                $order_data['shipping_custom_field'] = array();
                $order_data['shipping_method'] = '';
                $order_data['shipping_code'] = '';
            }

            $order_data['products'] = array();

            foreach ($this->cart->getProducts() as $product) {
                $option_data = array();

                foreach ($product['option'] as $option) {
                    $option_data[] = array(
                        'product_option_id'       => $option['product_option_id'],
                        'product_option_value_id' => $option['product_option_value_id'],
                        'option_id'               => $option['option_id'],
                        'option_value_id'         => $option['option_value_id'],
                        'name'                    => $option['name'],
                        'value'                   => $option['value'],
                        'type'                    => $option['type']
                    );
                }

                $order_data['products'][] = array(
                    'product_id' => $product['product_id'],
                    'name'       => $product['name'],
                    'model'      => $product['model'],
                    'option'     => $option_data,
                    'download'   => $product['download'],
                    'quantity'   => $product['quantity'],
                    'subtract'   => $product['subtract'],
                    'price'      => $product['price'],
                    'total'      => $product['total'],
                    'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
                    'reward'     => $product['reward']
                );
            }

            // Gift Voucher
            $order_data['vouchers'] = array();

            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $voucher) {
                    $order_data['vouchers'][] = array(
                        'description'      => $voucher['description'],
                        'code'             => token(10),
                        'to_name'          => $voucher['to_name'],
                        'to_email'         => $voucher['to_email'],
                        'from_name'        => $voucher['from_name'],
                        'from_email'       => $voucher['from_email'],
                        'voucher_theme_id' => $voucher['voucher_theme_id'],
                        'message'          => $voucher['message'],
                        'amount'           => $voucher['amount']
                    );
                }
            }

            $order_data['comment'] = $this->session->data['comment'];
            $order_data['total'] = $total_data['total'];

            if (isset($this->request->cookie['tracking'])) {
                $order_data['tracking'] = $this->request->cookie['tracking'];

                $subtotal = $this->cart->getSubTotal();

                // Affiliate
                $affiliate_info = $this->model_account_customer->getAffiliateByTracking($this->request->cookie['tracking']);

                if ($affiliate_info) {
                    $order_data['affiliate_id'] = $affiliate_info['customer_id'];
                    $order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
                } else {
                    $order_data['affiliate_id'] = 0;
                    $order_data['commission'] = 0;
                }

                // Marketing
                $this->load->model('checkout/marketing');

                $marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);

                if ($marketing_info) {
                    $order_data['marketing_id'] = $marketing_info['marketing_id'];
                } else {
                    $order_data['marketing_id'] = 0;
                }
            } else {
                $order_data['affiliate_id'] = 0;
                $order_data['commission'] = 0;
                $order_data['marketing_id'] = 0;
                $order_data['tracking'] = '';
            }

            $order_data['language_id'] = $this->config->get('config_language_id');
            $order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
            $order_data['currency_code'] = $this->session->data['currency'];
            $order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
            $order_data['ip'] = $this->request->server['REMOTE_ADDR'];

            if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                $order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                $order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
            } else {
                $order_data['forwarded_ip'] = '';
            }

            if (isset($this->request->server['HTTP_USER_AGENT'])) {
                $order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
            } else {
                $order_data['user_agent'] = '';
            }

            if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                $order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
            } else {
                $order_data['accept_language'] = '';
            }

            $this->load->model('checkout/order');

            $this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);

            $this->load->model('tool/upload');

            $data['products'] = array();

            foreach ($this->cart->getProducts() as $product) {
                $option_data = array();

                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['value'];
                    } else {
                        $upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

                        if ($upload_info) {
                            $value = $upload_info['name'];
                        } else {
                            $value = '';
                        }
                    }

                    $option_data[] = array(
                        'name'  => $option['name'],
                        'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
                    );
                }

                $recurring = '';

                if ($product['recurring']) {
                    $frequencies = array(
                        'day'        => $this->language->get('text_day'),
                        'week'       => $this->language->get('text_week'),
                        'semi_month' => $this->language->get('text_semi_month'),
                        'month'      => $this->language->get('text_month'),
                        'year'       => $this->language->get('text_year'),
                    );

                    if ($product['recurring']['trial']) {
                        $recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
                    }

                    if ($product['recurring']['duration']) {
                        $recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    } else {
                        $recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                    }
                }

                $data['products'][] = array(
                    'cart_id'    => $product['cart_id'],
                    'product_id' => $product['product_id'],
                    'name'       => $product['name'],
                    'model'      => $product['model'],
                    'option'     => $option_data,
                    'recurring'  => $recurring,
                    'quantity'   => $product['quantity'],
                    'subtract'   => $product['subtract'],
                    'price'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']),
                    'total'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $this->session->data['currency']),
                    'href'       => $this->url->link('product/product', 'product_id=' . $product['product_id'])
                );
            }

            // Gift Voucher
            $data['vouchers'] = array();

            if (!empty($this->session->data['vouchers'])) {
                foreach ($this->session->data['vouchers'] as $voucher) {
                    $data['vouchers'][] = array(
                        'description' => $voucher['description'],
                        'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency'])
                    );
                }
            }

            $data['totals'] = array();

            foreach ($order_data['totals'] as $total) {
                $data['totals'][] = array(
                    'title' => $total['title'],
                    'text'  => $this->currency->format($total['value'], $this->session->data['currency'])
                );
            }

            $data['payment'] = $this->load->controller('extension/payment/' . $this->session->data['payment_method']['code']);
        } else {
            $data['redirect'] = $redirect;
        }

        $this->response->setOutput($this->load->view('checkout/confirm', $data));
    }
}
