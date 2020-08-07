<?php
class ModelToolQuickStatusUpdater extends Model {
  protected $front_load;
  
  public function __construct($registry) {
    require_once(DIR_SYSTEM . 'engine/gkd_loader.php');
    require_once(DIR_SYSTEM . 'library/gkd_language.php');
    
    $this->front_load = new GkdLoader($registry);
    parent::__construct($registry);
  }
  
  public function addOrderHistory($order_id, $order_status_id, $comment = '', $notify = false, $override = false, $extra_info = array()) {
        $order_info = $this->model_sale_order->getOrder($order_id);
        
        if ($order_info) {
      if ($comment) {
        foreach ($extra_info as $key => $val) {
          if (is_string($val)) {
            $comment = str_replace('{'.$key.'}', $val, $comment);
          }
        }
      }
      
      if (version_compare(VERSION, '2', '>=')) {
        $process_complete_status = array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'));
      } else {
        $process_complete_status = array($this->config->get('config_complete_status_id'));
      }
      
            // If current order status is not processing or complete but new status is processing or complete then commence completing the order
      if (version_compare(VERSION, '2', '>=')) {
        if (!in_array($order_info['order_status_id'], $process_complete_status) && in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
          // Redeem coupon, vouchers and reward points
          $order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

          foreach ($order_total_query->rows as $order_total) {
            if (substr($order_total['code'], 0, 7) == 'xfeepro') {
              $order_total['code'] = 'xfeepro';
            }
            
            if (version_compare(VERSION, '3', '>=')) {
              $this->front_load->model('extension/total/' . $order_total['code']);

              if (property_exists($this->{'model_extension_total_' . $order_total['code']}, 'confirm')) {
                // Confirm coupon, vouchers and reward points
                $fraud_status_id = $this->{'model_extension_total_' . $order_total['code']}->confirm($order_info, $order_total);
                
                // If the balance on the coupon, vouchers and reward points is not enough to cover the transaction or has already been used then the fraud order status is returned.
                if ($fraud_status_id) {
                  $order_status_id = $fraud_status_id;
                }
              }
            } else {
              $this->front_load->model('total/' . $order_total['code']);

              if (property_exists($this->{'model_total_' . $order_total['code']}, 'confirm')) {
                // Confirm coupon, vouchers and reward points
                $fraud_status_id = $this->{'model_total_' . $order_total['code']}->confirm($order_info, $order_total);
                
                // If the balance on the coupon, vouchers and reward points is not enough to cover the transaction or has already been used then the fraud order status is returned.
                if ($fraud_status_id) {
                  $order_status_id = $fraud_status_id;
                }
              }
            }
          }

          // Add commission if sale is linked to affiliate referral.
          if ($order_info['affiliate_id'] && $this->config->get('config_affiliate_auto')) {
            $this->front_load->model('affiliate/affiliate');

            $this->model_affiliate_affiliate->addTransaction($order_info['affiliate_id'], $order_info['commission'], $order_id);
          }

          // Stock subtraction
          $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

          foreach ($order_product_query->rows as $order_product) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");

            $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");

            foreach ($order_option_query->rows as $option) {
              $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
            }
          }
        }
      }

            // Update the DB with the new statuses
            $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

      // update quick status updater tracking
      if ((!empty($extra_info['tracking_no']) || !empty($extra_info['tracking_url'])) && $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order` LIKE 'tracking_no'")->row && $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order` LIKE 'tracking_url'")->row) {
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET tracking_no = '" . $this->db->escape($extra_info['tracking_no']) . "', tracking_url = '" . $this->db->escape($extra_info['tracking_url']) . "' WHERE order_id = '" . (int)$order_id . "'");
      }
      
      // todo
            $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

      $order_history_id = $this->db->getLastId();
      
            // If old order status is the processing or complete status but new status is not then commence restock, and remove coupon, voucher and reward history
      if (version_compare(VERSION, '2', '>=')) {
        if (in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && !in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
          // Restock
          $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

          foreach($product_query->rows as $product) {
            $this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");

            $option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

            foreach ($option_query->rows as $option) {
              $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
            }
          }

          // Remove coupon, vouchers and reward points history
          $this->front_load->model('account/order');

          $order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

          foreach ($order_total_query->rows as $order_total) {
            if (version_compare(VERSION, '3', '>=')) {
              $this->front_load->model('extension/total/' . $order_total['code']);

              if (property_exists($this->{'model_extension_total_' . $order_total['code']}, 'unconfirm')) {
                $this->{'model_extension_total_' . $order_total['code']}->unconfirm($order_id);
              }
            } else {
              $this->front_load->model('total/' . $order_total['code']);

              if (property_exists($this->{'model_total_' . $order_total['code']}, 'unconfirm')) {
                $this->{'model_total_' . $order_total['code']}->unconfirm($order_id);
              }
            }
          }
        }
            }

            $this->cache->delete('product');
            
            // If order status is 0 then becomes greater than 0 send main html email
            if (!$order_info['order_status_id'] && $order_status_id) {
                // Check for any downloadable products
                $download_status = false;
    
                $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
    
                foreach ($order_product_query->rows as $order_product) {
                    // Check if there are any linked downloads
                    $product_download_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_to_download` WHERE product_id = '" . (int)$order_product['product_id'] . "'");
    
                    if ($product_download_query->row['total']) {
                        $download_status = true;
                    }
                }
    
                // Load the language for any mails that might be required to be sent out
        if (isset($order_info['language_directory'])) {
          $language = new GkdLanguage($order_info['language_directory']);
          $language->load($order_info['language_directory']);
        } else {
          $language = new GkdLanguage($order_info['language_code']);
          $language->load($order_info['language_code']);
        }

        if (version_compare(VERSION, '3', '>=')) {
          $language->load('mail/order_add');
          
          $data = array();
          
          $subject = sprintf($language->get('text_subject'), $order_info['store_name'], $order_info['order_id']);
          
          $data['title'] = sprintf($language->get('text_subject'), $order_info['store_name'], $order_info['order_id']);

          $data['text_greeting'] = sprintf($language->get('text_greeting'), $order_info['store_name']);
          $data['text_link'] = $language->get('text_link');
          $data['text_download'] = $language->get('text_download');
          $data['text_order_detail'] = $language->get('text_order_detail');
          $data['text_instruction'] = $language->get('text_instruction');
          $data['text_order_id'] = $language->get('text_order_id');
          $data['text_date_added'] = $language->get('text_date_added');
          $data['text_payment_method'] = $language->get('text_payment_method');
          $data['text_shipping_method'] = $language->get('text_shipping_method');
          $data['text_email'] = $language->get('text_email');
          $data['text_telephone'] = $language->get('text_telephone');
          $data['text_ip'] = $language->get('text_ip');
          $data['text_order_status'] = $language->get('text_order_status');
          $data['text_payment_address'] = $language->get('text_payment_address');
          $data['text_shipping_address'] = $language->get('text_shipping_address');
          $data['text_product'] = $language->get('text_product');
          $data['text_model'] = $language->get('text_model');
          $data['text_quantity'] = $language->get('text_quantity');
          $data['text_price'] = $language->get('text_price');
          $data['text_total'] = $language->get('text_total');
          $data['text_footer'] = $language->get('text_footer');
        } else {
          $language->load('mail/order');
          
          $subject = sprintf($language->get('text_new_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);
    
          $data = array();
    
          $data['title'] = sprintf($language->get('text_new_subject'), $order_info['store_name'], $order_id);
    
          $data['text_greeting'] = sprintf($language->get('text_new_greeting'), $order_info['store_name']);
          $data['text_link'] = $language->get('text_new_link');
          $data['text_download'] = $language->get('text_new_download');
          $data['text_order_detail'] = $language->get('text_new_order_detail');
          $data['text_instruction'] = $language->get('text_new_instruction');
          $data['text_order_id'] = $language->get('text_new_order_id');
          $data['text_date_added'] = $language->get('text_new_date_added');
          $data['text_payment_method'] = $language->get('text_new_payment_method');
          $data['text_shipping_method'] = $language->get('text_new_shipping_method');
          $data['text_email'] = $language->get('text_new_email');
          $data['text_telephone'] = $language->get('text_new_telephone');
          $data['text_ip'] = $language->get('text_new_ip');
          $data['text_order_status'] = $language->get('text_new_order_status');
          $data['text_payment_address'] = $language->get('text_new_payment_address');
          $data['text_shipping_address'] = $language->get('text_new_shipping_address');
          $data['text_product'] = $language->get('text_new_product');
          $data['text_model'] = $language->get('text_new_model');
          $data['text_quantity'] = $language->get('text_new_quantity');
          $data['text_price'] = $language->get('text_new_price');
          $data['text_total'] = $language->get('text_new_total');
          $data['text_footer'] = $language->get('text_new_footer');
        }
        
                $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
    
                if ($order_status_query->num_rows) {
                    $order_status = $order_status_query->row['name'];
                } else {
                    $order_status = '';
                }
    
                $data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
                $data['store_name'] = $order_info['store_name'];
                $data['store_url'] = $order_info['store_url'];
                $data['customer_id'] = $order_info['customer_id'];
                $data['link'] = $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id;
    
                if ($download_status) {
                    $data['download'] = $order_info['store_url'] . 'index.php?route=account/download';
                } else {
                    $data['download'] = '';
                }
    
                $data['order_id'] = $order_id;
                $data['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));
                $data['payment_method'] = $order_info['payment_method'];
                $data['shipping_method'] = $order_info['shipping_method'];
                $data['email'] = $order_info['email'];
                $data['telephone'] = $order_info['telephone'];
                $data['ip'] = $order_info['ip'];
                $data['order_status'] = $order_status;
    
                if ($comment && $notify) {
                    $data['comment'] = nl2br($comment);
                } else {
                    $data['comment'] = '';
                }
    
                if ($order_info['payment_address_format']) {
                    $format = $order_info['payment_address_format'];
                } else {
                    $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
                }
    
                $find = array(
                    '{firstname}',
                    '{lastname}',
                    '{company}',
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}'
                );
    
                $replace = array(
                    'firstname' => $order_info['payment_firstname'],
                    'lastname'  => $order_info['payment_lastname'],
                    'company'   => $order_info['payment_company'],
                    'address_1' => $order_info['payment_address_1'],
                    'address_2' => $order_info['payment_address_2'],
                    'city'      => $order_info['payment_city'],
                    'postcode'  => $order_info['payment_postcode'],
                    'zone'      => $order_info['payment_zone'],
                    'zone_code' => $order_info['payment_zone_code'],
                    'country'   => $order_info['payment_country']
                );
    
                $data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
    
                if ($order_info['shipping_address_format']) {
                    $format = $order_info['shipping_address_format'];
                } else {
                    $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
                }
    
                $find = array(
                    '{firstname}',
                    '{lastname}',
                    '{company}',
                    '{address_1}',
                    '{address_2}',
                    '{city}',
                    '{postcode}',
                    '{zone}',
                    '{zone_code}',
                    '{country}'
                );
    
                $replace = array(
                    'firstname' => $order_info['shipping_firstname'],
                    'lastname'  => $order_info['shipping_lastname'],
                    'company'   => $order_info['shipping_company'],
                    'address_1' => $order_info['shipping_address_1'],
                    'address_2' => $order_info['shipping_address_2'],
                    'city'      => $order_info['shipping_city'],
                    'postcode'  => $order_info['shipping_postcode'],
                    'zone'      => $order_info['shipping_zone'],
                    'zone_code' => $order_info['shipping_zone_code'],
                    'country'   => $order_info['shipping_country']
                );
    
                $data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
    
                $this->front_load->model('tool/upload');
    
                // Products
                $data['products'] = array();
    
                foreach ($order_product_query->rows as $product) {
                    $option_data = array();
    
                    $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");
    
                    foreach ($order_option_query->rows as $option) {
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
    
                    $data['products'][] = array(
                        'name'     => $product['name'],
                        'model'    => $product['model'],
                        'option'   => $option_data,
                        'quantity' => $product['quantity'],
                        'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                        'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
                    );
                }
    
                // Vouchers
                $data['vouchers'] = array();
    
                $order_voucher_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");
    
                foreach ($order_voucher_query->rows as $voucher) {
                    $data['vouchers'][] = array(
                        'description' => $voucher['description'],
                        'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
                    );
                }
    
                // Order Totals
                $data['totals'] = array();
                
                $order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");
    
                foreach ($order_total_query->rows as $total) {
                    $data['totals'][] = array(
                        'title' => $total['title'],
                        'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
                    );
                }
    
                // Text Mail
                $text  = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8')) . "\n\n";
                $text .= $language->get('text_new_order_id') . ' ' . $order_id . "\n";
                $text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
                $text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";
    
                if ($comment && $notify) {
                    $text .= $language->get('text_new_instruction') . "\n\n";
                    $text .= $comment . "\n\n";
                }
    
                // Products
                $text .= $language->get('text_new_products') . "\n";
    
                foreach ($order_product_query->rows as $product) {
                    $text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
    
                    $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");
    
                    foreach ($order_option_query->rows as $option) {
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
    
                        $text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value) . "\n";
                    }
                }
    
                foreach ($order_voucher_query->rows as $voucher) {
                    $text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
                }
    
                $text .= "\n";
    
                $text .= $language->get('text_new_order_total') . "\n";
    
                foreach ($order_total_query->rows as $total) {
                    $text .= $total['title'] . ': ' . html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
                }
    
                $text .= "\n";
    
                if ($order_info['customer_id']) {
                    $text .= $language->get('text_new_link') . "\n";
                    $text .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
                }
    
                if ($download_status) {
                    $text .= $language->get('text_new_download') . "\n";
                    $text .= $order_info['store_url'] . 'index.php?route=account/download' . "\n\n";
                }
    
                // Comment
                if ($order_info['comment']) {
                    $text .= $language->get('text_new_comment') . "\n\n";
                    $text .= $order_info['comment'] . "\n\n";
                }
    
                $text .= $language->get('text_new_footer') . "\n\n";
    
                if (version_compare(VERSION, '3', '>=')) {
          $mail = new Mail($this->config->get('config_mail_engine'));
        } else {
                  $mail = new Mail();
                  $mail->protocol = $this->config->get('config_mail_protocol');
        }
        
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
    
                $mail->setTo($order_info['email']);
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
                $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        
        if (version_compare(VERSION, '3', '>=')) {
          $mail->setHtml($this->front_load->view('mail/order_add.twig', $data));
        } else {
                $mail->setHtml($this->front_load->view('mail/order', $data));
        }
        
                $mail->setText($text);

        if($this->config->get('pdf_invoice_auto_generate')){
                    $invoice_no = '';
                    if ($order_info && !$order_info['invoice_no']) {
                        $query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "'");

                        if ($query->row['invoice_no']) {
                            $order_info['invoice_no'] = $query->row['invoice_no'] + 1;
                        } else {
                            $order_info['invoice_no'] = 1;
                        }

                        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int)$order_info['invoice_no'] . "', invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "' WHERE order_id = '" . (int)$order_id . "'");
                    }
                }
                
        $this->load->model('tool/pdf_invoice');

        // PDF order.confirm
        if ($this->config->get('pdf_invoice_mail') || in_array($order_status_id, (array) $this->config->get('pdf_invoice_auto_notify')) || ($order_info['payment_code'] == 'invoicepay' && $this->config->get('invoicepay_forcepdf'))) {
          if (!$this->config->get('pdf_invoice_invoiced') || ($this->config->get('pdf_invoice_invoiced') && $order_info['invoice_no'])) {
            $temp_pdf = $this->model_tool_pdf_invoice->generate($order_id, 'file', 'invoice', null, array('order_comment' => nl2br($comment)));
            $mail->addAttachment($temp_pdf);
          }
        }
        
        if ($this->config->get('pdf_invoice_backup') && $this->config->get('pdf_invoice_backup_moment') == 'order') {
          if ((!$this->config->get('pdf_invoice_adminlang') || ($this->config->get('pdf_invoice_adminlang') == $order_info['language_id'])) && isset($temp_pdf)) {
            copy($temp_pdf, $this->model_tool_pdf_invoice->getBackupPath($order_id));
          } else {
            $this->model_tool_pdf_invoice->generate($order_id, 'backup', 'invoice', $this->config->get('pdf_invoice_adminlang'), array('order_comment' => nl2br($comment)));
          }
        }

        $mail->send();

        if(isset($temp_pdf) && is_file($temp_pdf)){
                    unlink($temp_pdf);
                }
    
                // Admin Alert Mail
                if (in_array('order', (array)$this->config->get('config_mail_alert'))) {
          if (version_compare(VERSION, '3', '>=')) {
            $language->load('mail/order_alert');
            
            $language->set('text_new_subject', $language->get('text_subject'));
            $language->set('text_new_received', $language->get('text_received'));
            $language->set('text_new_order_id', $language->get('text_order_id'));
            $language->set('text_new_date_added', $language->get('text_date_added'));
            $language->set('text_new_order_status', $language->get('text_order_status'));
            $language->set('text_new_products', $language->get('text_product'));
            $language->set('text_new_order_total', $language->get('text_total'));
            $language->set('text_new_comment', $language->get('text_comment'));
          }
          
                    $subject = sprintf($language->get('text_new_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_id);
    
                    // HTML Mail
                    $data['text_greeting'] = $language->get('text_new_received');
    
                    if ($comment) {
                        if ($order_info['comment']) {
                            $data['comment'] = nl2br($comment) . '<br/><br/>' . $order_info['comment'];
                        } else {
                            $data['comment'] = nl2br($comment);
                        }
                    } else {
                        if ($order_info['comment']) {
                            $data['comment'] = $order_info['comment'];
                        } else {
                            $data['comment'] = '';
                        }
                    }
    
                    $data['text_download'] = '';
    
                    $data['text_footer'] = '';
    
                    $data['text_link'] = '';
                    $data['link'] = '';
                    $data['download'] = '';
    
                    // Text
                    $text  = $language->get('text_new_received') . "\n\n";
                    $text .= $language->get('text_new_order_id') . ' ' . $order_id . "\n";
                    $text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
                    $text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";
                    $text .= $language->get('text_new_products') . "\n";
    
                    foreach ($order_product_query->rows as $product) {
                        $text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
    
                        $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");
    
                        foreach ($order_option_query->rows as $option) {
                            if ($option['type'] != 'file') {
                                $value = $option['value'];
                            } else {
                                $value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
                            }
    
                            $text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value) . "\n";
                        }
                    }
    
                    foreach ($order_voucher_query->rows as $voucher) {
                        $text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
                    }
    
                    $text .= "\n";
    
                    $text .= $language->get('text_new_order_total') . "\n";
    
                    foreach ($order_total_query->rows as $total) {
                        $text .= $total['title'] . ': ' . html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
                    }
    
                    $text .= "\n";
    
                    if ($order_info['comment']) {
                        $text .= $language->get('text_new_comment') . "\n\n";
                        $text .= $order_info['comment'] . "\n\n";
                    }
    
          // admin alert email
                    if (version_compare(VERSION, '3', '>=')) {
            $mail = new Mail($this->config->get('config_mail_engine'));
          } else {
                      $mail = new Mail();
                      $mail->protocol = $this->config->get('config_mail_protocol');
          }
          
                    $mail->parameter = $this->config->get('config_mail_parameter');
                    $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                    $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                    $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                    $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                    $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
    
                    $mail->setTo($this->config->get('config_email'));

          $this->load->model('tool/pdf_invoice');
      
                if ($this->config->get('pdf_invoice_admincopy')){
                    $temp_pdf_admin = $this->model_tool_pdf_invoice->generate($order_id, 'file', 'invoice', $this->config->get('pdf_invoice_adminlang'), array('order_comment' => nl2br($comment)));
                    $mail->addAttachment($temp_pdf_admin);
                }
                
                if($this->config->get('pdf_invoice_packingslip')){
                    $temp_pdf_slip = $this->model_tool_pdf_invoice->generate($order_id, 'file', 'packingslip', $this->config->get('pdf_invoice_adminlang'));
                    $mail->addAttachment($temp_pdf_slip);
                }

                    $mail->setFrom($this->config->get('config_email'));
                    $mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
                    $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));

                    if (version_compare(VERSION, '3', '>=')) {
            $mail->setHtml($this->front_load->view('mail/order_add.twig', $data));
          } else {
                    $mail->setHtml($this->front_load->view('mail/order', $data));
          }
        
                    $mail->setText($text);
                    $mail->send();
    
                    // Send to additional alert emails
                    $emails = explode(',', $this->config->get('config_alert_email'));
    
                    foreach ($emails as $email) {
                        if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $mail->setTo($email);
                            $mail->send();
                        }
                    }

        if(isset($temp_pdf_slip) && is_file($temp_pdf_slip)){
                    unlink($temp_pdf_slip);
                }
                if(isset($temp_pdf_admin) && is_file($temp_pdf_admin)){
                    unlink($temp_pdf_admin);
                }

                }
            }

            // If order status is not 0 then send update text email
            if ($order_info['order_status_id'] && $order_status_id && $notify) {
        if (isset($order_info['language_directory'])) {
          $language = new GkdLanguage($order_info['language_directory']);
          $language->load($order_info['language_directory']);
        } else {
          $language = new GkdLanguage($order_info['language_code']);
          $language->load($order_info['language_code']);
        }

        if (version_compare(VERSION, '3', '>=')) {
          $language->load('mail/order_edit');
          $language->set('text_update_subject', $language->get('text_subject'));
          $language->set('text_update_order', $language->get('text_order_id'));
          $language->set('text_update_order_status', $language->get('text_order_status'));
          $language->set('text_update_date_added', $language->get('text_date_added'));
          $language->set('text_update_link', $language->get('text_link'));
          $language->set('text_update_comment', $language->get('text_comment'));
          $language->set('text_update_footer', $language->get('text_footer'));
        } else {
          $language->load('mail/order');
        }
                
                $subject = sprintf($language->get('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);
    
        if ($this->config->get('qosu_message_mode') && $comment) {
          $message = strip_tags($comment);
        } else {
          $message  = $language->get('text_update_order') . ' ' . $order_id . "\n";
          $message .= $language->get('text_update_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";
    
          $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
    
          if ($order_status_query->num_rows) {
            $message .= $language->get('text_update_order_status') . "\n\n";
            $message .= $order_status_query->row['name'] . "\n\n";
          }
    
          if ($order_info['customer_id']) {
            $message .= $language->get('text_update_link') . "\n";
            $message .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
          }
    
          if ($comment) {
            $message .= $language->get('text_update_comment') . "\n\n";
            $message .= strip_tags($comment) . "\n\n";
          }
    
          $message .= $language->get('text_update_footer');
        }
        // order status update email
                if (version_compare(VERSION, '3', '>=')) {
          $mail = new Mail($this->config->get('config_mail_engine'));
        } else {
                  $mail = new Mail();
                  $mail->protocol = $this->config->get('config_mail_protocol');
        }
        
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
    
                $mail->setTo($order_info['email']);
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
                $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
                $mail->setText($message);
                
        // PDF order.update
                if (in_array($order_status_id, (array) $this->config->get('pdf_invoice_auto_notify'))) {
          if (!$this->config->get('pdf_invoice_invoiced') || ($this->config->get('pdf_invoice_invoiced') && $order_info['invoice_no'])) {
            $this->load->model('tool/pdf_invoice');
            $temp_pdf = $this->model_tool_pdf_invoice->generate($order_id, 'file', 'invoice');
            $mail->addAttachment($temp_pdf);
          }
                }

        $mail->send();

        if (isset($temp_pdf) && is_file($temp_pdf)) {
                    unlink($temp_pdf);
                }
            }
        }
    }
  
}