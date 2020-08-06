<?php
include(DIR_STORAGE . 'vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class ControllerToolBackup extends Controller {
    public function index() {
        $this->load->language('tool/backup');

        $this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('tool/backup', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['user_token'] = $this->session->data['user_token'];

        $data['export'] = $this->url->link('tool/backup/export', 'user_token=' . $this->session->data['user_token'], true);

        $this->load->model('tool/backup');

        $data['tables'] = $this->model_tool_backup->getTables();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('tool/backup', $data));
    }

    public function import() {
        $this->load->language('tool/backup');

        $json = array();

        if (!$this->user->hasPermission('modify', 'tool/backup')) {
            $json['error'] = $this->language->get('error_permission');
        }

        if (isset($this->request->files['import']['tmp_name']) && is_uploaded_file($this->request->files['import']['tmp_name'])) {
            $filename = tempnam(DIR_UPLOAD, 'bac');

            move_uploaded_file($this->request->files['import']['tmp_name'], $filename);
        } elseif (isset($this->request->get['import'])) {
            $filename = html_entity_decode($this->request->get['import'], ENT_QUOTES, 'UTF-8');
        } else {
            $filename = '';
        }

        if (!is_file($filename)) {
            $json['error'] = $this->language->get('error_file');
        }

        if (isset($this->request->get['position'])) {
            $position = $this->request->get['position'];
        } else {
            $position = 0;
        }

        if (!$json) {
            // We set $i so we can batch execute the queries rather than do them all at once.
            $i = 0;
            $start = false;

            $handle = fopen($filename, 'r');

            fseek($handle, $position, SEEK_SET);

            while (!feof($handle) && ($i < 100)) {
                $position = ftell($handle);

                $line = fgets($handle, 1000000);

                if (substr($line, 0, 14) == 'TRUNCATE TABLE' || substr($line, 0, 11) == 'INSERT INTO') {
                    $sql = '';

                    $start = true;
                }

                if ($i > 0 && (substr($line, 0, 24) == 'TRUNCATE TABLE `oc_user`' || substr($line, 0, 30) == 'TRUNCATE TABLE `oc_user_group`')) {
                    fseek($handle, $position, SEEK_SET);

                    break;
                }

                if ($start) {
                    $sql .= $line;
                }

                if ($start && substr($line, -2) == ";\n") {
                    $this->db->query(substr($sql, 0, strlen($sql) -2));

                    $start = false;
                }

                $i++;
            }

            $position = ftell($handle);

            $size = filesize($filename);

            $json['total'] = round(($position / $size) * 100);

            if ($position && !feof($handle)) {
                $json['next'] = str_replace('&amp;', '&', $this->url->link('tool/backup/import', 'user_token=' . $this->session->data['user_token'] . '&import=' . $filename . '&position=' . $position, true));

                fclose($handle);
            } else {
                fclose($handle);

                unlink($filename);

                $json['success'] = $this->language->get('text_success');

                $this->cache->delete('*');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function export() {
        $this->load->language('tool/backup');

        if (!isset($this->request->post['backup'])) {
            $this->session->data['error'] = $this->language->get('error_export');

            $this->response->redirect($this->url->link('tool/backup', 'user_token=' . $this->session->data['user_token'], true));
        } elseif (!$this->user->hasPermission('modify', 'tool/backup')) {
            $this->session->data['error'] = $this->language->get('error_permission');

            $this->response->redirect($this->url->link('tool/backup', 'user_token=' . $this->session->data['user_token'], true));
        } else {
            $this->response->addheader('Pragma: public');
            $this->response->addheader('Expires: 0');
            $this->response->addheader('Content-Description: File Transfer');
            $this->response->addheader('Content-Type: application/octet-stream');
            $this->response->addheader('Content-Disposition: attachment; filename="' . DB_DATABASE . '_' . date('Y-m-d_H-i-s', time()) . '_backup.sql"');
            $this->response->addheader('Content-Transfer-Encoding: binary');

            $this->load->model('tool/backup');

            $this->response->setOutput($this->model_tool_backup->backup($this->request->post['backup']));
        }
    }

    public function import_product() {
        $this->load->language('tool/backup');
        $this->load->model('tool/backup');
        $this->load->model('catalog/product');
        $this->load->model('localisation/language');

        $json = array();

        if (!$this->user->hasPermission('modify', 'tool/backup')) {
            $json['error'] = $this->language->get('error_permission');
        }

        if (isset($this->request->files['import']['tmp_name']) && is_uploaded_file($this->request->files['import']['tmp_name'])) {
            $filename = tempnam(DIR_UPLOAD, 'excel');
            move_uploaded_file($this->request->files['import']['tmp_name'], $filename);
        } elseif (isset($this->request->get['import'])) {
            $filename = html_entity_decode($this->request->get['import'], ENT_QUOTES, 'UTF-8');
        } else {
            $filename = '';
        }

        if (isset($this->request->get['position'])) {
            $row = $this->request->get['position'];
        } else {
            $row = 1;
        }

        if (!$json) {
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filename);
            $sheet_data = $spreadsheet->getActiveSheet()->toArray();
            $total = count($sheet_data);
            $i = 0;

            while($row <= $total && $i < 20) {
                if (!isset($sheet_data[$row])) {
                    break;
                }

                if (!$data = $this->setProductData($sheet_data[$row], $this->model_tool_backup)) {
                    $i++;
                    $row++;
                    continue;
                }

                $this->model_catalog_product->addProduct($data);
                $i++;
                $row++;
            }
        }

        $json['total'] = round(($total / $row) * 20);

        if ($row < $total) {
            $json['next'] = str_replace('&amp;', '&', $this->url->link('tool/backup/import_product', 'user_token=' . $this->session->data['user_token'] . '&import=' . $filename . '&position=' . $row, true));
        } else {
            unlink($filename);
            $json['success'] = $this->language->get('text_success');
            $this->cache->delete('*');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    private function setProductData($row, $model) {
        $dir_image = DIR_IMAGE . "catalog/toplu_urun/";
        $path_prefix = "catalog/toplu_urun/";
        if (empty($row[0])) {
            return false;
        }

        $language_id = 1;

        $name = $row[0];
        $description = $row[1];
        $package_description[2];
        $product_model = $row[3];
        $barcode = $row[4];
        $tax_rate = $row[5];
        $tax_included_price = $row[6];
        $tax_free_price = $row[7];
        $quantity = $row[8];
        $categories = $row[9];
        $manufacturer = $row[10];
        $stores = $row[11];
        $status = $row[12];
        $image = $row[13];

        if (is_file($dir_image . $image)) {
            $image_path = $path_prefix . $image;
        } else if (is_file($dir_image . $image . ".jpg")) {
            $image_path = $path_prefix . $image . ".jpg";
        } else if (is_file($dir_image . $image . ".png")) {
            $image_path = $path_prefix . $image . ".png";
        } else if (is_file($dir_image . $image . ".gif")) {
            $image_path = $path_prefix . $image . ".gif";
        } else if (is_file($dir_image . $image . ".jpeg")) {
            $image_path = $path_prefix . $image . ".jpeg";
        }

        return array(
            'model' => (string)$product_model,
            'sku' => (string)$product_model,
            'upc' => (string)$product_model,
            'ean' => (string)$product_model,
            'jan' => (string)$product_model,
            'isbn' => (string)$product_model,
            'mpn' => (string)$product_model,
            'image' => $image_path,
            'tag' => '',
            'location' => '',
            'quantity' => is_null($quantity) ? 0 : $quantity,
            'minimum' => 1,
            'subtract' => 1,
            'stock_status_id' => 7,
            'date_available' => date('Y-m-d H:i:s'),
            'manufacturer_id' => $model->getManufacturer($manufacturer, $model->getStores(null)),
            'shipping' => 1,
            'price' => $price,
            'points' => 0,
            'weight' => 0,
            'weight_class_id' => 1,
            'length' => 0,
            'width' => 0,
            'height' => 0,
            'length_class_id' => 1,
            'status' => $status,
            'tax_class_id' => $model->getTaxClass($tax_rate),
            'sort_order' => 1,
            'product_description' => array(
                $language_id => array(
                    'name' => $name,
                    'tag' => '',
                    'description' => $description,
                    'package_description' => $description,
                    'meta_title' => $name,
                    'meta_description' => $name,
                    'meta_keyword' => $name,
                )
            ),
            'product_category' => $model->getCategories($categories),
            'product_store' => $model->getStores($stores),
            'product_image' => array()
        );
    }

    public function productsToStore() {
        $this->load->model('tool/backup');
        $this->model_tool_backup->productsToStore();
    }

    public function trimCustomerNames() {
        $this->load->model('tool/backup');
        $this->model_tool_backup->trimCustomerNames();
    }
}
