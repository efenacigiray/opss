<?php
if(!defined('__DIR__'))
    define('__DIR__',dirname(__FILE__));

function get_mainsite_url(){
    $HTTP_SERVER = get_http_server();
    $url = str_replace('admin/', '', $HTTP_SERVER);
    return $url;
}
function get_mainsite_dir(){
    $DIR_IMAGE = rev_image_url();
    $url = str_replace('image/', '', $DIR_IMAGE);
    return $url;
}
function get_rev_url(){
    $url = new Url();
    return $url;
}
function get_http(){
    if(is_ssl())
        return 'https://';
    else
        return 'http://';
}
function get_http_server(){
    if(is_ssl())
        return HTTPS_SERVER;
    else
        return HTTP_SERVER;
}   
function get_http_catalog(){
    if(is_ssl())
        return HTTPS_CATALOG;
    else
        return HTTP_CATALOG;
}
$get_mainsite_url = get_mainsite_url();
if(!defined('__PS_BASE_URI__'))
define('__PS_BASE_URI__', $get_mainsite_url);

if(!defined('__OC_BASE_URI__'))
define('__OC_BASE_URI__', $get_mainsite_url);

if(!defined('REV_DIR_CONFIG'))
define('REV_DIR_CONFIG', __OC_BASE_URI__.'system/config/');

if(!defined('SDS_REV_DIR_IMAGE'))
define('SDS_REV_DIR_IMAGE', $get_mainsite_url);

if(!defined('ARRAY_A'))
define('ARRAY_A', true);

if(!defined('OBJECT'))
define('OBJECT', false);

if(!defined('ABSPATH'))
define('ABSPATH', __DIR__);

$WP_CONTENT_DIR = uploads_url();
if(!defined('WP_CONTENT_DIR'))
define('WP_CONTENT_DIR',$WP_CONTENT_DIR);

$currentFolder = ABSPATH;

$folderIncludes = "{$currentFolder}/inc_php/framework/";

require_once $currentFolder . '/rev-db.php';

require_once $folderIncludes . 'include_framework.php';

require_once $currentFolder . '/inc_php/revslider_db.class.php'; 

require_once $folderIncludes . 'base.class.php';

require_once $folderIncludes . 'elements_base.class.php';

require_once $folderIncludes . 'base_admin.class.php';

require_once $folderIncludes . 'base_front.class.php';

require_once $currentFolder . '/inc_php/revslider_settings_product.class.php';

require_once $currentFolder . '/inc_php/revslider_globals.class.php';

require_once $currentFolder . '/inc_php/revslider_operations.class.php';

require_once $currentFolder . '/inc_php/revslider_slider.class.php';

require_once $currentFolder . '/inc_php/revslider_output.class.php';

require_once $currentFolder . '/inc_php/revslider_slide.class.php';

require_once $currentFolder . '/inc_php/revslider_params.class.php';

require_once $currentFolder . '/inc_php/revslider_tinybox.class.php';

require_once $currentFolder . '/inc_php/fonts.class.php'; //punchfonts

global $wpdb;

