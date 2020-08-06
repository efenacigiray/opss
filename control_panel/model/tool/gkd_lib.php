<?php
class ModelToolGkdLib extends Model {
  
	public function fetch($template, $data = array(), $snippet = false, $language = false) {
    $data['token'] = isset($this->session->data['user_token']) ? $this->session->data['user_token'] : $this->session->data['token'];
    $data['token_type'] = isset($this->session->data['user_token']) ? 'user_token' : 'token';
    $data['full_token'] = isset($this->session->data['user_token']) ? 'user_token='.$this->session->data['user_token'] : 'token='.$this->session->data['token'];
    $data['_language'] = $this->language;
    $data['_config'] = $this->config;
    $data['_url'] = $this->url;
    
    if (!$language) {
      $languages = array(array('language_id' => $this->config->get('config_language_id')));
    } else if ($language == 'all') {
      $this->load->model('localisation/language');
      $languages = $this->model_localisation_language->getLanguages();
      $return = array();
    } else {
      $languages = array(array('language_id' => $language));
    }
    
    if ($snippet == 'all') {
      preg_match_all('#\$gkd_snippet == \'(.+)\'#', file_get_contents(DIR_TEMPLATE . $template . '.tpl'), $res);
      
      if (isset($res[1])) {
        $snippets = $res[1];
      }
    } else {
      $snippets = array($snippet);
    }
    
    foreach ($snippets as $gkd_snippet) {
      $data['gkd_snippet'] = $gkd_snippet;
      
      foreach ($languages as $lang) {
        $data['_language_id'] = $lang['language_id'];
        
        if (version_compare(VERSION, '3', '>=')) {
          $tpl = new Template('template', $this->registry);
          
          foreach ($data as $key => $value) {
            $tpl->set($key, $value);
          }
          
          $rf = new ReflectionMethod('Template', 'render');
          
          if ($rf->getNumberOfParameters() > 2) {
            $render = $tpl->render($template, $this->registry, false);
          } else {
            $render = $tpl->render($template, false);
          }
        } else if (version_compare(VERSION, '2.2', '>=')) {
          $tpl = new Template(version_compare(VERSION, '2.3', '>=') ? 'php': 'basic');
          
          foreach ($data as $key => $value) {
            $tpl->set($key, $value);
          }
          
          $render = $tpl->render($template.'.tpl', null); // null is for compatibility with fastor theme
        } elseif (method_exists($this->load, 'view')) {
          $render = $this->load->view($template.'.tpl', $data);
        } else {
          $tpl = new Template();
          $tpl->data = &$data;
          $render = $tpl->fetch($template.'.tpl');
        }
        
        if ($snippet == 'all' && $language == 'all') {
            $return[$gkd_snippet][$lang['language_id']] = $render;
          } else if ($snippet == 'all') {
            $return[$gkd_snippet] = $render;
          } else if ($language == 'all') {
            $return[$lang['language_id']] = $render;
          } else {
            $return = $render;
          }
      }
    }
    
    return $return;
	}
  
  public function getLanguages() {
    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    
    foreach ($languages as $k => $language) {
      if (version_compare(VERSION, '2.2', '>=')) {
        $languages[$k]['image'] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $languages[$k]['image'] = 'view/image/flags/'. $language['image'];
      }
    }
    
    return $languages;
  }
}