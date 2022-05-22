<?php

function show($data){
	echo "<pre><b>";
	print_r($data);
	echo "<b></pre>";
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
