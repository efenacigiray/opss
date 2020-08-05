<?php
/**
 * shipping_method_admin.php
 *
 * Shipping method management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestShippingMethodAdmin extends RestAdminController
{

    public function shippingmethods()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->listShippingMethods();
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }


    public function listShippingMethods()
    {

        $this->load->model('setting/extension');

        $results = $this->model_setting_extension->getExtensions('shipping');

        $this->json['data'] = !empty($results) ? $results : array();

    }
}
