<?php
	session_start();
	
	if($_SESSION['access_token'] == null){
		$_SESSION['user_logged_in'] = false;
		$_SESSION['user_data'] = array();
	} else {
		$_SESSION['user_logged_in'] = true;
	}
	
	$appId         = ''; //Identificador de la Aplicación
	$appSecret     = ''; //Clave secreta de la aplicación
	$redirectURL   = ''; //Callback URL
	$urlAPI 	   = 'https://github.com/login/oauth/access_token';
?>