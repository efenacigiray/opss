<?php
/**
 * category_admin.php
 *
 * Category management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestCategoryAdmin extends RestAdminController
{

    private static $defaultFields = array(
        "category_description",
        "path",
        "parent_id",
        "category_store",
        "category_seo_url",
        "top",
        "column",
        "sort_order",
        "status",
        "category_layout",
    );

    private static $defaultFieldValues = array(
        "category_description" => array(),
        "category_layout" => array(),
        "parent_id" => 0,
        "category_store" => array(0),
        "top" => 0,
        "column" => 1,
        "sort_order" => 0,
        "status" => 1,
    );

    public function category()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {


            //get category details
            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->getCategory($this->request->get['id']);
            } else {
                /*check parent parameter*/
                if (isset($this->request->get['parent'])) {
                    $parent = $this->request->get['parent'];
                } else {
                    $parent = 0;
                }

                /*check level parameter*/
                if (isset($this->request->get['level'])) {
                    $level = $this->request->get['level'];
                } else {
                    $level = 1;
                }

                $this->listCategories($parent, $level);
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $post = $this->getPost();
            $this->addCategory($post);

        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

            $post = $this->getPost();

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->editCategory($this->request->get['id'], $post);
            } else {
                $this->statusCode = 400;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->load->model('rest/restadmin');
                $category = $this->model_rest_restadmin->getCategory($this->request->get['id']);

                if($category) {
                    $post["categories"] = array($this->request->get['id']);
                    $this->deleteCategory($post);
                } else {
                    $this->json['error'][] = "Category not found";
                    $this->statusCode = 404;
                }
            } else {

                $post = $this->getPost();

                if (isset($post["categories"])) {
                    $this->deleteCategory($post);
                } else {
                    $this->statusCode = 400;
                }
            }
        }

        return $this->sendResponse();
    }

    public function getCategory($id)
    {

        $this->load->model('rest/restadmin');
        $this->load->model('tool/image');

        if (ctype_digit($id)) {
            $category_id = $id;
        } else {
            $category_id = 0;
        }

        $imageUrlPrefix = $this->request->server['HTTPS'] ? HTTPS_SERVER : HTTP_SERVER;

        $results = $this->model_rest_restadmin->getCategory($category_id);
        if (count($results)) {

            foreach ($results as $result) {
                if (isset($result['image']) && !empty($result['image'])&& file_exists(DIR_IMAGE . $result['image'])) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('module_rest_admin_api_thumb_width'), $this->config->get('module_rest_admin_api_thumb_height'));
                    $original_image = $imageUrlPrefix . 'image/' . $result['image'];
                } else {
                    $image = "";
                    $original_image = "";
                }

                $languageId = isset($result['language_id']) ? $result['language_id'] : (int)$this->config->get('config_language_id');
                if ($this->multilang) {
                    $this->json['data']['categories'][$result['category_id']][] = array(
                        'category_id' => $result['category_id'],
                        'name' => $result['name'],
                        'description' => $result['description'],
                        'sort_order' => $result['sort_order'],
                        'meta_title' => $result['meta_title'],
                        'meta_description' => $result['meta_description'],
                        'meta_keyword' => $result['meta_keyword'],
                        'language_id' => $languageId,
                        'status' => $result['status'],
                        'parent_id' => $result['parent_id'],
                        'column' => $result['column'],
                        'top' => $result['top'],
                        'image' => $image,
                        'original_image' => $original_image
                    );
                } else {
                    $this->json['data'][] = array(
                        'category_id' => $result['category_id'],
                        'name' => $result['name'],
                        'description' => $result['description'],
                        'sort_order' => $result['sort_order'],
                        'meta_title' => $result['meta_title'],
                        'meta_description' => $result['meta_description'],
                        'meta_keyword' => $result['meta_keyword'],
                        'language_id' => $languageId,
                        'status' => $result['status'],
                        'parent_id' => $result['parent_id'],
                        'column' => $result['column'],
                        'top' => $result['top'],
                        'image' => $image,
                        'original_image' => $original_image
                    );
                }

            }
        } else {
            $this->json['error'][] = "Category not found";
            $this->statusCode = 404;

        }
    }

    public function listCategories($parent, $level)
    {

        $data = $this->loadCatTree($parent, $level);

        $this->json['data'] = !empty($data) ? $data['categories'] : array();
    }


    public function loadCatTree($parent = 0, $level = 1)
    {

        $this->load->model('rest/restadmin');
        $this->load->model('tool/image');

        $result['categories'] = array();

        $categories = $this->model_rest_restadmin->getCategories($parent);

        $imageUrlPrefix = $this->request->server['HTTPS'] ? HTTPS_SERVER : HTTP_SERVER;

        if ($categories && $level > 0) {
            $level--;

            foreach ($categories as $category) {
                if (isset($category['image']) && !empty($category['image'])&& file_exists(DIR_IMAGE . $category['image'])) {
                    $image = $this->model_tool_image->resize($category['image'], $this->config->get('module_rest_admin_api_thumb_width'), $this->config->get('module_rest_admin_api_thumb_height'));
                    $original_image = $imageUrlPrefix . 'image/' . $category['image'];
                } else {
                    $image = "";
                    $original_image = "";
                }

                $languageId = isset($category['language_id']) ? $category['language_id'] : (int)$this->config->get('config_language_id');

                $sub = $this->loadCatTree($category['category_id'], $level);
                if ($this->multilang) {
                    $result['categories'][$category['category_id']][] = array(
                        'category_id' => $category['category_id'],
                        'name' => $category['name'],
                        'description' => $category['description'],
                        'sort_order' => $category['sort_order'],
                        'meta_title' => $category['meta_title'],
                        'meta_description' => $category['meta_description'],
                        'meta_keyword' => $category['meta_keyword'],
                        'language_id' => $languageId,
                        'image' => $image,
                        'original_image' => $original_image,
                        'categories' => empty($sub) ? array() : $sub['categories']
                    );
                } else {
                    $result['categories'][] = array(
                        'category_id' => $category['category_id'],
                        'name' => $category['name'],
                        'description' => $category['description'],
                        'sort_order' => $category['sort_order'],
                        'meta_title' => $category['meta_title'],
                        'meta_description' => $category['meta_description'],
                        'meta_keyword' => $category['meta_keyword'],
                        'language_id' => $languageId,
                        'image' => $image,
                        'original_image' => $original_image,
                        'categories' => empty($sub) ? array() : $sub['categories']
                    );
                }

            }

            return $result;
        }
    }

    public function addCategory($post)
    {

        $this->load->language('restapi/category');
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
            $category_id = $this->model_rest_restadmin->addCategory($post);

            $this->json["data"]["id"] = $category_id;
        } else {
            $this->json['error'] = $error;
            $this->statusCode = 400;
        }

        $this->sendResponse();
    }

    protected function validateForm(&$post, $category_id = null)
    {

        $error = array();

        if (isset($post['category_description'])) {
            foreach ($post['category_description'] as &$category_description) {


                if(empty($category_id) && !isset($category_description['language_id'])){
                    $category_description['language_id'] = 1;
                }

                if(!empty($category_id) && !isset($category_description['language_id'])){
                    $error[] = 'Language ID is required';
                }

                if (!empty($category_id) && isset($category_description['name'])) {
                    if ((utf8_strlen($category_description['name']) < 2) || (utf8_strlen($category_description['name']) > 255)) {
                        //$error['name'][$category_description['language_id']] = $this->language->get('error_name');
                        $error[] = $this->language->get('error_name');
                    }
                }

                if ((empty($category_id) && !isset($category_description['name']))
                    || (utf8_strlen($category_description['name']) < 2) || (utf8_strlen($category_description['name']) > 255)
                ) {
                    //$error['name'][$category_description['language_id']] = $this->language->get('error_name');
                    $error[] = $this->language->get('error_name');
                }

                if (!empty($category_id) && isset($category_description['meta_title'])) {
                    if ((utf8_strlen($category_description['meta_title']) < 3) || (utf8_strlen($category_description['meta_title']) > 255)) {
                        //$error['meta_title'][$category_description['language_id']] = $this->language->get('error_meta_title');
                        $error[] = $this->language->get('error_meta_title');
                    }
                }

                if ((empty($category_id) && !isset($category_description['meta_title']))
                    || (utf8_strlen($category_description['meta_title']) < 3) || (utf8_strlen($category_description['meta_title']) > 255)
                ) {
                    //$error['meta_title'][$category_description['language_id']] = $this->language->get('error_meta_title');
                    $error[] = $this->language->get('error_meta_title');
                }
            }

            if(empty($category_id)){

                if(!isset($category_description['meta_description'])){
                    $category_description['meta_description'] = "";
                }

                if(!isset($category_description['meta_keyword'])){
                    $category_description['meta_keyword'] = "";
                }
            }
        } else {
            if(empty($category_id)){
                $error[] = "Category description is required";
            }
        }

        if (isset($post['category_seo_url'])) {

            foreach ($post['category_seo_url'] as &$keywordData) {

                if (!empty($keywordData["keyword"])) {
                    $seo_urls = $this->model_rest_restadmin->getSeoUrlsByKeyword($keywordData["keyword"]);

                    if(!isset($keywordData["store_id"]) || empty($keywordData["store_id"])){
                        $keywordData["store_id"] = 0;
                    }

                    if(!isset($keywordData["language_id"]) || empty($keywordData["language_id"])){
                        $keywordData["language_id"] = 1;
                    }

                    foreach ($seo_urls as $seo_url) {
                        if (($seo_url['store_id'] == $keywordData["store_id"]) && (!empty($category_id)
                                || ($seo_url['query'] != 'category_id=' . $category_id))) {
                            $error[] = $this->language->get('error_keyword');
                            break;
                        }
                    }
                }
            }
        }

        return $error;
    }

    public function editCategory($id, $post)
    {

        $this->load->language('restapi/category');
        $this->load->model('rest/restadmin');

        $results = $this->model_rest_restadmin->getCategory($id);

        if (count($results)) {
            $error = $this->validateForm($post, $id);

            if (empty($error)) {
                $this->model_rest_restadmin->editCategory($id, $post);
            } else {
                $this->json['error'] = $error;
                $this->statusCode = 400;
            }
        } else {
            $this->json['error'][] = "Category not found";
            $this->statusCode = 404;
        }

    }

    public function deleteCategory($post)
    {

        $this->load->language('restapi/category');
        $this->load->model('rest/restadmin');

        if (isset($post['categories'])) {
            foreach ($post['categories'] as $category_id) {
                $this->model_rest_restadmin->deleteCategory($category_id);
            }
        } else {
            $this->json['error'][] = "Category not found";
            $this->statusCode = 404;
        }
    }


    public function categoryimages()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveCategoryImage($this->request);
        } else {
            $this->allowedHeaders = array("POST");
            $this->statusCode = 405;
        }

        return $this->sendResponse();
    }


    public function saveCategoryImage($request)
    {

        $this->load->model('catalog/category');
        $this->load->model('rest/restadmin');

        if (ctype_digit($request->get['id'])) {
            $category = $this->model_rest_restadmin->getCategory($request->get['id']);

            //check category exists
            if (!empty($category)) {
                if (isset($request->files['file'])) {
                    $uploadResult = $this->upload($request->files['file'], "categories");
                    if (!isset($uploadResult['error'])) {
                        $this->model_rest_restadmin->setCategoryImage($request->get['id'], $uploadResult['file_path']);
                    } else {
                        $this->json['error'] = $uploadResult['error'];
                        $this->statusCode = 400;
                    }
                } else {
                    $this->json['error'][] = "File is required!";
                    $this->statusCode = 400;
                }
            } else {
                $this->json['error'][] = "Category not found";
                $this->statusCode = 404;
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


    //Image upload

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