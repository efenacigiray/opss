<?php
/**
 * coupon_admin.php
 *
 * Coupon management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestCouponAdmin extends RestAdminController
{

    private static $defaultFields = array(
        "name",
        "code",
        "date_start",
        "date_end",
        "type",
        "discount",
        "total",
        "logged",
        "shipping",
        "uses_total",
        "uses_customer",
        "coupon_product",
        "coupon_category",
        "status",
    );

    private static $defaultFieldValues = array(
        "discount" => 0,
        "total" => 0,
        "uses_total" => 1,
        "uses_customer" => 1,
        "status" => 1,
        "logged" => 0,
        "shipping" => 0,
        "type" => "P",
        "coupon_product" => array(),
        "coupon_category" => array(),
    );


    public function coupon()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->listCoupon($this->request);

        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->getPost();

            if (!empty($post)) {
                $this->addCoupon($post);
            } else {
                $this->statusCode = 400;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $post = $this->getPost();

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])
                && !empty($post)
            ) {
                $this->editCoupon($this->request->get['id'], $post);
            } else {
                $this->statusCode = 400;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->load->model('rest/restadmin');
                $coupon = $this->model_rest_restadmin->getCoupon($this->request->get['id']);

                if($coupon){
                    $post["coupons"] = array($this->request->get['id']);
                    $this->deleteCoupon($post);
                } else {
                    $this->json['error'][] = "Coupon not found";
                    $this->statusCode = 404;
                }
            } else {

                $post = $this->getPost();

                if (!empty($post) && isset($post["coupons"])) {
                    $this->deleteCoupon($post);
                } else {
                    $this->statusCode = 400;
                }
            }
        }

        return $this->sendResponse();
    }

    public function listCoupon($request)
    {

        $this->load->language('restapi/coupon');
        $this->load->model('rest/restadmin');

        $parameters = array(
            "limit" => $this->config->get('config_limit_admin'),
            "start" => 1,
        );

        /*check limit parameter*/
        if (isset($request->get['limit']) && ctype_digit($request->get['limit'])) {
            $parameters["limit"] = $request->get['limit'];
        }

        /*check page parameter*/
        if (isset($request->get['page']) && ctype_digit($request->get['page'])) {
            $parameters["start"] = $request->get['page'];
        }

        $parameters["start"] = ($parameters["start"] - 1) * $parameters["limit"];

        $coupons = array();

        $results = $this->model_rest_restadmin->getCoupons($parameters);
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');

        foreach ($results as $result) {
            $products = $this->model_rest_restadmin->getCouponProducts($result["coupon_id"]);

            $coupon_product = array();

            foreach ($products as $product_id) {
                $product_info = $this->model_catalog_product->getProduct($product_id);

                if ($product_info) {
                    $coupon_product[] = array(
                        'product_id' => $product_info['product_id'],
                        'name' => $product_info['name']
                    );
                }
            }

            $categories = $this->model_rest_restadmin->getCouponCategories($result["coupon_id"]);

            $coupon_category = array();

            foreach ($categories as $category_id) {
                $category_info = $this->model_catalog_category->getCategory($category_id);

                if ($category_info) {
                    $coupon_category[] = array(
                        'category_id' => $category_info['category_id'],
                        'name' => (isset($category_info['path']) && !empty($category_info['path']) ? $category_info['path'] . ' &gt; ' : '') . $category_info['name']
                    );
                }
            }

            $coupons['coupons'][] = array(
                'coupon_id' => $result['coupon_id'],
                'name' => $result['name'],
                'code' => $result['code'],
                'discount' => $result['discount'],
                'total' => $result['total'],
                'type' => $result['type'],
                'logged' => $result['logged'],
                'shipping' => $result['shipping'],
                'uses_total' => $result['uses_total'],
                'uses_customer' => $result['uses_customer'],
                'categories' => $coupon_category,
                'products' => $coupon_product,
                'date_start' => date($this->language->get('date_format_short'), strtotime($result['date_start'])),
                'date_end' => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
                'status' => $result['status']
            );
        }

        $this->json['data'] = !empty($coupons) ? $coupons['coupons'] : array();

    }

    public function addCoupon($post)
    {

        $this->load->language('restapi/coupon');
        $this->load->model('rest/restadmin');

        $error = $this->validateForm($post);

        if (!empty($post) && empty($error)) {

            $this->loadData($post);

            $retval = $this->model_rest_restadmin->addCoupon($post);
            $this->json["data"]["id"] = $retval;
        } else {
            $this->json["error"] = $error;
            $this->statusCode = 400;
        }

    }

    protected function validateForm($post, $coupon_id = null)
    {
        $this->load->model('rest/restadmin');
        $error = array();

        if (!isset($post['name']) || (utf8_strlen($post['name']) < 3) || (utf8_strlen($post['name']) > 128)) {
            //$error['name'] = $this->language->get('error_name');
            $error[] = $this->language->get('error_name');
        }

        if (!isset($post['code']) || (utf8_strlen($post['code']) < 3) || (utf8_strlen($post['code']) > 10)) {
            //$error['code'] = $this->language->get('error_code');
            $error[] = $this->language->get('error_code');
        } else {
            $coupon_info = $this->model_rest_restadmin->getCouponByCode($post['code']);
            if ($coupon_info) {
                if (empty($coupon_id)) {
                    $error[] = $this->language->get('error_exists');
                } elseif ($coupon_info['coupon_id'] != $coupon_id) {
                    $error[] = $this->language->get('error_exists');
                }
            }
        }

        return $error;
    }

    private function loadData(&$data, $item = null)
    {
        foreach (self::$defaultFields as $field) {
            if (!isset($data[$field])) {
                if (!empty($item)) {
                    if(isset($item[$field])) {
                        $data[$field] = $item[$field];
                    }
                } else {

                    if (!isset(self::$defaultFieldValues[$field])) {
                        if ($field == "date_start") {
                            $data[$field] = date('Y-m-d', time());
                        } else if($field == "date_end") {
                            $data[$field] =  date("Y-m-d", strtotime("+1 month", time()));
                        } else {
                            $data[$field] = "";
                        }
                    } else {
                        $data[$field] = self::$defaultFieldValues[$field];
                    }
                }
            }
        }

    }

    public function editCoupon($id, $post)
    {

        $this->load->language('restapi/coupon');
        $this->load->model('rest/restadmin');

        $data = $this->model_rest_restadmin->getCoupon($id);
        if ($data){
            $this->loadData($post, $data);

            $error = $this->validateForm($post, $id);

            if (!empty($post) && empty($error)) {
                $this->model_rest_restadmin->editCoupon($id, $post);
            } else {
                $this->json["error"] = $error;
                $this->statusCode = 400;
            }
        } else {
            $this->json['error'][] = "Coupon not found";
            $this->statusCode = 404;
        }
    }

    public function deleteCoupon($post)
    {

        $this->load->language('restapi/coupon');
        $this->load->model('rest/restadmin');

        if (isset($post['coupons'])) {
            foreach ($post['coupons'] as $coupon_id) {
                $this->model_rest_restadmin->deleteCoupon($coupon_id);
            }
        } else {
            $this->statusCode = 400;
        }
    }
}