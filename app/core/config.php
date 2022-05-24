<?php 
$path = $_SERVER['REQUEST_SCHEME'] . "://". $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
$path = str_replace("index.php", "", $path);

//website file paths
define('ROOT', $path);
define('ASSETS', $path . "assets/");
define('LOGIN', $path . "login/");
define('ADMIN', $path . "admin/");

define('THEME','');
define('CONTROLLER', 'home');
define('METHOD', 'index');
define('APPPATH', dirname(dirname(__FILE__)).'/');

// Global Variables
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

// My session start function support timestamp management
function my_session_start() {
  session_start();
  // Do not allow to use too old session ID
  if (!empty($_SESSION['deleted_time']) && $_SESSION['deleted_time'] < time() - 180) {
      session_destroy();
      session_start();
  }
}

// My session regenerate id function
function my_session_regenerate_id() {
  // Call session_create_id() while session is active to 
  // make sure collision free.
  if (session_status() != PHP_SESSION_ACTIVE) {
      session_start();
  }
  // WARNING: Never use confidential strings for prefix!
  $newid = session_create_id('gh58ji868x-');
  // Set deleted timestamp. Session data must not be deleted immediately for reasons.
  $_SESSION['deleted_time'] = time();
  // Finish session
  session_commit();
  // Make sure to accept user defined session ID
  // NOTE: You must enable use_strict_mode for normal operations.
  ini_set('session.use_strict_mode', 0);
  // Set new custom session ID
  session_id($newid);
  // Start with custom session ID
  session_start();
}

// Make sure use_strict_mode is enabled.
// use_strict_mode is mandatory for security reasons.
ini_set('session.use_strict_mode', 1);
session_set_cookie_params(['samesite' => 'Strict']);
my_session_start();

/*debug mode - SET TO FALSE!!! for production*/
define('DEBUG',true);

if(DEBUG){
  error_reporting(1);
	ini_set("display_errors",1);
}else{
  error_reporting(0);
	ini_set("display_errors",0);
}