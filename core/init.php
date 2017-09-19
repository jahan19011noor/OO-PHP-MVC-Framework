<?php

	session_start();
	
	$GLOBALS['config'] = array
	(
		'mysql' => array
		(
			'host' => '127.0.0.1',
			'username' => 'root',
			'password' => '',
			'db' => 'oop_login_register'
		),
		'remember' => array
		(
			'cookie_name' => 'hash',
			'cookie_expiry' => 604800
		),
		'session' => array
		(
			'session_name' => 'users',
			'token_name' => 'csrf_token'
		)
	);

	spl_autoload_register(function($class)
	{
		require_once 'classes/'.$class.'.php';
	});
	
	require_once 'functions/sanitize.php';
	
	if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name')))
	{
		//echo 'the user asked to be remembered';
		
		$hash = Cookie::get(Config::get('remember/cookie_name'));
		
		$hashCheck = DB::singleton()->get('users_session', array('hash', '=', $hash));
		//echo $hashCheck->first()->user_id;
		
		if($hashCheck->count())
		{
			//echo 'cookie found, log the user in.';
			if($user = new Users($hashCheck->first()->user_id))
			{
				$user->login($hashCheck->first()->user_id);
			}
		}
	}
?>