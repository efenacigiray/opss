<?php
class ControllerCatalogClass extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('catalog/class');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/class');

        $this->getList();
    }

    public function add() {
        $this->load->language('catalog/class');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/class');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_class->addClass($this->request->post);

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

            $this->response->redirect($this->url->link('catalog/class', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('catalog/class');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/class');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_class->editClass($this->request->get['class_id'], $this->request->post);

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

            $this->response->redirect($this->url->link('catalog/class', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('catalog/class');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/class');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $class_id) {
                $this->model_catalog_class->deleteClass($class_id);
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

            $this->response->redirect($this->url->link('catalog/class', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getList();
    }

    protected function getList() {
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
            'href' => $this->url->link('catalog/class', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        $data['add'] = $this->url->link('catalog/class/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['delete'] = $this->url->link('catalog/class/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

        $data['classes'] = array();

        $filter_data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $class_total = $this->model_catalog_class->getTotalClasses();

        $results = $this->model_catalog_class->getClasses($filter_data);

        foreach ($results as $result) {
            $data['classes'][] = array(
                'class_id'        => $result['class_id'],
                'name'            => $result['name'],
                'sort_order'      => $result['sort_order'],
                'edit'            => $this->url->link('catalog/class/edit', 'user_token=' . $this->session->data['user_token'] . '&class_id=' . $result['class_id'] . $url, true)
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

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_name'] = $this->url->link('catalog/class', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
        $data['sort_sort_order'] = $this->url->link('catalog/class', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_order' . $url, true);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $class_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('catalog/class', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($class_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($class_total - $this->config->get('config_limit_admin'))) ? $class_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $class_total, ceil($class_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/class_list', $data));
    }

    protected function getForm() {
        $data['text_form'] = !isset($this->request->get['class_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

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
            'href' => $this->url->link('catalog/class', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        if (!isset($this->request->get['class_id'])) {
            $data['action'] = $this->url->link('catalog/class/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        } else {
            $data['action'] = $this->url->link('catalog/class/edit', 'user_token=' . $this->session->data['user_token'] . '&class_id=' . $this->request->get['class_id'] . $url, true);
        }

        $data['cancel'] = $this->url->link('catalog/class', 'user_token=' . $this->session->data['user_token'] . $url, true);

        if (isset($this->request->get['class_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $class_info = $this->model_catalog_class->getClass($this->request->get['class_id']);
            $class_packages = $this->model_catalog_class->getClassPackages($this->request->get['class_id']);
        }

        $data['user_token'] = $this->session->data['user_token'];

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($class_info)) {
            $data['name'] = $class_info['name'];
        } else {
            $data['name'] = '';
        }

        $this->load->model('catalog/package');

        $data['packages'] = array();

        if (!empty($this->request->post['package'])) {
            $packages = $this->request->post['package'];
        } elseif (!empty($class_packages)) {
            $packages = $class_packages;
        } else {
            $packages = array();
        }

        foreach ($packages as $package) {
            $package_info = $this->model_catalog_package->getPackage($package["package_id"]);

            if ($package_info) {
                $data['packages'][] = array(
                    'package_id' => $package_info['package_id'],
                    'name'       => $package_info['name']
                );
            }
        }

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

        if (isset($this->request->post['class_store'])) {
            $data['class_store'] = $this->request->post['class_store'];
        } elseif (isset($this->request->get['class_id'])) {
            $data['class_store'] = $this->model_catalog_class->getClassStores($this->request->get['class_id']);
        } else {
            $data['class_store'] = array(0);
        }

        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } elseif (!empty($class_info)) {
            $data['image'] = $class_info['image'];
        } else {
            $data['image'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($class_info) && is_file(DIR_IMAGE . $class_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($class_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($class_info)) {
            $data['sort_order'] = $class_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['class_seo_url'])) {
            $data['class_seo_url'] = $this->request->post['class_seo_url'];
        } elseif (isset($this->request->get['class_id'])) {
            $data['class_seo_url'] = $this->model_catalog_class->getClassSeoUrls($this->request->get['class_id']);
        } else {
            $data['class_seo_url'] = array();
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/class_form', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/class')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if ($this->request->post['class_seo_url']) {
            $this->load->model('design/seo_url');

            foreach ($this->request->post['class_seo_url'] as $store_id => $language) {
                foreach ($language as $language_id => $keyword) {
                    if (!empty($keyword)) {
                        if (count(array_keys($language, $keyword)) > 1) {
                            $this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
                        }

                        $seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);

                        foreach ($seo_urls as $seo_url) {
                            if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['class_id']) || (($seo_url['query'] != 'class_id=' . $this->request->get['class_id'])))) {
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
        if (!$this->user->hasPermission('modify', 'catalog/class')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $this->load->model('catalog/package');

        return !$this->error;
    }

    public function autocomplete() {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('catalog/class');

            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'start'       => 0,
                'limit'       => 20
            );

            $results = $this->model_catalog_class->getClasses($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'class_id' => $result['class_id'],
                    'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
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
}