function rev_site_admin_url(){
    $get_mainsite_url = get_mainsite_url();
    $url = $get_mainsite_url.'admin/index.php';
    return $url;
}
function rev_module_url(){
    $dir_app = REV_DIR_CONFIG.'revslider';
    return $dir_app;
}
function rev_module_ajaxurl(){
    $url = REV_DIR_CONFIG.'revslider/ajax.php';
    return $url;
}
function get_catalog_path($sub_url = ''){
    $dir_app = str_replace('/admin/', '/catalog/', DIR_APPLICATION);
    return $dir_app.$sub_url;
}
function get_admin_path($sub_url = ''){
    $dir_app = str_replace('/catalog/', '/admin/', DIR_APPLICATION);
    return $dir_app.$sub_url;
}
function main_shop_url($sub_url = ''){
        if(!defined('__OC_BASE_URI__'))
            return false;
        else
            return __OC_BASE_URI__.$sub_url;
}
function sds_get_oc_user_token(){
    if(is_admin()){
        $ssn = ControllerExtensionModulerevslideropencart::$revSession;
        $user_token = isset($ssn->data['user_token'])? $ssn->data['user_token']: '';
        return $user_token;
    }else
        return false;
}
function sds_get_current_lang(){
    if(is_admin()){
        $ssn = ControllerExtensionModulerevslideropencart::$revSession;
    }else{
        $ssn = ControllerExtensionModuleRevolutionSlider::$revSession;
    }
    $language = isset($ssn->data['language']) ? $ssn->data['language'] : array() ;
    return $language;
}
function rev_slider_admin_url(){
    $ssn = ControllerExtensionModulerevslideropencart::$revSession;
    $lnk = 'extension/module/revslideropencart&user_token='.$ssn->data['user_token'];
    if(isset($lnk))
        return $lnk;
    else
        return false;
}
function is_ssl(){
// Config

    if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1')))  
        return true;
    return false;
}
function get_url($link = '') {
    $url = DIR_CONFIG ."revslider";            
    return $url;
}
function rev_image_url($src = ''){
    return DIR_IMAGE.$src;
}
function uploads_url($src = ''){
    return rev_image_url().'catalog/revslider_media_folder/'.$src;
}
function get_uploads_url($src = ''){
    return main_shop_url('image/catalog/revslider_media_folder/').$src;
}
function script_url() {
    return get_url() . '/';
}

function admin_url($link = '') {
    $url = $_SERVER['PHP_SELF'];
    preg_match('/\?(.*)$/', $link, $found);
    // $arr = $_GET;
    $arr = array();
    if (isset($found[1]) && !empty($found[1])) {
        if(!preg_match('/\&route\=/',$found[1])){            
            unset($arr['route']);
        }
        if(isset($arr['user_token']))
            unset($arr['user_token']);
        $level1 = explode('&',$found[1]);
        foreach($level1 as $level2){
            $lv2 = explode('=',$level2);            
            $arr[$lv2[0]] = $lv2[1];                       
        }    
    }
    $url .= '?'.http_build_query($arr);
    return $url;
         
}

function plugins_url($file = '') {
    if (!empty($file)) {
        return get_url(dirname($file));
    }
    return __DIR__;
}
function rev_slider_url() {
    $url = rev_module_url();   
    return $url;
}

function content_url($link = '') {
    $url = __OC_BASE_URI__ ."system/config/revslider";   
    return $url;

}

function main_site_url($link = '') {
    $url = __OC_BASE_URI__.$link;   
    return $url;
}


function get_template_directory_uri() {

    return get_url();

}
function modify_layer_image($img_src = ''){
    return $img_src;
}

function get_image_id_by_url($image){    

    $wpdb = rev_db_class::rev_db_instance();

    $tablename = $wpdb->prefix.GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES;

    $image = basename($image);

    $id = $wpdb->get_var("SELECT ID FROM {$tablename} WHERE file_name='{$image}'");

    return $id;

}

function wp_get_attachment_image_src($attach_id, $size = 'thumbnail', $args = array()){
    $wpdb = rev_db_class::rev_db_instance();
    $tablename = $wpdb->prefix.GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES;
    $filename = $wpdb->get_var("SELECT file_name FROM {$tablename} WHERE ID={$attach_id}");
    if(!empty($filename)){
        $filerealname = substr($filename,0,strrpos($filename,'.'));
        $fileext = substr($filename,strrpos($filename,'.'),strlen($filename)-strlen($filerealname));
        $newfilename = $filerealname;
        if(gettype($size) == 'string'){
            switch($size){
                case "thumbnail":
                    $px = GlobalsRevSlider::IMAGE_SIZE_THUMBNAIL;
                    $newfilename .= "-{$px}x{$px}";                
                    break;
                case "medium":
                    $px = GlobalsRevSlider::IMAGE_SIZE_MEDIUM;
                    $newfilename .= "-{$px}x{$px}";                
                    break;
                case "large":
                    $px = GlobalsRevSlider::IMAGE_SIZE_LARGE;
                    $newfilename .= "-{$px}x{$px}";                
                    break;
                default: break;
            }
            $newfilename .= $fileext;        
            $imagesize = get_image_real_size($newfilename);
            return array(uploads_url($newfilename),$imagesize[0],$imagesize[1]);
        }   
    }
    return false;
}

