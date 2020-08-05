<?php
/**
 * product_admin.php
 *
 * Product management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestProductAdmin extends RestAdminController
{

    private static $defaultFields = array(
        "model",
        "sku",
        "upc",
        "ean",
        "jan",
        "isbn",
        "mpn",
        "location",
        "quantity",
        "minimum",
        "subtract",
        "stock_status_id",
        "date_available",
        "manufacturer_id",
        "shipping",
        "price",
        "points",
        "weight",
        "weight_class_id",
        "length",
        "width",
        "height",
        "length_class_id",
        "status",
        "tax_class_id",
        "sort_order",
        "image",
        "product_store"
    );

    private static $defaultFieldValues = array(
        "quantity" => 1,
        "minimum" => 1,
        "subtract" => 1,
        "stock_status_id" => 6,
        "shipping" => 1,
        "manufacturer_id" => 0,
        "status" => 1,
        "product_store" => array(0),
        "tax_class_id" => 0,
        "weight_class_id" => 1,
        "sort_order" => 1
    );
    private static $defaultCategoryFields = array(
        "category_description",
        "path",
        "parent_id",
        "category_store",
        "product_seo_url",
        "top",
        "column",
        "sort_order",
        "status",
        "category_layout",
    );

    private static $defaultCategoryFieldValues = array(
        "category_description" => array(),
        "category_layout" => array(),
        "parent_id" => 0,
        "category_store" => array(0),
        "top" => 0,
        "column" => 1,
        "sort_order" => 0,
        "status" => 1,
    );

    private static $defaultManufacturerFields = array(
        "name",
        "manufacturer_store",
        "product_seo_url",
        "sort_order"
    );


    private static $defaultManufacturerFieldValues = array(
        "manufacturer_store" => array(0)
    );
    private $error = array();

    private $newCatetory = array();

    private $manufacturerId = null;

    public function products()
    {

        $this->checkPlugin();

        $this->load->language('restapi/product');

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //get product details
            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->getProduct($this->request->get['id']);
            } else {
                /*check category id parameter*/
                if (isset($this->request->get['category']) && ctype_digit($this->request->get['category'])) {
                    $category_id = $this->request->get['category'];
                } else {
                    $category_id = 0;
                }

                $this->listProducts($category_id, $this->request);
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //insert product
            $post = $this->getPost();

            $this->addProduct($post);

        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            //update product
            $post = $this->getPost();

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->updateProduct($this->request->get['id'], $post);
            } else {
                $this->json['error'][] = 'Invalid id.';
                $this->statusCode = 400;
            }

        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->deleteProduct($this->request->get['id']);
            } else {
                $this->json['error'][] = 'Invalid id.';
                $this->statusCode = 400;
            }
        }

        return $this->sendResponse();
    }

    public function getProduct($id)
    {

        $this->load->model('rest/restadmin');

        $products = $this->model_rest_restadmin->getProductsByIds(array($id), null);
        if (!empty($products)) {
            $this->json["data"] = $this->getProductInfo(reset($products));
        } else {
            $this->json['error'][] = 'Product not found';
            $this->statusCode = 404;
        }
    }

    private function getProductInfo($product)
    {

        $this->load->model('tool/image');
        $this->load->model('catalog/product');
        $this->load->model('rest/restadmin');

        $imageUrlPrefix = $this->request->server['HTTPS'] ? HTTPS_SERVER : HTTP_SERVER;

        //product image
        if (isset($product['image']) && !empty($product['image'])&& file_exists(DIR_IMAGE . $product['image'])) {
            $image = $this->model_tool_image->resize($product['image'], $this->config->get('module_rest_admin_api_thumb_width'), $this->config->get('module_rest_admin_api_thumb_height'));
            $original_image = $imageUrlPrefix . 'image/' . $product['image'];
        } else {
            $image = "";
            $original_image = "";
        }

        //additional images
        $additional_images = $this->model_catalog_product->getProductImages($product['product_id']);

        $images = array();
        $original_images = array();

        foreach ($additional_images as $additional_image) {
            if (isset($additional_image['image']) && file_exists(DIR_IMAGE . $additional_image['image']) && !empty($additional_image['image'])) {
                $images[] = $this->model_tool_image->resize($additional_image['image'], $this->config->get('module_rest_admin_api_thumb_width'), $this->config->get('module_rest_admin_api_thumb_height'));
                $original_images[] = $imageUrlPrefix . 'image/' . $additional_image['image'];
            }
        }

        //special
        $product_specials = $this->model_rest_restadmin->getProductSpecials($product['product_id']);

        $specials = array();

        foreach ($product_specials as $product_special) {
            $specials[] = array(
                'customer_group_id' => $product_special['customer_group_id'],
                'priority' => $product_special['priority'],
                'price' => $product_special['price'],
                'date_start' => ($product_special['date_start'] != '0000-00-00') ? $product_special['date_start'] : '',
                'date_end' => ($product_special['date_end'] != '0000-00-00') ? $product_special['date_end'] : ''
            );
        }

        //discounts
        $product_discounts = $this->model_rest_restadmin->getProductDiscounts($product['product_id']);

        $discounts = array();

        foreach ($product_discounts as $product_discount) {
            $discounts[] = array(
                'customer_group_id' => $product_discount['customer_group_id'],
                'quantity' => $product_discount['quantity'],
                'priority' => $product_discount['priority'],
                'price' => $product_discount['price'],
                'date_start' => ($product_discount['date_start'] != '0000-00-00') ? $product_discount['date_start'] : '',
                'date_end' => ($product_discount['date_end'] != '0000-00-00') ? $product_discount['date_end'] : ''
            );
        }

        $options = array();

        foreach ($this->model_rest_restadmin->getExtendedProductOptions($product['product_id']) as $option) {
            if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                $option_value_data = array();
                if (!empty($option['product_option_value'])) {
                    foreach ($option['product_option_value'] as $option_value) {
                        if ((float)$option_value['price']) {
                            $price = $this->tax->calculate($option_value['price'], $product['tax_class_id'], $this->config->get('config_tax'));
                            $price_formated = $this->currency->format($this->tax->calculate($option_value['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency'));
                        } else {
                            $price = 0;
                            $price_formated = 0;
                        }

                        if (isset($option_value['image']) && file_exists(DIR_IMAGE . $option_value['image'])) {
                            $option_image = $this->model_tool_image->resize($option_value['image'], $this->config->get('module_rest_admin_api_thumb_width'), $this->config->get('module_rest_admin_api_thumb_height'));
                        } else {
                            $option_image = $this->model_tool_image->resize('no_image.png', $this->config->get('module_rest_admin_api_thumb_width'), $this->config->get('module_rest_admin_api_thumb_height'));
                        }

                        $option_value_data[] = array(
                            'image' => $option_image,
                            'price' => $price,
                            'price_formated' => $price_formated,
                            'price_prefix' => $option_value['price_prefix'],
                            'product_option_value_id' => $option_value['product_option_value_id'],
                            'option_value_id' => $option_value['option_value_id'],
                            'name' => $option_value['name'],
                            'quantity' => !empty($option_value['quantity']) ? $option_value['quantity'] : 0,
                            'subtract' => $option_value['subtract'],
                            'points' => (isset($option_value['points'])) ? $option_value['points'] : 0,
                            'points_prefix' => isset($option_value['points_prefix']) ? $option_value['points_prefix'] : '',
                            'weight' => $option_value['weight'],
                            'weight_prefix' => $option_value['weight_prefix'],
                            'sku' => isset($option_value['sku']) ? $option_value['sku'] : ''

                        );
                    }
                }
                $options[] = array(
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'option_value' => $option_value_data,
                    'required' => $option['required'],
                    'product_option_id' => $option['product_option_id'],
                    'option_id' => $option['option_id'],

                );

            } elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                $option_value = array();
                if (!empty($option['product_option_value'])) {
                    $option_value = $option['product_option_value'];
                }
                $options[] = array(
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'option_value' => $option_value,
                    'required' => $option['required'],
                    'product_option_id' => $option['product_option_id'],
                    'option_id' => $option['option_id'],
                );
            }
        }


        $productCategories = array();
        $product_category = $this->model_rest_restadmin->getProductCategories($product['product_id']);

        foreach ($product_category as $category) {
            $languageId = isset($category['language_id']) ? $category['language_id'] : (int)$this->config->get('config_language_id');
            $productCategories[$category['category_id']][] = array(
                'category_id' => $category['category_id'],
                'name' => $category['name'],
                'description' => $category['description'],
                'sort_order' => $category['sort_order'],
                'meta_title' => $category['meta_title'],
                'meta_description' => $category['meta_description'],
                'meta_keyword' => $category['meta_keyword'],
                'language_id' => $languageId
            );

        }

        /*reviews*/
        $this->load->model('catalog/review');

        $reviews = array();

        $reviews["review_total"] = $this->model_catalog_review->getTotalReviewsByProductId($product['product_id']);

        $reviewList = $this->model_catalog_review->getReviewsByProductId($product['product_id'], 0, 1000);

        foreach ($reviewList as $review) {
            $reviews['reviews'][] = array(
                'author' => $review['author'],
                'text' => nl2br($review['text']),
                'rating' => (int)$review['rating'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($review['date_added']))
            );
        }

        $product_attributes = $this->model_rest_restadmin->getProductAttributes($product['product_id']);

        $productRelateds = $this->model_rest_restadmin->getProductRelated($product['product_id']);

        // Filters
        $filters = $this->model_rest_restadmin->getProductFilters($product['product_id']);

        $ret = array(
            'id' => $product['product_id'],
            //'seo_h1' => (!empty($product['seo_h1']) ? $product['seo_h1'] : ""),
            'manufacturer' => isset($product['manufacturer']) ? $product['manufacturer'] : "",
            'sku' => (!empty($product['sku']) ? $product['sku'] : ""),
            'model' => $product['model'],
            'image' => $image,
            'images' => $images,
            'original_image' => $original_image,
            'original_images' => $original_images,
            'price' => $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')),
            'tax_value' => $this->config->get('config_tax') ? $this->tax->getTax($product['price'], $product['tax_class_id']) : 0,
            'price_formated' => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency')),
            'rating' => isset($product['rating']) ? (int)$product['rating'] : '',
            'product_description' => isset($product['product_description']) ? array_values($product['product_description']) : '',
            'product_attributes' => $product_attributes,
            'special' => $specials,
            'discounts' => $discounts,
            'options' => $options,
            'minimum' => isset($product['minimum']) ? $product['minimum'] : 1,
            'upc' => $product['upc'],
            'ean' => $product['ean'],
            'jan' => $product['jan'],
            'isbn' => $product['isbn'],
            'mpn' => $product['mpn'],
            'location' => $product['location'],
            'stock_status' => isset($product['stock_status']) ? $product['stock_status'] : '',
            'manufacturer_id' => !empty($product['manufacturer_id']) ? $product['manufacturer_id'] : "",
            'tax_class_id' => $product['tax_class_id'],
            'date_available' => $product['date_available'],
            'weight' => $product['weight'],
            'weight_class_id' => $product['weight_class_id'],
            'length' => $product['length'],
            'width' => $product['width'],
            'height' => $product['height'],
            'length_class_id' => $product['length_class_id'],
            'subtract' => $product['subtract'],
            'sort_order' => $product['sort_order'],
            'status' => $product['status'],
            'stock_status_id' => $product['stock_status_id'],
            'date_added' => $product['date_added'],
            'date_modified' => $product['date_modified'],
            'viewed' => $product['viewed'],
            'weight_class' => isset($product['weight_class']) ? $product['weight_class'] : '',
            'length_class' => isset($product['length_class']) ? $product['length_class'] : '',
            'reward' => isset($product['reward']) ? $product['reward'] : '',
            'points' => $product['points'],
            'keyword' => isset($product['keyword']) ? $product['keyword'] : '',
            'shipping' => $product['shipping'],
            'category' => array_values($productCategories),
            'quantity' => !empty($product['quantity']) ? $product['quantity'] : 0,
            'reviews' => $reviews,
            'product_relateds' => $productRelateds,
            'filters' => $filters,
        );

        $ret['currency_id'] = $this->currency->getId($this->config->get('config_currency'));
        $ret['currency_code'] = $this->config->get('config_currency');
        $ret['currency_value'] = $this->currency->getValue($this->config->get('config_currency'));

        return $ret;
    }

    public function listProducts($category_id, $request)
    {

        $this->load->model('rest/restadmin');

        $parameters = array(
            "limit" => 100,
            "start" => 1,
            'filter_category_id' => $category_id
        );

        /*check limit parameter*/
        if (isset($request->get['limit']) && ctype_digit($request->get['limit'])) {
            $parameters["limit"] = $request->get['limit'];
        }

        /*check page parameter*/
        if (isset($request->get['page']) && ctype_digit($request->get['page'])) {
            $parameters["start"] = $request->get['page'];
        }

        /*check search parameter*/
        if (isset($request->get['search']) && !empty($request->get['search'])) {
            $parameters["filter_name"] = $request->get['search'];
            $parameters["filter_tag"] = $request->get['search'];
        }

        /*check sort parameter*/
        if (isset($request->get['sort']) && !empty($request->get['sort'])) {
            $parameters["sort"] = $request->get['sort'];
        }

        /*check order parameter*/
        if (isset($request->get['order']) && !empty($request->get['order'])) {
            $parameters["order"] = $request->get['order'];
        }
        /*check filters parameter*/
        if (isset($request->get['filters']) && !empty($request->get['filters'])) {
            $parameters["filter_filter"] = $request->get['filters'];
        }

        /*check manufacturer parameter*/
        if (isset($request->get['manufacturer']) && !empty($request->get['manufacturer'])) {
            $parameters["filter_manufacturer_id"] = $request->get['manufacturer'];
        }

        /*check category id parameter*/
        if (isset($request->get['category']) && !empty($request->get['category'])) {
            $parameters["filter_category_id"] = $request->get['category'];
        }

        /*check subcategory id parameter*/
        if (isset($request->get['subcategory']) && !empty($request->get['subcategory'])) {
            $parameters["filter_sub_category"] = $request->get['subcategory'];
        }

        /*check tag parameter*/
        if (isset($request->get['tag']) && !empty($request->get['tag'])) {
            $parameters["filter_tag"] = $request->get['tag'];
        }

        /*check description parameter*/
        if (isset($request->get['filter_description']) && !empty($request->get['filter_description'])) {
            $parameters["filter_description"] = $request->get['filter_description'];
        }

        if (isset($this->request->get['filter_date_added_from'])) {
            $date_added_from = date('Y-m-d H:i:s', strtotime($this->request->get['filter_date_added_from']));
            if ($this->validateDate($date_added_from)) {
                $parameters["filter_date_added_from"] = $date_added_from;
            }
        } else {
            $parameters["filter_date_added_from"] = null;
        }

        if (isset($this->request->get['filter_date_added_on'])) {
            $date_added_on = date('Y-m-d', strtotime($this->request->get['filter_date_added_on']));
            if ($this->validateDate($date_added_on, 'Y-m-d')) {
                $parameters["filter_date_added_on"] = $date_added_on;
            }
        } else {
            $parameters["filter_date_added_on"] = null;
        }

        if (isset($this->request->get['filter_date_added_to'])) {
            $date_added_to = date('Y-m-d H:i:s', strtotime($this->request->get['filter_date_added_to']));
            if ($this->validateDate($date_added_to)) {
                $parameters["filter_date_added_to"] = $date_added_to;
            }
        } else {
            $parameters["filter_date_added_to"] = null;
        }

        if (isset($this->request->get['filter_date_modified_on'])) {
            $date_modified_on = date('Y-m-d', strtotime($this->request->get['filter_date_modified_on']));
            if ($this->validateDate($date_modified_on, 'Y-m-d')) {
                $parameters["filter_date_modified_on"] = $date_modified_on;
            }
        } else {
            $parameters["filter_date_modified_on"] = null;
        }

        if (isset($this->request->get['filter_date_modified_from'])) {
            $date_modified_from = date('Y-m-d H:i:s', strtotime($this->request->get['filter_date_modified_from']));
            if ($this->validateDate($date_modified_from)) {
                $parameters["filter_date_modified_from"] = $date_modified_from;
            }
        } else {
            $parameters["filter_date_modified_from"] = null;
        }

        if (isset($this->request->get['filter_date_modified_to'])) {
            $date_modified_to = date('Y-m-d H:i:s', strtotime($this->request->get['filter_date_modified_to']));
            if ($this->validateDate($date_modified_to)) {
                $parameters["filter_date_modified_to"] = $date_modified_to;
            }
        } else {
            $parameters["filter_date_modified_to"] = null;
        }

        $parameters["start"] = ($parameters["start"] - 1) * $parameters["limit"];

        $products = $this->model_rest_restadmin->getProductsData($parameters, null);

        if (empty($products)) {
            $this->json['data'] = array();
        } else {
            foreach ($products as $product) {
                $this->json['data'][] = $this->getProductInfo($product);
            }
        }
    }

    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function addProduct($data)
    {

        $this->load->model('rest/restadmin');

        if ($this->validateProductForm($data, false)) {
            $productId = $this->model_rest_restadmin->addProduct($data);
            $this->json['data']['id'] = $productId;
        } else {
            $this->statusCode = 400;
            $this->json['error'] = $this->error;
        }

    }

    private function validateProductForm(&$data, $validateSku = false, $current = null)
    {

        $isUpdate = !empty($current);

        if ($validateSku) {
            if (!isset($data['sku']) || (utf8_strlen($data['sku']) < 2) || (utf8_strlen($data['sku']) > 255)) {
                $this->error[] = $this->language->get('error_sku');
            }
        }

        if(!$isUpdate){
            if (!empty($data['date_available'])) {
                $date_available = date('Y-m-d', strtotime($data['date_available']));
                if ($this->validateDate($date_available, 'Y-m-d')) {
                    $data['date_available'] = $date_available;
                } else {
                    $data['date_available'] = date('Y-m-d');
                }
            } else {
                $data['date_available'] = date('Y-m-d');
            }

            if (isset($data['length_class_id']) && !empty($data['length_class_id'])) {
                $data['length_class_id'] = $data['length_class_id'];
            } else {
                $data['length_class_id'] = $this->config->get('config_length_class_id');
            }

            if (isset($data['weight_class_id']) && !empty($data['weight_class_id'])) {
                $data['weight_class_id'] = $data['weight_class_id'];
            } else {
                $data['weight_class_id'] = $this->config->get('config_weight_class_id');
            }

            if (isset($data['product_description'])) {
                foreach ($data['product_description'] as $language_id => &$value) {

                    if(!isset($value['language_id'])){
                        $value['language_id'] = 1;
                    }

                    if(!isset($value['description'])){
                        $value['description'] = "";
                    }

                    if(!isset($value['meta_description'])){
                        $value['meta_description'] = "";
                    }

                    if(!isset($value['meta_keyword'])){
                        $value['meta_keyword'] = "";
                    }

                    if(!isset($value['tag'])){
                        $value['tag'] = "";
                    }

                    if (!isset($value['name']) || (utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
                        //$this->error['name'][$language_id] = $this->language->get('error_name');
                        $this->error[] = $this->language->get('error_name');
                    }

                    if (!isset($value['meta_title']) || (utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
                        //$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
                        $this->error[] = $this->language->get('error_meta_title');
                    }
                }
            } else {
                $this->error[] = "Product description is required";
            }
        } else {
            if (isset($data['date_available']) && !empty($data['date_available'])) {
                $date_available = date('Y-m-d', strtotime($data['date_available']));
                if ($this->validateDate($date_available, 'Y-m-d')) {
                    $data['date_available'] = $date_available;
                } else {
                    $data['date_available'] = date('Y-m-d');
                }
            }

            if (isset($data['length_class_id']) && !empty($data['length_class_id'])) {
                $data['length_class_id'] = $data['length_class_id'];
            }

            if (isset($data['weight_class_id']) && !empty($data['weight_class_id'])) {
                $data['weight_class_id'] = $data['weight_class_id'];
            }

            if (isset($data['product_description'])) {
                foreach ($data['product_description'] as $language_id => &$value) {

                    if(!isset($value['language_id'])){
                        $value['language_id'] = 1;
                    }

                    if(!isset($value['description'])){
                        $value['description'] = "";
                    }

                    if(!isset($value['meta_description'])){
                        $value['meta_description'] = "";
                    }

                    if(!isset($value['meta_keyword'])){
                        $value['meta_keyword'] = "";
                    }

                    if(!isset($value['tag'])){
                        $value['tag'] = "";
                    }

                    if (!isset($value['name']) || (utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
                        //$this->error['name'][$language_id] = $this->language->get('error_name');
                        $this->error[] = $this->language->get('error_name');
                    }

                    if (!isset($value['meta_title']) || (utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
                        //$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
                        $this->error[] = $this->language->get('error_meta_title');
                    }
                }
            }
        }


        if (!$isUpdate && !isset($data['model']) || (utf8_strlen($data['model']) < 1) || (utf8_strlen($data['model']) > 64)) {
            $this->error[] = $this->language->get('error_model');
        }

        if (isset($data['product_seo_url'])) {

            foreach ($data['product_seo_url'] as &$keywordData) {

                if (!empty($keywordData["keyword"])) {
                    $seo_urls = $this->model_rest_restadmin->getSeoUrlsByKeyword($keywordData["keyword"]);

                    if(!isset($keywordData["store_id"]) || empty($keywordData["store_id"])){
                        $keywordData["store_id"] = 0;
                    }

                    if(!isset($keywordData["language_id"]) || empty($keywordData["language_id"])){
                        $keywordData["language_id"] = 1;
                    }

                    foreach ($seo_urls as $seo_url) {
                        if (($seo_url['store_id'] == $keywordData["store_id"]) && (!isset($data['product_id'])
                                || ($seo_url['query'] != 'product_id=' . $data['product_id']))) {
                            $this->error[] = sprintf($this->language->get('error_keyword'), $keywordData["keyword"]);
                            break;
                        }
                    }
                }
            }
        }
        
        foreach (self::$defaultFields as $field) {
            if (!isset($data[$field])) {
                if (!isset(self::$defaultFieldValues[$field])) {
                    $data[$field] = "";
                } else {
                    $data[$field] = self::$defaultFieldValues[$field];
                }
            }
        }

        return !$this->error;
    }

    private function updateProduct($id, $data)
    {
        $this->load->model('catalog/product');
        $this->load->model('rest/restadmin');

        if (ctype_digit($id)) {
            $valid = $this->model_rest_restadmin->checkProductExists($id);

            if (!empty($valid)) {
                $product = $this->model_rest_restadmin->getProduct($id);
                if ($product) {
                    $this->loadProductSavedData($data, $product);
                    if ($this->validateProductForm($data, false, $product)) {
                        $this->model_rest_restadmin->editProductById($id, $data);
                    } else {
                        $this->json['error'] = $this->error;
                        $this->statusCode = 400;
                    }
                } else {
                    $this->json['error'][] = "Product not found";
                    $this->statusCode = 404;
                }

            } else {
                $this->json['error'][] = "Product not found";
                $this->statusCode = 404;
            }
        } else {
            $this->statusCode = 400;
            $this->json['error'][] = "Invalid identifier.";
        }
    }

    private function loadProductSavedData(&$data, $product)
    {

        foreach (self::$defaultFields as $field) {
            if (!isset($data[$field])) {
                if (isset($product[$field])) {
                    $data[$field] = $product[$field];
                } else {
                    $data[$field] = "";
                }
            }
        }
    }

    public function deleteProduct($id)
    {

        $this->load->model('catalog/product');
        $this->load->model('rest/restadmin');

        if (ctype_digit($id)) {

            $product = $this->model_rest_restadmin->checkProductExists($id);

            if (!empty($product)) {

                $this->model_rest_restadmin->deleteProduct($id);
            } else {
                $this->json['error'][] = "Product not found";
                $this->statusCode = 404;
            }
        } else {
            $this->json['error'][] = "Invalid id";
            $this->statusCode = 400;
        }

    }

    public function bulkproducts()
    {

        $this->checkPlugin();
        $this->load->language('restapi/product');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $post = $this->getPost();

            $this->addProducts($post);

        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

            $post = $this->getPost();
            $this->updateProducts($post);
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST", "PUT");
        }

        return $this->sendResponse();
    }

    public function addProducts($products)
    {

        $this->load->model('rest/restadmin');
        $ids = array();

        foreach ($products as $product) {

            if ($this->validateProductForm($product, false)) {
                $productId = $this->model_rest_restadmin->addProduct($product);
                $ids[] = $productId;
            } else {
                $this->statusCode = 400;
                $this->json['error'] = $this->error;
            }
        }

        $this->json['data'] = $ids;
    }


    private function updateProducts($products)
    {

        $this->load->model('catalog/product');
        $this->load->model('rest/restadmin');

        foreach ($products as $productItem) {

            $id = $productItem['product_id'];

            if (ctype_digit($id)) {

                $valid = $this->model_rest_restadmin->checkProductExists($id);

                if (!empty($valid)) {
                    $product = $this->model_rest_restadmin->getProduct($id);
                    if ($product) {
                        $this->loadProductSavedData($productItem, $product);
                        if ($this->validateProductForm($productItem, false, $product)) {
                            $this->model_rest_restadmin->editProductById($id, $productItem);
                        } else {
                            $this->statusCode = 400;
                            $this->json['error'] = $this->error;
                        }
                    } else {
                        $this->json['error'][] = "Product not found";
                        $this->statusCode = 404;
                    }

                } else {
                    $this->json['error'][] = "Product not found";
                    $this->statusCode = 404;
                }

            } else {
                $this->statusCode = 400;
                $this->json['error'][] = "Invalid identifier";
            }
        }
    }


    public function featured()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //get featured products
            $limit = 0;

            if (isset($this->request->get['limit']) && ctype_digit($this->request->get['limit']) && $this->request->get['limit'] > 0) {
                $limit = $this->request->get['limit'];
            }
            $this->getFeaturedProducts($limit);

        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $post = $this->getPost();

            $this->setFeaturedproducts($post);

        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

            $post = $this->getPost();

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->editFeaturedproducts($this->request->get['id'], $post);
            } else {
                $this->json['error'][] = "Invalid id";
                $this->statusCode = 400;
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET", "POST", "PUT");
        }

        return $this->sendResponse();
    }

    public function getFeaturedProducts($limit)
    {

        $this->load->model('catalog/product');
        $this->load->model('rest/restadmin');

        $this->load->model('tool/image');

        $featureds = $this->model_rest_restadmin->getModulesByCode('featured');
        $data = array();
        $index = 0;

        if (count($featureds)) {
            foreach ($featureds as $featured) {
                $data[$index]['module_id'] = $featured['module_id'];
                $data[$index]['name'] = $featured['name'];
                $data[$index]['code'] = $featured['code'];

                $settings = json_decode($featured['setting'], true);

                $products = $settings['product'];

                if ($limit) {
                    $products = array_slice($products, 0, (int)$limit);
                }

                foreach ($products as $product_id) {
                    $product_info = $this->model_catalog_product->getProduct($product_id);

                    if ($product_info) {
                        if ($product_info['image']) {
                            $image = $this->model_tool_image->resize($product_info['image'], 500, 500);
                        } else {
                            $image = false;
                        }

                        $price = $this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
                        $price_formated = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency'));

                        if ((float)$product_info['special']) {
                            $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency'));
                        } else {
                            $special = false;
                        }

                        if ($this->config->get('config_review_status')) {
                            $rating = $product_info['rating'];
                        } else {
                            $rating = false;
                        }

                        $data[$index]['products'][] = array(
                            'product_id' => $product_info['product_id'],
                            'thumb' => $image,
                            'name' => $product_info['name'],
                            'price' => $price,
                            'tax_value' => $this->config->get('config_tax') ? $this->tax->getTax($product_info['price'], $product_info['tax_class_id']) : 0,
                            'price_formated' => $price_formated,
                            'special' => $special,
                            'rating' => $rating
                        );
                    }
                }
                $index++;
            }
        }

        $this->json['data'] = $data;

    }

    private function setFeaturedproducts($post)
    {

        $this->load->model('rest/restadmin');

        if ($this->validateFeatured($post)) {
            $this->model_rest_restadmin->addModule('featured', $post);
        } else {
            $this->statusCode = 400;
            $this->json["error"] = $this->error;
        }

    }

    protected function validateFeatured($post)
    {

        if (!isset($post['name']) || (utf8_strlen($post['name']) < 3) || (utf8_strlen($post['name']) > 64)) {
            $this->error[] = "Name field is required";
        }

        if (!isset($post['width']) || !$post['width']) {
            $this->error[] = "Image width is required";
        }

        if (!isset($post['height']) || !$post['height']) {
            $this->error[] = "Image height is required";
        }

        if (!isset($post['status']) || !$post['status']) {
            $this->error[] = "Status is required";
        }

        if (!isset($post['limit']) || !$post['limit']) {
            $this->error[] = "Limit is required";
        }

        return empty($this->error);
    }

    private function editFeaturedproducts($id, $post)
    {

        $this->load->model('rest/restadmin');

        if ($this->validateFeatured($post)) {
            $this->model_rest_restadmin->editModule($id, $post);
        } else {
            $this->statusCode = 400;
            $this->json["error"] = $this->error;
        }

    }


    public function productimages()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //upload and save image
            if (!empty($this->request->get['other']) && $this->request->get['other'] == 1) {
                $this->addProductImage($this->request);
            } else {
                $this->updateProductImage($this->request);
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        return $this->sendResponse();
    }

    public function addProductImage($request)
    {

        $this->load->model('catalog/product');
        $this->load->model('rest/restadmin');

        if (ctype_digit($request->get['id'])) {
            $product = $this->model_rest_restadmin->getProduct($request->get['id']);
            //check product exists
            if (!empty($product)) {
                if (count($request->files)) {
                    foreach ($request->files as $file) {
                        if (isset($file) && !empty($file)) {
                            $uploadResult = $this->upload($file, "products");
                            if (!isset($uploadResult['error'])) {
                                $sortOrder = !empty($request->get['sort_order']) ? (int)$request->get['sort_order'] : 0;
                                $this->model_rest_restadmin->addProductImage($request->get['id'], $uploadResult['file_path'], $sortOrder);
                            } else {
                                $this->json['error'] = $uploadResult['error'];
                                $this->statusCode = 400;
                            }
                        } else {
                            $this->statusCode = 400;
                            $this->json['error'][] = "File is required!";
                        }
                    }
                }
            } else {
                $this->json['error'][] = "Product not found";
                $this->statusCode = 404;
            }
        } else {
            $this->json['error'][] = "Invalid id";
            $this->statusCode = 400;
        }

        if (!empty($this->json['error'])) {
            $this->statusCode = 400;
        }

    }

    public function upload($uploadedFile, $subdirectory)
    {
        $this->language->load('restapi/category');

        $result = array();

        if (!empty($uploadedFile['name'])) {
            $filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($uploadedFile['name'], ENT_QUOTES, 'UTF-8')));

            if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
                $result['error'][] = $this->language->get('error_filename');
            }

            // Allowed file extension types
            $allowed = array(
                'jpg',
                'jpeg',
                'gif',
                'png'
            );

            if (!in_array(utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
                $result['error'][] = $this->language->get('error_filetype');
            }

            // Allowed file mime types
            $allowed = array(
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/x-png',
                'image/gif'
            );

            if (!in_array($uploadedFile['type'], $allowed)) {
                $result['error'][] = $this->language->get('error_filetype');
            }

            // Check to see if any PHP files are trying to be uploaded
            $content = file_get_contents($uploadedFile['tmp_name']);

            if (preg_match('/\<\?php/i', $content)) {
                $result['error'][] = $this->language->get('error_filetype');
            }

            if ($uploadedFile['error'] != UPLOAD_ERR_OK) {
                $result['error'][] = $this->language->get('error_upload_' . $uploadedFile['error']);
            }
        } else {
            $result['error'][] = $this->language->get('error_upload');
        }

        if (!$result && is_uploaded_file($uploadedFile['tmp_name']) && file_exists($uploadedFile['tmp_name'])) {
            $file = basename($filename) . '.' . md5(mt_rand());

            // Hide the uploaded file name so people can not link to it directly.
            $result['file'] = $this->encryption->encrypt($file);

            $result['file_path'] = "catalog/" . $subdirectory . "/" . $filename;
            if ($this->rmkdir(DIR_IMAGE . "catalog/" . $subdirectory)) {
                move_uploaded_file($uploadedFile['tmp_name'], DIR_IMAGE . $result['file_path']);
            } else {
                $result['error'][] = "Could not create directory or directory is not writeable: " . DIR_IMAGE . "catalog/" . $subdirectory;
            }
        }
        return $result;

    }

    function rmkdir($path, $mode = 0777)
    {

        if (!file_exists($path)) {
            $path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
            $e = explode("/", ltrim($path, "/"));
            if (substr($path, 0, 1) == "/") {
                $e[0] = "/" . $e[0];
            }
            $c = count($e);
            $cp = $e[0];
            for ($i = 1; $i < $c; $i++) {
                if (!is_dir($cp) && !@mkdir($cp, $mode)) {
                    return false;
                }
                $cp .= "/" . $e[$i];
            }
            return @mkdir($path, $mode);
        }

        if (is_writable($path)) {
            return true;
        } else {
            return false;
        }
    }


    public function updateProductImage($request)
    {

        $this->load->model('catalog/product');
        $this->load->model('rest/restadmin');

        if (ctype_digit($request->get['id'])) {
            $product = $this->model_rest_restadmin->getProduct($request->get['id']);
            //check product exists
            if (!empty($product)) {
                if (isset($request->files['file'])) {
                    $uploadResult = $this->upload($request->files['file'], "products");
                    if (!isset($uploadResult['error'])) {
                        $this->model_rest_restadmin->setProductImage($request->get['id'], $uploadResult['file_path']);
                    } else {
                        $this->json['error'] = $uploadResult['error'];
                        $this->statusCode = 400;
                    }
                } else {
                    $this->json['error'][] = "File is required!";
                    $this->statusCode = 400;
                }
            } else {
                $this->statusCode = 404;
                $this->json['error'][] = "The specified product does not exist.";

            }
        } else {
            $this->json['error'][] = "Invalid id";
            $this->statusCode = 400;
        }

    }

    public function productquantity()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $post = $this->getPost();

            $this->updateProductsQuantity($post);
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("PUT");
        }

        return $this->sendResponse();
    }

    private function updateProductsQuantity($products)
    {

        $this->load->model('catalog/product');
        $this->load->model('rest/restadmin');

        foreach ($products as $productItem) {

            if (isset($productItem['product_id'])) {
                //if don't update product option quantity, product quantity must be set
                if (!isset($productItem['product_option'])) {
                    if (!isset($productItem['quantity'])) {
                        $this->statusCode = 400;
                        $this->json['error'][] = "Missing quantity, product id:" . $productItem['product_id'];
                    }
                } else {
                    foreach ($productItem['product_option'][0]['product_option_value'] as $option) {
                        if (!isset($option['quantity'])) {
                            $this->statusCode = 400;
                            $this->json['error'][] = "Missing quantity, product id:" . $productItem['product_id'];
                            break;
                        }
                    }
                }

                if (empty($this->json['error'])) {
                    $id = $productItem['product_id'];

                    $product = $this->model_rest_restadmin->checkProductExists($id);

                    if (!empty($product)) {
                        $this->model_rest_restadmin->editProductQuantity($id, $productItem);
                    } else {
                        $this->statusCode = 404;
                        $this->json['error'][] = "The specified product does not exist, id: " . $productItem['product_id'];
                    }
                }
            } else {
                $this->statusCode = 400;
                $this->json['error'][] = "Missing product id";
            }
        }
    }

    public function productquantitybysku()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

            $post = $this->getPost();

            $this->updateProductsQuantityBySku($post);

        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("PUT");
        }

        return $this->sendResponse();
    }

    private function updateProductsQuantityBySku($products)
    {
        $this->load->model('rest/restadmin');

        $error = array();

        $optionSkuEnabled = $this->model_rest_restadmin->checkFieldExist('product_option_value', 'option_sku');

        foreach ($products as $productItem) {

            if (isset($productItem['sku']) && isset($productItem['quantity'])) {
                if (!empty($productItem['sku'])) {

                    if(empty($productItem['quantity'])){
                        $productItem['quantity'] = 0;
                    }

                    if (!$this->model_rest_restadmin->updateProductBySku($productItem, $optionSkuEnabled)) {
                        $error[] = "Not updated item: Product by sku: " . $productItem['sku'] . " not found";
                    }
                } else {
                    $error[] = "Missing sku.";
                }
            } else {
                $error[] = "Missing fields, sku or quantity";
            }
        }

        if (!empty($error)) {
            $this->json["error"] = $error;
            $this->statusCode = 400;
        }
    }

    public function latest()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $limit = 1;
            if (isset($this->request->get['limit']) && ctype_digit($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            }
            $this->getLatest($limit);
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();

    }

    private function getLatest($limit)
    {

        $data = array();

        $this->load->model('rest/restadmin');


        $filter_data = array(
            'sort' => 'date_added',
            'order' => 'DESC',
            'start' => 0,
            'limit' => $limit
        );

        $results = $this->model_rest_restadmin->getProductsData($filter_data);

        if ($results) {
            foreach ($results as $result) {
                $data[] = $result['product_id'];
            }
        }

        $this->json['data'] = !empty($data) ? $data : array();
    }

    public function latestwithdetails()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $limit = 1;
            if (isset($this->request->get['limit']) && ctype_digit($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            }
            $this->getLatestWithDetails($limit);
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }

    private function getLatestWithDetails($limit)
    {

        $this->load->model('rest/restadmin');
        $this->load->model('catalog/product');

        $data['products'] = array();

        $filter_data = array(
            'sort' => 'date_added',
            'order' => 'DESC',
            'start' => 0,
            'limit' => $limit
        );

        $results = $this->model_rest_restadmin->getProductsData($filter_data);

        if ($results) {
            foreach ($results as $result) {
                $product = $this->model_catalog_product->getProduct($result['product_id']);
                $this->json['data'][] = $this->getProductBaseInfo($product);
            }
        }
    }

    private function getProductBaseInfo($product)
    {

        $this->load->model('tool/image');
        if (isset($product['image']) && file_exists(DIR_IMAGE . $product['image'])) {
            $image = $this->model_tool_image->resize($product['image'], $this->config->get('module_rest_admin_api_thumb_width'), $this->config->get('module_rest_admin_api_thumb_height'));
        } else {
            $image = $this->model_tool_image->resize('no_image.png', $this->config->get('module_rest_admin_api_thumb_width'), $this->config->get('module_rest_admin_api_thumb_height'));
        }

        $special = false;
        $special_excluding_tax = false;
        $special_formated = false;
        $discounts = array();

        //special
        if ((float)$product['special']) {
            $special_excluding_tax = $this->currency->format($product['special'], $this->config->get('config_currency'));
            $special = $this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax'));
            $special_formated = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency'));
        }

        //discounts
        $data_discounts = $this->model_rest_restadmin->getProductDiscounts($product['product_id']);

        foreach ($data_discounts as $discount) {
            $discounts[] = array(
                'quantity' => $discount['quantity'],
                'price_excluding_tax' => empty($hidePrices) ? $this->currency->format($discount['price'], $this->config->get('config_currency')) : false,
                'price' => $this->tax->calculate($discount['price'], $product['tax_class_id'], $this->config->get('config_tax')),
                'price_formated' => empty($hidePrices) ? $this->currency->format($this->tax->calculate($discount['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency')) : false
            );
        }

        if ($this->config->get('config_review_status')) {
            $rating = (int)$product['rating'];
        } else {
            $rating = "";
        }

        $item = array(
            'product_id' => $product['product_id'],
            'thumb' => $image,
            'name' => $product['name'],
            'price_excluding_tax' => $this->currency->format($product['price'], $this->config->get('config_currency')),
            'price' => $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')),
            'price_formated' => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->config->get('config_currency')),
            'special' => $special,
            'special_excluding_tax' => $special_excluding_tax,
            'special_formated' => $special_formated,
            'discounts' => $discounts,
            'rating' => $rating
        );

        $item['description'] = utf8_substr(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..';

        return $item;
    }

    public function getproductbysku()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $sku = null;
            if (isset($this->request->get['sku'])) {
                $sku = $this->request->get['sku'];
            }

            if (!empty($sku)) {
                $this->getProductInfoBySku($sku);
            } else {
                $this->json['error'][] = "Sku is required";
                $this->statusCode = 400;
            }

        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }

    private function getProductInfoBySku($sku)
    {
        $this->load->model('rest/restadmin');

        $optionSkuEnabled = $this->model_rest_restadmin->checkFieldExist('product_option_value', 'option_sku');

        $product = $this->model_rest_restadmin->getProductBySku($sku, $optionSkuEnabled);

        if (!empty($product)) {
            $this->json['data'] = $this->getProductInfo($product);
        } else {
            $this->json['error'][] = "Product not found";
            $this->statusCode = 404;
        }

    }

    public function addproductandwithotherinfos()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->getPost();
            $this->addProductandWithOtherInfosToDb($post);

        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        return $this->sendResponse();
    }

    public function addProductandWithOtherInfosToDb($data)
    {

        $this->load->model('rest/restadmin');
        $this->load->language('restapi/product');

        if ($this->validateProductForm($data, true)) {

            if (isset($data['product_category'])) {
                $this->addCategory($data['product_category']);
            }

            if (isset($data['product_manufacturer'])) {
                $this->addManufacturer($data['product_manufacturer'][0]);
            }

            if (empty($this->error)) {
                $data['product_category'] = array_keys($this->newCatetory);
                $data['manufacturer_id'] = $this->manufacturerId;
                $productId = $this->model_rest_restadmin->addProduct($data);
                $this->json['product_id'] = $productId;
            } else {
                $this->statusCode = 400;
                $this->json['error'] = $this->error;
            }
        } else {
            $this->statusCode = 400;
            $this->json['error'] = $this->error;
        }

    }

    private function addCategory($categories)
    {

        $this->load->language('restapi/category');

        $new = $this->validateCategoryForm($categories);

        if (!empty($new) && !$this->error) {
            foreach ($new as $post) {
                foreach (self::$defaultCategoryFields as $field) {
                    if (!isset($post[$field])) {
                        if (!isset(self::$defaultCategoryFieldValues[$field])) {
                            $post[$field] = "";
                        } else {
                            $post[$field] = self::$defaultCategoryFieldValues[$field];
                        }
                    }
                }
                $catId = $this->model_rest_restadmin->addCategory($post);
                $this->newCatetory[$catId] = $catId;
            }
        }
    }

    protected function validateCategoryForm($categories)
    {
        $new = array();
        foreach ($categories as $post) {
            if (isset($post['category_description'])) {
                foreach ($post['category_description'] as $category_description) {
                    if ((utf8_strlen($category_description['name']) < 2) || (utf8_strlen($category_description['name']) > 255)) {
                        $this->error[] = $this->language->get('error_name');
                    }

                    if ((utf8_strlen($category_description['meta_title']) < 3) || (utf8_strlen($category_description['meta_title']) > 255)) {
                        $this->error[] = $this->language->get('error_meta_title');
                    }

                    $categoryExist = $this->model_rest_restadmin->checkCategoryExist($category_description['name'], $category_description['language_id'], $post['parent_id']);

                    if ($categoryExist) {
                        //$this->error['category_exist'] = 'Category with the same name, language and parent exist';
                        foreach ($categoryExist as $c) {
                            $this->newCatetory[$c['category_id']] = $c['category_id'];
                        }
                    } else {
                        $new[] = $post;
                    }
                }
            }

            if (isset($post) && isset($post['keyword'])) {
                if (utf8_strlen($post['keyword']) > 0) {

                    $url_alias_info = $this->model_rest_restadmin->getUrlAlias($post['keyword']);

                    if ($url_alias_info && isset($category_id) && $url_alias_info['query'] != 'category_id=' . $category_id) {
                        $this->error[] = sprintf($this->language->get('error_keyword'));
                    }

                    if ($url_alias_info && !isset($category_id)) {
                        $this->error[] = sprintf($this->language->get('error_keyword'));
                    }
                }
            }
        }

        return $new;
    }

    private function addManufacturer($manufacturer)
    {

        $this->load->language('restapi/manufacturer');

        $valid = $this->validateManufacturerForm($manufacturer);

        if (!empty($manufacturer) && $valid && empty($this->manufacturerId)) {
            foreach (self::$defaultManufacturerFields as $field) {
                if (!isset($post[$field])) {
                    if (!isset(self::$defaultManufacturerFieldValues[$field])) {
                        $post[$field] = "";
                    } else {
                        $post[$field] = self::$defaultManufacturerFieldValues[$field];
                    }
                }
            }
            $id = $this->model_rest_restadmin->addManufacturer($manufacturer);
            $this->manufacturerId = $id;
        }

        return false;
    }

    protected function validateManufacturerForm($post)
    {
        $manufacturerExist = $this->model_rest_restadmin->checkManufacturerExist($post['name']);

        if ($manufacturerExist) {
            foreach ($manufacturerExist as $m) {
                $this->manufacturerId = $m['id'];
            }
        }

        if ((utf8_strlen($post['name']) < 2) || (utf8_strlen($post['name']) > 64)) {
            $this->error[] = $this->language->get('error_name');
        }

        if (empty($manufacturerExist) && utf8_strlen($post['keyword']) > 0) {
            $this->load->model('rest/restadmin');

            $url_alias_info = $this->model_rest_restadmin->getUrlAlias($post['keyword']);

            if ($url_alias_info && !empty($manufacturer_id) && $url_alias_info['query'] != 'manufacturer_id=' . $manufacturer_id) {
                $this->error[] = sprintf($this->language->get('error_keyword'));
            }

            if ($url_alias_info && empty($manufacturer_id)) {
                $this->error[] = sprintf($this->language->get('error_keyword'));
            }
        }


        return !$this->error;
    }
}