<?php
/**
 * voucher_admin.php
 *
 * Voucher management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestVoucherAdmin extends RestAdminController
{

    public function vouchers()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->listVouchers($this->request);

        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->getPost();

            $this->addVoucher($post);

        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $post = $this->getPost();

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
                $this->editVoucher($this->request->get['id'], $post);
            } else {
                $this->statusCode = 400;
            }

        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

            if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {

                $this->load->model('rest/restadmin');

                $voucher = $this->model_rest_restadmin->getVoucher($this->request->get['id']);

                if($voucher) {
                    $post["vouchers"] = array($this->request->get['id']);
                    $this->deleteVoucher($post);
                } else {
                    $this->json['error'][] = "Voucher not found";
                    $this->statusCode = 404;
                }
            } else {

                $post = $this->getPost();

                if (isset($post["vouchers"])) {
                    $this->deleteVoucher($post);
                } else {
                    $this->statusCode = 400;
                }
            }
        }

        return $this->sendResponse();
    }

    public function listVouchers($request)
    {


        $this->load->language('restapi/voucher');
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

        $vouchers = array();

        $results = $this->model_rest_restadmin->getVouchers($parameters);

        foreach ($results as $result) {
            $vouchers[] = array(
                'voucher_id' => $result['voucher_id'],
                'code' => $result['code'],
                'from' => $result['from_name'],
                'to' => $result['to_name'],
                'theme' => $result['theme'],
                'amount' => $this->currency->format($result['amount'], $this->config->get('config_currency')),
                'status' => $result['status'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
            );
        }

        $this->json['data'] = !empty($vouchers) ? $vouchers : array();
    }

    public function addVoucher($post)
    {

        $this->load->language('restapi/voucher');
        $this->load->model('rest/restadmin');

        $error = $this->validateForm($post);

        if (!empty($post) && empty($error)) {

            if(!isset($post['voucher_theme_id']) || empty($post['voucher_theme_id'])) {
                $post['voucher_theme_id'] = 7; //Birthday
            }

            if(!isset($post['status'])) {
                $post['status'] = 1; //Enabled
            }

            if(!isset($post['message'])) {
                $post['message'] = "";
            }

            $retval = $this->model_rest_restadmin->addVoucher($post);
            $this->json["data"]["id"] = $retval;
        } else {
            $this->json['error'] = $error;
            $this->statusCode = 400;
        }

    }

    protected function validateForm($post, $voucher_id = null)
    {
        $this->load->model('rest/restadmin');
        $error = array();

        if(empty($voucher_id)) {

            if (!isset($post['code']) || (utf8_strlen($post['code']) < 3) || (utf8_strlen($post['code']) > 10)) {
                $error[] = $this->language->get('error_code');
            } else {

                $voucher_info = $this->model_rest_restadmin->getVoucherByCode($post['code']);

                if ($voucher_info) {
                    if (empty($voucher_id)) {
                        $error[] = $this->language->get('error_exists');
                    } elseif ($voucher_info['voucher_id'] != $voucher_id) {
                        $error[] = $this->language->get('error_exists');
                    }
                }
            }

            if (!isset($post['to_name']) || (utf8_strlen($post['to_name']) < 1) || (utf8_strlen($post['to_name']) > 64)) {
                $error[] = $this->language->get('error_to_name');
            }

            if (!isset($post['to_email']) || (utf8_strlen($post['to_email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $post['to_email'])) {
                $error[] = $this->language->get('error_email');
            }

            if (!isset($post['from_name']) || (utf8_strlen($post['from_name']) < 1) || (utf8_strlen($post['from_name']) > 64)) {
                $error[] = $this->language->get('error_from_name');
            }

            if (!isset($post['from_email']) || (utf8_strlen($post['from_email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $post['from_email'])) {
                $error[] = $this->language->get('error_email');
            }

            if (!isset($post['amount']) || $post['amount'] < 1) {
                $error[] = $this->language->get('error_amount');
            }
        } else {

            if (isset($post['code']) && !empty($post['code'])) {
                if((utf8_strlen($post['code']) < 3) || (utf8_strlen($post['code']) > 10)){
                    $error[] = $this->language->get('error_code');
                }
                $voucher_info = $this->model_rest_restadmin->getVoucherByCode($post['code']);

                if ($voucher_info) {
                    if (empty($voucher_id)) {
                        $error[] = $this->language->get('error_exists');
                    } elseif ($voucher_info['voucher_id'] != $voucher_id) {
                        $error[] = $this->language->get('error_exists');
                    }
                }
            }
            if (isset($post['to_name'])){
                if ((utf8_strlen($post['to_name']) < 1) || (utf8_strlen($post['to_name']) > 64)) {
                    $error[] = $this->language->get('error_to_name');
                }
            }

            if (isset($post['to_email'])){
                if ((utf8_strlen($post['to_email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $post['to_email'])) {
                    $error[] = $this->language->get('error_email');
                }
            }

            if (isset($post['from_name'])){
                if ((utf8_strlen($post['from_name']) < 1) || (utf8_strlen($post['from_name']) > 64)) {
                    $error[] = $this->language->get('error_from_name');
                }
            }

            if (isset($post['from_email'])){
                if ((utf8_strlen($post['from_email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $post['from_email'])) {
                    $error[] = $this->language->get('error_email');
                }
            }

            if (isset($post['amount'])){
                if ($post['amount'] < 1) {
                    $error[] = $this->language->get('error_amount');
                }
            }

        }

        return $error;
    }

    public function editVoucher($id, $post)
    {

        $this->load->language('restapi/voucher');
        $this->load->model('rest/restadmin');

        $data = $this->model_rest_restadmin->getVoucher($id);

        if($data){
            $error = $this->validateForm($post, $id);

            if (!empty($post) && empty($error)) {
                $post = array_merge($data, $post);
                $this->model_rest_restadmin->editVoucher($id, $post);
            } else {
                $this->json['error'] = $error;
                $this->statusCode = 400;
            }
        } else {
            $this->json['error'][] = "Voucher not found";
            $this->statusCode = 404;
        }
    }

    public function deleteVoucher($post)
    {

        $this->load->language('restapi/voucher');
        $this->load->model('rest/restadmin');

        if (isset($post['vouchers'])) {
            foreach ($post['vouchers'] as $voucher_id) {
                $this->model_rest_restadmin->deleteVoucher($voucher_id);
            }
        } else {
            $this->json['error'][] = "Error";
            $this->statusCode = 400;
        }

    }

    public function voucherthemes()
    {

        $this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->listVoucherThemes();
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }


    public function listVoucherThemes()
    {
        $this->load->model('rest/restadmin');

        $this->json['data'] = $this->model_rest_restadmin->getVoucherThemes();
    }
}