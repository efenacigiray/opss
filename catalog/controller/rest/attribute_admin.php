<?php
/**
 * attribute_admin.php
 *
 * Attribute management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestAttributeAdmin extends RestAdminController
{

    private static $defaultFields = array(
        "attribute_description",
        "attribute_group_id",
        "attribute_groups",
        "sort_order"
    );

    private static $defaultFieldValues = array(
        "attribute_description" => array(),
        "sort_order" => 0
    );

    public function attribute()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->listAttribute($this->request);

        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $post = $this->getPost();

            $this->addAttribute($post);

        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

            $post = $this->getPost();

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->editAttribute($this->request->get['id'], $post);
            } else {
                $this->statusCode = 400;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->load->model('rest/restadmin');
                $attribute = $this->model_rest_restadmin->getAttribute($this->request->get['id']);

                if($attribute) {
                    $post["attributes"] = array($this->request->get['id']);
                    $this->deleteAttribute($post);
                } else {
                    $this->json['error'][] = "Attribute not found";
                    $this->statusCode = 404;
                }
            } else {

                $post = $this->getPost();

                if (isset($post["attributes"])) {
                    $this->deleteAttribute($post);
                } else {
                    $this->statusCode = 400;
                }
            }
        }

        return $this->sendResponse();
    }

    public function listAttribute($request)
    {

        $this->load->language('restapi/attribute');
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

        /*group parameter*/
        if (isset($request->get['group']) && ctype_digit($request->get['group'])) {
            $parameters["filter_attribute_group_id"] = $request->get['group'];
        }

        $parameters["start"] = ($parameters["start"] - 1) * $parameters["limit"];

        $attributes = array();

        $results = $this->model_rest_restadmin->getAttributes($parameters);

        foreach ($results as $result) {
            $languageId = isset($result['language_id']) ? $result['language_id'] : (int)$this->config->get('config_language_id');
            if($this->multilang){
                $attributes['attributes'][$result['attribute_id']][] = array(
                    'attribute_id' => $result['attribute_id'],
                    'name' => $result['name'],
                    'attribute_group_id' => $result['attribute_group_id'],
                    'sort_order' => $result['sort_order'],
                    'language_id' => $languageId
                );
            } else {
                $attributes['attributes'][] = array(
                    'attribute_id' => $result['attribute_id'],
                    'name' => $result['name'],
                    'attribute_group_id' => $result['attribute_group_id'],
                    'sort_order' => $result['sort_order'],
                    'language_id' => $languageId
                );
            }

        }

        $this->json['data'] = !empty($attributes) ? $attributes['attributes'] : array();
    }


    public function addAttribute($post)
    {

        $this->load->language('restapi/attribute');
        $this->load->model('rest/restadmin');

        $error = $this->validateForm($post);

        if (!empty($post) && empty($error)) {

            foreach (self::$defaultFields as $field) {
                if (!isset($post[$field])) {
                    if (!isset(self::$defaultFieldValues[$field])) {
                        $post[$field] = "";
                    } else {
                        $post[$field] = self::$defaultFieldValues[$field];
                    }
                }
            }

            $retval = $this->model_rest_restadmin->addAttribute($post);
            $this->json["data"]["id"] = $retval;
        } else {
            $this->json['error'] = $error;
            $this->statusCode = 400;
        }
    }


    protected function validateForm(&$post)
    {

        $error = array();

        if(isset($post['attribute_description'])){
            foreach ($post['attribute_description'] as $attribute_description) {
                if (!isset($attribute_description['name']) || (utf8_strlen($attribute_description['name']) < 3) || (utf8_strlen($attribute_description['name']) > 64)) {
                    //$error['name'][$attribute_description['language_id']] = $this->language->get('error_name');
                    $error[] = $this->language->get('error_name');
                }

                if(!isset($attribute_description['language_id'])){
                    $attribute_description['language_id'] = 1;
                }
            }
        } else {
            if(empty($id)){
                //$error['name'][1] = $this->language->get('error_name');
                $error[] = $this->language->get('error_name');
            }
        }

        if(!isset($post['attribute_group_id'])){
            //$error['attribute_group_id'][1] = "Attribute group ID is required";
            $error[] = "Attribute group ID is required";
        }

        return $error;
    }

    public function editAttribute($id, $post)
    {

        $this->load->language('restapi/attribute');
        $this->load->model('rest/restadmin');

        $attribute = $this->model_rest_restadmin->getAttribute($id);

        if($attribute) {
            $error = $this->validateForm($post);

            if (!empty($post) && empty($error)) {

                $this->model_rest_restadmin->editAttribute($id, $post);
            } else {
                $this->statusCode = 400;
            }
        } else {
            $this->json['error'][] = "Attribute not found";
            $this->statusCode = 404;
        }
    }

    public function deleteAttribute($post)
    {

        $this->load->language('restapi/attribute');
        $this->load->model('rest/restadmin');

        $error = $this->validateDelete($post);

        if (isset($post['attributes']) && empty($error)) {
            foreach ($post['attributes'] as $attribute_id) {
                $this->model_rest_restadmin->deleteAttribute($attribute_id);
            }
        } else {
            $this->statusCode = 400;
        }
    }

    protected function validateDelete($post)
    {

        $this->load->model('rest/restadmin');

        $error = array();

        foreach ($post['attributes'] as $attribute_id) {
            $product_total = $this->model_rest_restadmin->getTotalProductsByAttributeId($attribute_id);

            if ($product_total) {
                $error[] = sprintf($this->language->get('error_product'), $product_total);
            }
        }

        return $error;
    }
}