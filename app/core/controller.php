<?php 

Class Controller
{
	public function view(string $url,$data = []){
		
 		if(is_array($data)){
 			extract($data);
		}
		elseif(is_object($data)){
			get_object_vars($data);
			new $data;
		}
		if(file_exists(APPPATH."/views/" . $url . ".php")){
      require_once APPPATH."/views/" . $url . ".php";
      }
    }

	public function load_model(string $model){

		if(file_exists("../app/models/" . strtolower($model) . ".class.php")){
			require_once "../app/models/" . strtolower($model) . ".class.php";
			return $a = new $model();
		}
		
		return false;
	}

}