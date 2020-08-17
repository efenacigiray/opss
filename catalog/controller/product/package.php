<?php
class ControllerProductPackage extends Controller {
    private $error = array();

    public function index() {
        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login', '', true));
        }

        if (!$this->customer->class_verified) {
            $this->response->redirect($this->url->link('account/edit', '', true));
        }

        $this->cart->clear();

        $this->load->language('product/package');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $this->load->model('catalog/package');
        $this->load->model('catalog/product');

        $class = $this->model_catalog_package->getClass($this->customer->getClassId());

        $data['breadcrumbs'][] = array(
            'text' => $class['name'] . $this->language->get('text_package'),
            'href' => $this->url->link('product/package')
        );

        $data['packages'] = $this->model_catalog_package->getClassPackages($this->customer->getClassId());
        //var_dump($this->customer->getClassId());
        //var_dump($data[''])

        foreach ($data['packages'] as &$package) {
            foreach ($package['products'] as &$product) {
                $product['purchased'] = 0;
                $product['purchase_quantity'] = 0;
                $product['in_package'] = 1;
            }
        }

        if ($data['packages']) {
            $url = '';

            $data['heading_title'] = $class['name'] . $this->language->get('text_package');
            $this->document->setTitle($data['heading_title']);
            $this->load->model('tool/image');
            $this->load->model('account/order');

            $data['package_totals'] = array();
            $orders = $this->model_account_order->getOrders(0, 100);
            $store_status = $this->config->get('config_store_status');

            foreach ($orders as $key => $order) {
                $orders[$key]['products'] = $this->model_account_order->getOrderProducts($order['order_id']);
            }

            foreach ($data['packages'] as &$package) {
                $cart_ids = array();
                if ($package['image']) {
                    $package['thumb'] = $this->model_tool_image->resize($package['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'));
                } else {
                    $package['thumb'] = '';
                }

                foreach ($package['products'] as &$product) {
                    $product_info = $this->model_catalog_product->getProduct($product['product_id']);
                    $product['purchased_before'] = 0;
                    foreach ($orders as $order_new) {
                        foreach ($order_new['products'] as $order_product) {
                            if ($order_product['product_id'] == $product['product_id']) {
                                $product['purchased_before'] = 1;
                                $product['date_purchased'] = $order_new['date_added'];
                                $product['order_link'] = $this->url->link('account/order/info', 'order_id=' . $order_new['order_id']);
                                $product['in_package'] = 0;
                                $status_id = $this->model_account_order->getStatusByName($order_new['status']);
                                if (in_array($status_id['order_status_id'], $store_status))
                                    $product['purchased_before'] = 2;
                            }
                        }
                    }

                    $product['href'] = $this->url->link('product/product', 'product_id=' . $product['product_id']);
                    $product['name'] = $product_info['name'];
                    $product['manufacturer'] = $product_info['manufacturer'];
                    $product['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
                    $product['model'] = $product_info['model'];
                    $product['package_description'] = $product_info['package_description'];
                    $product['original_price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], true), $this->session->data['currency']);

                    if ($product_info['quantity'] <= 0) {
                        $product['stock'] = $product_info['stock_status'];
                    } elseif ($this->config->get('config_stock_display')) {
                        $product['stock'] = $product_info['quantity'];
                    } else {
                        $product['stock'] = $this->language->get('text_instock');
                    }

                    if ($product_info['image']) {
                        $product['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_thumb_height'));
                    } else {
                        $product['thumb'] = '';
                    }

                    if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                        $product['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], true), $this->session->data['currency']);
                        if ($product['package_price'] > 0) {
                            $product['price'] = $this->currency->format($this->tax->calculate($product['package_price'], $product_info['tax_class_id'], true), $this->session->data['currency']);
                        }
                    } else {
                        $product['price'] = false;
                    }

                    if ($product['original_price'] == $product['price']) {
                        $product['original_price'] = false;
                    }

                    if ((float)$product_info['special']) {
                        $product['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], true), $this->session->data['currency']);
                    } else {
                        $product['special'] = false;
                    }

                    if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                        if ($product['special'])
                            $price = (float)$product_info['special'] * (float)$product['quantity'];
                        else if ($product['package_price'] > 0)
                            $price = (float)$product['package_price'] * (float)$product['quantity'];
                        else
                            $price = (float)$product_info['price'] * (float)$product['quantity'];

                        $product['total_price'] = $this->currency->format($this->tax->calculate($price, $product_info['tax_class_id'], true), $this->session->data['currency']);
                    } else {
                        $product['total_price'] = false;
                    }

                    if (true) {
                        $product['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
                    } else {
                        $product['tax'] = false;
                    }

                    $discounts = $this->model_catalog_product->getProductDiscounts($product['product_id']);

                    $product['discounts'] = array();

                    foreach ($discounts as $discount) {
                        $product['discounts'][] = array(
                            'quantity' => $discount['quantity'],
                            'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], true), $this->session->data['currency'])
                        );
                    }

                    if ($product['in_package'] === 1)
                        $cart_ids[] = $this->cart->add($product['product_id'], $product['quantity'], array(), 0, 1, $product['package_price']);
                }

                $package['totals'] = $this->calculateTotals();

                foreach ($cart_ids as $cart_id) {
                    $this->cart->remove($cart_id, true);
                }
            }

            $this->model_catalog_package->setCustomerPackages($this->customer->getId(), $data['packages']);

            $cart_ids = [];
            foreach ($data['packages'] as $package_new) {
                foreach ($package_new['products'] as $product_new) {
                    if ($product_new['in_package']) {
                        $cart_ids[] = $this->cart->add($product_new['product_id'], $product_new['quantity'], array(), 0, 1, $product_new['package_price']);
                    }
                }
            }

            $data['totals'] = $this->calculateTotals();

            foreach ($cart_ids as $value) {
                $this->cart->remove($value, true);
            }

            $data['checkout'] = $this->url->link('product/package/toCart');
            $data['continue'] = $this->url->link('common/home');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('product/package', $data));
        } else {
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
            );

            $this->document->setTitle($this->language->get('text_error'));

            $data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('error/not_found', $data));
        }
    }

    function toCart() {
        $this->load->model('catalog/package');
        $this->cart->clear();
        $packages = $this->model_catalog_package->getCustomerPackages($this->customer->getId());

        foreach ($packages as $package) {
            foreach($package['products'] as $product) {
                if ($product['in_package']) {
                    $this->cart->add($product['product_id'], $product['quantity'], array(), 0, $product['type'], $product['package_price']);
                }
            }
        }

        $this->response->redirect($this->url->link('checkout/cart', '', true));
    }

    function calculateTotals() {
        $this->load->model('setting/extension');

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

        // Display prices
        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
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
        }

        $data['totals'] = array();

        foreach ($totals as $total) {
            $data['totals'][] = array(
                'title' => $total['title'],
                'text'  => $this->currency->format($total['value'], $this->session->data['currency']),
            );
        }

        return $data['totals'];
    }

    function remove() {
        $this->load->model('catalog/package');

        $new_packages = $package_cart_ids = $cart_ids = array();
        $totals = array(
            'package' => array(),
            'general' => array()
        );
        $packages = $this->model_catalog_package->getCustomerPackages($this->customer->getId());

        foreach ($packages as &$package) {
            foreach($package['products'] as &$product) {
                if ($product['product_id'] == $this->request->get['product_id']) {
                    if ($product['type'] != 3) {
                        $product['in_package'] = 0;
                    }

                    unset($product["href"]);
                    unset($product["name"]);
                    unset($product["manufacturer"]);
                    unset($product["manufacturers"]);
                    unset($product["model"]);
                    unset($product["reward"]);
                    unset($product["points"]);
                    unset($product["description"]);
                    unset($product["stock"]);
                    unset($product["popup"]);
                    unset($product["thumb"]);
                    unset($product["images"]);
                    unset($product["price"]);
                    unset($product["special"]);
                    unset($product["tax"]);
                    unset($product["discounts"]);
                    unset($product["options"]);
                    unset($product["minimum"]);
                    unset($product["review_status"]);
                    unset($product["review_guest"]);
                    unset($product["customer_name"]);
                    unset($product["reviews"]);
                    unset($product["rating"]);
                    unset($product["attribute_groups"]);
                    unset($product["products"]);
                    unset($product["tax_class_id"]);
                    unset($product["tags"]);
                }

                if ($product['in_package']) {
                    $cart_ids[] = $this->cart->add($product['product_id'], $product['quantity'], array(), 0, 1, $product['package_price']);
                }
            }

            $new_packages[] = $package;
        }

        $totals['general'] = array_reverse($this->calculateTotals());
        foreach ($cart_ids as $value) {
            $this->cart->remove($value, true);
        }
        $this->model_catalog_package->setCustomerPackages($this->customer->getId(), $packages);

        foreach ($new_packages as $new_package) {
            if ($new_package['package_id'] == $this->request->get['package_id']) {
                foreach($new_package['products'] as $new_product) {
                    if ($new_product['in_package']) {
                        $package_cart_ids[] = $this->cart->add($new_product['product_id'], $new_product['quantity'], array(), 0, 1, $new_product['package_price']);
                    }
                }
            }
        }

        $totals['package'] = array_reverse($this->calculateTotals());
        foreach ($package_cart_ids as $value) {
            $this->cart->remove($value, true);
        }

        echo json_encode($totals);
    }

    function remove_whole() {
        $this->load->model('catalog/package');

        $pp = $this->model_catalog_package->getPackageProducts($this->request->get['package_id']);
        $remove_pp = array();
        foreach ($pp as $key => $value) {
            $remove_pp[] = $value['product_id'];
        }

        $new_packages = $package_cart_ids = $cart_ids = array();
        $totals = array(
            'package' => array(),
            'general' => array()
        );

        $packages = $this->model_catalog_package->getCustomerPackages($this->customer->getId());

        foreach ($packages as &$package) {
            foreach($package['products'] as &$product) {
                if (in_array($product['product_id'], $remove_pp) && $package['package_id'] == $this->request->get['package_id']) {
                    $product['in_package'] = 0;

                    unset($product["href"]);
                    unset($product["name"]);
                    unset($product["manufacturer"]);
                    unset($product["manufacturers"]);
                    unset($product["model"]);
                    unset($product["reward"]);
                    unset($product["points"]);
                    unset($product["description"]);
                    unset($product["stock"]);
                    unset($product["popup"]);
                    unset($product["thumb"]);
                    unset($product["images"]);
                    unset($product["price"]);
                    unset($product["special"]);
                    unset($product["tax"]);
                    unset($product["discounts"]);
                    unset($product["options"]);
                    unset($product["minimum"]);
                    unset($product["review_status"]);
                    unset($product["review_guest"]);
                    unset($product["customer_name"]);
                    unset($product["reviews"]);
                    unset($product["rating"]);
                    unset($product["attribute_groups"]);
                    unset($product["products"]);
                    unset($product["tax_class_id"]);
                    unset($product["tags"]);
                }

                if ($product['in_package']) {
                    $cart_ids[] = $this->cart->add($product['product_id'], $product['quantity'], array(), 0, 1, $product['package_price']);
                }
            }

            $new_packages[] = $package;
        }

        $totals['general'] = array_reverse($this->calculateTotals());
        foreach ($cart_ids as $value) {
            $this->cart->remove($value, true);
        }
        $this->model_catalog_package->setCustomerPackages($this->customer->getId(), $packages);

        foreach ($new_packages as $new_package) {
            if ($new_package['package_id'] == $this->request->get['package_id']) {
                foreach($new_package['products'] as $new_product) {
                    if ($new_product['in_package']) {
                        $package_cart_ids[] = $this->cart->add($new_product['product_id'], $new_product['quantity'], array(), 0, 1, $new_product['package_price']);
                    }
                }
            }
        }

        $totals['package'] = array_reverse($this->calculateTotals());
        foreach ($package_cart_ids as $value) {
            $this->cart->remove($value, true);
        }

        echo json_encode($totals);
    }

    function add() {
        $this->load->model('catalog/package');

        $new_packages = $package_cart_ids = $cart_ids = array();
        $totals = array(
            'package' => array(),
            'general' => array()
        );
        $packages = $this->model_catalog_package->getCustomerPackages($this->customer->getId());

        foreach ($packages as &$package) {
            foreach($package['products'] as &$product) {
                if ($product['product_id'] != $this->request->get['product_id'] && $product['in_package'] === 1) {
                    $cart_ids[] = $this->cart->add($product['product_id'], $product['quantity'], array(), 0, 1, $product['package_price']);
                } else if ($product['product_id'] == $this->request->get['product_id']){
                    $product['in_package'] = 1;
                    $cart_ids[] = $this->cart->add($product['product_id'], $product['quantity'], array(), 0, 1, $product['package_price']);
                }

                unset($product["href"]);
                unset($product["name"]);
                unset($product["manufacturer"]);
                unset($product["manufacturers"]);
                unset($product["model"]);
                unset($product["reward"]);
                unset($product["points"]);
                unset($product["description"]);
                unset($product["stock"]);
                unset($product["popup"]);
                unset($product["thumb"]);
                unset($product["images"]);
                unset($product["price"]);
                unset($product["special"]);
                unset($product["tax"]);
                unset($product["discounts"]);
                unset($product["options"]);
                unset($product["minimum"]);
                unset($product["review_status"]);
                unset($product["review_guest"]);
                unset($product["customer_name"]);
                unset($product["reviews"]);
                unset($product["rating"]);
                unset($product["attribute_groups"]);
                unset($product["products"]);
                unset($product["tax_class_id"]);
                unset($product["tags"]);
            }

            $new_packages[] = $package;
        }

        $totals['general'] = array_reverse($this->calculateTotals());
        foreach ($cart_ids as $value) {
            $this->cart->remove($value, true);
        }

        $this->model_catalog_package->setCustomerPackages($this->customer->getId(), $packages);

        foreach ($new_packages as $new_package) {
            if ($new_package['package_id'] == $this->request->get['package_id']) {
                foreach($new_package['products'] as $new_product) {
                    if ($new_product['in_package']) {
                        $package_cart_ids[] = $this->cart->add($new_product['product_id'], $new_product['quantity'], array(), 0, 1, $new_product['package_price']);
                    }
                }
            }
        }

        $totals['package'] = array_reverse($this->calculateTotals());
        foreach ($package_cart_ids as $value) {
            $this->cart->remove($value, true);
        }

        echo json_encode($totals);
    }

    function add_whole() {
        $this->load->model('catalog/package');

        $pp = $this->model_catalog_package->getPackageProducts($this->request->get['package_id']);
        $remove_pp = array();
        foreach ($pp as $key => $value) {
            $remove_pp[] = $value['product_id'];
        }

        $new_packages = $package_cart_ids = $cart_ids = array();
        $totals = array(
            'package' => array(),
            'general' => array()
        );
        $packages = $this->model_catalog_package->getCustomerPackages($this->customer->getId());

        foreach ($packages as &$package) {
            foreach($package['products'] as &$product) {
                if ($product['product_id'] != $this->request->get['product_id'] && $product['in_package'] === 1) {
                    $cart_ids[] = $this->cart->add($product['product_id'], $product['quantity'], array(), 0, 1, $product['package_price']);
                } else if (in_array($product['product_id'], $remove_pp) &&  $package['package_id'] == $this->request->get['package_id']){
                    $product['in_package'] = 1;
                    $cart_ids[] = $this->cart->add($product['product_id'], $product['quantity'], array(), 0, 1, $product['package_price']);
                }

                unset($product["href"]);
                unset($product["name"]);
                unset($product["manufacturer"]);
                unset($product["manufacturers"]);
                unset($product["model"]);
                unset($product["reward"]);
                unset($product["points"]);
                unset($product["description"]);
                unset($product["stock"]);
                unset($product["popup"]);
                unset($product["thumb"]);
                unset($product["images"]);
                unset($product["price"]);
                unset($product["special"]);
                unset($product["tax"]);
                unset($product["discounts"]);
                unset($product["options"]);
                unset($product["minimum"]);
                unset($product["review_status"]);
                unset($product["review_guest"]);
                unset($product["customer_name"]);
                unset($product["reviews"]);
                unset($product["rating"]);
                unset($product["attribute_groups"]);
                unset($product["products"]);
                unset($product["tax_class_id"]);
                unset($product["tags"]);
            }

            $new_packages[] = $package;
        }

        $totals['general'] = array_reverse($this->calculateTotals());
        foreach ($cart_ids as $value) {
            $this->cart->remove($value, true);
        }

        $this->model_catalog_package->setCustomerPackages($this->customer->getId(), $packages);

        foreach ($new_packages as $new_package) {
            if ($new_package['package_id'] == $this->request->get['package_id']) {
                foreach($new_package['products'] as $new_product) {
                    if ($new_product['in_package']) {
                        $package_cart_ids[] = $this->cart->add($new_product['product_id'], $new_product['quantity'], array(), 0, 1, $new_product['package_price']);
                    }
                }
            }
        }

        $totals['package'] = array_reverse($this->calculateTotals());
        foreach ($package_cart_ids as $value) {
            $this->cart->remove($value, true);
        }

        echo json_encode($totals);
    }
}