<?php
/**
 * option_value_admin.php
 *
 * Option value management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestOptionValueAdmin extends RestAdminController
{

    private static $defaultFields = array(
        "option_value_description",
        "sort_order",
        "image",
    );

    private static $defaultFieldValues = array(
        "option_value_description" => array()
    );

    public function optionvalue()
    {

        $this->checkPlugin();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {

                $post = $this->getPost();

                $this->addOptionValue($this->request->get['id'], $post);

            } else {
                $this->statusCode = 400;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {

                $post = $this->getPost();

                $this->editOptionValue($this->request->get['id'], $post);

            } else {
                $this->statusCode = 400;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $post["option_values"] = array($this->request->get['id']);

                $this->load->model('rest/restadmin');

                if (!$this->model_rest_restadmin->isOptionValueExist($this->request->get['id'])) {
                    $this->json['error'][] = 'Option value with id: ' . $this->request->get['id'] . ' does not exist.';
                    $this->statusCode = 404;
                } else {
                    $this->deleteOptionValue($post);
                }

            } else {

                $post = $this->getPost();

                if (!empty($post) && isset($post["option_values"])) {
                    $this->deleteOptionValue($post);
                } else {
                    $this->statusCode = 400;
                }
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST", "PUT", "DELETE");
        }

        return $this->sendResponse();
    }


    public function addOptionValue($option_id, $post)
    {

        $this->load->model('rest/restadmin');

        if (!$this->model_rest_restadmin->isOptionExist($option_id)) {
            $this->statusCode = 404;
            $this->json['error'][] = 'Option with id: ' . $option_id . ' does not exist.';
        } else {
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

                $optionError = array();

                foreach ($post['option_value_description'] as $option_value_description) {
                    if ($this->model_rest_restadmin->isOptionValueNameExist($option_id, $option_value_description['name'], $option_value_description['language_id'])) {
                        $optionError[] = $option_value_description['name'];
                    }
                }

                if (empty($optionError)) {
                    $retval = $this->model_rest_restadmin->addOptionValue($option_id, $post);
                    $this->json["data"] = $retval;
                } else {
                    $this->json['error'][] = 'Error.Invalid option value name(s): ' . implode(',', $optionError);
                    $this->statusCode = 400;
                }

            } else {
                if (!empty($error)) {
                    $this->json['error'] = $error;
                } else {
                    $this->json['error'][] = 'Empty request.';
                }
                $this->statusCode = 400;
            }
        }

    }

    protected function validateForm(&$post, $id=null)
    {

        $error = array();

        if(isset($post['option_value_description'])) {
            foreach ($post['option_value_description'] as $option_value_description) {

                if(!isset($option_description["language_id"])){
                    $option_description["language_id"] = 1;
                }

                if (!isset($option_value_description['name']) || (utf8_strlen($option_value_description['name']) < 1) || (utf8_strlen($option_value_description['name']) > 128)) {
                    //$error['name'][$option_value_description['language_id']] = 'Option value Name must be between 1 and 128 characters!';
                    $error[] = 'Option value Name must be between 1 and 128 characters!';
                }
            }
        }

        if(empty($id) && (!isset($post['option_value_description']) || empty($post['option_value_description']))){
            //$error['name'][$option_value_description['language_id']] = 'Option value Name must be between 1 and 128 characters!';
            $error[] = 'Option value Name must be between 1 and 128 characters!';
        }

        return $error;
    }

    public function editOptionValue($id, $post)
    {

        $this->load->model('rest/restadmin');

        if (!$this->model_rest_restadmin->isOptionValueExist($id)) {
            $this->json['error'][] = 'Option value with id: ' . $id . ' does not exist.';
            $this->statusCode = 404;
        } else {
            $error = $this->validateForm($post, $id);

            if (!empty($post) && empty($error)) {
                $this->model_rest_restadmin->editOptionValue($id, $post);
            } else {
                if (!empty($error)) {
                    $this->json['error'] = $error;
                } else {
                    $this->json['error'][] = 'Empty request.';
                }
                $this->statusCode = 400;
            }
        }

    }

    public function deleteOptionValue($post)
    {

        $this->load->model('rest/restadmin');

        if (isset($post['option_values'])) {
            foreach ($post['option_values'] as $option_value_id) {
                $this->model_rest_restadmin->deleteOptionValue($option_value_id);
            }
        } else {
            $this->json['error'][] = "Empty request.";
            $this->statusCode = 400;
        }
    }
}