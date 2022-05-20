<?php 
$path = $_SERVER['REQUEST_SCHEME'] . "://". $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
$path = str_replace("index.php", "", $path);

//website file paths
define('ROOT', $path);
define('ASSETS', $path . "assets/");
define('THEME','');
define('CONTROLLER', 'home');
define('METHOD', 'index');
define('APPPATH', dirname(dirname(__FILE__)).'/');

//protocal type http or https
define('PROTOCAL','http');

// Code we want to run on every page/script
date_default_timezone_set('UTC'); 
session_set_cookie_params(['samesite' => 'Strict']);

/*debug mode - SET TO FALSE!!! for production*/
define('DEBUG',true);

if(DEBUG){
  error_reporting(1);
	ini_set("display_errors",1);
}else{
  error_reporting(0);
	ini_set("display_errors",0);
}