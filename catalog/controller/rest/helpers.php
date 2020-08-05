<?php
/**
 * helpers.php
 *
 * Helper informations
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestHelpers extends RestAdminController
{

    /*
    * GET UTC AND LOCAL TIME DIFFERENCE
    * returns offset in seconds
    */
    public function utc_offset()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $this->load->model('rest/restadmin');

            $dbTimeZone= $this->model_rest_restadmin->getDBTimezone();

            $zones = array();
            $zones['MST']                  = 'America/Phoenix';
            $zones['Canada/Saskatchewan']  = 'America/Chicago';
            $zones['EST']                  = 'America/New_York';

            if(isset($zones[$dbTimeZone])) {
                $dbTimeZone  = $zones[$dbTimeZone];
            }

            $dateTimeZoneDB = new DateTimeZone($dbTimeZone);

            $utcTimezone    = new DateTimeZone("UTC");
            $now            = new DateTime('now', $utcTimezone);

            $offset = $dateTimeZoneDB->getOffset($now);

            $this->json['data'] = array(
                'database_timezone' => $dateTimeZoneDB,
                //'server_timezone' => $dateTimeZoneServer,
                'offset' => $offset);

        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }

    /*check database modification*/
    public function getchecksum()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $this->load->model('rest/restadmin');

            $checksum = $this->model_rest_restadmin->getChecksum();

            $checksumArray = array();

            for ($i = 0; $i < count($checksum); $i++) {
                $checksumArray[] = array('table' => $checksum[$i]['Table'], 'checksum' => $checksum[$i]['Checksum']);
            }

            $this->json['data'] = $checksumArray;

        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }


    /*
    * PRODUCT SPECIFIC INFOS
    */
    public function productclasses()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {


            $this->load->model('rest/restadmin');

            $type = "";

            if (isset($this->request->get['type']) && !empty($this->request->get['type'])) {
                $type = $this->request->get['type'];
            }

            if(empty($type) || $type == "stock_statuses") {
                $this->json['data']['stock_statuses'] = $this->model_rest_restadmin->getStockStatuses();
            }

            if(empty($type) || $type == "length_classes") {
                $this->json['data']['length_classes'] = $this->model_rest_restadmin->getLengthClasses();
            }

            if(empty($type) || $type == "weight_classes") {
                $this->json['data']['weight_classes'] = $this->model_rest_restadmin->getWeightClasses();
            }

            if(empty($type) || $type == "tax_rates") {
                $this->json['data']['tax_rates'] = $this->model_rest_restadmin->getTaxRates();
            }

            if(empty($type) || $type == "tax_classes") {
                $this->json['data']['tax_classes'] = $this->model_rest_restadmin->getTaxClasses();
            }

            if(empty($type) || $type == "tax_rules") {
                $this->json['data']['tax_rules'] = $this->model_rest_restadmin->getAllTaxRules();
            }

            if(empty($type) || $type == "stores") {
                $stores_result = $this->model_rest_restadmin->getStores();

                $stores = array();

                foreach ($stores_result as $result) {
                    $stores[] = array(
                        'store_id' => $result['store_id'],
                        'name' => $result['name']
                    );
                }

                $default_store[] = array(
                    'store_id' => 0,
                    'name' => $this->config->get('config_name')
                );

                $this->json['data']['stores'] = array_merge($default_store, $stores);
            }

            if(empty($type) || $type == "languages") {
                $this->load->model('localisation/language');

                $languages = $this->model_localisation_language->getLanguages();

                if (count($languages) == 0) {
                    $this->json['data']['languages'] = array();
                } else {
                    $this->json['data']['languages'] = array_values($languages);
                }
            }


            if(empty($type) || $type == "currency") {
                $this->load->model('localisation/currency');

                $currencies = $this->model_localisation_currency->getCurrencies();

                if (count($currencies) == 0) {
                    $this->json['data']['currency'] = array();
                } else {
                    $this->json['data']['currency'] = array_values($currencies);
                }
            }

            if(empty($type) || $type == "order_statuses") {

                $orderStatuses = $this->model_rest_restadmin->getOrderStatuses();

                if (count($orderStatuses) == 0) {
                    $this->json['data']['order_statuses'] = array();
                } else {
                    $this->json['data']['order_statuses'] = $orderStatuses;
                }
            }

            if(empty($type) || $type == "recurrings") {
                $this->json['data']['recurrings'] = $this->model_rest_restadmin->getRecurrings();
            }

            if(!empty($type)) {
                $this->json['data'] = array_values($this->json['data']);
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }

    /*
    * COUNTRY FUNCTIONS
    */
    public function countries()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //get country details
            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->getCountry($this->request->get['id']);
            } else {
                $this->listCountries();
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }

    /*
    * Get countries
    */

    public function getCountry($country_id)
    {


        $this->load->model('localisation/country');

        $country_info = $this->model_localisation_country->getCountry($country_id);

        if (!empty($country_info)) {
            $this->json["data"] = $this->getCountryInfo($country_info);
        } else {
            $this->statusCode = 404;
        }

    }

    /*
    * Get country details
    */

    private function getCountryInfo($country_info, $addZone = true)
    {
        $this->load->model('localisation/zone');
        $info = array(
            'country_id' => $country_info['country_id'],
            'name' => $country_info['name'],
            'iso_code_2' => $country_info['iso_code_2'],
            'iso_code_3' => $country_info['iso_code_3'],
            'address_format' => $country_info['address_format'],
            'postcode_required' => $country_info['postcode_required'],
            'status' => $country_info['status']
        );
        if ($addZone) {
            $info['zone'] = $this->model_localisation_zone->getZonesByCountryId($country_info['country_id']);
        }

        return $info;
    }

    private function listCountries()
    {


        $this->load->model('localisation/country');

        $results = $this->model_localisation_country->getCountries();

        $data = array();

        foreach ($results as $country) {
            $data[] = $this->getCountryInfo($country, false);
        }

        $this->json['data'] = $data;

    }

    /*
    * SESSION FUNCTIONS
    */

    public function session()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //get session details
            $this->getSessionId();
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }

    /*
    * Get current session id
    */
    public function getSessionId()
    {

        $this->json['data'] = array('session' => session_id());

    }
}