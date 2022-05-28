<?php
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
		ini_set('session.use_strict_mode', 1);
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

	require_once "../app/core/config.php";
	require_once APPPATH."core/functions.php";
	require_once APPPATH."core/database.php";
	require_once APPPATH."core/controller.php";
	require_once APPPATH."core/setting.class.php";
	require_once APPPATH."core/app.php";

	spl_autoload_register(function($class_name){
		require APPPATH."models/" .$class_name . ".class.php";
	});

	$app = new App();