<?php
class Template {
	private $adaptor;

  	public function __construct($adaptor) {
	    $class = 'Template\\' . $adaptor;
		
		if (class_exists($class)) {
			$this->adaptor = new $class();
		} else {
			throw new \Exception('Error: Could not load template adaptor ' . $adaptor . '!');
		}
	}

	public function set($key, $value) {
		$this->adaptor->set($key, $value);
	}

	public function render($template, $registry, $cache = false) {
		$this->adaptor->set('registry', $registry);
		$template_name = $registry->get('config')->get('theme_' . $registry->get('config')->get('config_theme') . '_directory');
		return $this->adaptor->render($template, false, $template_name);
	}
}