//end all url 
function get_post_types(){
    return true;
}
function get_post_type_object( $post_type ) {
        return null;
}
function get_object_taxonomies($object, $output = 'names') {
    return null;
}
function wp_create_nonce(){
      return true;
}
function is_multisite(){
	return false;
}

function load_plugin_textdomain(){
	return true;
}
function get_bloginfo($parms){
	if($parms == 'version'){
		return 3.5;
	}else{
		return true;
	}
}
function add_action(){
	return true;
}
function register_activation_hook(){
	return true;
}
function get_option(){
	return true;
}


function bloginfo($prop) {
    switch ($prop):
        case 'charset':
            echo "UTF-8";
            break;
        default : break;
    endswitch;
}



function is_admin() {
    return defined('HTTP_CATALOG') && defined('HTTP_SERVER');
}


function rev_title() {
    if (is_admin()) {
        echo "Revolution Slider";
        return;
    }
    echo "Homepage";
}


function get_image_real_size($image){
    $filepath = uploads_url().$image;    
    if(file_exists($filepath))
        return list($width,$height) = getimagesize ($filepath);
    return false;
}
function load_additional_scripts($deps = array(), $parent) {
    if (empty($deps) || !is_array($deps))
        return false;
    $load = array();
    foreach ($deps as $dep) {
        switch ($dep) {
            case 'jquery':
                $load[$dep] = 'js/jquery-1.9.1.min.js';
                break;
            case 'thickbox':
                //$load[$dep] = __OC_BASE_URI__'system/config/revslider/js/thickbox.js';
                break;
            default:
                break;
        }
    }
    return $load;
}

function wp_enqueue_script($scriptName, $src = '', $deps = array(), $ver = '1.0', $in_footer = false) {

    UniteBaseClassRev::wp_enqueue_script($scriptName, $src, $deps, $ver, $in_footer);

}



function wp_enqueue_style($handle, $src = '', $deps = array(), $ver = '', $media = 'all', $noscript = false) {

    UniteBaseClassRev::wp_enqueue_style($handle, $src, $deps, $ver, $media, $noscript);

}



function rev_head() {

    UniteBaseClassRev::rev_head();

}



function rev_footer() {

    UniteBaseClassRev::rev_footer();

}



function __($text, $textdomain = '') {
    return $text;
}



function _e($text, $textdomain = '') {
    echo $text;
}


