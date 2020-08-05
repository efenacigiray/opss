<?php
/**
 * customer_group_admin.php
 *
 * Customer group management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestCustomerGroupAdmin extends RestAdminController
{

    public function customergroup()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->listCustomerGroups($this->request);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->getPost();

            $this->addCustomerGroup($post);

        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $post = $this->getPost();

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->editCustomerGroup($this->request->get['id'], $post);
            } else {
                $this->statusCode = 400;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->load->model('rest/restadmin');

                $customerGroup = $this->model_rest_restadmin->getCustomerGroup($this->request->get['id']);

                if($customerGroup) {
                    $this->deleteCustomerGroup($this->request->get['id']);
                } else {
                    $this->json['error'][] = "Customer group not found";
                    $this->statusCode = 404;
                }
            } else {

                $post = $this->getPost();

                if (isset($post["groups"])) {
                    $this->deleteCustomerGroups($post);
                } else {
                    $this->statusCode = 400;
                }
            }
        }

        return $this->sendResponse();
    }

    public function listCustomerGroups($request)
    {

        $this->load->language('restapi/customer_group');
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

        $customer_groups = array();

        $results = $this->model_rest_restadmin->getCustomerGroups($parameters);

        foreach ($results as $result) {
            $languageId = isset($result['language_id']) ? $result['language_id'] : (int)$this->config->get('config_language_id');

            if($this->multilang){
                $customer_groups['customer_groups'][$result['customer_group_id']][] = array(
                    'customer_group_id' => $result['customer_group_id'],
                    'name' => $result['name'] . (($result['customer_group_id'] == $this->config->get('config_customer_group_id')) ? $this->language->get('text_default') : null),
                    'sort_order' => $result['sort_order'],
                    'approval' => $result['approval'],
                    'description' => $result['description'],
                    'language_id' => $languageId
                );
            } else {
                $customer_groups['customer_groups'][] = array(
                    'customer_group_id' => $result['customer_group_id'],
                    'name' => $result['name'] . (($result['customer_group_id'] == $this->config->get('config_customer_group_id')) ? $this->language->get('text_default') : null),
                    'sort_order' => $result['sort_order'],
                    'approval' => $result['approval'],
                    'description' => $result['description'],
                    'language_id' => $languageId
                );
            }
        }

        $this->json['data'] = !empty($customer_groups) ? $customer_groups['customer_groups'] : array();

    }

    public function addCustomerGroup($post)
    {

        $this->load->language('restapi/customer_group');
        $this->load->model('rest/restadmin');

        $error = $this->validateForm($post);

        if (!empty($post) && empty($error)) {

            if(!isset($post['approval'])){
                $post['approval'] = 0;
            }

            if(!isset($post['sort_order'])){
                $post['sort_order'] = "";
            }

            $retval = $this->model_rest_restadmin->addCustomerGroup($post);
            $this->json["data"]["id"] = $retval;
        } else {
            $this->json['error'] = $error;
            $this->statusCode = 400;
        }

    }

    protected function validateForm(&$post, $id=null)
    {

        $error = array();

        if(isset($post['customer_group_description'])){
            foreach ($post['customer_group_description'] as &$customer_group_description) {

                if(!isset($customer_group_description['language_id'])){
                    $customer_group_description['language_id'] = 1;
                }

                if (!isset($customer_group_description['name']) || (utf8_strlen($customer_group_description['name']) < 3) || (utf8_strlen($customer_group_description['name']) > 64)) {
                    //$error['name'][$customer_group_description['language_id']] = $this->language->get('error_name');
                    $error[] = $this->language->get('error_name');
                }

                if(!isset($customer_group_description['description'])){
                    $customer_group_description['description'] = "";
                }

            }

        } else {
            if(empty($id)){
                //$error['customer_group_description'][1] = "Customer group description is required";
                $error[] = "Customer group description is required";
            }
        }

        return $error;
    }

    public function editCustomerGroup($id, $post)
    {

        $this->load->language('restapi/customer_group');
        $this->load->model('rest/restadmin');

        $customerGroup = $this->model_rest_restadmin->getCustomerGroup($id);

        if($customerGroup) {

            $error = $this->validateForm($post, $id);

            if (!empty($post) && empty($error)) {

                if (!isset($post['approval'])) {
                    $post['approval'] = $customerGroup['approval'];
                }

                if (!isset($post['sort_order'])) {
                    $post['sort_order'] = $customerGroup['sort_order'];
                }

                $this->model_rest_restadmin->editCustomerGroup($id, $post);
            } else {
                $this->json['error'] = $error;
                $this->statusCode = 400;
            }
        } else {
            $this->json['error'][] = "Customer group not found";
            $this->statusCode = 404;
        }
    }

    public function deleteCustomerGroups($post)
    {

        $this->load->language('restapi/customer_group');
        $this->load->model('rest/restadmin');

        $error = $this->validateDelete($post);

        if (isset($post['groups']) && empty($error)) {
            foreach ($post['groups'] as $customer_group_id) {
                $this->model_rest_restadmin->deleteCustomerGroup($customer_group_id);
            }
        } else {
            $this->json['error'] = $error;
            $this->statusCode = 400;
        }

    }

    public function deleteCustomerGroup($id)
    {

        $this->load->model('rest/restadmin');

        if (!empty($id)) {
            $this->model_rest_restadmin->deleteCustomerGroup($id);
        } else {
            $this->statusCode = 400;
        }
    }

    protected function validateDelete($post)
    {

        $error = array();

        $this->load->model('setting/store');
        $this->load->model('rest/restadmin');

        foreach ($post['groups'] as $customer_group_id) {

            $store_total = $this->model_rest_restadmin->getTotalStoresByCustomerGroupId($customer_group_id);

            if ($store_total) {
                $error[] = sprintf($this->language->get('error_store'), $store_total);
            }

            $customer_total = $this->model_rest_restadmin->getTotalCustomersByCustomerGroupId($customer_group_id);

            if ($customer_total) {
                $error[] = sprintf($this->language->get('error_customer'), $customer_total);
            }
        }

        return $error;
    }
}