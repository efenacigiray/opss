<?php
/**
 * store_admin.php
 *
 * Store management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestStoreAdmin extends RestAdminController
{

    public function store()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->getStore($this->request->get['id']);
            } else {
                $this->listStore();
            }

        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->getPost();


            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->copyStore($this->request->get['id'], $post);
            } else {
                $this->statusCode = 400;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $post = $this->getPost();


            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->editStore($this->request->get['id'], $post);
            } else {
                $this->statusCode = 400;
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET", "POST", "PUT");
        }

        return $this->sendResponse();
    }

    public function getStore($id)
    {

        $this->load->model('rest/restadmin');
        $store_info = $this->model_rest_restadmin->getSetting('config', $id);
        $data = array();

        foreach ($store_info as $key => $value){

            if(strpos($key, "_ftp_") === false && strpos($key, "_mail_") === false  && strpos($key, "robots") === false){
                $data[$key] = $value;
            }
        }

        if (!empty($data)) {
            $this->json["data"] = $data;
        } else {
            $this->json['error'][] = "Store not found";
            $this->statusCode = 404;
        }

    }

    public function listStore()
    {


        $this->load->language('restapi/store');
        $this->load->model('rest/restadmin');

        $data['stores'] = array();

        $storeURL = $this->request->server['HTTPS'] ? HTTPS_SERVER : HTTP_SERVER;

        $data['stores'][] = array(
            'store_id' => 0,
            'name' => $this->config->get('config_name'),
            'url' => $storeURL
        );

        $results = $this->model_rest_restadmin->getStores();

        foreach ($results as $result) {
            $data['stores'][] = array(
                'store_id' => $result['store_id'],
                'name' => $result['name'],
                'url' => $result['url']
            );
        }


        $this->json['data'] = $data['stores'];

    }

    public function copyStore($id, $post = array())
    {

        $this->load->model('rest/restadmin');
        $store_info = $this->model_rest_restadmin->getSetting('config', $id);
        if (!empty($store_info)) {
            if (!empty($post)) {
                $store_info = array_merge($store_info, $post);
            }

            $store_id = $this->model_rest_restadmin->addStore($store_info);
            $this->model_rest_restadmin->editSetting('config', $store_info, $store_id);
            $this->json["data"] = $store_id;
        } else {
            $this->json['error'][] = "Store not found";
            $this->statusCode = 404;
        }

    }

    public function editStore($id, $post)
    {

        $this->load->model('rest/restadmin');
        $store_info = $this->model_rest_restadmin->getSetting('config', $id);
        if (!empty($store_info)) {

            if (!empty($post)) {
                $store_info = array_merge($store_info, $post);
            }

            if ($id != 0) {
                $this->model_rest_restadmin->editStore($id, $store_info);
            }

            $this->model_rest_restadmin->editSetting('config', $store_info, $id);

        } else {
            $this->json['error'][] = "Store not found";
            $this->statusCode = 404;
        }

    }
}