function esc_sql($data) {

    $wpdb = rev_db_class::rev_db_instance();    

    return $wpdb->_escape($data);

}
function add_shortcode($tag, $func) {
    UniteBaseClassRev::add_shortcode($tag, $func);

}
function do_shortcode($str) {
    return UniteBaseClassRev::parse($str);
}
function get_instance($class = '')
{   
                $registry = new Registry();
                $loader = new Loader($registry);
                $registry->set('load', $loader);
                $config = new Config();
                $registry->set('config', $config);
                $db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                $registry->set('db', $db);
                $request = new Request();
                $registry->set('request', $request);
                $response = new Response();
                $response->addHeader('Content-Type: text/html; charset=utf-8');
                $response->setCompression($config->get('config_compression'));
                $registry->set('response', $response); 
                $cache = new Cache('file');
                $registry->set('cache', $cache); 
                $session = new Session();
                $registry->set('session', $session);
    $languages = array();
    $query = $db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE status = '1'"); 
    foreach ($query->rows as $result) {
        $languages[$result['code']] = $result;
    }
    $detect = '';
    if (isset($request->server['HTTP_ACCEPT_LANGUAGE']) && $request->server['HTTP_ACCEPT_LANGUAGE']) { 
        $browser_languages = explode(',', $request->server['HTTP_ACCEPT_LANGUAGE']);
        foreach ($browser_languages as $browser_language) {
            foreach ($languages as $key => $value) {
                if ($value['status']) {
                    $locale = explode(',', $value['locale']);

                    if (in_array($browser_language, $locale)) {
                        $detect = $key;
                    }
                }
            }
        }
    }
    if (isset($session->data['language']) && array_key_exists($session->data['language'], $languages) && $languages[$session->data['language']]['status']) {
        $code = $session->data['language'];
    } elseif (isset($request->cookie['language']) && array_key_exists($request->cookie['language'], $languages) && $languages[$request->cookie['language']]['status']) {
        $code = $request->cookie['language'];
    }elseif($detect){
        $code = $detect;
    }else{
        $code = $config->get('config_language');
    }
    if (!isset($session->data['language']) || $session->data['language'] != $code) {
        $session->data['language'] = $code;
    }
    if (!isset($request->cookie['language']) || $request->cookie['language'] != $code) {      
        setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', $request->server['HTTP_HOST']);
    }
    $config->set('config_language_id', $languages[$code]['language_id']);
    $config->set('config_language', $languages[$code]['code']);
    $language = new Language($languages[$code]['directory']);
    $registry->set('language', $language); 
    $language->load('extension/module/revslideropencart');
    $currency = new Currency($registry);
    $registry->set('currency', $currency);
    $instance = new $class($registry);
    return $instance;
}



function putRevSlider($data, $putIn = "") {

   $operations = new RevOperations();

   $arrValues = $operations->getGeneralSettingsValues();

   $includesGlobally = UniteFunctionsRev::getVal($arrValues, "includes_globally", "on");

   $strPutIn = UniteFunctionsRev::getVal($arrValues, "pages_for_includes");

   $isPutIn = RevSliderOutput::isPutIn($strPutIn, true);



   if ($isPutIn == false && $includesGlobally == "off") {

       $output = new RevSliderOutput();

       $option1Name = "Include RevSlider libraries globally (all pages/posts)";

       $option2Name = "Pages to include RevSlider libraries";

       $output->putErrorMessage(__("If you want to use the PHP function \"putRevSlider\" in your code please make sure to check \" ", REVSLIDER_TEXTDOMAIN) . $option1Name . __(" \" in the backend's \"General Settings\" (top right panel). <br> <br> Or add the current page to the \"", REVSLIDER_TEXTDOMAIN) . $option2Name . __("\" option box."));

       return(false);

   }



   RevSliderOutput::putSlider($data, $putIn);

}


    function update_option($parm1='',$parm2='') {        
    	return true;
    }

    function rev_slider_shortcode($args) {        



        $sliderAlias = UniteFunctionsRev::getVal($args, 0);

        ob_start();

        $slider = RevSliderOutput::putSlider($sliderAlias);

        $content = ob_get_contents();

        ob_clean();

        ob_end_clean();



        //handle slider output types

        if (!empty($slider)) {

            $outputType = $slider->getParam("output_type", "");

            switch ($outputType) {

                case "compress":

                    $content = str_replace("\n", "", $content);

                    $content = str_replace("\r", "", $content);

                    return($content);

                    break;

                case "echo":

                    echo $content;  //bypass the filters

                    break;

                default:

                    return($content);

                    break;

            }

        }

        else

            return($content);  //normal output

    }

class Shop{

        public static function getShops()
        {

           return false;
        }
        public static function isFeatureActive()
        {

           return true;
        }
}
class Configuration{

        public static function get($key)
        {

            return false;
        }
}
class sdsconfig{
    public $ocdb;

