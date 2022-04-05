<?php
	require_once 'config.php';
	$code = $_GET['code'];
	
	if($code == ""){
		header('Location: index.php');
		exit;
	}
	
	$postParams = [
		'client_id' => $appId,
		'client_secret' => $appSecret,
		'code' => $code
	];
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $urlAPI);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
	$response = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($response);
	
	if($data->access_token != ""){
		session_start();
		$_SESSION['access_token'] = $data->access_token;
		header('Location: index.php');
		exit;
	}
?>