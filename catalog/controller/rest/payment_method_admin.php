<?php
/**
 * payment_method_admin.php
 *
 * Payment method management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestPaymentMethodAdmin extends RestAdminController
{
    /*
     * çalýþan kýsým bu
     */
    public function paymentmethods()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->listPaymentMethods();
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }

    public function listPaymentMethods()
    {

        $this->load->model('setting/extension');

        $results = $this->model_setting_extension->getExtensions('payment');

        $this->json['data'] = !empty($results) ? $results : array();

    }

    public function listOrderStatus() {

        //$json = array('success' => false);

        $this->load->model('rest/restadmin');

        $results = $this->model_rest_restadmin->getOrderStatuses();

        $this->json['data'] = !empty($results) ? $results : array();

        //if (count($results) == 0 || empty($results)) {
        //    $json['error'] = "No orderstatus method found";
        //} else {
        //    $json['success'] = true;
        //    $json['data'] = $results;
        //}

        //$this->sendResponse($json);

        //$json = array('success' => false);

        //$this->load->model('rest/restadmin');

        //$results = $this->model_rest_restadmin->getOrderStatuses();

        //if (count($results) == 0 || empty($results)) {
        //    $json['error'] = "No orderstatus method found";
        //} else {
        //    $json['success'] = true;
        //    $json['data'] = $results;
        //}

        //$this->sendResponse($json);
    }

    /*
     * PAYMENT METHOD FUNCTIONS
     * index.php?route=rest/orderstatus_method_admin/orderstatusmethods
     */
    public function orderstatusmethods() {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->listOrderStatus();
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }


        //if ( $_SERVER['REQUEST_METHOD'] === 'GET' ){
        //    $this->listOrderStatus();
        //}

        return $this->sendResponse();
    }
}