    public static function getval($key,$store_id = 0,$group = 'config')
    {
        
        $wpdb = rev_db_class::rev_db_instance();
        $sql ="SELECT `value` FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `code` = '" .$group. "' AND `key` = '".$key."'";
        $value = $wpdb->get_var($sql);
        if(isset($value))
            return $value;
        else
            return false;
    }
    public static function setval($key,$value='',$group = 'config',$store_id = 0,$serialized = 0)
    {
        $sql = '';
        $wpdb = rev_db_class::rev_db_instance();
        $getvalue = self::getval($key,$store_id,$group);
        if(isset($getvalue) && !empty($getvalue)){
            $sql = "UPDATE `" . DB_PREFIX . "setting` SET `store_id` = ".(int)$store_id.",`code` = '".$group."',`value` ='".serialize($value)."',`serialized` = ".$serialized." WHERE `key` = '".$key."'";
        }else{
            $sql = "INSERT INTO `" . DB_PREFIX . "setting` SET `store_id` = '".(int)$store_id."',`code` = '".$group."',`value` ='".serialize($value)."',`serialized` = '".$serialized."',`key` ='".$key."'";
        }
        $rslt = $wpdb->query($sql);
        if(isset($rslt))
            return true;
        else
            return false;
    }
    public static function getallinformations()
    {   
        $store_id = self::getval('config_store_id');
        $language_id = (int)self::getval('config_language_id');
            if(!isset($store_id)){
                $store_id = 0;  
            }
            if(!isset($language_id) || $language_id == 0){
                $language_id = 1;
            }
        $wpdb = rev_db_class::rev_db_instance();
        $sql ="SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE id.language_id = '" . (int)$language_id  . "' AND i2s.store_id = '" . (int)$store_id . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC";
        
        $value = $wpdb->get_results($sql);
        if(isset($value))
            return $value;
        else
            return false;
    }
    public static function get_current_lang(){
        $ssn = ControllerExtensionModuleRevolutionSlider::$revSession;
        if(!isset($ssn->data['language']) && empty($ssn->data['language'])){
            $language = sdsconfig::getval('config_language');
        }else{
            $language = $ssn->data['language'];
        }
        return $language;
    }
    public static function get_current_lang_id(){
        $language_id = 1;
        $ssn = ControllerExtensionModuleRevolutionSlider::$revSession;
        if(!isset($ssn->data['language']) && empty($ssn->data['language'])){
            $language = sdsconfig::getval('config_language');
        }else{
            $language = $ssn->data['language'];
        }
        $sql = "SELECT * FROM ".DB_PREFIX."language WHERE `code` = '".$language."'";
        $wpdb = rev_db_class::rev_db_instance();
        $value = $wpdb->get_results($sql);
        if(isset($value[0]['language_id']) && !empty($value[0]['language_id'])){
           $language_id = $value[0]['language_id']; 
        }
        return $language_id;
    }
    public static function isLogged() {
        $ssn = ControllerExtensionModuleRevolutionSlider::$revSession;
        if(isset($ssn->data['customer_id']) && !empty($ssn->data['customer_id'])){
            $customer_id = $ssn->data['customer_id'];
        }else{
            $customer_id = false;
        }
        return $customer_id;
    }
    public static function getCustomerGroupId() {
        $ssn = new Session();
        
    }
    public static function get_current_store() {
        $store_id = self::getval('config_store_id');
        if(isset($store_id) && !empty($store_id)){
                $store_id = $store_id;  
            }else{
                $store_id = 0;
            }
        return (int)$store_id;
    }
    public static function getCategories($parent_id = 0) {
        $store_id = self::getval('config_store_id');
        $language_id = (int)self::getval('config_language_id');
            if(!isset($store_id)){
                $store_id = 0;  
            }
            if(!isset($language_id) || $language_id == 0){
                $language_id = 1;
            }
        $wpdb = rev_db_class::rev_db_instance();
        $sql = "SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$language_id . "' AND c2s.store_id = '" . (int)$store_id . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)";
        $value = $wpdb->get_results($sql);
        if(isset($value))
            return $value;
        else
            return false;
    }
    public static function getcaptioncss($tabl){
        $wpdb = rev_db_class::rev_db_instance();
        $sql = "SELECT * FROM ".DB_PREFIX.$tabl;
        $value = $wpdb->get_results($sql);
        if(isset($value))
            return $value;
        else
            return false;
    }
    public static function getgeneratecss(){
        $getcss = self::getcaptioncss(GlobalsRevSlider::TABLE_CSS_NAME);
        
        $value = UniteCssParserRev::parseDbArrayToCss($getcss, "\n");
        if(isset($value))
            return $value;
        else
            return false;
    }
    public static function getgeneratecssfile(){
        $csscontent = sdsconfig::getgeneratecss();
        $cache_filename = RevSliderAdmin::$path_plugin.'rs-plugin/css/captions.css';
        @file_put_contents($cache_filename, $csscontent);
        @chmod($cache_filename, 0755);
    }
    public static function getlanguages(){
        $wpdb = rev_db_class::rev_db_instance();
        $sql = "SELECT * FROM " . DB_PREFIX . "language WHERE status = 1 ORDER BY sort_order, name";
        $query = $wpdb->get_results($sql);
        $language_data = array();
            $i = 0;
            foreach($query as $result){
                 $language_data[$i]['language_id'] = $result['language_id'];
                 $language_data[$i]['name'] = $result['name'];
                 $language_data[$i]['code'] = $result['code'];
                 $language_data[$i]['locale'] = $result['locale'];
                 $language_data[$i]['image'] = $result['image'];
                 $language_data[$i]['directory'] = $result['directory'];
                 // $language_data[$i]['filename'] = $result['filename'];
                 $language_data[$i]['sort_order'] = $result['sort_order'];
                 $language_data[$i]['status'] = $result['status'];
                $i++;
            }
        return $language_data;  
    }
    public static function getLayouts($data = array()) {

        $wpdb = rev_db_class::rev_db_instance();

        $sql = "SELECT * FROM " . DB_PREFIX . "layout";

        $sort_data = array('name'); 

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];   
        } else {
            $sql .= " ORDER BY name";   
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }
        
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }                   

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }   

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $wpdb->get_results($sql);

        return $query;
    }
    public static function editSetting($group, $data){
        $wpdb = rev_db_class::rev_db_instance();
        $store_id = self::getval('config_store_id');
        if(!isset($store_id)){
                $store_id = 0;  
            }
        $wpdb->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $wpdb->_escape($group) . "'");
        if(!empty($data))
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $wpdb->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $wpdb->_escape($group) . "', `key` = '" . $wpdb->_escape($key) . "', `value` = '" . $wpdb->_escape($value) . "'");
            } else {
                $wpdb->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $wpdb->_escape($group) . "', `key` = '" . $wpdb->_escape($key) . "', `value` = '" . $wpdb->_escape(serialize($value)) . "', serialized = '1'");
            }
        }
    }
    public static function getrevslide()
    {
        $result = array();
        $wpdb = rev_db_class::rev_db_instance();
        $sql = "SELECT * FROM " .$wpdb->prefix.GlobalsRevSlider::TABLE_SLIDERS_NAME;
        $data = $wpdb->get_results($sql);
        if(!empty($data))
        {
            $i = 0;
            foreach ($data as $val)
            {
                $params = json_decode($val['params']);
                if(!isset($params->template)){
                    $params->template = 'false';
                }
                if($params->template == 'false'){
                    $result[$i]['id'] = $val['id'];
                    $result[$i]['title'] = $val['title'];
                    $i = $i+1;
                }
            }
        }
        if(!empty($result))
            return $result;
        else
            return false;
    }
    public static function sdsgetlayoutid($name=''){
        $wpdb = rev_db_class::rev_db_instance();
        $sql = "SELECT `layout_id` FROM " .$wpdb->prefix.'layout WHERE `name` = "'.$name.'"';
        $data = $wpdb->get_row($sql);
        if(!empty($data['layout_id']))
            return $data['layout_id'];
        else
            return false;
    }
    // start get products
    public static function getProducts($data = array()){
        
        $wpdb = rev_db_class::rev_db_instance();

        $sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special "; 

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])){
                $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";         
            }else{
                $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
            }

            if (!empty($data['filter_filter'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
            } else {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
            }
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" .(int)sdsconfig::get_current_lang_id(). "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)sdsconfig::get_current_store() . "'";


        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'"; 
            } else {
                $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";            
            }   

            if (!empty($data['filter_filter'])) {
                $implode = array();

                $filters = explode(',', $data['filter_filter']);

                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }

                $sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";                
            }
        }

        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
            $sql .= " AND (";

            if (!empty($data['filter_name'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

                foreach ($words as $word) {
                    $implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
                }

                if ($implode) {
                    $sql .= " " . implode(" AND ", $implode) . "";
                }

                if (!empty($data['filter_description'])) {
                    $sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
                }
            }

            if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                $sql .= " OR ";
            }

            if (!empty($data['filter_tag'])) {
                $sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
            }

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }   

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }       

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }       

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }

            $sql .= ")";
        }

        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
        }

        $sql .= " GROUP BY p.product_id";

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.quantity',
            'p.price',
            'rating',
            'p.sort_order',
            'p.date_added'
        );  

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
            } elseif ($data['sort'] == 'p.price') {
                $sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
            } else {
                $sql .= " ORDER BY " . $data['sort'];
            }
        } else {
            $sql .= " ORDER BY p.sort_order";   
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC, LCASE(pd.name) DESC";
        } else {
            $sql .= " ASC, LCASE(pd.name) ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $product_data = array();

        $query = $wpdb->get_results($sql);

        if(!empty($query) && isset($query)){
            foreach ($query as $result) {
            $product_data[$result['product_id']] = self::getProduct($result['product_id']);
            }
        }

        return $product_data;
    }
    public static function getProduct($product_id){
         $wpdb = rev_db_class::rev_db_instance();
        $sql = "SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id  AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id) AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)sdsconfig::get_current_lang_id() . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)sdsconfig::get_current_lang_id() . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)sdsconfig::get_current_lang_id() . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)sdsconfig::get_current_lang_id() . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)sdsconfig::get_current_store() . "'";


        $query = $wpdb->get_results($sql);

        if (isset($query) && !empty($query)) {
            $query = $query[0];
        }
        if (isset($query) && !empty($query)) {
            $get_mainsite_url = get_mainsite_url();
            $img_path = $get_mainsite_url.'image/';
            $lnk = new Url($get_mainsite_url);
            return array(
                'product_id'       => $query['product_id'],
                'link'       => $lnk->link('product/product','product_id=' . $query['product_id']),
                'id_product'       => $query['product_id'],
                'name'             => $query['name'],
                'description'      => $query['description'],
                'meta_description' => $query['meta_description'],
                'meta_keyword'     => $query['meta_keyword'],
                'tag'              => $query['tag'],
                'model'            => $query['model'],
                'sku'              => $query['sku'],
                'upc'              => $query['upc'],
                'ean'              => $query['ean'],
                'jan'              => $query['jan'],
                'isbn'             => $query['isbn'],
                'mpn'              => $query['mpn'],
                'location'         => $query['location'],
                'quantity'         => $query['quantity'],
                'stock_status'     => $query['stock_status'],
                'image'            => $img_path.$query['image'],
                'manufacturer_id'  => $query['manufacturer_id'],
                'manufacturer'     => $query['manufacturer'],
                'price'            => ($query['discount'] ? $query['discount'] : $query['price']),
                'special'          => $query['special'],
                'reward'           => $query['reward'],
                'points'           => $query['points'],
                'tax_class_id'     => $query['tax_class_id'],
                'date_available'   => $query['date_available'],
                'weight'           => $query['weight'],
                'weight_class_id'  => $query['weight_class_id'],
                'length'           => $query['length'],
                'width'            => $query['width'],
                'height'           => $query['height'],
                'length_class_id'  => $query['length_class_id'],
                'subtract'         => $query['subtract'],
                'rating'           => round($query['rating']),
                'reviews'          => $query['reviews'] ? $query['reviews'] : 0,
                'minimum'          => $query['minimum'],
                'sort_order'       => $query['sort_order'],
                'status'           => $query['status'],
                'date_added'       => $query['date_added'],
                'date_modified'    => $query['date_modified'],
                'viewed'           => $query['viewed']
            );
        } else {
            return false;
        }
    }

    public static function getProductimg($product_id,$img_arr = array()){
        $wpdb = rev_db_class::rev_db_instance();
        $sql = "SELECT `image` FROM `".DB_PREFIX."product_image` WHERE `product_id` = ".$product_id;
        $query = $wpdb->get_results($sql);
        if (isset($query) && !empty($query)) {
            $query = $query[0];
        }
        if(isset($query) && !empty($query)){
            $get_mainsite_url = get_mainsite_url();
            $img_path = $get_mainsite_url.'image/';
                if(isset($img_arr) && !empty($img_arr)){
                    $old_img = rev_image_url().$query['image'];
                    
                    $pathinfo = pathinfo($old_img);
                    $dirname = $pathinfo['dirname'];
                    $basename = $pathinfo['basename'];
                    $extension = $pathinfo['extension'];
                    $basenameWE = $pathinfo['filename'];
                    $height = $img_arr['height'];
                    $width = $img_arr['width'];
                    $newimagename = $basenameWE.'_'.$width.'_'.$height.'.'.$extension;
                    $new_img = $dirname.'/'.$newimagename;
                    $dnypath = str_replace($basename, '', $query['image']);
                    $newimage = $img_path.$dnypath.$newimagename;
                    $img = new Image($old_img);
                    $img->resize($width,$height);
                    $img->save($new_img);
                }else{
                    $newimage = $img_path.$query['image'];
                }
            return $newimage;
        }else{
            return false;
        }
    }
    // end get products
}

