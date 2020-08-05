<?php
/**
 * option_admin.php
 *
 * Option management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestOptionAdmin extends RestAdminController
{

    public function optionimages()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //upload and save image
            $this->saveOptionImage($this->request);
        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

            $post = $this->getPost();

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])
                && !empty($post) && isset($post["image"])
            ) {
                $this->updateOptionValueImage($this->request->get['id'], $post);
            } else {
                $this->statusCode = 400;
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST", "PUT");
        }

        return $this->sendResponse();
    }


    public function saveOptionImage($request)
    {

        $this->load->model('rest/restadmin');

        if (ctype_digit($request->get['id'])) {
            $option = $this->model_rest_restadmin->getOptionValue($request->get['id']);
            if (!empty($option)) {
                if (isset($request->files['file'])) {
                    $uploadResult = $this->upload($request->files['file'], "product_options");
                    if (!isset($uploadResult['error'])) {
                        $this->model_rest_restadmin->setOptionImage($request->get['id'], $uploadResult['file_path']);
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
                $this->json['error'][] = "The specified option value does not exist.";
            }
        } else {
            $this->json['error'][] = "Invalid id.";
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


    public function updateOptionValueImage($id, $request)
    {

        $this->load->model('rest/restadmin');

        $option = $this->model_rest_restadmin->getOptionValue($id);

        if (!empty($option)) {
            $this->model_rest_restadmin->setOptionImage($id, $request['image']);
        } else {
            $this->statusCode = 404;
            $this->json['error'][] = "The specified option value does not exist.";
        }

    }


    public function option()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //get option details
            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->getOption($this->request->get['id']);
            } else {
                $this->listOption($this->request);
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->getPost();
            $this->addOption($post);

        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

            $post = $this->getPost();

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->editOption($this->request->get['id'], $post);
            } else {
                $this->json['error'][] = "Invalid id";
                $this->statusCode = 400;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->load->model('rest/restadmin');
                $option = $this->model_rest_restadmin->getOption($this->request->get['id']);
                if(!empty($option)) {
                    $post["options"] = array($this->request->get['id']);
                    $this->deleteOption($post);
                } else {
                    $this->json['error'][] = "Option not found";
                    $this->statusCode = 404;
                }
            } else {

                $post = $this->getPost();

                if (!empty($post) && isset($post["options"])) {
                    $this->deleteOption($post);
                } else {
                    $this->statusCode = 400;
                }
            }
        }

        return $this->sendResponse();
    }

    public function getOption($id)
    {

        $this->load->model('rest/restadmin');

        $result = $this->model_rest_restadmin->getOption($id);

        if ($result) {
            $this->json["data"] = $this->getOptionInfo($result);
        } else {
            $this->json['error'][] = "The specified option does not exist.";
            $this->statusCode = 404;

        }

    }

    private function getOptionInfo($result)
    {
        $info = array(
            'option_id' => $result['option_id'],
            'name' => $result['name'],
            'sort_order' => $result['sort_order'],
        );

        $option_values = $this->model_rest_restadmin->getOptionValueDescriptions($result['option_id']);

        $this->load->model('tool/image');

        $info['option_values'] = array();

        foreach ($option_values as $option_value) {
            if (is_file(DIR_IMAGE . $option_value['image'])) {
                $image = $option_value['image'];
                $thumb = $option_value['image'];
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }

            $info['option_values'][] = array(
                'option_value_id' => $option_value['option_value_id'],
                'option_value_description' => $option_value['option_value_description'],
                'image' => $image,
                'thumb' => $this->model_tool_image->resize($thumb, $this->config->get('module_rest_admin_api_thumb_width'), $this->config->get('module_rest_admin_api_thumb_height')),
                'sort_order' => $option_value['sort_order']
            );
        }

        return $info;
    }

    public function listOption($request)
    {

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

        $options = array();

        $results = $this->model_rest_restadmin->getOptions($parameters);

        foreach ($results as $result) {
            $options['options'][] = $this->getOptionInfo($result);
        }

        $this->json['data'] = !empty($options) ? $options['options'] : array();

    }

    public function addOption($post)
    {

        $this->load->model('rest/restadmin');

        $error = $this->validateForm($post);

        if (!empty($post) && empty($error)) {

            if(!isset($post['sort_order'])){
                $post['sort_order'] = "";
            }

            $retval = $this->model_rest_restadmin->addOption($post);
            if ($retval) {
                $result = $this->model_rest_restadmin->getOption($retval);

                if ($result) {
                    $this->json["data"] = $this->getOptionInfo($result);
                }
            } else {
                $this->json['error'][] = 'Create option failed.';
                $this->statusCode = 400;
            }

        } else {
            $this->json['error'] = $error;
            $this->statusCode = 400;
        }

    }


    protected function validateForm(&$post)
    {

        $error = array();
        $this->load->language('restapi/option');

        if(isset($post['option_description'])){
            foreach ($post['option_description'] as $option_description) {
                if(!isset($option_description["language_id"])){
                    $option_description["language_id"] = 1;
                }
                if (!isset($option_description['name']) || (utf8_strlen($option_description['name']) < 1) || (utf8_strlen($option_description['name']) > 128)) {
                    //$error['name'][$option_description['language_id']] = $this->language->get('error_name');
                    $error[] = $this->language->get('error_name');
                }
            }
        } else {
            $error['option_description'][1] = "Option description is required";
        }

        if (!isset($post['type']) || ($post['type'] != 'select' && $post['type'] != 'radio' && $post['type'] != 'checkbox')) {
            $error[] = $this->language->get('error_type');
        }

        if (isset($post['option_value'])) {
            foreach ($post['option_value'] as $option_value_id => &$option_value) {
                foreach ($option_value['option_value_description'] as &$option_value_description) {
                    if (!isset($option_value_description["language_id"])) {
                        $option_value_description["language_id"] = 1;
                    }
                    if (!isset($option_value_description['name']) || (utf8_strlen($option_value_description['name']) < 1) || (utf8_strlen($option_value_description['name']) > 128)) {
                        //$error['option_value'][$option_value_id][$option_value_description["language_id"]] = $this->language->get('error_option_value');
                        $error[] = $this->language->get('error_option_value');
                    }
                }
            }
        } else {
            //$error['option_value'][1] = "Option value is required";
            $error[] = "Option value is required";
        }

        return $error;
    }

    public function editOption($id, $post)
    {

        $this->load->model('rest/restadmin');
        $option = $this->model_rest_restadmin->getOption($id);

        if($option) {
            $error = $this->validateForm($post);

            if (!empty($post) && empty($error)) {
                $this->model_rest_restadmin->editOption($id, $post);
            } else {
                $this->json['error'] = $error;
                $this->statusCode = 400;
            }
        } else {
            $this->json['error'][] = "Option not found";
            $this->statusCode = 404;
        }
    }

    public function deleteOption($post)
    {

        $this->load->model('rest/restadmin');

        $error = $this->validateDelete($post);

        if (isset($post['options']) && empty($error)) {
            foreach ($post['options'] as $option_id) {
                $this->model_rest_restadmin->deleteOption($option_id);
            }
        } else {
            $this->json['error'] = $error;
            $this->statusCode = 400;
        }

    }

    protected function validateDelete($post)
    {

        $this->load->model('rest/restadmin');
        $this->load->language('restapi/option');

        $error = array();

        foreach ($post['options'] as $option_id) {
            $product_total = $this->model_rest_restadmin->getTotalProductsByOptionId($option_id);

            if ($product_total) {
                $error[] = sprintf($this->language->get('error_product'), $product_total);
            }
        }

        return $error;
    }
}