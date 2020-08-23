<?php
/**
 * order_admin.php
 *
 * Order management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');


class ControllerRestOrderAdmin extends RestAdminController
{


    public function orders()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //get order details
            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->getOrder($this->request->get['id']);
            } else {
                //get orders list
                $this->listOrders();
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            //update order data
            $post = $this->getPost();


            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])
                && !empty($post)
            ) {
                $this->updateOrder($this->request->get['id'], $post);
            } else {
                $this->statusCode = 400;
            }


        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            //delete order
            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->deleteOrder($this->request->get['id']);
            } else {
                $this->statusCode = 400;
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST", "PUT", "DELETE");
        }

        return $this->sendResponse();
    }

    public function getOrder($order_id)
    {

        $this->load->model('checkout/order');
        $this->load->model('account/order');


        if (ctype_digit($order_id)) {
            $order_info = $this->model_checkout_order->getOrder($order_id);

            if (!empty($order_info)) {

                $this->json['data'] = $this->getOrderDetailsToOrder($order_info);

            } else {
                $this->json['error'][] = "Order not found";
                $this->statusCode = 404;

            }
        } else {
            $this->statusCode = 400;

        }

    }


    private function getOrderDetailsToOrder($order_info)
    {

        $this->load->model('catalog/product');
        $this->load->model('rest/restadmin');
        $this->load->model('account/order');

        $orderData = array();

        if (!empty($order_info)) {
            foreach ($order_info as $key => $value) {
                $orderData[$key] = $value;
            }

            $orderData['products'] = array();

            $products = $this->model_account_order->getOrderProducts($orderData['order_id']);

            $item_total_exclude_tax = 0;
            $item_total_tax = 0;

            foreach ($products as $product) {
                $option_data = array();

                $options = $this->model_rest_restadmin->getOrderOptions($orderData['order_id'], $product['order_product_id']);

                foreach ($options as $option) {
                    if ($option['type'] != 'file') {
                        $option_data[] = array(
                            'name' => $option['name'],
                            'value' => $option['value'],
                            'type' => $option['type'],
                            'product_option_id' => isset($option['product_option_id']) ? $option['product_option_id'] : "",
                            'product_option_value_id' => isset($option['product_option_value_id']) ? $option['product_option_value_id'] : "",
                            'option_id' => isset($option['option_id']) ? $option['option_id'] : "",
                            'option_value_id' => isset($option['option_value_id']) ? $option['option_value_id'] : "",
                            'sku' => isset($option['option_sku']) ? $option['option_sku'] : ""

                        );
                    } else {
                        $option_data[] = array(
                            'name' => $option['name'],
                            'value' => utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.')),
                            'type' => $option['type'],
                            'sku' => isset($option['option_sku']) ? $option['option_sku'] : ""

                        );
                    }
                }

                $origProduct = $this->model_catalog_product->getProduct($product['product_id']);

                $orderData['products'][] = array(
                    'order_product_id' => $product['order_product_id'],
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'model' => $product['model'],
                    'image' => $origProduct['image'],
                    'sku' => (!empty($origProduct['sku']) ? $origProduct['sku'] : ""),
                    'option' => $option_data,
                    'quantity' => $product['quantity'],
                    'currency_code' => $order_info['currency_code'],
                    'currency_value' => $order_info['currency_value'],
                    'price_formated' => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
                    'price' => (float)$this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value'], false),
                    'price_exclude_tax' => (float)$this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value'], false),
                    'tax' => (float)$this->currency->format(($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value'], false),
                    'total_formated' => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
                    'total' => (float)$this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'], false),
                    'total_exclude_tax' => (float)$this->currency->format($product['total'], $order_info['currency_code'], $order_info['currency_value'], false),
                    'total_tax' => (float)$this->currency->format(($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'], false),
                );

                $item_total_exclude_tax += $product['total'];
                $item_total_tax += ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0);
            }
        }

        $orderData['histories'] = array();

        $histories = $this->model_rest_restadmin->getOrderHistories($orderData['order_id'], 0, 1000);

        foreach ($histories as $result) {
            $orderData['histories'][] = array(
                'notify' => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
                'status' => $result['status'],
                'comment' => nl2br($result['comment']),
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
            );
        }

        $vouchers = $this->model_rest_restadmin->getOrderVouchers($orderData['order_id']);

        foreach ($vouchers as $voucher) {
            $orderData['vouchers'][] = array(
                'description' => $voucher['description'],
                'amount' => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
            );
        }

        $totals = $this->model_rest_restadmin->getOrderTotals($orderData['order_id']);

        foreach ($totals as $total) {
            $orderData['totals'][] = array(
                'title' => $total['title'],
                'text' => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
                'value' => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'], false)
            );
        }

        unset($total);

        $shippingCode = explode(".", $orderData['shipping_code']);
        $shippingTaxClassId = $this->config->get($shippingCode[0] . '_tax_class_id');

        $shipping_total = $this->model_rest_restadmin->getOrderSubValue($orderData['order_id'], 'shipping');

        $orderData['shipping_exclude_tax'] = 0;
        $orderData['shipping_tax'] = 0;

        if (!empty($shippingTaxClassId)) {
            $shipping_lines = $this->model_rest_restadmin->getOrderTotalSubTaxes($shippingTaxClassId, 'shipping');

            foreach ($shipping_lines as $line) {
                $rate = (float)$line['rate'];
                if ($line['type'] == "P") {
                    $tax = array(
                        'name' => $line['name'],
                        'price' => $this->currency->format($shipping_total, $order_info['currency_code'], $order_info['currency_value'], false),
                        'tax' => $this->currency->format((($shipping_total / 100) * $rate), $order_info['currency_code'], $order_info['currency_value'], false)
                    );
                    $orderData['shipping_exclude_tax'] += $shipping_total;
                    $orderData['shipping_tax'] += (($shipping_total / 100) * $rate);
                } else {
                    $tax = array(
                        'name' => $line['name'],
                        'price' => 0,
                        'tax' => $this->currency->format($rate, $order_info['currency_code'], $order_info['currency_value'], false)
                    );

                    $orderData['shipping_exclude_tax'] += 0;
                    $orderData['shipping_tax'] += $rate;

                }
                $orderData['shipping_lines'][] = $tax;
            }
        } else {
            $orderData['shipping_total'] = $this->currency->format($shipping_total, $order_info['currency_code'], $order_info['currency_value'], false);
        }

        $orderData['shipping_exclude_tax'] = (float)$this->currency->format($orderData['shipping_exclude_tax'], $order_info['currency_code'], $order_info['currency_value'], false);
        $orderData['shipping_tax'] = (float)$this->currency->format($orderData['shipping_tax'], $order_info['currency_code'], $order_info['currency_value'], false);

        $orderData['item_total_tax'] = (float)$this->currency->format($item_total_tax, $order_info['currency_code'], $order_info['currency_value'], false);
        $orderData['item_total_exclude_tax'] = (float)$this->currency->format($item_total_exclude_tax, $order_info['currency_code'], $order_info['currency_value'], false);

        $subtotal = $this->model_rest_restadmin->getOrderSubValue($orderData['order_id'], 'sub_total');
        $orderData['subtotal'] = (float)$this->currency->format($subtotal, $order_info['currency_code'], $order_info['currency_value'], false);
        $orderData['total'] = (float)$this->currency->format($orderData['total'], $order_info['currency_code'], $order_info['currency_value'], false);

        $couponInfo = $this->model_rest_restadmin->getOrderCoupon($orderData['order_id']);

        $orderData['coupons'] = array();

        if (!empty($couponInfo)) {
            foreach ($couponInfo as $couponItem) {
                $orderData['coupons'][] = array('code' => $couponItem['code'], 'amount' =>
                    (string)$this->currency->format(abs($couponItem['amount']), $order_info['currency_code'], $order_info['currency_value'], false)
                );
            }
        }

        $voucherInfo = $this->model_rest_restadmin->getOrderVoucher($orderData['order_id']);
        $orderData['discounts'] = array();
        if (!empty($voucherInfo)) {
            foreach ($voucherInfo as $voucherItem) {
                $orderData['discounts'][] = array('code' => $voucherItem['code'], 'amount' =>
                    (string)$this->currency->format(abs($voucherItem['amount']), $order_info['currency_code'], $order_info['currency_value'], false)
                );
            }
        }

        return $orderData;
    }


    public function listOrders()
    {

        $this->load->model('rest/restadmin');

        /*check limit parameter*/
        if (isset($this->request->get['limit']) && $this->request->get['limit'] != "" && ctype_digit($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
        } else {
            $limit = 20;
        }

        $page = 1;

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        }

        /*check offset parameter because of BC compatibility*/
        if (isset($this->request->get['offset']) && $this->request->get['offset'] != "" && ctype_digit($this->request->get['offset'])) {
            $page = $this->request->get['page'];
        }

        $filter_date_added_from = null;

        if (isset($this->request->get['filter_date_added_from'])) {
            $date_added_from = date('Y-m-d H:i:s', strtotime($this->request->get['filter_date_added_from']));
            if ($this->validateDate($date_added_from)) {
                $filter_date_added_from = $date_added_from;
            }
        }

        $filter_date_added_on = null;

        if (isset($this->request->get['filter_date_added_on'])) {
            $date_added_on = date('Y-m-d', strtotime($this->request->get['filter_date_added_on']));
            if ($this->validateDate($date_added_on, 'Y-m-d')) {
                $filter_date_added_on = $date_added_on;
            }
        }

        $filter_date_added_to = null;
        if (isset($this->request->get['filter_date_added_to'])) {
            $date_added_to = date('Y-m-d H:i:s', strtotime($this->request->get['filter_date_added_to']));
            if ($this->validateDate($date_added_to)) {
                $filter_date_added_to = $date_added_to;
            }
        }

        $filter_date_modified_on = null;

        if (isset($this->request->get['filter_date_modified_on'])) {
            $date_modified_on = date('Y-m-d', strtotime($this->request->get['filter_date_modified_on']));
            if ($this->validateDate($date_modified_on, 'Y-m-d')) {
                $filter_date_modified_on = $date_modified_on;
            }
        }

        $filter_date_modified_from = null;

        if (isset($this->request->get['filter_date_modified_from'])) {
            $date_modified_from = date('Y-m-d H:i:s', strtotime($this->request->get['filter_date_modified_from']));
            if ($this->validateDate($date_modified_from)) {
                $filter_date_modified_from = $date_modified_from;
            }
        }

        $filter_date_modified_to = null;
        if (isset($this->request->get['filter_date_modified_to'])) {
            $date_modified_to = date('Y-m-d H:i:s', strtotime($this->request->get['filter_date_modified_to']));
            if ($this->validateDate($date_modified_to)) {
                $filter_date_modified_to = $date_modified_to;
            }
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $filter_order_status_id = $this->request->get['filter_order_status_id'];
        } else {
            $filter_order_status_id = null;
        }

        /*check filter_id_lower_than parameter*/
        if (isset($this->request->get['filter_id_lower_than']) && ctype_digit($this->request->get['filter_id_lower_than'])) {
            $filter_id_lower_than = $this->request->get['filter_id_lower_than'];
        } else {
            $filter_id_lower_than = null;
        }

        /*check filter_id_larger_than parameter*/
        if (isset($this->request->get['filter_id_larger_than']) && ctype_digit($this->request->get['filter_id_larger_than'])) {
            $filter_id_larger_than = $this->request->get['filter_id_larger_than'];
        } else {
            $filter_id_larger_than = null;
        }

        $data = array(
            'filter_date_added_on' => $filter_date_added_on,
            'filter_date_added_from' => $filter_date_added_from,
            'filter_date_added_to' => $filter_date_added_to,
            'filter_date_modified_on' => $filter_date_modified_on,
            'filter_date_modified_from' => $filter_date_modified_from,
            'filter_date_modified_to' => $filter_date_modified_to,
            'filter_order_status' => $filter_order_status_id,
            'filter_id_lower_than' => $filter_id_lower_than,
            'filter_id_larger_than' => $filter_id_larger_than,
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );

        /*get all orders of user*/
        $results = $this->model_rest_restadmin->getAllOrders($data);

        $orders = array();

        if (count($results)) {
            foreach ($results as $result) {

                $product_total = $this->model_rest_restadmin->getTotalOrderProductsByOrderId($result['order_id']);
                $voucher_total = $this->model_rest_restadmin->getTotalOrderVouchersByOrderId($result['order_id']);

                $orders[] = array(
                    'order_id' => $result['order_id'],
                    'name' => $result['firstname'] . ' ' . $result['lastname'],
                    'status' => $result['status'],
                    'date_added' => $result['date_added'],
                    'products' => ($product_total + $voucher_total),
                    'total' => $result['total'],
                    'currency_code' => $result['currency_code'],
                    'currency_value' => $result['currency_value'],
                );
            }

            $this->json['data'] = $orders;

        } else {
            $this->json['data'] = array();
        }
    }

    public function updateOrder($id, $data)
    {

        $this->load->model('checkout/order');

        if (ctype_digit($id)) {

            if (isset($data['status']) && ctype_digit($data['status'])) {

                $result = $this->model_checkout_order->getOrder($id);
                if (!empty($result)) {
                    $this->model_checkout_order->addOrderHistory($id, $data['status']);
                } else {
                    $this->json['error'][] = "Order not found";
                    $this->statusCode = 404;
                }

            } else {
                $this->statusCode = 400;
            }
        }
    }

    public function deleteOrder($id)
    {

        $this->load->model('checkout/order');

        if (ctype_digit($id)) {
            $result = $this->model_checkout_order->getOrder($id);

            if (!empty($result)) {
                // Void the order first
                $this->model_checkout_order->addOrderHistory($id, 0);

                $this->model_checkout_order->deleteOrder($id);

                // Gift Voucher
                $this->load->model('extension/total/voucher');

                $this->model_extension_total_voucher->disableVoucher($id);


            } else {
                $this->json['error'][] = "Order not found";
                $this->statusCode = 404;
            }
        } else {
            $this->statusCode = 400;
        }
    }

    public function listorderswithdetails()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $this->load->model('rest/restadmin');

            /*check limit parameter*/
            if (isset($this->request->get['limit']) && $this->request->get['limit'] != "" && ctype_digit($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 100000;
            }

            $filter_date_added_from = null;

            if (isset($this->request->get['filter_date_added_from'])) {
                $date_added_from = date('Y-m-d H:i:s', strtotime($this->request->get['filter_date_added_from']));
                if ($this->validateDate($date_added_from)) {
                    $filter_date_added_from = $date_added_from;
                }
            }

            $filter_date_added_on = null;

            if (isset($this->request->get['filter_date_added_on'])) {
                $date_added_on = date('Y-m-d', strtotime($this->request->get['filter_date_added_on']));
                if ($this->validateDate($date_added_on, 'Y-m-d')) {
                    $filter_date_added_on = $date_added_on;
                }
            }

            $filter_date_added_to = null;
            if (isset($this->request->get['filter_date_added_to'])) {
                $date_added_to = date('Y-m-d H:i:s', strtotime($this->request->get['filter_date_added_to']));
                if ($this->validateDate($date_added_to)) {
                    $filter_date_added_to = $date_added_to;
                }
            }

            $filter_date_modified_on = null;

            if (isset($this->request->get['filter_date_modified_on'])) {
                $date_modified_on = date('Y-m-d', strtotime($this->request->get['filter_date_modified_on']));
                if ($this->validateDate($date_modified_on, 'Y-m-d')) {
                    $filter_date_modified_on = $date_modified_on;
                }
            }

            $filter_date_modified_from = null;

            if (isset($this->request->get['filter_date_modified_from'])) {
                $date_modified_from = date('Y-m-d H:i:s', strtotime($this->request->get['filter_date_modified_from']));
                if ($this->validateDate($date_modified_from)) {
                    $filter_date_modified_from = $date_modified_from;
                }
            }

            $filter_date_modified_to = null;
            if (isset($this->request->get['filter_date_modified_to'])) {
                $date_modified_to = date('Y-m-d H:i:s', strtotime($this->request->get['filter_date_modified_to']));
                if ($this->validateDate($date_modified_to)) {
                    $filter_date_modified_to = $date_modified_to;
                }
            }

            if (isset($this->request->get['page'])) {
                $page = $this->request->get['page'];
            } else {
                $page = 1;
            }

            if (isset($this->request->get['filter_order_status_id'])) {
                $filter_order_status_id = $this->request->get['filter_order_status_id'];
            } else {
                $filter_order_status_id = null;
            }

            /*check filter_id_lower_than parameter*/
            if (isset($this->request->get['filter_id_lower_than']) && ctype_digit($this->request->get['filter_id_lower_than'])) {
                $filter_id_lower_than = $this->request->get['filter_id_lower_than'];
            } else {
                $filter_id_lower_than = null;
            }

            /*check filter_id_larger_than parameter*/
            if (isset($this->request->get['filter_id_larger_than']) && ctype_digit($this->request->get['filter_id_larger_than'])) {
                $filter_id_larger_than = $this->request->get['filter_id_larger_than'];
            } else {
                $filter_id_larger_than = null;
            }

            $data = array(
                'filter_date_added_on' => $filter_date_added_on,
                'filter_date_added_from' => $filter_date_added_from,
                'filter_date_added_to' => $filter_date_added_to,
                'filter_date_modified_on' => $filter_date_modified_on,
                'filter_date_modified_from' => $filter_date_modified_from,
                'filter_date_modified_to' => $filter_date_modified_to,
                'filter_order_status' => $filter_order_status_id,
                'filter_id_lower_than' => $filter_id_lower_than,
                'filter_id_larger_than' => $filter_id_larger_than,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );


            $results = $this->model_rest_restadmin->getOrdersByFilter($data);
            /*get all orders*/
            //$results = $this->model_account_order->getAllOrders($offset, $limit);

            $orders = array();

            if (count($results)) {

                foreach ($results as $result) {

                    $orderData = $this->getOrderDetailsToOrder($result);

                    if (!empty($orderData)) {
                        $orders[] = $orderData;
                    }
                }

                $this->json['data'] = $orders;

            } else {
                $this->json['data'] = array();
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();

    }


    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function userorders()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $user = null;

            /*check user parameter*/
            if (isset($this->request->get['user']) && $this->request->get['user'] != ""
                && ctype_digit($this->request->get['user'])) {
                $user = $this->request->get['user'];

                $orderData['orders'] = array();

                $this->load->model('rest/restadmin');

                /*get all orders of user*/
                $results = $this->model_rest_restadmin->getOrdersByUser($user);

                $orders = array();

                foreach ($results as $result) {

                    $product_total = $this->model_rest_restadmin->getTotalOrderProductsByOrderId($result['order_id']);
                    $voucher_total = $this->model_rest_restadmin->getTotalOrderVouchersByOrderId($result['order_id']);

                    $orders[] = array(
                        'order_id' => $result['order_id'],
                        'name' => $result['firstname'] . ' ' . $result['lastname'],
                        'status' => $result['status'],
                        'date_added' => $result['date_added'],
                        'products' => ($product_total + $voucher_total),
                        'total' => $result['total'],
                        'currency_code' => $result['currency_code'],
                        'currency_value' => $result['currency_value'],
                    );
                }

                $this->json['data'] = $orders;

            } else {
                $this->statusCode = 400;
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }

    public function orderstatus()
    {

        $this->checkPlugin();
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {

                $post = $this->getPost();

                $this->updateOrderStatusByName($this->request->get['id'], $post);

            } else {
                $this->statusCode = 400;
                $this->json['error'][] = "Invalid request, please set order id.";

            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("PUT");
        }

        return $this->sendResponse();
    }

    public function updateOrderStatusByName($id, $data)
    {

        $this->load->model('checkout/order');

        if (ctype_digit($id)) {
            if (isset($data['status']) && ($data['status']) != "") {

                $status = $this->findStatusByName($data['status']);

                if ($status) {
                    $result = $this->model_checkout_order->getOrder($id);
                    if (!empty($result)) {

                        $this->model_checkout_order->addOrderHistory($id, $status);
                    } else {
                        $this->json['error'][] = "Order not found";
                        $this->statusCode = 404;
                    }
                } else {
                    $this->statusCode = 400;
                    $this->json['error'][] = "The specified status does not exist.";
                }
            } else {
                $this->statusCode = 400;
                $this->json['error'][] = "Invalid status id";
            }
        } else {
            $this->statusCode = 400;
            $this->json['error'][] = "Invalid order id";
        }

    }

    private function findStatusByName($status_name)
    {
        $this->load->model('rest/restadmin');

        $status_id = $this->model_rest_restadmin->getOrderStatusByName($status_name);
        return ((count($status_id) > 0 && $status_id[0]['order_status_id']) ? $status_id[0]['order_status_id'] : false);
    }

    public function orderhistory()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

            $post = $this->getPost();

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->addOrderHistory($this->request->get['id'], $post);
            } else {
                $this->json['error'][] = "Invalid order id";
                $this->statusCode = 400;
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("PUT");
        }

        return $this->sendResponse();
    }

    //date format validator

    private function addOrderHistory($id, $data)
    {

        $this->load->model('checkout/order');

        $order_info = $this->model_checkout_order->getOrder($id);

        if ($order_info) {
            $this->model_checkout_order->addOrderHistory($id, $data['order_status_id'], $data['comment'], $data['notify']);
        } else {
            $this->json['error'][] = "Order not found";
            $this->statusCode = 404;
        }
    }


    public function order()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->getPost();

            $this->addOrder($post);
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        return $this->sendResponse();
    }


    public function addOrder($post)
    {
        $error = array();

        unset($this->session->data['shipping_method']);
        unset($this->session->data['shipping_methods']);
        unset($this->session->data['payment_address']);
        unset($this->session->data['payment_methods']);
        unset($this->session->data['payment_method']);
        unset($this->session->data['customer']);
        $this->cart->clear();

        // Validate if payment address has been set.
        if (!isset($post['payment_address'])) {
            $error[] = "Payment address is empty";
        }

        // Validate if payment method has been set.
        if (!isset($post['payment_method'])) {
            $error[] = "Payment method is empty";
        }

        // Validate if customer has been set.
        if (!isset($post['customer'])) {
            $error[] = "Customer is required";
        }

        if ((!isset($post['products'])) || empty($post['products'])) {
            $error[] = "Product is required";
        }

        if (empty($error)) {

            //Add items to cart
            $this->load->model('catalog/product');

            $cartResult = true;

            $products = $post['products'];

            foreach ($products as $product) {
                $cartResult = $this->addItemCart($product);
                if ($cartResult["success"] == false) {
                    break;
                }
            }

            if ($cartResult["success"] == false || !empty($this->json['error'])) {
                return $this->sendResponse();
            }

            $this->load->model('rest/restadmin');

            $order_data = array();

            $this->load->language('checkout/checkout');

            $order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
            $order_data['store_id'] = $this->config->get('config_store_id');
            $order_data['store_name'] = $this->config->get('config_name');

            if ($order_data['store_id']) {
                $order_data['store_url'] = $this->config->get('config_url');
            } else {
                $order_data['store_url'] = HTTP_SERVER;
            }


            $customer_info = $post["customer"];

            $order_data['customer_id'] = $customer_info['customer_id'];
            $order_data['customer_group_id'] = $customer_info['customer_group_id'];
            $order_data['firstname'] = $customer_info['firstname'];
            $order_data['lastname'] = $customer_info['lastname'];
            $order_data['email'] = $customer_info['email'];
            $order_data['telephone'] = $customer_info['telephone'];
            $order_data['fax'] = $customer_info['fax'];

            $custom_field = array();
            if (isset($customer_info['custom_field']) && !empty($customer_info['custom_field'])) {
                $custom_field = json_decode($customer_info['custom_field'], true);
            }
            $order_data['custom_field'] = $custom_field;

            $order_data['payment_firstname'] = $post['payment_address']['firstname'];
            $order_data['payment_lastname'] = $post['payment_address']['lastname'];
            $order_data['payment_company'] = isset($post['payment_address']['company']) ? $post['payment_address']['company'] : "";
            $order_data['payment_address_1'] = $post['payment_address']['address_1'];
            $order_data['payment_address_2'] = $post['payment_address']['address_2'];
            $order_data['payment_city'] = $post['payment_address']['city'];
            $order_data['payment_postcode'] = $post['payment_address']['postcode'];
            $order_data['payment_zone'] = isset($post['payment_address']['zone']) ? $post['payment_address']['zone'] : "";
            $order_data['payment_zone_id'] = $post['payment_address']['zone_id'];
            $order_data['payment_country'] = isset($post['payment_address']['country']) ? $post['payment_address']['country'] : "";
            $order_data['payment_country_id'] = $post['payment_address']['country_id'];
            //$order_data['payment_address_format'] = $post['payment_address']['address_format'];
            $order_data['payment_address_format'] = "";
            $order_data['payment_custom_field'] = (isset($post['payment_address']['custom_field']) ? $post['payment_address']['custom_field'] : array());

            if (isset($post['payment_method']['title'])) {
                $order_data['payment_method'] = $post['payment_method']['title'];
            } else {
                $order_data['payment_method'] = '';
            }

            if (isset($post['payment_method']['code'])) {
                $order_data['payment_code'] = $post['payment_method']['code'];
            } else {
                $order_data['payment_code'] = '';
            }


            // Customer Group
            if ($order_data['customer_group_id'] != "") {
                $this->config->set('config_customer_group_id', $order_data['customer_group_id']);
                //$order_data['customer_group_id'] = $order_data['customer_group_id'];
            } else {
                $order_data['customer_group_id'] = $this->config->get('config_customer_group_id');
            }
            // Customer Details
            $this->session->data['customer']['customer_id'] = $order_data['customer_id'];
            $this->session->data['customer']['customer_group_id'] = $order_data['customer_group_id'];
            $this->session->data['customer']['firstname'] = $order_data['firstname'];
            $this->session->data['customer']['lastname'] = $order_data['lastname'];
            $this->session->data['customer']['email'] = $order_data['email'];
            $this->session->data['customer']['telephone'] = $order_data['telephone'];
            $this->session->data['customer']['fax'] = $order_data['fax'];
            $this->session->data['customer']['custom_field'] = $order_data['custom_field'];

            $this->session->data['payment_address']['firstname'] = $order_data['payment_firstname'];
            $this->session->data['payment_address']['lastname'] = $order_data['payment_lastname'];
            $this->session->data['payment_address']['company'] = $order_data['payment_company'];
            $this->session->data['payment_address']['address_1'] = $order_data['payment_address_1'];
            $this->session->data['payment_address']['address_2'] = $order_data['payment_address_2'];
            $this->session->data['payment_address']['city'] = $order_data['payment_city'];
            $this->session->data['payment_address']['postcode'] = $order_data['payment_postcode'];
            $this->session->data['payment_address']['zone'] = $order_data['payment_zone'];
            $this->session->data['payment_address']['zone_id'] = $order_data['payment_zone_id'];
            $this->session->data['payment_address']['country'] = $order_data['payment_country'];
            $this->session->data['payment_address']['country_id'] = $order_data['payment_country_id'];
            $this->session->data['payment_address']['address_format'] = $order_data['payment_address_format'];
            $this->session->data['payment_address']['custom_field'] = $order_data['payment_custom_field'];


            if (isset($post['shipping_address']) && !empty($post['shipping_address'])) {

                $order_data['shipping_firstname'] = $post['shipping_address']['firstname'];
                $order_data['shipping_lastname'] = $post['shipping_address']['lastname'];
                $order_data['shipping_company'] = isset($post['shipping_address']['company']) ? $post['shipping_address']['company'] : "";
                $order_data['shipping_address_1'] = $post['shipping_address']['address_1'];
                $order_data['shipping_address_2'] = $post['shipping_address']['address_2'];
                $order_data['shipping_city'] = $post['shipping_address']['city'];
                $order_data['shipping_postcode'] = $post['shipping_address']['postcode'];
                $order_data['shipping_zone_id'] = isset($post['shipping_address']['zone_id']) ? $post['shipping_address']['zone_id'] : "";
                $order_data['shipping_country_id'] = $post['shipping_address']['country_id'];

                $order_data['shipping_address_format'] = "";

                $order_data['shipping_custom_field'] = (isset($post['shipping_address']['custom_field']) ? $post['shipping_address']['custom_field'] : array());

                if (isset($post['shipping_method']['title'])) {
                    $order_data['shipping_method'] = $post['shipping_method']['title'];
                } else {
                    $order_data['shipping_method'] = '';
                }

                if (isset($post['shipping_method']['code'])) {
                    $order_data['shipping_code'] = $post['shipping_method']['code'];
                } else {
                    $order_data['shipping_code'] = '';
                }

                $this->load->model('localisation/country');

                $country_info = $this->model_localisation_country->getCountry($order_data['shipping_country_id']);

                if ($country_info) {
                    $country = $country_info['name'];
                    $iso_code_2 = $country_info['iso_code_2'];
                    $iso_code_3 = $country_info['iso_code_3'];
                } else {
                    $country = '';
                    $iso_code_2 = '';
                    $iso_code_3 = '';
                }

                $this->load->model('localisation/zone');

                $zone_info = $this->model_localisation_zone->getZone($order_data['shipping_zone_id']);

                if ($zone_info) {
                    $zone = $zone_info['name'];
                    $zone_code = $zone_info['code'];
                } else {
                    $zone = '';
                    $zone_code = '';
                }

                $order_data['shipping_country'] = isset($post['shipping_address']['country']) ? $post['shipping_address']['country'] : $country;
                $order_data['shipping_zone'] =  isset($post['shipping_address']['zone']) ? $post['shipping_address']['zone'] : $zone;
                $order_data['shipping_zone_code'] = isset($post['shipping_address']['zone_id']) ? $post['shipping_address']['zone_id'] : $zone_code;

                $order_data['iso_code_2'] = $iso_code_2;
                $order_data['iso_code_3'] = $iso_code_3;

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
                $order_data['shipping_zone_code'] = '';
                $order_data['iso_code_2'] = '';
                $order_data['iso_code_3'] = '';
            }

            $this->session->data['shipping_address']['firstname'] = $order_data['shipping_firstname'];
            $this->session->data['shipping_address']['lastname'] = $order_data['shipping_lastname'];
            $this->session->data['shipping_address']['company'] = $order_data['shipping_company'];
            $this->session->data['shipping_address']['address_1'] = $order_data['shipping_address_1'];
            $this->session->data['shipping_address']['address_2'] = $order_data['shipping_address_2'];
            $this->session->data['shipping_address']['city'] = $order_data['shipping_city'];
            $this->session->data['shipping_address']['postcode'] = $order_data['shipping_postcode'];
            $this->session->data['shipping_address']['zone'] = $order_data['shipping_zone'];
            $this->session->data['shipping_address']['zone_id'] = $order_data['shipping_zone_id'];
            $this->session->data['shipping_address']['country'] = $order_data['shipping_country'];
            $this->session->data['shipping_address']['country_id'] = $order_data['shipping_country_id'];
            $this->session->data['shipping_address']['address_format'] = $order_data['shipping_address_format'];
            $this->session->data['shipping_address']['custom_field'] = $order_data['shipping_custom_field'];
            $this->session->data['shipping_address']['shipping_zone_code'] = $order_data['shipping_zone_code'];
            $this->session->data['shipping_address']['iso_code_2'] = $order_data['iso_code_2'];
            $this->session->data['shipping_address']['iso_code_3'] = $order_data['iso_code_3'];


            // Tax
            $this->registry->set('tax', new Cart\Tax($this->registry));

            if ($this->config->get('config_tax_default') == 'shipping') {
                $this->tax->setShippingAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
            }

            if ($this->config->get('config_tax_default') == 'payment') {
                $this->tax->setPaymentAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
            }

            $this->tax->setStoreAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));

            // Cart
            $this->registry->set('cart', new Cart\Cart($this->registry));

            $this->paymentmethods();

            if (isset($this->session->data['payment_methods'][$order_data['payment_code']])) {
                $this->session->data['payment_method'] = $this->session->data['payment_methods'][$order_data['payment_code']];
            } else {
                $this->session->data['payment_method'] = '';
            }

            $this->shippingmethods();

            if ($this->cart->hasShipping()) {
                $shipping = explode('.', $order_data['shipping_code']);
                if(count($shipping) > 1){
                    $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
                } else {
                    $this->json['error'][] = "Shipping method is required";
                }

                if(!empty($this->json['error'])){
                    $this->statusCode = 400;
                    return false;
                }
            } else {
                unset($this->session->data['shipping_address']);
                unset($this->session->data['shipping_method']);
                unset($this->session->data['shipping_methods']);
            }

            $order_data['products'] = array();

            foreach ($this->cart->getProducts() as $product) {
                $option_data = array();

                foreach ($product['option'] as $option) {
                    if ($option['type'] != 'file') {
                        $value = $option['value'];
                    } else {
                        $value = "";
                    }

                    $option_data[] = array(
                        'product_option_id' => $option['product_option_id'],
                        'product_option_value_id' => $option['product_option_value_id'],
                        'option_id' => $option['option_id'],
                        'option_value_id' => $option['option_value_id'],
                        'name' => $option['name'],
                        'value' => $value,
                        'type' => $option['type']
                    );
                }

                $order_data['products'][] = array(
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'model' => $product['model'],
                    'option' => $option_data,
                    'download' => (isset($product['download']) && !empty($product['download'])) ? $product['download'] : array(),
                    'quantity' => $product['quantity'],
                    'subtract' => $product['subtract'],
                    'price' => $product['price'],
                    'total' => $product['total'],
                    'tax' => $this->tax->getTax($product['price'], $product['tax_class_id']),
                    'reward' => $product['reward']
                );
            }

            // Gift Voucher

            if (isset($post["coupon"]) && $this->validateCoupon($post["coupon"])) {
                $this->session->data['coupon'] = $post["coupon"];
            }

            if (isset($post["voucher"]) && $this->validateVoucher($post["voucher"])) {
                $this->session->data['voucher'] = $post["voucher"];
            }

            $order_data['totals'] = array();

            $totals = array();
            $taxes = $this->cart->getTaxes();
            $total = 0;

            // Because __call can not keep var references so we put them into an array.
            $total_data = array(
                'totals' => &$totals,
                'taxes' => &$taxes,
                'total' => &$total
            );


            $sort_order = array();

            $results = $this->model_rest_restadmin->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get('total_' . $result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $sort_order = array();

            foreach ($total_data['totals'] as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $total_data['totals']);

            $order_data['totals'] = $totals;

            $order_data['total'] = $total_data['total'];

            $order_data['comment'] = $post['comment'];

            $order_data['affiliate_id'] = (isset($post['affiliate_id']) ? $post['affiliate_id'] : 0);
            $order_data['commission'] = (isset($post['commission']) ? $post['commission'] : 0);
            $order_data['marketing_id'] = (isset($post['marketing_id']) ? $post['marketing_id'] : 0);
            $order_data['tracking'] = (isset($post['tracking']) ? $post['tracking'] : '');


            $order_data['language_id'] = $this->config->get('config_language_id');
            $order_data['currency_id'] = $this->currency->getId($this->config->get('config_currency'));
            $order_data['currency_code'] = $this->config->get('config_currency');
            $order_data['currency_value'] = $this->currency->getValue($this->config->get('config_currency'));

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

            $data['order_id'] = $this->model_checkout_order->addOrder($order_data);

            $order_status_id = 1;
            $notify = 0;
            $cod_status = $this->config->get('payment_cod_order_status_id');

            if (!empty($cod_status)) {
                $order_status_id = $cod_status;
            }

            if (!isset($this->session->data['payment_method']) || empty($this->session->data['payment_method'])) {
                $this->model_checkout_order->addOrderHistory($data['order_id'], $order_status_id, isset($order_data['comment']) ? $order_data['comment'] : '', $notify);
            } else {
                $defaultStatus = $this->config->get("payment_" . $this->session->data['payment_method']['code'] . '_order_status_id');
                $defaultStatus = is_null($defaultStatus) ? $order_status_id : $defaultStatus;

                $this->model_checkout_order->addOrderHistory($data['order_id'], $defaultStatus, isset($order_data['comment']) ? $order_data['comment'] : '', $notify);
            }

            $this->json["data"] = array("id" => $data['order_id']);

            //clear session data
            $this->cart->clear();

            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['guest']);
            unset($this->session->data['comment']);
            unset($this->session->data['order_id']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['voucher']);
            unset($this->session->data['vouchers']);
            unset($this->session->data['totals']);


        } else {
            $this->json["error"] = $error;
            $this->statusCode = 400;
        }
    }


    private function addItemCart($data)
    {

        $this->language->load('checkout/cart');

        if (isset($data['product_id'])) {
            $product_id = $data['product_id'];
        } else {
            $product_id = 0;
        }

        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info) {
            if (isset($data['quantity'])) {
                $quantity = $data['quantity'];
            } else {
                $quantity = 1;
            }

            if (isset($data['option']) && !empty($data['option'])) {
                $option = array_filter($data['option']);
            } else {
                $option = array();
            }

            $product_options = $this->model_catalog_product->getProductOptions($data['product_id']);

            foreach ($product_options as $product_option) {
                if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
                    $this->json['error'][] = sprintf($this->language->get('error_required'), $product_option['name']);
                }
            }

            if (isset($data['recurring_id'])) {
                $recurring_id = $data['recurring_id'];
            } else {
                $recurring_id = 0;
            }

            $recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

            if ($recurrings) {
                $recurring_ids = array();

                foreach ($recurrings as $recurring) {
                    $recurring_ids[] = $recurring['recurring_id'];
                }

                if (!in_array($recurring_id, $recurring_ids)) {
                    $this->json['error'][] = $this->language->get('error_recurring_required');
                }
            }
            
            if (empty($this->json['error'])) {
                $this->cart->add($data['product_id'], $quantity, $option);
            }
        } else {

            $this->json['error'][] = "Product not found";
        }

        return $this->json;
    }


    public function paymentmethods()
    {

        $this->load->language('api/payment');

        // Delete past shipping methods and method just in case there is an error
        unset($this->session->data['payment_methods']);
        unset($this->session->data['payment_method']);


        // Totals
        $totals = array();
        $taxes = $this->cart->getTaxes();
        $total = 0;

        // Because __call can not keep var references so we put them into an array.
        $total_data = array(
            'totals' => &$totals,
            'taxes' => &$taxes,
            'total' => &$total
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
                $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);

            }
        }

        // Payment Methods
        $json['payment_methods'] = array();

        $this->load->model('setting/extension');

        $results = $this->model_setting_extension->getExtensions('payment');

        $recurring = $this->cart->hasRecurringProducts();

        foreach ($results as $result) {
            if ($this->config->get('payment_' . $result['code'] . '_status')) {

                $this->load->model('extension/payment/' . $result['code']);

                $method = $this->{'model_extension_payment_' . $result['code']}->getMethod($this->session->data['payment_address'], $total);

                if ($method) {
                    if ($recurring) {
                        if (property_exists($this->{'model_extension_payment_' . $result['code']}, 'recurringPayments') && $this->{'model_extension_payment_' . $result['code']}->recurringPayments()) {
                            $json['payment_methods'][$result['code']] = $method;
                        }
                    } else {
                        $json['payment_methods'][$result['code']] = $method;
                    }
                }
            }
        }

        $sort_order = array();

        foreach ($json['payment_methods'] as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $json['payment_methods']);

        $this->session->data['payment_methods'] = $json['payment_methods'];

    }

    public function shippingmethods()
    {

        // Delete past shipping methods and method just in case there is an error
        unset($this->session->data['shipping_methods']);
        unset($this->session->data['shipping_method']);

        // Shipping Methods
        $json['shipping_methods'] = array();

        $this->load->model('setting/extension');

        $results = $this->model_setting_extension->getExtensions('shipping');

        foreach ($results as $result) {
            if ($this->config->get('shipping_' . $result['code'] . '_status')) {

                $this->load->model('extension/shipping/' . $result['code']);
                $quote = $this->{'model_extension_shipping_' . $result['code']}->getQuote($this->session->data['shipping_address']);


                if ($quote) {
                    $json['shipping_methods'][$result['code']] = array(
                        'title' => $quote['title'],
                        'quote' => $quote['quote'],
                        'sort_order' => $quote['sort_order'],
                        'error' => $quote['error']
                    );
                }
            }
        }

        $sort_order = array();

        foreach ($json['shipping_methods'] as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $json['shipping_methods']);

        if ($json['shipping_methods']) {
            $this->session->data['shipping_methods'] = $json['shipping_methods'];
        } else {
            $this->json['error'][] = $this->language->get('error_no_shipping');
        }

    }


    private function validateCoupon($coupon)
    {
        $error = false;

        $this->load->language('extension/total/coupon');
        $this->load->model('extension/total/coupon');
        $coupon_info = $this->model_extension_total_coupon->getCoupon($coupon);

        if (!$coupon_info) {
            $error = true;
        }

        if (!$error) {
            return true;
        } else {
            return false;
        }
    }

    private function validateVoucher($voucher)
    {
        $error = false;

        $this->load->language('extension/total/voucher');
        $this->load->model('extension/total/voucher');
        $voucher_info = $this->model_extension_total_voucher->getVoucher($voucher);

        if (!$voucher_info) {
            $error = true;
        }

        if (!$error) {
            return true;
        } else {
            return false;
        }
    }

    public function invoice()
    {

        $this->checkPlugin();

        $this->load->model('rest/restadmin');
        $this->load->model('checkout/order');

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

            $post = $this->getPost();

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {

                if(!isset($post['invoice_no']) || empty($post['invoice_no'])
                    || !isset($post['invoice_prefix']) || empty($post['invoice_prefix'])){
                    $this->json['error'][] = "Missing invoice_no or invoice_prefix parameter";
                    $this->statusCode = 400;
                } else {

                    $order_info = $this->model_checkout_order->getOrder($this->request->get['id']);

                    if (!empty($order_info)) {
                        $invoice = $this->model_rest_restadmin->editInvoiceNo(
                            $this->request->get['id'], $post['invoice_no'], $post['invoice_prefix']);

                        if(empty($invoice)) {
                            $this->json['error'][] = "Duplicate Invoice ID";
                            $this->statusCode = 400;
                        } else {
                            $this->json['data'] = $invoice;
                        }

                    } else {
                        $this->json['error'][] = "Order not found";
                        $this->statusCode = 404;
                    }
                }
            } else {
                $this->json['error'][] = "Missing order ID";
                $this->statusCode = 400;
            }

        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {

                $order_info = $this->model_checkout_order->getOrder($this->request->get['id']);

                if (!empty($order_info)) {

                    $this->json['data'] = $this->model_rest_restadmin->createInvoiceNo($this->request->get['id'], $order_info);

                } else {
                    $this->json['error'][] = "Order not found";
                    $this->statusCode = 404;
                }
            } else {
                $this->json['error'][] = "Missing order ID";
                $this->statusCode = 400;
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST", "PUT");
        }

        return $this->sendResponse();
    }


    public function trackingnumber()
    {
        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {

                $post = $this->getPost();

                $this->load->model('rest/restadmin');
                $this->load->model('checkout/order');

                $result = $this->model_checkout_order->getOrder($this->request->get['id']);

                if (!empty($result)) {
                    if(isset($post["tracking"])){
                        $this->model_rest_restadmin->updateOrderTrackingNumber($this->request->get['id'], $post["tracking"]);
                    }
                } else {
                    $this->json['error'][] = "Order not found";
                    $this->statusCode = 404;
                }
            } else {
                $this->statusCode = 400;
                $this->json['error'][] = "Invalid request, please set order id.";
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("PUT");
        }

        return $this->sendResponse();
    }
}