<?php 

Class App 
{
	protected $controller = CONTROLLER;
	protected $method = METHOD;
	protected $params;

	public function __construct(){
		$url = $this->parseURL();

    if(isset($url[0])){

				if(in_array($url[0],$this->files(APPPATH.'controllers/'))){
				$this->controller = $url[0];
				unset($url[0]);
			}
		}
		
		require_once APPPATH."controllers/" . $this->controller . ".php";

		$this->controller = new $this->controller;

		if(isset($url[1])){
			if (method_exists($this->controller, $url[1])){
				$check = new ReflectionMethod($this->controller, $url[1]);
				if (!$check->isPublic()) {
					$this->method = METHOD;
				}else{
					$this->method = $url[1];
					unset($url[1]);
				}
			}
		}

		$this->params = (count($url) > 0) ? $url : [CONTROLLER];
		
		call_user_func_array([$this->controller,$this->method], $this->params);
	}

	private function parseURL(){
		$url = isset($_GET['url']) ? htmlentities($_GET['url'], ENT_QUOTES, 'UTF-8') : CONTROLLER;
		if(!preg_match("/^[a-zA-Z0-9-_?=\/]+$/", $url)){
			$url = null;
			return 404;
		}
		return explode("/", filter_var(trim($url,"/"),FILTER_SANITIZE_URL, FILTER_FLAG_PATH_REQUIRED));
 	}

	 private function files(string $path){
		$path = glob($path . "[a-zA-Z0-9_-]*.php");
		$path = array_map('basename', $path);
		$path = preg_replace('/.php/', '', $path);
		$path = array_map('strtolower', $path);
		
		return $path;
	}


}