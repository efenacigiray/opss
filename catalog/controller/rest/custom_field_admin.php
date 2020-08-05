<?php
/**
 * custom_field_admin.php
 *
 * Custom field management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestCustomFieldAdmin extends RestAdminController
{

    public function customfield()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->listCustomFields($this->request);
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }
        return $this->sendResponse();
    }

    public function listCustomFields($request)
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

        $customfields = array();

        $results = $this->model_rest_restadmin->getCustomFields($parameters);

        foreach ($results as $result) {
            $languageId = isset($result['language_id']) ? $result['language_id'] : (int)$this->config->get('config_language_id');

            if($this->multilang){
                $customfields['customfields'][$result['custom_field_id']][] = array(
                    'custom_field_id' => $result['custom_field_id'],
                    'name' => $result['name'],
                    'value' => $result['value'],
                    'type' => $result['type'],
                    'location' => $result['location'],
                    'status' => $result['status'],
                    'sort_order' => $result['sort_order'],
                    'language_id' => $languageId,
                    'values' => $this->model_rest_restadmin->getCustomFieldValues($result['custom_field_id'], $languageId)
                );
            } else {
                $customfields['customfields'][$result['custom_field_id']][] = array(
                    'custom_field_id' => $result['custom_field_id'],
                    'name' => $result['name'],
                    'value' => $result['value'],
                    'type' => $result['type'],
                    'location' => $result['location'],
                    'status' => $result['status'],
                    'sort_order' => $result['sort_order'],
                    'language_id' => $languageId,
                    'values' => $this->model_rest_restadmin->getCustomFieldValues($result['custom_field_id'], $languageId)
                );
            }
        }

        $this->json['data'] = !empty($customfields) ? $customfields['customfields'] : array();

    }
}