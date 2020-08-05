<?php
class ModelB5bQoreEngineGeneralSettings extends Model {

	public function getSettings($settings_name) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "b5b_qore_engine_settings WHERE name = '" . $settings_name .  "'");

		if($query->num_rows){
			return $query->row['value'];
		}else{
			return FALSE;
		}
	}

	public function getSettingsAll() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "b5b_qore_engine_settings");

		return $query->rows;
	}

	public function changeColorPreset($theme_name, $color_preset) {
		$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "b5b_qore_engine_settings WHERE name = 'color_preset_" . $theme_name . "'");

		if($query->num_rows){
			$this->db->query("UPDATE " . DB_PREFIX . "b5b_qore_engine_settings SET value = '" . (string)$color_preset . "' WHERE name = 'color_preset_" . $theme_name . "'");
		}else{
			$this->db->query("INSERT INTO " . DB_PREFIX . "b5b_qore_engine_settings SET name = 'color_preset_" . (string)$theme_name . "', value = '" . (string)$color_preset . "'");
		}
	}

	public function install_white_labelling($theme_name){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "b5b_qore_engine_settings WHERE name = 'white_label_" . $theme_name . "_settings'");

		if(!$query->num_rows){
			// Install the settings here
			$white_label_settings = array(
				'enable_white_label' => 0,
				'use_own_logo' => 0,
				'show_theme_name_footer' => 1,
				'show_opencart_footer' => 1,
				'show_copyright_footer' => 1,
				'show_company_name_footer' => 0,
				'powered_by' => '',
				'show_b5b_support_header' => 1
				);

			$white_label_settings = serialize($white_label_settings);

			$this->db->query("INSERT INTO " . DB_PREFIX . "b5b_qore_engine_settings SET name = 'white_label_" . $theme_name . "_settings', value = '" . (string)$white_label_settings . "'");
		}
	}

	public function updateWhiteLabelSetting($theme_name, $white_label_setting_name, $white_label_setting_value){
		$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "b5b_qore_engine_settings WHERE name = 'white_label_" . $theme_name . "_settings'");

		if($query->num_rows){

			$white_label_settings = unserialize($query->row['value']);

			$white_label_settings[$white_label_setting_name] = $white_label_setting_value;

			$white_label_settings_new = serialize($white_label_settings);

			$this->db->query("UPDATE " . DB_PREFIX . "b5b_qore_engine_settings SET value = '" . (string)$white_label_settings_new . "' WHERE name = 'white_label_" . $theme_name . "_settings'");

			return TRUE;
		}else{
			$this->install_white_labelling($theme_name);

			return FALSE;
		}
	}

	public function save_custom_admin_page($data){

		// TODO: Check if the admin page already exists before inserting

		$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "b5b_qore_engine_settings WHERE name = 'compatible_page_route_" . $data['active_theme'] . "'");

		if($query->row['value'] == ''){

			// serialize the data then store it in the database
			$page_route_serialized = serialize(array($data['admin_page']));

			$this->db->query("UPDATE " . DB_PREFIX . "b5b_qore_engine_settings SET value = '" . $page_route_serialized . "' WHERE name = 'compatible_page_route_" . $data['active_theme'] . "'");
		}else{

			// unserialize the data, then check if the page_route already exists.
			// If exists then do nothing
			// Else, add it to the data then serialize it ans store it

			$page_route_unserialized = unserialize($query->row['value']);
			array_push($page_route_unserialized, $data['admin_page']);
			$page_route_serialized = serialize($page_route_unserialized);

			$this->db->query("UPDATE " . DB_PREFIX . "b5b_qore_engine_settings SET value = '" . $page_route_serialized . "' WHERE name = 'compatible_page_route_" . $data['active_theme'] . "'");
		}

		return TRUE;
	}

	public function remove_custom_admin_page($data){

		// First, get the entire entry, if it's empty then no nothing,
		// Else, unserialize the data and remove the entry with the specific name

		$query = $this->db->query("SELECT value FROM " . DB_PREFIX . "b5b_qore_engine_settings WHERE name = 'compatible_page_route_" . $data['active_theme'] . "'");

		if($query->row['value'] !== ''){

			$page_route_unserialized = unserialize($query->row['value']);

			if(in_array($data['admin_page'], $page_route_unserialized)){
				$key = array_search($data['admin_page'], $page_route_unserialized);
				array_splice($page_route_unserialized, $key);
				$page_route_serialized = serialize($page_route_unserialized);

				$this->db->query("UPDATE " . DB_PREFIX . "b5b_qore_engine_settings SET value = '" . $page_route_serialized . "' WHERE name = 'compatible_page_route_" . $data['active_theme'] . "'");
			}

		}

		return TRUE;
	}

	public function getCustomAdminPage(){

		$query = $this->db->query("SELECT page_route FROM " . DB_PREFIX . "circloid_custom_admin_page WHERE status = '1'");

		return $query->rows;
	}

	public function tableExsits($table_name){
		$query = $this->db->query("SELECT * FROM information_schema.tables WHERE table_schema = '" . DB_DATABASE . "' AND table_name = '" . DB_PREFIX . $table_name . "' LIMIT 1;");

		return $query->rows;

	}
}
