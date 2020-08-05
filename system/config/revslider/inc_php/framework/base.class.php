<?php



	class UniteBaseClassRev{
		
		protected static $wpdb;
		protected static $table_prefix;		
		protected static $mainFile;
		protected static $t;
		
		protected static $dir_plugin;
		protected static $dir_languages;
		public static $url_plugin;
		protected static $url_ajax;
		public static $url_ajax_actions;
		protected static $url_ajax_showimage;
		protected static $path_settings;
		public static $path_plugin;
		protected static $path_languages;		
		protected static $path_temp;
		protected static $path_views;
		protected static $path_templates;
		protected static $path_cache;
		protected static $path_base;	
		protected static $is_multisite;
		protected static $debugMode = false;
		public static $static_shortcode_tags;
		//start custom code
		protected static $actions = array();
		protected static $admin_scripts = array();
		protected static $front_scripts = array();
		protected static $admin_styles = array();
		protected static $front_styles = array();
		//end custom code
		/**
		 * 
		 * the constructor
		 */
		public function __construct($mainFile,$t){
			//global $wpdb;
			self::$is_multisite = UniteFunctionsWPRev::isMultisite();
            self::$wpdb = rev_db_class::rev_db_instance();                            
			self::$table_prefix = self::$wpdb->prefix;
			if(UniteFunctionsWPRev::isMultisite()){
				$blogID = UniteFunctionsWPRev::getBlogID();
				if($blogID != 1){
					self::$table_prefix .= $blogID."_";
				}
			}
			self::$mainFile = $mainFile;
			self::$t = $t;
			//set plugin dirname (as the main filename)
			$info = pathinfo($mainFile);
			$baseName = $info["basename"];
			$filename = str_replace(".php","",$baseName);
			self::$dir_plugin = $filename;			
			//self::$url_plugin = plugins_url(self::$dir_plugin)."/";			
			self::$url_plugin = rev_slider_url().'/';		
				
			self::$url_ajax = admin_url();

			$sds_rev_user_token = sds_get_oc_user_token();

			self::$url_ajax_actions = admin_url("index.php?route=extension/module/revslideropencart&user_token=".$sds_rev_user_token) . "&action=".self::$dir_plugin."_ajax_action";


			//self::$url_ajax_showimage = self::$url_ajax . "&action=".self::$dir_plugin."_show_image";
			self::$url_ajax_showimage = self::$url_plugin . "ajax.php?action=".self::$dir_plugin."_show_image";
			self::$path_plugin = self::$mainFile."/";
			self::$path_settings = self::$path_plugin."settings/";
			self::$path_temp = self::$path_plugin."temp/";
			//set cache path:
			self::setPathCache();
			self::$path_views = self::$path_plugin."views/";
			self::$path_templates = self::$path_views."/templates/";
			self::$path_base = ABSPATH;
			self::$path_languages = self::$path_plugin."languages/";
			self::$dir_languages = self::$dir_plugin."/languages/";
			//load_plugin_textdomain(self::$dir_plugin,false,self::$dir_languages);
			//update globals oldversion flag
			GlobalsRevSlider::$isNewVersion = true;
//			$version = get_bloginfo("version");
//			$version = (double)$version;
//			if($version >= 3.5)
//				GlobalsRevSlider::$isNewVersion = true;
		}
		
		/**
		 * 
		 * set cache path for images. for multisite it will be current blog content folder
		 */
		private static function setPathCache(){
			
			self::$path_cache = self::$path_plugin."cache/";
			if(self::$is_multisite){
			
				if(!defined("BLOGUPLOADDIR") || !is_dir(BLOGUPLOADDIR))
					return(false);
			
				$path = BLOGUPLOADDIR.self::$dir_plugin."-cache/";
				
				if(!is_dir($path))
					mkdir($path);
				if(is_dir($path))
					self::$path_cache = $path;
			}
		}
		
		/**
		 * 
		 * set debug mode.
		 */
		public static function setDebugMode(){
			self::$debugMode = true;
		}
		
		public static function wp_enqueue_style($scriptName, $src = '' , $deps = array(),$ver = '1.0',$media = 'all', $noscript)
		{
                    //global $admin_styles, $front_styles;
                    $cadm = count(self::$admin_styles) ? count(self::$admin_styles): 0;
                    $cfrt = count(self::$front_styles) ? count(self::$front_styles): 0;
                    if(is_array($scriptName))
                        $deps = $scriptName;
                    if(is_admin()){        
                        self::$admin_styles[$cadm] = new stdClass();        
                        //self::$admin_styles[$cadm]->deps = load_additional_scripts($deps, self::$admin_styles);
                        //self::$admin_styles[$cadm]->footer = false;
                        if(is_string($scriptName))
                            self::$admin_styles[$cadm]->css = "<link rel='stylesheet' id='{$scriptName}' media='{$media}' href='{$src}' type='text/css' />";
                        if($noscript)
                            self::$admin_styles[$cadm]->css = "<noscript>{self::$admin_styles[$cadm]->css}</noscript>";
                    }
                    else{
                        self::$front_styles[$cfrt] = new stdClass();                        
                        if(is_string($scriptName))
                            self::$front_styles[$cfrt]->css = "<link rel='stylesheet' id='{$scriptName}' media='{$media}' href='{$src}' type='text/css' />";                            
                    }
        }
        public static function wp_enqueue_script($scriptName, $src = '' , $deps = array(),$ver = '1.0',$in_footer = false)
        {
                    //global $admin_scripts, $front_scripts;
                    $cadm = count(self::$admin_scripts) ? count(self::$admin_scripts): 0;
                    $cfrt = count(self::$front_scripts) ? count(self::$front_scripts): 0;
                    if(is_array($scriptName))
                        $deps = $scriptName;
                    if(is_admin()){        
                        self::$admin_scripts[$cadm] = new stdClass();        
                        self::$admin_scripts[$cadm]->deps = load_additional_scripts($deps, self::$admin_scripts);
                        self::$admin_scripts[$cadm]->footer = $in_footer;
                        if(is_string($scriptName) && !empty($src))
                            self::$admin_scripts[$cadm]->script = "<script id='{$scriptName}' src='{$src}' type='text/javascript'></script>";
                        else{
                            $scriptArr = is_array($scriptName)? $scriptName : array($scriptName);                            
                            $getScripts = load_additional_scripts($scriptArr, self::$admin_scripts);                            
                            if(!empty($getScripts))
                            foreach($getScripts as $id => $src):                                
                                self::$admin_scripts[$cadm]->script = "<script id='{$id}' src='".script_url().$src."' type='text/javascript'></script>";
                                self::$admin_scripts[$cadm]->footer = $in_footer;
                                $cadm++;
                            endforeach;
                        }
                    }
                    else{
                        self::$front_scripts[$cfrt] = new stdClass();
                        self::$front_scripts[$cadm]->deps = load_additional_scripts($deps, self::$front_scripts);
                        self::$front_scripts[$cfrt]->footer = $in_footer;
                        if(is_string($scriptName) && !empty($src))
                            self::$front_scripts[$cfrt]->script = "<script id='{$scriptName}' src='{$src}' type='text/javascript'></script>";
                        else{
                            $scriptArr = is_array($scriptName)? $scriptName : array($scriptName);                            
                            $getScripts = load_additional_scripts($scriptArr, self::$front_scripts);                            
                            if(!empty($getScripts))
                            foreach($getScripts as $id => $src):                                
                                self::$front_scripts[$cadm]->script = "<script id='{$id}' src='".script_url().$src."' type='text/javascript'></script>";
                                self::$front_scripts[$cadm]->footer = $in_footer;
                                $cadm++;
                            endforeach;
                        }
                    }
        }
        public static function enqueue_css($script)
        {                    
            echo "\t\n";
            if(isset($script->css))
            echo $script->css;
        }
        
        public static function enqueue_script($script)
        {                    
            if(!empty($script->deps)){
                foreach($script->deps as $key=>$src):                    
                    echo "<script id='{$key}' type='text/javascript' src='".script_url().$src."'></script>";                    
                endforeach;
            }
            echo "\t\n";
            if(isset($script->script))
            echo $script->script;
        }
    public static function rev_head()
    {
	//global self::$admin_scripts, $front_scripts, self::$admin_styles, $front_styles;
	//var_dump(self::$admin_scripts);
		if(is_admin() && !empty(self::$admin_styles)){
	        foreach(self::$admin_styles as $script):                            
	            self::enqueue_css($script);
	            endforeach;
		}
		elseif(!is_admin() && !empty(self::$front_styles)){
			foreach(self::$front_styles as $script):                            
                            self::enqueue_css($script);
                        endforeach;
                    }
                    echo "\t\n";
                    if(is_admin() && !empty(self::$admin_scripts)){        
                        foreach(self::$admin_scripts as $script):                            
                            if($script->footer) continue;
                            self::enqueue_script($script);
                        endforeach;                        
                    }
                    elseif(!is_admin() && !empty($front_scripts)){
                        foreach($front_scripts as $script):
                            if($script->footer) continue;
                            self::enqueue_script($script);
                        endforeach;        
                    }
                    echo "\t\n";
        }
        public static function rev_footer()
        {            
              
                   // global self::$admin_scripts, $front_scripts ;  
                    if(is_admin() && !empty(self::$admin_scripts)){        
                        foreach(self::$admin_scripts as $script):
                            if(!$script->footer) continue;
                            self::enqueue_script($script);            
                        endforeach;
                    }
                    elseif(!is_admin() && !empty(self::$front_scripts)){
                        foreach(self::$front_scripts as $script):
                            if(!$script->footer) continue;
                            self::enqueue_script($script);          
                        endforeach;        
                    }                    
        }
		protected static function addAction($action,$eventFunction){
			//add_action( $action, array(self::$t, $eventFunction) );	
			 if(!isset(self::$actions[$action])) {
                        self::$actions[$action] = array();
                        self::$actions[$action][0] = $eventFunction;
                    }
                    else
                        self::$actions[$action][count(self::$actions[$action])] = $eventFunction;
		
		}
		
		
		/**
		 * 
		 * register script helper function
		 * @param $scriptFilename
		 */
		protected static function addScriptAbsoluteUrl($scriptPath,$handle)
		{
			//wp_register_script($handle , $scriptPath);
			//wp_enqueue_script($handle);
            wp_enqueue_script($handle , $scriptPath, array('jquery'), '', false);
		}
		
		/**
		 * 
		 * register script helper function
		 * @param $scriptFilename
		 */
		protected static function addScriptAbsoluteUrlWaitForOther($scriptPath,$handle,$waitfor = array())
		{
			wp_enqueue_script($handle, $scriptPath, $waitfor);
		}
		
		/**
		 * 
		 * register script helper function
		 * @param $scriptFilename
		 */
		protected static function addScript($scriptName,$folder="js",$handle=null){
			if($handle == null)
				$handle = self::$dir_plugin."-".$scriptName;
			$scriptPath = self::$url_plugin .$folder."/".$scriptName.".js";
			//wp_register_script($handle , self::$url_plugin .$folder."/".$scriptName.".js?rev=". GlobalsRevSlider::SLIDER_REVISION );
			//wp_enqueue_script($handle , self::$url_plugin .$folder."/".$scriptName.".js", $deps, $ver, $in_footer);
            wp_enqueue_script($handle , $scriptPath, array(), '', false);
		}
		
		/**
		 * 
		 * register script helper function
		 * @param $scriptFilename
		 */
		protected static function addScriptWaitFor($scriptName,$folder="js",$handle=null,$waitfor = array())
		{
			if($handle == null)
				$handle = self::$dir_plugin."-".$scriptName;
			wp_enqueue_script($handle, self::$url_plugin .$folder."/".$scriptName.".js?rev=". GlobalsRevSlider::SLIDER_REVISION, $waitfor);
		}
		
		/**
		 * 
		 * register common script helper function
		 * the handle for the common script is coming without plugin name
		 */
		protected static function addScriptCommon($scriptName,$handle=null, $folder="js")
		{
			if($handle == null)
				$handle = $scriptName;
			self::addScript($scriptName,$folder,$handle);
		}
		
		
		/**
		 * 
		 * simple enqueue script
		 */
		protected static function addWPScript($scriptName)
		{
			wp_enqueue_script($scriptName);
		}
		
		
		/**
		 * 
		 * register style helper function
		 * @param $styleFilename
		 */

		protected static function addStyle($styleName,$handle=null,$folder="css")
		{
			if($handle == null)
				$handle = self::$dir_plugin."-".$styleName;
			//wp_register_style($handle , self::$url_plugin .$folder."/".$styleName.".css?rev=". GlobalsRevSlider::SLIDER_REVISION);
			wp_enqueue_style($handle , self::$url_plugin .$folder."/".$styleName.".css");
		}
		
		/**
		 * 
		 * register style helper function
		 * @param $styleFilename
		 */
		protected static function addDynamicStyle($styleName,$handle=null,$folder="css")
		{
			if($handle == null)
				$handle = self::$dir_plugin."-".$styleName;
				//wp_register_style($handle , self::$url_plugin .$folder."/".$styleName.".php?rev=". GlobalsRevSlider::SLIDER_REVISION );
			wp_enqueue_style($handle , self::$url_plugin .$folder."/".$styleName.".php?rev=". GlobalsRevSlider::SLIDER_REVISION );
		}
		
		/**
		 * 
		 * register common script helper function
		 * the handle for the common script is coming without plugin name
		 */
		protected static function addStyleCommon($styleName,$handle=null,$folder="css"){
			if($handle == null)	
				$handle = $styleName;
			self::addStyle($styleName,$handle,$folder);
		}
		
		/**
		 * 
		 * register style absolute url helper function
		 */
		protected static function addStyleAbsoluteUrl($styleUrl,$handle)
		{
		//wp_register_style($handle , $styleUrl);
			wp_enqueue_style($handle,$styleUrl);
		}
		
		
		/**
		 * 
		 * simple enqueue style
		 */
		protected static function addWPStyle($styleName)
		{
			$src = self::$url_plugin."css/{$styleName}.css";
			wp_enqueue_style($styleName,$src);
		}
		
		/**
		 * 
		 * get image url to be shown via thumb making script.
		 */
		public static function getImageUrl($filepath, $width=null,$height=null,$exact=false,$effect=null,$effect_param=null)
		{
			$urlImage = UniteImageViewRev::getUrlThumb(self::$url_ajax_showimage, $filepath,$width ,$height ,$exact ,$effect ,$effect_param);
			return($urlImage);
		}
		
		
		/**
		 * 
		 * on show image ajax event. outputs image with parameters 
		 */
		public static function onShowImage()
		{
            $img = Tools::getValue('img');
                if(empty($img)) die('Image doesn\'t exists!');
			$pathImages = UniteFunctionsWPRev::getPathContent();
			$urlImages = UniteFunctionsWPRev::getUrlContent();
			try{
				$imageView = new UniteImageViewRev(self::$path_cache,$pathImages,$urlImages);
				$imageView->showImageFromGet();
			}catch (Exception $e){
				header("status: 500");
				echo $e->getMessage();
				exit();
			}
		}
		
		/**
		 * 
		 * get POST var
		 */
		protected static function getPostVar($key,$defaultValue = "")
		{
			$val = self::getVar($_POST, $key, $defaultValue);
			return($val);			
		}
		
		/**
		 * 
		 * get GET var
		 */
		protected static function getGetVar($key,$defaultValue = "")
		{
			$val = self::getVar($_GET, $key, $defaultValue);
			return($val);
		}
		
		
		/**
		 * 
		 * get post or get variable
		 */
		protected static function getPostGetVar($key,$defaultValue = "")
		{
			
			if(array_key_exists($key, $_POST))
				$val = self::getVar($_POST, $key, $defaultValue);
			else
				$val = self::getVar($_GET, $key, $defaultValue);				
			return($val);							
		}
		
		/**
		 * 
		 * get some var from array
		 */
		protected static function getVar($arr,$key,$defaultValue = "")
		{
			$val = $defaultValue;

			if(isset($arr[$key])){
				$val = $arr[$key];

			} 
			return($val);
		}
		
		
		
		/**
		 * 
		 * make config file of all the text in the settings for the .mo and .po creation
		 */
		protected static function updateSettingsText()
		{
			$filelist = UniteFunctionsRev::getFileList(self::$path_settings,"xml");
			foreach($filelist as $file){
				$filepath = self::$path_settings.$file;
				UniteFunctionsWPRev::writeSettingLanguageFile($filepath);
			}
		} 
				public static function add_shortcode($tag,$func){
                    self::$static_shortcode_tags[$tag] = $func;
                }

                public static function do_shortcode($content) {

                        //$this->shortcodes = self::$static_shortcode_tags;

                        $shortcode_tags = self::$static_shortcode_tags;



                        if (empty($shortcode_tags) || !is_array($shortcode_tags))

                                return $content;



                        $pattern = self::get_shortcode_regex();

                        return preg_replace_callback( "/$pattern/s", array(__CLASS__,'do_shortcode_tag'), $content );

                }

                public static function do_shortcode_tag( $m ) {

                        $shortcode_tags = self::$static_shortcode_tags;



                        // allow [[foo]] syntax for escaping a tag

                        if ( $m[1] == '[' && $m[6] == ']' ) {

                                return substr($m[0], 1, -1);

                        }



                        $tag = $m[2];

                        $attr = self::shortcode_parse_atts( $m[3] );



                        if ( isset( $m[5] ) ) {

                                // enclosing tag - extra parameter

                                return $m[1] . call_user_func( $shortcode_tags[$tag], $attr, $m[5], $tag ) . $m[6];

                        } else {

                                // self-closing tag

                                return $m[1] . call_user_func( $shortcode_tags[$tag], $attr, null,  $tag ) . $m[6];

                        }

                }

                public static function get_shortcode_regex() {



                        $tagnames = array_keys(self::$static_shortcode_tags);

                        $tagregexp = join( '|', array_map('preg_quote', $tagnames) );



                        // WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()

                        // Also, see shortcode_unautop() and shortcode.js.

                        return

                                  '\\['                              // Opening bracket

                                . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]

                                . "($tagregexp)"                     // 2: Shortcode name

                                . '(?![\\w-])'                       // Not followed by word character or hyphen

                                . '('                                // 3: Unroll the loop: Inside the opening shortcode tag

                                .     '[^\\]\\/]*'                   // Not a closing bracket or forward slash

                                .     '(?:'

                                .         '\\/(?!\\])'               // A forward slash not followed by a closing bracket

                                .         '[^\\]\\/]*'               // Not a closing bracket or forward slash

                                .     ')*?'

                                . ')'

                                . '(?:'

                                .     '(\\/)'                        // 4: Self closing tag ...

                                .     '\\]'                          // ... and closing bracket

                                . '|'

                                .     '\\]'                          // Closing bracket

                                .     '(?:'

                                .         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags

                                .             '[^\\[]*+'             // Not an opening bracket

                                .             '(?:'

                                .                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag

                                .                 '[^\\[]*+'         // Not an opening bracket

                                .             ')*+'

                                .         ')'

                                .         '\\[\\/\\2\\]'             // Closing shortcode tag

                                .     ')?'

                                . ')'

                                . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]

                }



                public static function shortcode_parse_atts($text) {

                        $atts = array();

                        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';

                        $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);

                        if ( preg_match_all($pattern, $text, $match, PREG_SET_ORDER) ) {

                                foreach ($match as $m) {

                                        if (!empty($m[1]))

                                                $atts[strtolower($m[1])] = stripcslashes($m[2]);

                                        elseif (!empty($m[3]))

                                                $atts[strtolower($m[3])] = stripcslashes($m[4]);

                                        elseif (!empty($m[5]))

                                                $atts[strtolower($m[5])] = stripcslashes($m[6]);

                                        elseif (isset($m[7]) and strlen($m[7]))

                                                $atts[] = stripcslashes($m[7]);

                                        elseif (isset($m[8]))

                                                $atts[] = stripcslashes($m[8]);

                                }

                        } else {

                                $atts = ltrim($text);

                        }

                        return $atts;

                }



                public static function shortcode_atts( $pairs, $atts, $shortcode = '' ) {

                    $atts = (array)$atts;

                    $out = array();

                    foreach($pairs as $name => $default) {

                            if ( array_key_exists($name, $atts) )

                                    $out[$name] = $atts[$name];

                            else

                                    $out[$name] = $default;

                    }            

                    if ( $shortcode )

                            $out = apply_filters( "shortcode_atts_{$shortcode}", $out, $pairs, $atts );



                    return $out;

                }



                public static function strip_shortcodes( $content ) {

                        $shortcode_tags = self::$static_shortcode_tags;



                        if (empty($shortcode_tags) || !is_array($shortcode_tags))

                                return $content;



                        $pattern = $this->get_shortcode_regex();



                        return preg_replace_callback( "/$pattern/s", array($this,'strip_shortcode_tag'), $content );

                }



                public static function strip_shortcode_tag( $m ) {

                        // allow [[foo]] syntax for escaping a tag

                        if ( $m[1] == '[' && $m[6] == ']' ) {

                                return substr($m[0], 1, -1);

                        }



                        return $m[1] . $m[6];

                }



                public static function parse ($str)

                {           

                    return self::do_shortcode($str);

                }   

	}

?>