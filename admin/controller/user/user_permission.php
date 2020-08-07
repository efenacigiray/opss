<?php
class ControllerUserUserPermission extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('user/user_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('user/user_group');

        $this->getList();
    }

    public function add() {
        $this->load->language('user/user_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('user/user_group');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_user_user_group->addUserGroup($this->request->post);

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

            $this->response->redirect($this->url->link('user/user_permission', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('user/user_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('user/user_group');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_user_user_group->editUserGroup($this->request->get['user_group_id'], $this->request->post);

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

            $this->response->redirect($this->url->link('user/user_permission', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('user/user_group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('user/user_group');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $user_group_id) {
                $this->model_user_user_group->deleteUserGroup($user_group_id);
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

            $this->response->redirect($this->url->link('user/user_permission', 'user_token=' . $this->session->data['user_token'] . $url, true));
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
            'href' => $this->url->link('user/user_permission', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        $data['add'] = $this->url->link('user/user_permission/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['delete'] = $this->url->link('user/user_permission/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

        $data['user_groups'] = array();

        $filter_data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $user_group_total = $this->model_user_user_group->getTotalUserGroups();

        $results = $this->model_user_user_group->getUserGroups($filter_data);

        foreach ($results as $result) {
            $data['user_groups'][] = array(
                'user_group_id' => $result['user_group_id'],
                'name'          => $result['name'],
                'edit'          => $this->url->link('user/user_permission/edit', 'user_token=' . $this->session->data['user_token'] . '&user_group_id=' . $result['user_group_id'] . $url, true)
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

        $data['sort_name'] = $this->url->link('user/user_permission', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $user_group_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('user/user_permission', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($user_group_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($user_group_total - $this->config->get('config_limit_admin'))) ? $user_group_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $user_group_total, ceil($user_group_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('user/user_group_list', $data));
    }

    protected function getForm() {
        $map = array(
            "common/dashboard" => "Anasayfa",
            "b5b_qore_engine/dash_activity_medium" => "Anasayfa -> Son Etkinlikler",
            "b5b_qore_engine/dash_chart_most_viewed_products_medium" => "Anasayfa -> En Çok Görüntülenen Ürünler",
            "b5b_qore_engine/dash_chart_sales_analytics_large" => "Anasayfa -> Satış Raporu",
            "b5b_qore_engine/dash_chart_top_customer_medium" => "Anasayfa -> En Aktif Müşteriler",
            "b5b_qore_engine/dash_chart_top_product_medium" => "Anasayfa -> En Aktif Ürünler",
            "b5b_qore_engine/dash_completed_orders_mini" => "Anasayfa -> Tamamlanan Siparişler",
            "b5b_qore_engine/dash_latest_orders_large" => "Anasayfa -> Son Sipaişler",
            "b5b_qore_engine/dash_map_medium" => "Anasayfa -> Dünya Haritası",
            "b5b_qore_engine/dash_processing_orders_mini" => "Anasayfa -> İşlenen Sipariş",
            "b5b_qore_engine/dash_product_views_mini" => "Anasayfa -> Ürün Görüntülenmeleri",
            "b5b_qore_engine/dash_returned_orders_mini" => "Anasayfa -> İade",
            "b5b_qore_engine/dash_total_customers_mini" => "Anasayfa -> Toplam Müşteri",
            "b5b_qore_engine/dash_total_orders_mini" => "Anasayfa -> Toplam Sipariş",
            "b5b_qore_engine/dash_total_sales_mini" => "Anasayfa -> Toplam Satış",
            "b5b_qore_engine/dash_users_online_mini" => "Anasayfa -> Çevrim İçi Olanlar",
            "b5b_qore_engine/theme_settings" => "Admin Tema Ayaları",
            "catalog/attribute" => "Özellikler",
            "catalog/attribute_group" => "Özellik Grupları",
            "catalog/category" => "Kategoriler",
            "catalog/class" => "Sınıflar",
            "catalog/download" => "İndirmeler",
            "catalog/filter" => "Filterler",
            "catalog/hizliurun" => "Hızlı Ürün Ekleme",
            "catalog/information" => "Bilgi Sayfaları",
            "catalog/manufacturer" => "Markalar",
            "catalog/option" => "Seçenekler",
            "catalog/package" => "Ürün Paketleri",
            "catalog/product" => "Ürünler",
            "catalog/recurring" => "Tekrarlayan Siparişler",
            "catalog/review" => "Yorumlar",
            "common/column_left" => "Ana Menü",
            "common/developer" => "Geliştirme Ayarları",
            "common/filemanager" => "Dosya Yöneticisi",
            "common/profile" => "Profil",
            "common/security" => "Güvenlik",
            "customer/custom_field" => "Müşteri Özel Alanlar",
            "customer/customer" => "Müşteri Tanımları",
            "customer/customer_approval" => "Müşteri Detay",
            "customer/customer_group" => "Müşteri Grupları",
            "design/banner" => "Tasarım -> Afişler",
            "design/layout" => "Tasarım -> Bölümler",
            "design/seo_url" => "Tasarım -> SEO Bağlantıları",
            "design/theme" => "Tasarım -> Tema Editörü",
            "design/translation" => "Tasarım -> Dil Editörü",
            "event/language" => "event/language",
            "event/statistics" => "event/statistics",
            "event/theme" => "event/theme",
            "extension/advertise/google" => "Eklentiler: advertise/google",
            "extension/analytics/google" => "Eklentiler: analytics/google",
            "extension/captcha/basic" => "Eklentiler: captcha/basic",
            "extension/captcha/google" => "Eklentiler: captcha/google",
            "extension/dashboard/activity" => "Eklentiler: dashboard/activity",
            "extension/dashboard/chart" => "Eklentiler: dashboard/chart",
            "extension/dashboard/customer" => "Eklentiler: dashboard/customer",
            "extension/dashboard/map" => "Eklentiler: dashboard/map",
            "extension/dashboard/online" => "Eklentiler: dashboard/online",
            "extension/dashboard/order" => "Eklentiler: dashboard/order",
            "extension/dashboard/recent" => "Eklentiler: dashboard/recent",
            "extension/dashboard/sale" => "Eklentiler: dashboard/sale",
            "extension/extension/advertise" => "Eklentiler: extension/advertise",
            "extension/extension/analytics" => "Eklentiler: extension/analytics",
            "extension/extension/captcha" => "Eklentiler: extension/captcha",
            "extension/extension/dashboard" => "Eklentiler: extension/dashboard",
            "extension/extension/feed" => "Eklentiler: extension/feed",
            "extension/extension/fraud" => "Eklentiler: extension/fraud",
            "extension/extension/menu" => "Eklentiler: extension/menu",
            "extension/extension/module" => "Eklentiler: extension/module",
            "extension/extension/payment" => "Eklentiler: extension/payment",
            "extension/extension/promotion" => "Eklentiler: extension/promotion",
            "extension/extension/report" => "Eklentiler: extension/report",
            "extension/extension/shipping" => "Eklentiler: extension/shipping",
            "extension/extension/theme" => "Eklentiler: extension/theme",
            "extension/extension/total" => "Eklentiler: extension/total",
            "extension/feed/google_base" => "Eklentiler: feed/google_base",
            "extension/feed/google_sitemap" => "Eklentiler: feed/google_sitemap",
            "extension/feed/openbaypro" => "Eklentiler: feed/openbaypro",
            "extension/fraud/fraudlabspro" => "Eklentiler: fraud/fraudlabspro",
            "extension/fraud/ip" => "Eklentiler: fraud/ip",
            "extension/fraud/maxmind" => "Eklentiler: fraud/maxmind",
            "extension/module/account" => "Eklentiler: module/account",
            "extension/module/advanced_grid" => "Eklentiler: module/advanced_grid",
            "extension/module/amazon_login" => "Eklentiler: module/amazon_login",
            "extension/module/amazon_pay" => "Eklentiler: module/amazon_pay",
            "extension/module/b5b_qore_engine" => "Eklentiler: module/b5b_qore_engine",
            "extension/module/banner" => "Eklentiler: module/banner",
            "extension/module/bestseller" => "Eklentiler: module/bestseller",
            "extension/module/blog" => "Eklentiler: module/blog",
            "extension/module/blog_category" => "Eklentiler: module/blog_category",
            "extension/module/blog_latest" => "Eklentiler: module/blog_latest",
            "extension/module/blog_popular" => "Eklentiler: module/blog_popular",
            "extension/module/blog_related_post" => "Eklentiler: module/blog_related_post",
            "extension/module/blog_search" => "Eklentiler: module/blog_search",
            "extension/module/blog_tags" => "Eklentiler: module/blog_tags",
            "extension/module/breadcrumb_background_image" => "Eklentiler: module/breadcrumb_background_image",
            "extension/module/bulk_special" => "Eklentiler: module/bulk_special",
            "extension/module/camera_slider" => "Eklentiler: module/camera_slider",
            "extension/module/carousel" => "Eklentiler: module/carousel",
            "extension/module/carousel_item" => "Eklentiler: module/carousel_item",
            "extension/module/category" => "Eklentiler: module/category",
            "extension/module/category_wall" => "Eklentiler: module/category_wall",
            "extension/module/cookie" => "Eklentiler: module/cookie",
            "extension/module/custom_module" => "Eklentiler: module/custom_module",
            "extension/module/custom_module2" => "Eklentiler: module/custom_module2",
            "extension/module/divido_calculator" => "Eklentiler: module/divido_calculator",
            "extension/module/ebay_listing" => "Eklentiler: module/ebay_listing",
            "extension/extension" => "Eklenti Ayarları",
            "extension/module/faq" => "Eklentiler: module/faq",
            "extension/module/featured" => "Eklentiler: module/featured",
            "extension/module/filter" => "Eklentiler: module/filter",
            "extension/module/filter_product" => "Eklentiler: module/filter_product",
            "extension/module/full_screen_background_slider" => "Eklentiler: module/full_screen_background_slider",
            "extension/module/google_hangouts" => "Eklentiler: module/google_hangouts",
            "extension/module/header_notice" => "Eklentiler: module/header_notice",
            "extension/module/html" => "Eklentiler: module/html",
            "extension/module/information" => "Eklentiler: module/information",
            "extension/module/klarna_checkout_module" => "Eklentiler: module/klarna_checkout_module",
            "extension/module/latest" => "Eklentiler: module/latest",
            "extension/module/laybuy_layout" => "Eklentiler: module/laybuy_layout",
            "extension/module/mass_discount" => "Eklentiler: module/mass_discount",
            "extension/module/megamenu" => "Eklentiler: module/megamenu",
            "extension/module/megamenu_manager_links" => "Eklentiler: module/megamenu_manager_links",
            "extension/module/mobile_menu" => "Eklentiler: module/mobile_menu",
            "extension/module/newsletter" => "Eklentiler: module/newsletter",
            "extension/module/pilibaba_button" => "Eklentiler: module/pilibaba_button",
            "extension/module/popup" => "Eklentiler: module/popup",
            "extension/module/porto" => "Eklentiler: module/porto",
            "extension/module/pp_braintree_button" => "Eklentiler: module/pp_braintree_button",
            "extension/module/pp_button" => "Eklentiler: module/pp_button",
            "extension/module/pp_login" => "Eklentiler: module/pp_login",
            "extension/module/product_blocks" => "Eklentiler: module/product_blocks",
            "extension/module/product_questions" => "Eklentiler: module/product_questions",
            "extension/module/product_tabs" => "Eklentiler: module/product_tabs",
            "extension/module/product_tabs" => "Eklentiler: module/product_tabs",
            "extension/module/revolution_slider" => "Eklentiler: module/revolution_slider",
            "extension/module/revslideropencart" => "Eklentiler: module/revslideropencart",
            "extension/module/sagepay_direct_cards" => "Eklentiler: module/sagepay_direct_cards",
            "extension/module/sagepay_server_cards" => "Eklentiler: module/sagepay_server_cards",
            "extension/module/slideshow" => "Eklentiler: module/slideshow",
            "extension/module/special" => "Eklentiler: module/special",
            "extension/module/store" => "Eklentiler: module/store",
            "extension/openbay/amazon" => "Eklentiler: openbay/amazon",
            "extension/openbay/amazon_listing" => "Eklentiler: openbay/amazon_listing",
            "extension/openbay/amazon_product" => "Eklentiler: openbay/amazon_product",
            "extension/openbay/amazonus" => "Eklentiler: openbay/amazonus",
            "extension/openbay/amazonus_listing" => "Eklentiler: openbay/amazonus_listing",
            "extension/openbay/amazonus_product" => "Eklentiler: openbay/amazonus_product",
            "extension/openbay/ebay" => "Eklentiler: openbay/ebay",
            "extension/openbay/ebay_profile" => "Eklentiler: openbay/ebay_profile",
            "extension/openbay/ebay_template" => "Eklentiler: openbay/ebay_template",
            "extension/openbay/etsy" => "Eklentiler: openbay/etsy",
            "extension/openbay/etsy_product" => "Eklentiler: openbay/etsy_product",
            "extension/openbay/etsy_shipping" => "Eklentiler: openbay/etsy_shipping",
            "extension/openbay/etsy_shop" => "Eklentiler: openbay/etsy_shop",
            "extension/openbay/fba" => "Eklentiler: openbay/fba",
            "extension/payment/alipay" => "Eklentiler: payment/alipay",
            "extension/payment/alipay_cross" => "Eklentiler: payment/alipay_cross",
            "extension/payment/amazon_login_pay" => "Eklentiler: payment/amazon_login_pay",
            "extension/payment/authorizenet_aim" => "Eklentiler: payment/authorizenet_aim",
            "extension/payment/authorizenet_sim" => "Eklentiler: payment/authorizenet_sim",
            "extension/payment/bank_transfer" => "Eklentiler: payment/bank_transfer",
            "extension/payment/bluepay_hosted" => "Eklentiler: payment/bluepay_hosted",
            "extension/payment/bluepay_redirect" => "Eklentiler: payment/bluepay_redirect",
            "extension/payment/cardconnect" => "Eklentiler: payment/cardconnect",
            "extension/payment/cardinity" => "Eklentiler: payment/cardinity",
            "extension/payment/cheque" => "Eklentiler: payment/cheque",
            "extension/payment/cod" => "Eklentiler: payment/cod",
            "extension/payment/divido" => "Eklentiler: payment/divido",
            "extension/payment/eway" => "Eklentiler: payment/eway",
            "extension/payment/firstdata" => "Eklentiler: payment/firstdata",
            "extension/payment/firstdata_remote" => "Eklentiler: payment/firstdata_remote",
            "extension/payment/free_checkout" => "Eklentiler: payment/free_checkout",
            "extension/payment/g2apay" => "Eklentiler: payment/g2apay",
            "extension/payment/globalpay" => "Eklentiler: payment/globalpay",
            "extension/payment/globalpay_remote" => "Eklentiler: payment/globalpay_remote",
            "extension/payment/klarna_account" => "Eklentiler: payment/klarna_account",
            "extension/payment/klarna_checkout" => "Eklentiler: payment/klarna_checkout",
            "extension/payment/klarna_invoice" => "Eklentiler: payment/klarna_invoice",
            "extension/payment/laybuy" => "Eklentiler: payment/laybuy",
            "extension/payment/liqpay" => "Eklentiler: payment/liqpay",
            "extension/payment/nochex" => "Eklentiler: payment/nochex",
            "extension/payment/paymate" => "Eklentiler: payment/paymate",
            "extension/payment/paypoint" => "Eklentiler: payment/paypoint",
            "extension/payment/paytr_checkout" => "Eklentiler: payment/paytr_checkout",
            "extension/payment/payza" => "Eklentiler: payment/payza",
            "extension/payment/perpetual_payments" => "Eklentiler: payment/perpetual_payments",
            "extension/payment/pilibaba" => "Eklentiler: payment/pilibaba",
            "extension/payment/pp_braintree" => "Eklentiler: payment/pp_braintree",
            "extension/payment/pp_express" => "Eklentiler: payment/pp_express",
            "extension/payment/pp_payflow" => "Eklentiler: payment/pp_payflow",
            "extension/payment/pp_payflow_iframe" => "Eklentiler: payment/pp_payflow_iframe",
            "extension/payment/pp_pro" => "Eklentiler: payment/pp_pro",
            "extension/payment/pp_pro_iframe" => "Eklentiler: payment/pp_pro_iframe",
            "extension/payment/pp_standard" => "Eklentiler: payment/pp_standard",
            "extension/payment/realex" => "Eklentiler: payment/realex",
            "extension/payment/realex_remote" => "Eklentiler: payment/realex_remote",
            "extension/payment/sagepay_direct" => "Eklentiler: payment/sagepay_direct",
            "extension/payment/sagepay_server" => "Eklentiler: payment/sagepay_server",
            "extension/payment/sagepay_us" => "Eklentiler: payment/sagepay_us",
            "extension/payment/securetrading_pp" => "Eklentiler: payment/securetrading_pp",
            "extension/payment/securetrading_ws" => "Eklentiler: payment/securetrading_ws",
            "extension/payment/skrill" => "Eklentiler: payment/skrill",
            "extension/payment/squareup" => "Eklentiler: payment/squareup",
            "extension/payment/storecard" => "Eklentiler: payment/storecard",
            "extension/payment/storecash" => "Eklentiler: payment/storecash",
            "extension/payment/twocheckout" => "Eklentiler: payment/twocheckout",
            "extension/payment/web_payment_software" => "Eklentiler: payment/web_payment_software",
            "extension/payment/wechat_pay" => "Eklentiler: payment/wechat_pay",
            "extension/payment/worldpay" => "Eklentiler: payment/worldpay",
            "extension/report/customer_activity" => "Eklentiler: report/customer_activity",
            "extension/report/customer_order" => "Eklentiler: report/customer_order",
            "extension/report/customer_reward" => "Eklentiler: report/customer_reward",
            "extension/report/customer_search" => "Eklentiler: report/customer_search",
            "extension/report/customer_transaction" => "Eklentiler: report/customer_transaction",
            "extension/report/marketing" => "Eklentiler: report/marketing",
            "extension/report/product_purchased" => "Eklentiler: report/product_purchased",
            "extension/report/product_viewed" => "Eklentiler: report/product_viewed",
            "extension/report/sale_coupon" => "Eklentiler: report/sale_coupon",
            "extension/report/sale_order" => "Eklentiler: report/sale_order",
            "extension/report/sale_return" => "Eklentiler: report/sale_return",
            "extension/report/sale_shipping" => "Eklentiler: report/sale_shipping",
            "extension/report/sale_tax" => "Eklentiler: report/sale_tax",
            "extension/shipping/auspost" => "Eklentiler: shipping/auspost",
            "extension/shipping/ec_ship" => "Eklentiler: shipping/ec_ship",
            "extension/shipping/fedex" => "Eklentiler: shipping/fedex",
            "extension/shipping/flat" => "Eklentiler: shipping/flat",
            "extension/shipping/free" => "Eklentiler: shipping/free",
            "extension/shipping/item" => "Eklentiler: shipping/item",
            "extension/shipping/parcelforce_48" => "Eklentiler: shipping/parcelforce_48",
            "extension/shipping/pickup" => "Eklentiler: shipping/pickup",
            "extension/shipping/royal_mail" => "Eklentiler: shipping/royal_mail",
            "extension/shipping/ups" => "Eklentiler: shipping/ups",
            "extension/shipping/usps" => "Eklentiler: shipping/usps",
            "extension/shipping/weight" => "Eklentiler: shipping/weight",
            "extension/theme/default" => "Eklentiler: theme/default",
            "extension/total/coupon" => "Eklentiler: total/coupon",
            "extension/total/credit" => "Eklentiler: total/credit",
            "extension/total/handling" => "Eklentiler: total/handling",
            "extension/total/klarna_fee" => "Eklentiler: total/klarna_fee",
            "extension/total/low_order_fee" => "Eklentiler: total/low_order_fee",
            "extension/total/reward" => "Eklentiler: total/reward",
            "extension/total/shipping" => "Eklentiler: total/shipping",
            "extension/total/sub_total" => "Eklentiler: total/sub_total",
            "extension/total/tax" => "Eklentiler: total/tax",
            "extension/total/total" => "Eklentiler: total/total",
            "extension/total/voucher" => "Eklentiler: total/voucher",
            "localisation/country" => "Yerelleştirme -> Yerelleştirme -> Ülkeler",
            "localisation/currency" => "Yerelleştirme -> Para Birimi",
            "localisation/geo_zone" => "Yerelleştirme -> Şehirler",
            "localisation/language" => "Yerelleştirme -> Dil",
            "localisation/length_class" => "Yerelleştirme -> Uzunluk Birimleri",
            "localisation/location" => "Yerelleştirme -> Konumlar",
            "localisation/order_status" => "Yerelleştirme -> Sipariş Durumları",
            "localisation/return_action" => "Yerelleştirme -> İade Eylemleri",
            "localisation/return_reason" => "Yerelleştirme -> İade Nedenleri",
            "localisation/return_status" => "Yerelleştirme -> İade Durumları",
            "localisation/stock_status" => "Yerelleştirme -> Stok Durumları",
            "localisation/tax_class" => "Yerelleştirme -> Vergi Sınıfları",
            "localisation/tax_rate" => "Yerelleştirme -> Vergi Oranları",
            "localisation/weight_class" => "Yerelleştirme -> Ağırlık Birimleri",
            "localisation/zone" => "Yerelleştirme -> Bölgeler",
            "mail/affiliate" => "mail/affiliate",
            "mail/customer" => "mail/customer",
            "mail/forgotten" => "mail/forgotten",
            "mail/return" => "mail/return",
            "mail/reward" => "mail/reward",
            "mail/transaction" => "mail/transaction",
            "marketing/contact" => "İletişim",
            "marketing/coupon" => "Kupon",
            "marketing/marketing" => "Pazarlama",
            "marketplace/api" => "marketplace/api",
            "marketplace/event" => "marketplace/event",
            "marketplace/extension" => "marketplace/extension",
            "marketplace/install" => "marketplace/install",
            "marketplace/installer" => "marketplace/installer",
            "marketplace/marketplace" => "marketplace/marketplace",
            "marketplace/modification" => "marketplace/modification",
            "marketplace/openbay" => "marketplace/openbay",
            "module/quick_status_updater" => "Hızlı Sipariş Güncelleme",
            "report/online" => "Raporlar -> Çevrim içi Raporlar",
            "report/report" => "Raporlar -> Raporlar",
            "report/statistics" => "Raporlar -> İstatistik",
            "sale/order" => "Satışlar -> Siparişler",
            "sale/recurring" => "Satışlar -> Tekrar Eden Siparişler",
            "sale/return" => "Satışlar -> İadeler",
            "sale/store_order" => "Satışlar -> Mağaza Satış Modülü",
            "sale/voucher" => "Satışlar -> Hediye Çekleri",
            "sale/voucher_theme" => "Satışlar -> Hediye Çeki Temaları",
            "setting/setting" => "Ayarlar",
            "setting/store" => "Mağaza Ayaları",
            "startup/error" => "Hata Kayıtları",
            "startup/event" => "Olaylar",
            "startup/login" => "Giriş",
            "startup/permission" => "Izinler",
            "startup/router" => "startup/router",
            "startup/sass" => "startup/sass",
            "startup/startup" => "startup/startup",
            "tool/backup" => "Yedekleme",
            "tool/log" => "Kayıtlar",
            "tool/upload" => "Yükleme",
            "user/api" => "API İzinleri",
            "user/user" => "Kullanıcı Tanımları",
            "user/user_permission" => "Kullanıcı Grubu Tanımları"
        );

        $data['text_form'] = !isset($this->request->get['user_group_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

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
            'href' => $this->url->link('user/user_permission', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        if (!isset($this->request->get['user_group_id'])) {
            $data['action'] = $this->url->link('user/user_permission/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        } else {
            $data['action'] = $this->url->link('user/user_permission/edit', 'user_token=' . $this->session->data['user_token'] . '&user_group_id=' . $this->request->get['user_group_id'] . $url, true);
        }

        $data['cancel'] = $this->url->link('user/user_permission', 'user_token=' . $this->session->data['user_token'] . $url, true);

        if (isset($this->request->get['user_group_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
            $user_group_info = $this->model_user_user_group->getUserGroup($this->request->get['user_group_id']);
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($user_group_info)) {
            $data['name'] = $user_group_info['name'];
        } else {
            $data['name'] = '';
        }

        $ignore = array(
/*          'common/startup',
            'common/login',
            'common/logout',
            'common/forgotten',
            'common/reset',
            'common/footer',
            'common/header',
            'error/not_found',
            'error/permission',
            'startup/router',
            'startup/sass',
            'startup/startup',
            'marketplace/api',
            'marketplace/event',
            'marketplace/extension',
            'marketplace/install',
            'marketplace/installer',
            'marketplace/marketplace',
            'marketplace/modification',
            'marketplace/openbay',
            'mail/affiliate',
            'mail/customer',
            'mail/forgotten',
            'mail/return',
            'mail/reward',
            'mail/transaction'*/
        );

        $data['permissions'] = array();

        $files = array();

        // Make path into an array
        $path = array(DIR_APPLICATION . 'controller/*');

        // While the path array is still populated keep looping through
        while (count($path) != 0) {
            $next = array_shift($path);

            foreach (glob($next) as $file) {
                // If directory add to path array
                if (is_dir($file)) {
                    $path[] = $file . '/*';
                }

                // Add the file to the files to be deleted array
                if (is_file($file)) {
                    $files[] = $file;
                }
            }
        }

        // Sort the file array
        sort($files);

        foreach ($files as $file) {
            $controller = substr($file, strlen(DIR_APPLICATION . 'controller/'));

            $permission = substr($controller, 0, strrpos($controller, '.'));

            if (!in_array($permission, $ignore)) {
                $data['permissions'][] = array('permission' => $permission, "label" => isset($map[$permission]) ? $map[$permission] : $permission);
            }
        }

        $data['permissions'][] = array('permission' => "customer/quick_add", "label" => "Mağaza Satış -> Öğrenci Ekleme");
        $data['permissions'][] = array('permission' => "extension/extension", "label" => "Modül Ayarları");

        if (isset($this->request->post['permission']['access'])) {
            $data['access'] = $this->request->post['permission']['access'];
        } elseif (isset($user_group_info['permission']['access'])) {
            $data['access'] = $user_group_info['permission']['access'];
        } else {
            $data['access'] = array();
        }

        if (isset($this->request->post['permission']['modify'])) {
            $data['modify'] = $this->request->post['permission']['modify'];
        } elseif (isset($user_group_info['permission']['modify'])) {
            $data['modify'] = $user_group_info['permission']['modify'];
        } else {
            $data['modify'] = array();
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('user/user_group_form', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'user/user_permission')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'user/user_permission')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $this->load->model('user/user');

        foreach ($this->request->post['selected'] as $user_group_id) {
            $user_total = $this->model_user_user->getTotalUsersByGroupId($user_group_id);

            if ($user_total) {
                $this->error['warning'] = sprintf($this->language->get('error_user'), $user_total);
            }
        }

        return !$this->error;
    }
}