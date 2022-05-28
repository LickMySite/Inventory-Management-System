<?php

function show($data){
	echo "<pre><b>";
	print_r($data);
	echo "<b></pre>";
}

function check_msg(){
	if(isset($_SESSION['msg']) && $_SESSION['msg'] != "")
	{
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
}

function check_error(){
	if(isset($_SESSION['error']) && $_SESSION['error'] != "")
	{
		echo $_SESSION['error'];
		unset($_SESSION['error']);
	}
}

function redirect($link){
	header("Location: " . ROOT . $link);
	die;
}

function redirect_ADMIN($link){
	header("Location: " . ADMIN . $link);
	die;
}


function show_input($data){
	$data = trim($data);
	$data = htmlspecialchars($data);
	return $data;
}

function clean_input($data) {
  $data = trim($data);
  $data = addslashes($data);
  $data = htmlentities($data, ENT_QUOTES, 'UTF-8');
  return $data;
}

function str_to_url($url) {
	$url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
	$url = trim($url, "-");
	$url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
	$url = strtolower($url);
	$url = preg_replace('~[^-a-z0-9_]+~', '', $url);
	return $url;
}

//CSRF
function createToken() {
	$seed = urlSafeEncode(random_bytes(8));
	$t = time();
	$hash = urlSafeEncode(hash_hmac('sha256', session_id() . $seed . $t, CSRF_TOKEN_SECRET, true));
	return urlSafeEncode($hash . '|' . $seed . '|' . $t);
}

function validateToken($token) {
	$parts = explode('|', urlSafeDecode($token));
	if(count($parts) === 3) {
		$hash = hash_hmac('sha256', session_id() . $parts[1] . $parts[2], CSRF_TOKEN_SECRET, true);
		if(hash_equals($hash, urlSafeDecode($parts[0]))) {
			return true;
		}
	}
	return false;
}

function urlSafeEncode($m) {
	return rtrim(strtr(base64_encode($m), '+/', '-_'), '=');
}
function urlSafeDecode($m) {
	return base64_decode(strtr($m, '-_', '+/'));
}
