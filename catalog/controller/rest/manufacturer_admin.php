<?php
/**
 * manufacturer_admin.php
 *
 * Manufacturer management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestManufacturerAdmin extends RestAdminController
{

    private static $defaultFields = array(
        "name",
        "manufacturer_store",
        "manufacturer_seo_url",
        "sort_order"
    );

    private static $defaultFieldValues = array(
        "manufacturer_store" => array(0)
    );

    public function manufacturer()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->listManufacturer($this->request);

        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->getPost();

            $this->addManufacturer($post);

        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $post = $this->getPost();


            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->editManufacturer($this->request->get['id'], $post);
            } else {
                $this->statusCode = 400;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->load->model('rest/restadmin');

                $manufacturer = $this->model_rest_restadmin->getManufacturer($this->request->get['id']);

                if($manufacturer) {
                    $post["manufacturers"] = array($this->request->get['id']);
                    $this->deleteManufacturer($post);
                } else {
                    $this->statusCode = 404;
                    $this->json['error'][] = "The specified manufacturer does not exist.";
                }
            } else {

                $post = $this->getPost();


                if (isset($post["manufacturers"])) {
                    $this->deleteManufacturer($post);
                } else {
                    $this->statusCode = 400;
                }
            }
        }

        return $this->sendResponse();
    }

    public function listManufacturer($request)
    {

        $this->load->language('restapi/manufacturer');
        $this->load->model('rest/restadmin');
        $this->load->model('tool/image');

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

        $manufacturers = array();

        $results = $this->model_rest_restadmin->getManufacturers($parameters);

        $imageUrlPrefix = $this->request->server['HTTPS'] ? HTTPS_SERVER : HTTP_SERVER;

        foreach ($results as $result) {

            if (isset($result['image']) && !empty($result['image'])&& file_exists(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], $this->config->get('module_rest_admin_api_thumb_width'), $this->config->get('module_rest_admin_api_thumb_height'));
                $original_image = $imageUrlPrefix . 'image/' . $result['image'];
            } else {
                $image = "";
                $original_image = "";
            }

            $manufacturers['manufacturers'][] = array(
                'manufacturer_id' => $result['manufacturer_id'],
                'name' => $result['name'],
                'sort_order' => $result['sort_order'],
                'image' => $image,
                'original_image' => $original_image,
            );
        }

        $this->json['data'] = !empty($manufacturers) ? $manufacturers['manufacturers'] :  array();
    }

    public function addManufacturer($post)
    {

        $this->load->language('restapi/manufacturer');
        $this->load->model('rest/restadmin');

        $error = $this->validateForm($post);

        if (!empty($post) && empty($error)) {

            $this->loadData($post);

            $retval = $this->model_rest_restadmin->addManufacturer($post);
            $this->json["data"]["id"] = $retval;
        } else {
            $this->json['error'] = $error;
            $this->statusCode = 400;
        }
    }


    protected function validateForm($post, $manufacturer_id = null)
    {

        $error = array();

        if (!isset($post['name']) || (utf8_strlen($post['name']) < 2) || (utf8_strlen($post['name']) > 64)) {
            $error[] = $this->language->get('error_name');
        }


        if (isset($post['manufacturer_seo_url'])) {

            foreach ($post['manufacturer_seo_url'] as &$keywordData) {

                if (!empty($keywordData["keyword"])) {
                    $seo_urls = $this->model_rest_restadmin->getSeoUrlsByKeyword($keywordData["keyword"]);

                    if(!isset($keywordData["store_id"]) || empty($keywordData["store_id"])){
                        $keywordData["store_id"] = 0;
                    }

                    if(!isset($keywordData["language_id"]) || empty($keywordData["language_id"])){
                        $keywordData["language_id"] = 1;
                    }

                    foreach ($seo_urls as $seo_url) {
                        if (($seo_url['store_id'] == $keywordData["store_id"]) && (!empty($manufacturer_id)
                                || ($seo_url['query'] != 'manufacturer_id=' . $manufacturer_id))) {
                            $error[] = $this->language->get('error_keyword');
                            break;
                        }
                    }
                }
            }
        }

        return $error;
    }

    private function loadData(&$data, $item = null)
    {
        foreach (self::$defaultFields as $field) {
            if (!isset($data[$field])) {
                if (!empty($item) && isset($item[$field])) {
                    $data[$field] = $item[$field];
                } else {
                    if (!isset(self::$defaultFieldValues[$field])) {
                        $data[$field] = "";
                    } else {
                        $data[$field] = self::$defaultFieldValues[$field];
                    }
                }
            }
        }
    }

    public function editManufacturer($id, $post)
    {

        $this->load->language('restapi/manufacturer');
        $this->load->model('rest/restadmin');

        $data = $this->model_rest_restadmin->getManufacturer($id);

        if($data){
            $this->loadData($post, $data);

            $error = $this->validateForm($post, $id);

            if (!empty($post) && empty($error)) {
                $this->model_rest_restadmin->editManufacturer($id, $post);
            } else {
                $this->json['error'] = $error;
                $this->statusCode = 400;
            }
        } else {
            $this->statusCode = 404;
            $this->json['error'][] = "The specified manufacturer does not exist.";
        }

    }

    public function deleteManufacturer($post)
    {

        $this->load->language('restapi/manufacturer');
        $this->load->model('rest/restadmin');

        $error = $this->validateDelete($post);

        if (isset($post['manufacturers']) && empty($error)) {
            foreach ($post['manufacturers'] as $manufacturer_id) {
                $this->model_rest_restadmin->deleteManufacturer($manufacturer_id);
            }
        } else {
            $this->json['error'] = $error;
            $this->statusCode = 400;
        }

    }

    protected function validateDelete($post)
    {

        $this->load->model('rest/restadmin');

        $error = array();

        foreach ($post['manufacturers'] as $manufacturer_id) {
            $product_total = $this->model_rest_restadmin->getTotalProductsByManufacturerId($manufacturer_id);

            if ($product_total) {
                $error[] = sprintf($this->language->get('error_product'), $product_total);
            }
        }

        return $error;
    }

    public function manufacturerimages()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //upload and save manufacturer image
            $this->saveManufacturerImage($this->request);
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        return $this->sendResponse();
    }

    public function saveManufacturerImage($request)
    {


        $this->load->model('catalog/manufacturer');
        $this->load->model('rest/restadmin');

        if (ctype_digit($request->get['id'])) {
            $manufacturer = $this->model_catalog_manufacturer->getManufacturer($request->get['id']);
            //check manufacturer exists
            if (!empty($manufacturer)) {
                if (isset($request->files['file'])) {
                    $uploadResult = $this->upload($request->files['file'], "manufacturers");
                    if (!isset($uploadResult['error'])) {
                        $this->model_rest_restadmin->setManufacturerImage($request->get['id'], $uploadResult['file_path']);
                    } else {
                        $this->json['error'] = $uploadResult['error'];
                        $this->statusCode = 400;
                    }
                } else {
                    $this->json['error'][] = "File is required!";
                    $this->statusCode = 400;
                }
            } else {
                $this->statusCode = 404;
                $this->json['error'][] = "The specified manufacturer does not exist.";
            }
        } else {
            $this->statusCode = 400;
        }

    }

    public function upload($uploadedFile, $subdirectory)
    {
        $this->language->load('product/product');

        $result = array();


        if (!empty($uploadedFile['name'])) {
            $filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($uploadedFile['name'], ENT_QUOTES, 'UTF-8')));

            if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
                $result['error'][] = $this->language->get('error_filename');
            }

            // Allowed file extension types
            $allowed = array(
                'jpg',
                'jpeg',
                'gif',
                'png'
            );

            if (!in_array(utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
                $result['error'][] = $this->language->get('error_filetype');
            }

            // Allowed file mime types
            $allowed = array(
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/x-png',
                'image/gif'
            );

            if (!in_array($uploadedFile['type'], $allowed)) {
                $result['error'][] = $this->language->get('error_filetype');
            }

            // Check to see if any PHP files are trying to be uploaded
            $content = file_get_contents($uploadedFile['tmp_name']);

            if (preg_match('/\<\?php/i', $content)) {
                $result['error'][] = $this->language->get('error_filetype');
            }

            if ($uploadedFile['error'] != UPLOAD_ERR_OK) {
                $result['error'][] = $this->language->get('error_upload_' . $uploadedFile['error']);
            }
        } else {
            $result['error'][] = $this->language->get('error_upload');
        }

        if (!$result && is_uploaded_file($uploadedFile['tmp_name']) && file_exists($uploadedFile['tmp_name'])) {
            $file = basename($filename) . '.' . md5(mt_rand());

            // Hide the uploaded file name so people can not link to it directly.
            $result['file'] = $this->encryption->encrypt($file);

            $result['file_path'] = "catalog/" . $subdirectory . "/" . $filename;
            if ($this->rmkdir(DIR_IMAGE . "catalog/" . $subdirectory)) {
                move_uploaded_file($uploadedFile['tmp_name'], DIR_IMAGE . $result['file_path']);
            } else {
                $result['error'][] = "Could not create directory or directory is not writeable: " . DIR_IMAGE . "catalog/" . $subdirectory;
            }

        }
        return $result;

    }

    function rmkdir($path, $mode = 0777)
    {

        if (!file_exists($path)) {
            $path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
            $e = explode("/", ltrim($path, "/"));
            if (substr($path, 0, 1) == "/") {
                $e[0] = "/" . $e[0];
            }
            $c = count($e);
            $cp = $e[0];
            for ($i = 1; $i < $c; $i++) {
                if (!is_dir($cp) && !@mkdir($cp, $mode)) {
                    return false;
                }
                $cp .= "/" . $e[$i];
            }
            return @mkdir($path, $mode);
        }

        if (is_writable($path)) {
            return true;
        } else {
            return false;
        }
    }
}