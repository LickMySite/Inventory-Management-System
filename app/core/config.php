<?php 

// Global Variables
define('ROOT', str_replace("index.php", "", $_SERVER['REQUEST_SCHEME'] . "://". $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']));

define('ASSETS', ROOT . "assets/");
define('LOGIN', ROOT . "login/");
define('ADMIN', ROOT . "admin/");

define('THEME','');
define('CONTROLLER', 'home');
define('METHOD', 'index');
define('APPPATH', dirname(dirname(__FILE__)).'/');

define('MAX_LOGIN_ATTEMPTS_PER_HOUR', 15);
define('MAX_EMAIL_VERIFICATION_REQUESTS_PER_DAY', 3);
define('MAX_PASSWORD_RESET_REQUESTS_PER_DAY', 3);
define('PASSWORD_RESET_REQUEST_EXPIRY_TIME', 60*60);
define('CSRF_TOKEN_SECRET', '1234'); //Enter unique string 
//define('VALIDATE_EMAIL_ENDPOINT', 'http://localhost/Secure/validateEmail'); //Do not include trailing /
//define('RESET_PASSWORD_ENDPOINT', 'http://localhost/Secure/resetpassword'); //Do not include trailing /

//protocal type http or https
define('PROTOCAL','http');

// Code we want to run on every page/script
date_default_timezone_set('UTC'); 


/*debug mode - SET TO FALSE!!! for production*/
define('DEBUG',true);

if(DEBUG){
  error_reporting(1);
	ini_set("display_errors",1);
}else{
  error_reporting(0);
	ini_set("display_errors",0);
}