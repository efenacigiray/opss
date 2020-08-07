<?php
require_once DIR_CONFIG . 'revslider/revslideropencart_loader.php';
require_once DIR_CONFIG . 'revslider/revslider_admin.php';
class ModelModulerevslideropencart extends Model
{
		public function setup() {
			RevSliderAdmin::onActivate();
		}

		public function remove() {
			$tableSliders = DB_PREFIX.GlobalsRevSlider::TABLE_SLIDERS_NAME;
			$tableSlides = DB_PREFIX.GlobalsRevSlider::TABLE_SLIDES_NAME;
			$tableSettings = DB_PREFIX.GlobalsRevSlider::TABLE_SETTINGS_NAME;
			$tableCss = DB_PREFIX.GlobalsRevSlider::TABLE_CSS_NAME;
			$tableAnims = DB_PREFIX.GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME;
			$tablestatic = DB_PREFIX.GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME;
			$tableattach = DB_PREFIX.GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES;

			$q1 = "DROP TABLE IF EXISTS $tableSliders";
			$q2 = "DROP TABLE IF EXISTS $tableSlides";
			$q3 = "DROP TABLE IF EXISTS $tableSettings";
			$q4 = "DROP TABLE IF EXISTS $tableCss";
			$q5 = "DROP TABLE IF EXISTS $tableAnims";
			$q6 = "DROP TABLE IF EXISTS $tablestatic";
			$q7 = "DROP TABLE IF EXISTS $tableattach";

			$query = $this->db->query($q1);
			$query = $this->db->query($q2);
			$query = $this->db->query($q3);
			$query = $this->db->query($q4);
			$query = $this->db->query($q5);
			$query = $this->db->query($q6);
			$query = $this->db->query($q7);
		}
}
?>