class Tools
{
    protected static $file_exists_cache = array();
    protected static $_forceCompile;
    protected static $_caching;
    protected static $_user_plateform;
    protected static $_user_browser;

    public static function getRemoteAddr()
    {
        // This condition is necessary when using CDN, don't remove it.
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && (!isset($_SERVER['REMOTE_ADDR']) || preg_match('/^127\..*/i', trim($_SERVER['REMOTE_ADDR'])) || preg_match('/^172\.16.*/i', trim($_SERVER['REMOTE_ADDR'])) || preg_match('/^192\.168\.*/i', trim($_SERVER['REMOTE_ADDR'])) || preg_match('/^10\..*/i', trim($_SERVER['REMOTE_ADDR']))))
        {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ','))
            {
                $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                return $ips[0];
            }
            else
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $_SERVER['REMOTE_ADDR'];
    }
}

class SdsRevToolImage{
    public function resizez($filename,$width,$height,$newfilename=''){
        $info = pathinfo($filename);
        $extension = $info['extension'];
        $old_image = $filename;
        $new_image = $newfilename;
        $new_info = pathinfo($newfilename);
        $only_new_filename = $new_info['basename'];
        $get_http_catalog = get_http_catalog();
        $only_new_fileurl = $get_http_catalog.'image/catalog/revslider_media_folder/'.$only_new_filename;
    
        if (!file_exists($new_image) || (filemtime($old_image) > filemtime($new_image))) {
            $path = '';
            $directories = explode('/', dirname(str_replace('../', '', $new_image)));
            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;
            }
            $image = new Image($old_image);
            $image->resize($width, $height);
            $image->save($new_image);
        }
        return $only_new_fileurl;  
    }
    public function resize($filename,$width,$height,$newfilename)
    {
        $pathinfo = pathinfo($filename);
        $dirname = $pathinfo['dirname'];
        $basename = $pathinfo['basename'];
        $extension = $pathinfo['extension'];
        $basenameWE = $pathinfo['filename'];
        $newpathinfo = pathinfo($newfilename);
        $newdirname = $newpathinfo['dirname'];
        $newbasename = $newpathinfo['basename'];
        $newextension = $newpathinfo['extension'];
        $newbasenameWE = $newpathinfo['filename'];
        $img = new Image($filename);
        $img->resize($width,$height);
        $img->save($newfilename);
        // print get_uploads_url($newbasename);
        // die();
        return get_uploads_url($newbasename);
    }
}