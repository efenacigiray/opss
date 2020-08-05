<?php
/**
 * attribute_group_admin.php
 *
 * Attribute group management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestAttributeGroupAdmin extends RestAdminController
{

    private static $defaultFields = array(
        "attribute_description",
        "sort_order"
    );

    private static $defaultFieldValues = array(
        "attribute_description" => array(),
        "sort_order" => ""
    );

    /*
    * Get attribute groups
    */

    public function attributegroup()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->listAttributeGroups($this->request);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $post = $this->getPost();

            $this->addAttributeGroup($post);

        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

            $post = $this->getPost();

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->editAttributeGroup($this->request->get['id'], $post);
            } else {
                $this->statusCode = 400;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->load->model('rest/restadmin');
                $attributeGroup = $this->model_rest_restadmin->getAttributeGroup($this->request->get['id']);

                if($attributeGroup) {
                    $post["groups"] = array($this->request->get['id']);
                    $this->deleteAttributeGroup($post);
                } else {
                    $this->json['error'][] = "Attribute group not found";
                    $this->statusCode = 404;
                }

            } else {

                $post = $this->getPost();

                if (isset($post["groups"])) {
                    $this->deleteAttributeGroup($post);
                } else {
                    $this->statusCode = 400;
                }
            }

        }

        return $this->sendResponse();
    }

    public function listAttributeGroups($request)
    {

        $this->load->language('restapi/attribute_group');
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

        $results = $this->model_rest_restadmin->getAttributeGroups($parameters);

        $attribute_groups = array();

        foreach ($results as $result) {
            $languageId = isset($result['language_id']) ? $result['language_id'] : (int)$this->config->get('config_language_id');

            if($this->multilang){
                $attribute_groups['attribute_groups'][$result['attribute_group_id']][] = array(
                    'attribute_group_id' => $result['attribute_group_id'],
                    'name' => $result['name'],
                    'sort_order' => $result['sort_order'],
                    'language_id' => $languageId
                );
            } else {
                $attribute_groups['attribute_groups'][] = array(
                    'attribute_group_id' => $result['attribute_group_id'],
                    'name' => $result['name'],
                    'sort_order' => $result['sort_order'],
                    'language_id' => $languageId
                );
            }
        }

        $this->json['data'] = !empty($attribute_groups) ? $attribute_groups['attribute_groups'] : array() ;

    }


    public function addAttributeGroup($post)
    {

        $this->load->language('restapi/attribute_group');
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
            $retval = $this->model_rest_restadmin->addAttributeGroup($post);
            $this->json["data"]["id"] = $retval;
        } else {
            $this->json['error'] = $error;
            $this->statusCode = 400;
        }
    }

    protected function validateForm(&$post, $id=null)
    {

        $error = array();

        if(isset($post['attribute_group_description'])) {
            foreach ($post['attribute_group_description'] as $attribute_group_description) {
                if(!isset($attribute_group_description['language_id'])){
                    $attribute_group_description['language_id'] = 1;
                }
                if (!isset($attribute_group_description['name']) || (utf8_strlen($attribute_group_description['name']) < 3) || (utf8_strlen($attribute_group_description['name']) > 64)) {
                    //$error['name'][$attribute_group_description['language_id']] = $this->language->get('error_name');
                    $error[] = $this->language->get('error_name');
                }
            }
        } else {
            if(empty($id)){
                //$error['name'][1] = $this->language->get('error_name');
                $error[] = $this->language->get('error_name');
            }
        }


        return $error;
    }

    public function editAttributeGroup($id, $post)
    {

        $this->load->language('restapi/attribute_group');
        $this->load->model('rest/restadmin');

        $attributeGroup = $this->model_rest_restadmin->getAttributeGroup($id);

        if($attributeGroup) {
            $error = $this->validateForm($post, $id);

            if (!empty($post) && empty($error)) {
                $this->model_rest_restadmin->editAttributeGroup($id, $post);
            } else {
                $this->json['error'] = $error;
                $this->statusCode = 400;
            }
        } else {
            $this->json['error'][] = "Attribute group not found";
            $this->statusCode = 404;
        }
    }

    public function deleteAttributeGroup($post)
    {

        $this->load->language('restapi/attribute_group');
        $this->load->model('rest/restadmin');

        $error = $this->validateDelete($post);

        if (isset($post['groups']) && empty($error)) {
            foreach ($post['groups'] as $attribute_group_id) {
                $this->model_rest_restadmin->deleteAttributeGroup($attribute_group_id);
            }
        } else {
            $this->statusCode = 400;
        }
    }

    protected function validateDelete($post)
    {

        $this->load->model('catalog/product');

        $error = array();

        foreach ($post['groups'] as $attribute_group_id) {
            $attribute_total = $this->model_rest_restadmin->getTotalAttributesByAttributeGroupId($attribute_group_id);

            if ($attribute_total) {
                $error[] = sprintf($this->language->get('error_attribute'), $attribute_total);
            }
        }

        return $error;
    }
}