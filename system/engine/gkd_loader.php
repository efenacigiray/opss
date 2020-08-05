<?php
final class GkdLoader {
	protected $registry;
	protected $DIR_APPLICATION;

	public function __construct($registry) {
		$this->registry = $registry;
		$this->DIR_APPLICATION = defined('DIR_CATALOG') ? DIR_CATALOG : DIR_APPLICATION;
	}
	
	public function controller($route, $data = array()) {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		$output = null;
		
		if (!$output) {
			$action = new Action($route);
			$output = $action->execute($this->registry, array(&$data));
		}
    
		if ($output instanceof Exception) {
			return false;
		}

		return $output;
	}
	
	public function model($route) {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
		
		if (!$this->registry->has('model_' . str_replace(array('/', '-', '.'), array('_', '', ''), $route))) {
			$file  = $this->DIR_APPLICATION . 'model/' . $route . '.php';
			$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $route);
			
			if (is_file($file)) {
				include_once($file);
	
        if (version_compare(VERSION, '2.2', '>=')) {
          $proxy = new Proxy();
          
          foreach (get_class_methods($class) as $method) {
            $proxy->{$method} = $this->callback($this->registry, $route . '/' . $method);
          }
          
          $this->registry->set('model_' . str_replace(array('/', '-', '.'), array('_', '', ''), (string)$route), $proxy);
        } else {
          $this->registry->set('model_' . str_replace('/', '_', $route), new $class($this->registry));
        }
			} else {
				throw new \Exception('Error: Could not load model ' . $route . '!');
			}
		}
	}

	public function view($route, $data = array()) {
		$output = null;
    
    if (defined('DIR_CATALOG')) {
      $template_path = '../../../catalog/view/theme/default/template/';
    } else {
      $template_path = 'default/template/';
    }
    
    $tpl_file = $template_path . preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route) . '.tpl';
    
    if (version_compare(VERSION, '3', '>=')) {
      $tpl_file = $template_path . preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
      
      if (strpos($route, '.twig')) {
        $tpl_file = str_replace('.twig', '', $tpl_file);
        $template = new Template('twig', $this->registry);
      } else {
        $template = new Template('template', $this->registry);
      }
      
      foreach ($data as $key => $value) {
        $template->set($key, $value);
      }
      
      $tpl_file = pathinfo($tpl_file, PATHINFO_DIRNAME) . '/' . pathinfo($tpl_file, PATHINFO_FILENAME);
      
      $rf = new ReflectionMethod('Template', 'render');
      
      if ($rf->getNumberOfParameters() > 2) {
        $output = $template->render($tpl_file, $this->registry, false);
      } else {
        $output = $template->render($tpl_file, false);
      }
      
    } else if (version_compare(VERSION, '2.2', '>=')) {
      $template = new Template(version_compare(VERSION, '2.3', '>=') ? 'php': 'basic');
      
      foreach ($data as $key => $value) {
        $template->set($key, $value);
      }
      
      $output = $template->render($tpl_file, null);
    } elseif (method_exists($this->load, 'view')) {
      $output = $this->load->view($tpl_file, $data);
    } else {
      $template = new Template();
      $template->data = &$data;
      $output = $template->fetch($tpl_file);
    }
    
		return $output;
	}

	public function library($route) {
		// Sanitize the call
		$route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);
			
		$file = DIR_SYSTEM . 'library/' . $route . '.php';
		$class = str_replace('/', '\\', $route);

		if (is_file($file)) {
			include_once($file);

			$this->registry->set(basename($route), new $class($this->registry));
		} else {
			throw new \Exception('Error: Could not load library ' . $route . '!');
		}
	}
	
	public function helper($route) {
		$file = DIR_SYSTEM . 'helper/' . preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route) . '.php';

		if (is_file($file)) {
			include_once($file);
		} else {
			throw new \Exception('Error: Could not load helper ' . $route . '!');
		}
	}
	
	public function config($route) {
		$this->registry->get('config')->load($route);
	}

	public function language($route) {
		$output = null;
    
		$output = $this->registry->get('language')->load($route);
    
		return $output;
	}
	
	protected function callback($registry, $route) {
		return function($args) use($registry, &$route) {
			static $model = array(); 			
			
			$output = null;
			
			// Store the model object
			if (!isset($model[$route])) {
				$file = $this->DIR_APPLICATION . 'model/' .  substr($route, 0, strrpos($route, '/')) . '.php';
				$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', substr($route, 0, strrpos($route, '/')));

				if (is_file($file)) {
					include_once($file);
				
					$model[$route] = new $class($registry);
				} else {
					throw new \Exception('Error: Could not load model ' . substr($route, 0, strrpos($route, '/')) . '!');
				}
			}

			$method = substr($route, strrpos($route, '/') + 1);
			
			$callable = array($model[$route], $method);

			if (is_callable($callable)) {
				$output = call_user_func_array($callable, $args);
			} else {
				throw new \Exception('Error: Could not call model/' . $route . '!');
			}
      
			return $output;
		};
	}	
}