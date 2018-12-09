<?php

	//Starting session
	session_start();

	//Unset all stored session variables
	$_SESSION = array();

	//Terminate session
	session_destroy();

	//Redirecting user to login
	header("location: login.php");
	exit;

?>