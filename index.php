<?php
	require_once 'config.php';
	
	if($_SESSION['user_logged_in'] == true){
		$accessToken = $_SESSION['access_token'];
		$URL = "https://api.github.com/user";
		$authHeader = "Authorization: token " . $accessToken;
		$userAgentHeader = "User-Agent: test-login-github";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json',$authHeader, $userAgentHeader));
		curl_exec($ch);
		
		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
		}else {
			$response = curl_exec($ch);
			$data = json_decode($response);
			$_SESSION['user_data'] = array(
				'userName'=>$data->login,
				'name'=>$data->name,
				'email'=>$data->email,
				'imgUser'=>$data->avatar_url
			);
			
			$userInfo = '
				<p><b>Usuario:</b> '.$_SESSION['user_data']['userName'].'<p>
				<p><b>Nombre(s):</b> '.$_SESSION['user_data']['name'].'<p>
				<p><b>Email:</b> '.$_SESSION['user_data']['email'].'</p>
				<a href="cerrar.php" class="mt-2 btn btn-block btn-danger">Cerrar sesión <i class="fa-solid fa-arrow-right-from-bracket"></i></a>';
		}
		curl_close($ch);

		if (isset($error_msg)) {
			// TODO - Handle cURL error accordingly
		}
	} else {
		$urlBtnLogin = 'https://github.com/login/oauth/authorize?client_id=' . $appId;
		$output = '
			<a id="github-button" class="btn  btn-dark" href="'.$urlBtnLogin.'" style="display:block;">
				<i class="fa-brands fa-github"></i> <span>Iniciar sesión con github</span>
			</a>';
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Conoce Tu Pasión - Login</title>
	<?php include('cdns/cdns.php');?>
</head>
<body>
	<div class="container vh-100">
		<?php
		if($_SESSION['user_logged_in'] == true){
		echo 
		'<div class="row justify-content-center pt-5">
			<div class="col-12 col-sm-8 col-md-6 col-lg-4">
				<div class="text-center">
					<a href="https://conocetupasion.com/">
						<img src="assets/images/logo2.png" class="img-responsive center-block">
					</a>   
				</div>
			</div>
		</div>';	
		}
		?>
		
		<div class="row justify-content-center pt-5">
			<div class="col-12 col-sm-8 col-md-6 col-lg-4">
				<div class="card pt-5 border-0 shadow-sm">
					<div class="text-center mb-4">
						<?php
							if($_SESSION['user_logged_in'] == true){
								echo '<img src="'.$_SESSION['user_data']['imgUser'].'" class="rounded-circle container"/>';
							} else {
								echo '<a href="https://conocetupasion.com/" class="text-dark text-decoration-none">
									<img src="assets/images/conocetupasionLogo.png" class="img-responsive center-block" style="max-width:40%">
									</a>';
							}
						?>
						
					</div>
					<div class="card-body bg-light">
						<div>
							<?php 
								echo $output; 
								echo $userInfo; 
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('cdns/js.php');?>
</body>
</html>