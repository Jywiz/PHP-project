<?php
//forming connection to database
include('connection.php');

//Starting session
session_start();

//If user is not logged in, redirecting them to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: login.php");
	exit;
}

?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width = device-width, initial-scale = 1.0">

		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<title>Easy Schedules</title>

	</head>
	
	<!-- Title -->
	<body class="main">
	
		<div class="title">Easy Schedules</div>
		<div class="subtitle">Managing your schedule has never been easier!</div>
		
		<!-- Navigation -->
		<nav class="navbar navbar-default">
		
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle">
					<span class="sr-only">Toggle navigation</span>
                </button>
				<a class="navbar-nav" href="index.php">Easy Schedules</a>
			</div>
			
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="schedule.php">Schedule</a>
                    </li>
                    <li>
                        <a href="help.php">Help</a>
                    </li>
                </ul>
            </div>
		</div>
		</nav>
		
		<!-- Content -->
		<div class="container">
			<div class="row">
				<div class="box">
					<h2 class="intro-text text-center">
					Instructions
					</h2>
					<hr class="line">
					<hr>
					<strong>Here are the instructions on how to use this site!</strong>
					<hr>
					<p>1. Start by making a new entry at the schedule tab.</p>
					<p>2. In the entry fields you must input a title for your entry and a date.</p>
					<p>3. After that your entry will appear on the upper part of the page.</p>
					<p>4. In the index site you can sign out by clicking the button on the bottom part of the page.</p>
					</p>
				</div>
			</div>
		</div>
					
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	</body>
	
	<footer>
	<?php
	include "footer.php";
	?>
	</footer>
</html>