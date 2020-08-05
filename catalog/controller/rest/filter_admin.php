<?php
/**
 * filter_admin.php
 *
 * Product filter management
 *
 * @author          Opencart-api.com
 * @copyright       2017
 * @license         License.txt
 * @version         2.0
 * @link            https://opencart-api.com/product/opencart-rest-admin-api/
 * @documentations  https://opencart-api.com/opencart-rest-api-documentations/
 */
require_once(DIR_SYSTEM . 'engine/restadmincontroller.php');

class ControllerRestFilterAdmin extends RestAdminController {

    public function filters() {

        $this->checkPlugin();

        if ( $_SERVER['REQUEST_METHOD'] === 'GET' ) {

            $this->load->model('rest/restadmin');

            $parameters = array(
                "limit" => $this->config->get('config_limit_admin'),
                "start" => 1,
            );

            /*check limit parameter*/
            if (isset($this->request->get['limit']) && ctype_digit($this->request->get['limit'])) {
                $parameters["limit"] = $this->request->get['limit'];
            }

            /*check page parameter*/
            if (isset($this->request->get['page']) && ctype_digit($this->request->get['page'])) {
                $parameters["start"] = $this->request->get['page'];
            }

            if (isset($this->request->get['filter_group']) && ctype_digit($this->request->get['filter_group'])) {
                $parameters["filter_group"] = $this->request->get['filter_group'];
            }

            $parameters["start"] = ($parameters["start"] - 1) * $parameters["limit"];

            $data = $this->model_rest_restadmin->getFilters($parameters);

            $this->json['data'] = !empty($data) ? $data : array();

        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }

    public function groups() {

        $this->checkPlugin();

        if ( $_SERVER['REQUEST_METHOD'] === 'GET' ){

            $this->load->model('rest/restadmin');

            $parameters = array(
                "limit" => $this->config->get('config_limit_admin'),
                "start" => 1,
                "sort" => 'fgd.name',
                "order" => 'ASC',
            );

            if (isset($this->request->get['sort'])) {
                $parameters["sort"] = $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $parameters["order"] = $this->request->get['order'];
            }

            /*check limit parameter*/
            if (isset($this->request->get['limit']) && ctype_digit($this->request->get['limit'])) {
                $parameters["limit"] = $this->request->get['limit'];
            }

            /*check page parameter*/
            if (isset($this->request->get['page']) && ctype_digit($this->request->get['page'])) {
                $parameters["start"] = $this->request->get['page'];
            }

            $parameters["start"] = ($parameters["start"] - 1) * $parameters["limit"];

            $results = $this->model_rest_restadmin->getFilterGroups($parameters);


            foreach ($results as $result) {
                $this->json['data'][] = array(
                    'filter_group_id' => $result['filter_group_id'],
                    'name'            => $result['name'],
                    'sort_order'      => $result['sort_order']
                );
            }

        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();

    }
}