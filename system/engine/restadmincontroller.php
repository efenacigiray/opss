<?php
error_reporting(E_ALL & ~E_NOTICE);

abstract class RestAdminController extends Controller
{
    public static $ocRegistry = null;
    public static $ocVersion = null;

    public $statusCode = 200;
    public $post = array();

    public $allowedHeaders = array("GET", "POST", "PUT", "DELETE");

    public $accessControlAllowHeaders = array(
        "Content-Type",
        "Authorization",
        "X-Requested-With",
        "X-Oc-Restadmin-Id",
        "X-Oc-Merchant-Language",
        "X-Oc-Store-Id"
    );

    public $json = array("success" => 1, "error" => array(), "data" => array());

    public $multilang = 0;
    public $opencartVersion = "";

    private $httpVersion = "HTTP/1.1";

    public function checkPlugin()
    {

        $this->opencartVersion = str_replace(".", "", VERSION);

        static::$ocRegistry = $this->registry;
        static::$ocVersion = $this->opencartVersion;

        /*check rest api is enabled*/
        //$module_rest_admin_api_licensed_on = $this->config->get('module_rest_admin_api_licensed_on');

        if (!$this->config->get('module_rest_admin_api_status')) {
            $this->json["error"][] = 'Rest Admin API is disabled. Enable it!';
            $this->statusCode = 403;
            $this->sendResponse();
        }

        //if (!$this->ipValidation()) {
        //    $this->statusCode = 403;
        //    $this->sendResponse();
        //}

        $this->setSystemParameters();

    }

    public function sendResponse()
    {

        $statusMessage = $this->getHttpStatusMessage($this->statusCode);

        //fix missing allowed OPTIONS header
        $this->allowedHeaders[] = "OPTIONS";

        if ($this->statusCode != 200) {
            if (!isset($this->json["error"])) {
                $this->json["error"][] = $statusMessage;
            }

            if ($this->statusCode == 405 && $_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
                $this->response->addHeader('Allow: ' . implode(",", $this->allowedHeaders));
            }

            $this->json["success"] = 0;

            //enable OPTIONS header
            if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
                $this->statusCode = 200;
                $this->json["success"] = 1;
                $this->json["error"] = array();
            }
        }

        if (isset($this->request->server['HTTP_ORIGIN'])) {
            $this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
            $this->response->addHeader('Access-Control-Allow-Methods: '. implode(", ", $this->allowedHeaders));
            $this->response->addHeader('Access-Control-Allow-Headers: '. implode(", ", $this->accessControlAllowHeaders));
            $this->response->addHeader('Access-Control-Allow-Credentials: true');
        }

        $this->response->addHeader($this->httpVersion . " " . $this->statusCode . " " . $statusMessage);
        $this->response->addHeader('Content-Type: application/json; charset=utf-8');

        if (defined('JSON_UNESCAPED_UNICODE')) {
            $this->response->setOutput(json_encode($this->json, JSON_UNESCAPED_UNICODE));
        } else {
            $this->response->setOutput($this->rawJsonEncode($this->json));
        }

        $this->response->output();

        die;
    }

    public function getHttpStatusMessage($statusCode)
    {
        $httpStatus = array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed'
        );

        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];
    }

    private function ipValidation()
    {
        $allowedIPs = $this->config->get('module_rest_admin_api_allowed_ip');
        if (!empty($allowedIPs)) {
            $ips = explode(",", $allowedIPs);

            $ips = array_map(
                function ($ip) {
                    return trim($ip);
                },
                $ips
            );

            if (!in_array($_SERVER['REMOTE_ADDR'], $ips)
                || (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && !in_array($_SERVER["HTTP_X_FORWARDED_FOR"], $ips))
            ) {
                return false;
            } else {
                return true;
            }
        }
        return true;
    }

    private function setSystemParameters()
    {

        $headers = $this->getRequestHeaders();

        $key = "";

        //set api key
        if (isset($headers['x-oc-restadmin-id'])) {
            $key = $headers['x-oc-restadmin-id'];
        }

        /*validate api security key*/
        if ($this->config->get('module_rest_admin_api_key') && ($key != $this->config->get('module_rest_admin_api_key'))) {
            $this->json["error"][] = 'Invalid or missing secret key';
            $this->statusCode = 403;
            $this->sendResponse();
        }

        //set currency
        if (isset($headers['x-oc-currency'])) {
            $currency = $headers['x-oc-currency'];
            if (!empty($currency)) {
                $this->currency->set($currency);
            }
        }

        //set store ID
        if (isset($headers['x-oc-store-id'])) {
            $this->config->set('config_store_id', $headers['x-oc-store-id']);
            $this->config->set('config_rest_store_id', $headers['x-oc-store-id']);
        }

        $this->load->model('localisation/language');
        $allLanguages = $this->model_localisation_language->getLanguages();

        if (count($allLanguages) > 1) {
            $this->multilang = 1;
        }

        //set language
        if (isset($headers['x-oc-merchant-language'])) {
            $osc_lang = $headers['x-oc-merchant-language'];

            $this->session->data['language'] = $osc_lang;
            $this->config->set('config_language', $osc_lang);

            $languages = array();

            foreach ($allLanguages as $result) {
                $languages[$result['code']] = $result;
            }

            $this->config->set('config_language_id', $languages[$osc_lang]['language_id']);

            if (isset($languages[$osc_lang]['directory']) && !empty($languages[$osc_lang]['directory'])) {
                $directory = $languages[$osc_lang]['directory'];
            } else {
                $directory = $languages[$osc_lang]['code'];
            }

            $language = new \Language($directory);
            $language->load($directory);
            $this->registry->set('language', $language);
        }
    }

    private function getRequestHeaders()
    {
        $arh = array();
        $rx_http = '/\AHTTP_/';

        foreach ($_SERVER as $key => $val) {
            if (preg_match($rx_http, $key)) {
                $arh_key = preg_replace($rx_http, '', $key);

                $rx_matches = explode('_', $arh_key);

                if (count($rx_matches) > 0 and strlen($arh_key) > 2) {
                    foreach ($rx_matches as $ak_key => $ak_val) {
                        $rx_matches[$ak_key] = ucfirst($ak_val);
                    }

                    $arh_key = implode('-', $rx_matches);
                }

                $arh[strtolower($arh_key)] = $val;
            }
        }

        return ($arh);

    }

    public function getPost()
    {
        $input = file_get_contents('php://input');
        $post = json_decode($input, true);

        if (!is_array($post) || empty($post)) {
            $this->statusCode = 400;
            $this->json['error'][] = 'Invalid request body, please validate the json object';
            $this->sendResponse();
        }

        return $post;
    }

    private function rawJsonEncode($input, $flags = 0) {
        $fails = implode('|', array_filter(array(
            '\\\\',
            $flags & JSON_HEX_TAG ? 'u003[CE]' : '',
            $flags & JSON_HEX_AMP ? 'u0026' : '',
            $flags & JSON_HEX_APOS ? 'u0027' : '',
            $flags & JSON_HEX_QUOT ? 'u0022' : '',
        )));
        $pattern = "/\\\\(?:(?:$fails)(*SKIP)(*FAIL)|u([0-9a-fA-F]{4}))/";
        $callback = function ($m) {
            return html_entity_decode("&#x$m[1];", ENT_QUOTES, 'UTF-8');
        };
        return preg_replace_callback($pattern, $callback, json_encode($input, $flags));
    }
}