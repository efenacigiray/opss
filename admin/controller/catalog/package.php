<?php
class ControllerCatalogPackage extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('catalog/package');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/package');

        $this->getList();
    }

    public function add() {
        $this->load->language('catalog/package');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/package');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_package->addPackage($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('catalog/package', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('catalog/package');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/package');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_package->editPackage($this->request->get['package_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('catalog/package', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('catalog/package');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/package');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $package_id) {
                $this->model_catalog_package->deletePackage($package_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('catalog/package', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getList();
    }

    protected function getList() {
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = '';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
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

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/package', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        $data['add'] = $this->url->link('catalog/package/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['delete'] = $this->url->link('catalog/package/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

        $data['packages'] = array();

        $filter_data = array(
            'filter_name' => $filter_name,
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $package_total = $this->model_catalog_package->getTotalPackages();

        $results = $this->model_catalog_package->getPackages($filter_data);

        foreach ($results as $result) {
            $data['packages'][] = array(
                'package_id' => $result['package_id'],
                'name'            => $result['name'],
                'sort_order'      => $result['sort_order'],
                'edit'            => $this->url->link('catalog/package/edit', 'user_token=' . $this->session->data['user_token'] . '&package_id=' . $result['package_id'] . $url, true)
            );
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_name'] = $this->url->link('catalog/package', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
        $data['sort_sort_order'] = $this->url->link('catalog/package', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_order' . $url, true);

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $package_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('catalog/package', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($package_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($package_total - $this->config->get('config_limit_admin'))) ? $package_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $package_total, ceil($package_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['filter_name'] = $filter_name;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['user_token'] = $this->session->data['user_token'];

        $this->response->setOutput($this->load->view('catalog/package_list', $data));
    }

    protected function getForm() {
        $data['text_form'] = !isset($this->request->get['package_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        if (isset($this->error['keyword'])) {
            $data['error_keyword'] = $this->error['keyword'];
        } else {
            $data['error_keyword'] = '';
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/package', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        if (!isset($this->request->get['package_id'])) {
            $data['action'] = $this->url->link('catalog/package/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        } else {
            $data['action'] = $this->url->link('catalog/package/edit', 'user_token=' . $this->session->data['user_token'] . '&package_id=' . $this->request->get['package_id'] . $url, true);
        }

        $data['cancel'] = $this->url->link('catalog/package', 'user_token=' . $this->session->data['user_token'] . $url, true);

        if (isset($this->request->get['package_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $package_info = $this->model_catalog_package->getPackage($this->request->get['package_id']);
            $package_products = $this->model_catalog_package->getPackageProducts($this->request->get['package_id']);
        }

        $data['user_token'] = $this->session->data['user_token'];

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($package_info)) {
            $data['name'] = $package_info['name'];
        } else {
            $data['name'] = '';
        }

        $this->load->model('catalog/product');

        $data['products'] = array();

        if (!empty($this->request->post['product'])) {
            $products = $this->request->post['product'];
        } elseif (!empty($package_products)) {
            $products = $package_products;
        } else {
            $products = array();
        }


        $this->load->model('localisation/tax_class');
        $this->load->model('localisation/tax_rate');
        $data['package_total'] = 0;
        foreach ($products as $product) {
            $product_info = $this->model_catalog_product->getProduct($product["product_id"]);
            $specials = $this->model_catalog_product->getProductSpecials($product["product_id"]);

            foreach ($specials as $special) {
                $product_info['price'] = $special['price'];
            }

            if ($product_info) {
                $taxed_price = $product_info['price'];

                $rules = $this->model_localisation_tax_class->getTaxRules($product_info['tax_class_id']);
                foreach ($rules as $tax_rule) {
                    $tax_rate = $this->model_localisation_tax_rate->getTaxRate($tax_rule['tax_rate_id']);
                    $taxed_price = round(($taxed_price * $tax_rate['rate'] / 100) + $taxed_price, 2);
                    $taxed_price = number_format((float)$taxed_price, 2, '.', '');
                }

                $data['products'][] = array(
                    'product_id' => $product_info['product_id'],
                    'name'       => $product_info['name'],
                    'quantity'   => $product['quantity'],
                    'type'       => $product['type'],
                    'price'      => $taxed_price,
                    'package_price' => $product['package_price'] > 0 ? number_format($product['package_price'], 2, '.', '') : $taxed_price
                );

                $data['package_total'] += ($product['package_price'] > 0 ? $product['package_price'] : $product_info['price']);
            }
        }
        $data['package_total'] = $this->currency->format($data['package_total'], $this->config->get('config_currency'));
        $this->load->model('setting/store');

        $data['stores'] = array();

        $data['stores'][] = array(
            'store_id' => 0,
            'name'     => $this->config->get('config_name')
        );

        $stores = $this->model_setting_store->getStores();

        foreach ($stores as $store) {
            $data['stores'][] = array(
                'store_id' => $store['store_id'],
                'name'     => $store['name']
            );
        }

        if (isset($this->request->post['package_store'])) {
            $data['package_store'] = $this->request->post['package_store'];
        } elseif (isset($this->request->get['package_id'])) {
            $data['package_store'] = $this->model_catalog_package->getPackageStores($this->request->get['package_id']);
        } else {
            $data['package_store'] = array();
            foreach ($data['stores'] as $store) {
                $data['package_store'][] = $store["store_id"];
            }
        }

        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($package_info)) {
            $data['image'] = $package_info['image'];
        } else {
            $data['image'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($package_info) && is_file(DIR_IMAGE . $package_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($package_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($package_info)) {
            $data['sort_order'] = $package_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['package_seo_url'])) {
            $data['package_seo_url'] = $this->request->post['package_seo_url'];
        } elseif (isset($this->request->get['package_id'])) {
            $data['package_seo_url'] = $this->model_catalog_package->getPackageSeoUrls($this->request->get['package_id']);
        } else {
            $data['package_seo_url'] = array();
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/package_form', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/package')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if ($this->request->post['package_seo_url']) {
            $this->load->model('design/seo_url');

            foreach ($this->request->post['package_seo_url'] as $store_id => $language) {
                foreach ($language as $language_id => $keyword) {
                    if (!empty($keyword)) {
                        if (count(array_keys($language, $keyword)) > 1) {
                            $this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
                        }

                        $seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);

                        foreach ($seo_urls as $seo_url) {
                            if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['package_id']) || (($seo_url['query'] != 'package_id=' . $this->request->get['package_id'])))) {
                                $this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');
                            }
                        }
                    }
                }
            }
        }

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'catalog/package')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $this->load->model('catalog/product');

        return !$this->error;
    }

    public function deleteClassCache() {
        $this->load->model('catalog/package');
        $this->model_catalog_package->deleteClassCache($this->request->get['class_id']);
    }

    public function deleteCustomerCache() {
        $this->load->model('catalog/package');
        $this->model_catalog_package->deleteCustomerCache($this->request->get['customer_id']);
    }

    public function autocomplete() {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('catalog/package');

            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'start'       => 0,
                'limit'       => 30
            );

            $results = $this->model_catalog_package->getPackages($filter_data);

            $this->load->model('localisation/tax_class');
            $this->load->model('localisation/tax_rate');
            $this->load->model('catalog/product');

            foreach ($results as $result) {
                $package_products = $this->model_catalog_package->getPackageProducts($result['package_id']);
                $package_total = 0;

                foreach ($package_products as $product) {
                    $product_info = $this->model_catalog_product->getProduct($product["product_id"]);
                    $specials = $this->model_catalog_product->getProductSpecials($product["product_id"]);

                    foreach ($specials as $special) {
                        $product_info['price'] = $special['price'];
                    }

                    if ($product_info) {
                        $taxed_price = $product_info['price'];

                        $rules = $this->model_localisation_tax_class->getTaxRules($product_info['tax_class_id']);
                        foreach ($rules as $tax_rule) {
                            $tax_rate = $this->model_localisation_tax_rate->getTaxRate($tax_rule['tax_rate_id']);
                            $taxed_price = round(($taxed_price * $tax_rate['rate'] / 100) + $taxed_price, 2);
                            $taxed_price = number_format((float)$taxed_price, 2, '.', '');
                        }

                        $package_total += ($product['package_price'] > 0 ? $product['package_price'] : $product_info['price']);
                    }
                }

                $json[] = array(
                    'package_id' => $result['package_id'],
                    'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                    'price'      => $this->currency->format($package_total, $this->config->get('config_currency'))
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function pprint() {
        $this->load->model('catalog/package');
        $this->load->model('catalog/product');
        $this->load->model('localisation/tax_class');
        $this->load->model('localisation/tax_rate');

        $packages = array('packages'=>array(), 'overall' => 0);

        foreach ($this->request->post['selected'] as $package_id) {
            $data = array();
            $package_info = $this->model_catalog_package->getPackage($package_id);
            $package_products = $this->model_catalog_package->getPackageProducts($package_id);

            $data['name'] = $package_info['name'];
            $data['products'] = array();

            $products = $package_products;
            $data['package_total'] = 0;

            foreach ($products as $product) {
                $product_info = $this->model_catalog_product->getProduct($product["product_id"]);
                $specials = $this->model_catalog_product->getProductSpecials($product["product_id"]);

                $special_p = false;
                foreach ($specials as $special) {
                    $special_p = $special['price'];
                }

                if ($product_info) {
                    $taxed_price = $product_info['price'];

                    $rules = $this->model_localisation_tax_class->getTaxRules($product_info['tax_class_id']);
                    foreach ($rules as $tax_rule) {
                        $tax_rate = $this->model_localisation_tax_rate->getTaxRate($tax_rule['tax_rate_id']);
                        $taxed_price = round(($taxed_price * $tax_rate['rate'] / 100) + $taxed_price, 2);
                        $taxed_price = number_format((float)$taxed_price, 2, '.', '');
                        $special_p = round(($special_p * $tax_rate['rate'] / 100) + $special_p, 2);
                        $special_p = number_format((float)$special_p, 2, '.', '');
                    }

                    $pp = !$special_p ? ($product['package_price'] > 0 ? number_format($product['package_price'], 2, '.', '') : $taxed_price) : $special_p;
                    $pp = $pp > 0 ? $pp : $taxed_price;

                    $data['products'][] = array(
                        'model' => $product_info['model'],
                        'product_id' => $product_info['product_id'],
                        'name'       => $product_info['name'],
                        'quantity'   => $product['quantity'],
                        'type'       => $product['type'],
                        'price'      => $this->currency->format($taxed_price, $this->config->get('config_currency')),
                        'package_price' => $this->currency->format($pp, $this->config->get('config_currency')),
                        'total'   => $this->currency->format($pp * $product['quantity'], $this->config->get('config_currency'))
                    );
                    $data['package_total'] += $pp * $product['quantity'];
                }
            }
            $packages['overall'] += $data['package_total'];
            $data['package_total'] = $this->currency->format($data['package_total'], $this->config->get('config_currency'));
            while(true) {
                if (!isset($packages['packages'][$package_info['sort_order']])) {
                    $packages['packages'][$package_info['sort_order']] = $data;
                    break;
                }
                $package_info['sort_order']++;
            }
        }

        ksort($packages['packages']);
        $packages['overall'] = $this->currency->format($packages['overall'], $this->config->get('config_currency'));

        $this->response->setOutput($this->load->view('catalog/package_print', $packages));
    }
}