<?php
$link = mysqli_connect("127.0.0.1", "azure", "6#vWHD_$", "localdb", "49477");

// Checking connection
if($link === false) {
	die("ERROR: couldn't connect" . mysqli_connect_error());
}

?>