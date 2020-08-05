<?php

/**
 * admin_security.php
 *
 * Admin login
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestAdminSecurity extends RestAdminController
{

    private $error = array();

    /*
    * Login user
    */
    public function login()
    {

        $this->checkPluginSimple();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $input = file_get_contents('php://input');
            $post = json_decode($input, true);

            if ($this->user->isLogged()) {
                $this->json['error'][] = "User already is logged";
                $this->statusCode = 400;
            }

            if (empty($this->json['error'])) {
                if (!isset($post['username']) || !isset($post['password'])) {
                    $this->json['error'][] = 'Username and password required';
                    $this->statusCode = 401;
                } else {
                    if (!$this->user->login($post['username'], $post['password'])) {
                        $this->json['error'][] = 'Invalid username or password';
                        $this->statusCode = 401;
                    } else {
                        $this->load->model('rest/restadmin');
                        $user_info = $this->model_rest_restadmin->getUser($this->user->getId());

                        if($user_info){
                            unset($user_info['password']);
                            unset($user_info['salt']);
                            unset($user_info['code']);

                            $this->json['data'] = $user_info;
                        }
                    }
                }
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        return $this->sendResponse();
    }

    /*
    * Logout user
    */
    public function logout()
    {

        $this->checkPluginSimple();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($this->user->isLogged()) {
                $this->user->logout();
            } else {
                $this->json["error"][]    = "User is not logged.";
                $this->statusCode = 400;
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        return $this->sendResponse();
    }

    public function getToken()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /*check rest api is enabled*/
            if (!$this->config->get('module_rest_admin_api_status')) {
                $this->json["error"][] = 'Rest Admin API is disabled. Enable it!';
            } else {
                $this->opencartVersion = str_replace(".", "", VERSION);

                RestAdminController::$ocRegistry = $this->registry;
                RestAdminController::$ocVersion = $this->opencartVersion;

                $input = file_get_contents('php://input');
                $post = json_decode($input, true);

                $oldToken = isset($post['old_token']) ? $post['old_token'] : null;
                $oldTokenData = null;
                $this->load->model('rest/restadmin');

                if(!empty($oldToken)){
                    $oldTokenData = $this->model_rest_restadmin->loadOldAdminToken($oldToken);
                }

                $server = $this->getOauthServer();
                $token = $server->handleTokenRequest(OAuth2\Request::createFromGlobals())->getParameters();

                if(!empty($oldTokenData)){
                    $this->model_rest_restadmin->loadAdminSessionToNew($oldTokenData['data'], $token['access_token']);
                    $this->model_rest_restadmin->deleteOldAdminToken($oldToken);
                }

                if(isset($token['access_token'])) {
                    //clear token table
                    $this->clearAdminTokensTable($token['access_token'], session_id());

                    unset($token['scope']);

                    $token['expires_in'] = (int)$token['expires_in'];

                    $this->json['data'] = $token;
                } else {

                    if(isset($token['error_description'])){
                        $this->json["error"][]  = $token['error_description'];
                    } else {
                        $this->json["error"][]	= "Token problem. Invalid token.";
                    }

                    $this->statusCode = 400;
                }
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        return $this->sendResponse();
    }


    function clearAdminTokensTable($token = null, $sessionid = null)
    {
        //delete all previous token to this session and delete all expired session
        $this->load->model('rest/restadmin');
        $this->model_rest_restadmin->clearAdminTokens($token, $sessionid);
    }


    /*
    * forgotten password
    */
    public function forgotten() {

        $this->checkPluginSimple();

        $this->load->language('restapi/forgotten');

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){

            $post = $this->getPost();

            if ($this->user->isLogged()) {
                $this->json['error'][] = "User already is logged";
                $this->statusCode = 400;
            }

            if (!$this->config->get('config_password')) {
                $this->json['error'][]		= "Password reset is disabled";
                $this->statusCode = 400;
            }

            if ($this->json['success']) {

                $this->load->model('rest/restadmin');

                if ($this->validateForgotten($post)) {

                    $code = token(40);

                    $this->model_rest_restadmin->editCode($post['email'], $code);

                    $subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

                    $message = sprintf($this->language->get('text_greeting'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
                    $message .= $this->language->get('text_change') . "\n\n";
                    $message .= $this->url->link('common/reset', 'code=' . $code, true) . "\n\n";
                    $message .= sprintf($this->language->get('text_ip'), $this->request->server['REMOTE_ADDR']) . "\n\n";

                    $mail = new Mail();
                    $mail->protocol = $this->config->get('config_mail_protocol');
                    $mail->parameter = $this->config->get('config_mail_parameter');
                    $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                    $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                    $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                    $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                    $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

                    $mail->setTo($post['email']);
                    $mail->setFrom($this->config->get('config_email'));
                    $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
                    $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
                    $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                    $mail->send();
                } else {
                    $this->json["error"] = $this->error['error'];
                    $this->statusCode = 400;
                }
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        return $this->sendResponse();
    }

    /*
    * Reset password
    */
    public function reset() {

        $this->checkPluginSimple();

        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){

            $post = $this->getPost();

            if ($this->user->isLogged()) {
                $this->json['error'][]		= "User already is logged";
                $this->statusCode = 400;
            }

            if (!$this->config->get('config_password')) {
                $this->json['error'][]		= "Password reset is disabled";
                $this->statusCode = 400;
            }

            if ($this->json['success']) {

                $this->load->model('rest/restadmin');
                $this->load->language('restapi/reset');

                if (isset($post['code'])) {
                    $code = $post['code'];
                } else {
                    $code = '';
                }

                if ($this->validateReset($post)) {

                    $user_info = $this->model_rest_restadmin->getUserByCode($code);

                    if ($user_info) {
                        $this->model_rest_restadmin->editPassword($user_info['user_id'], $post['password']);
                        $this->json['error'][] = $this->language->get('text_success');
                        $this->statusCode = 400;
                    } else {
                        $this->json["error"][] = 'User not found by code';
                        $this->statusCode = 404;
                    }
                } else {
                    $this->json["error"] = $this->error['error'];
                    $this->statusCode = 400;
                }
            }
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        return $this->sendResponse();
    }

    protected function validateForgotten($post) {
        if (!isset($post['email'])) {
            $this->error['error'][] = $this->language->get('error_email');
        } elseif (!$this->model_rest_restadmin->getTotalUsersByEmail($post['email'])) {
            $this->error['error'][] = $this->language->get('error_email');
        }

        return !$this->error;
    }
    protected function validateReset($post) {

        if (!isset($post['password']) || (utf8_strlen($post['password']) < 4) || (utf8_strlen($post['password']) > 20)) {
            $this->error['error'][] = $this->language->get('error_password');
        }

        if ($post['confirm'] != $post['password']) {
            $this->error['error'][] = $this->language->get('error_confirm');
        }

        return !$this->error;
    }
}