<?php
// Deshacer la sesión
session_start();
unset($_SESSION['access_token']);

// Deshacer la información del usuario
unset($_SESSION['user_data']);

//Destroy entire session data.
session_destroy();

//redirect page to index.php
header('location:index.php');
?>