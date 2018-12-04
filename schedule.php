<!DOCTYPE html>

<?php

include('connection.php');

?>

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
                        <a href="#">Calendar</a>
                    </li>
                    <li>
                        <a href="#">Help</a>
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
					Your Appointments
					</h2>
					<hr class="line">
					<?php 
					
					/* NOTE: Currently trying to invent a better way to fetch data 
					(ie. using a separate .php file)*/
					
					// Attempting query selection
					$sql = "SELECT * FROM `appointment`";
					if($result = mysqli_query($link, $sql)) {
						if(mysqli_num_rows($result) > 0) {
							echo "<table>";
								echo "<tr>";
									echo "<th>Title</th>";
									echo "<th>Date</th>";
									echo "<th>UserID</th>";
								echo "<tr>";
							while($row = mysqli_fetch_array($result)){
								echo "<tr>";
									echo "<td>" . $row['Title'] . "</td>";
									echo "<td>" . $row['Date'] . "</td>";
									echo "<td>" . $row['UserID'] . "</td>";
								echo "</tr>";
							}
							echo "</table>";
							//Free result set
							mysqli_free_result($result);
						} else {
							echo "Your query was not found.";
						}
					} else {
						echo "ERROR: Could not execute $sql. " . mysqli_error($link);
					}

					//Closing connection
					mysqli_close($link);
					?>
				</div>
			</div>
		
			<div class="row">
				<div class="box">
					<h2 class="intro-text text-center">
					Make a new entry
					</h2>
					<hr class="line">
					<br>
					<p>Under construction</p>
				</div>
			</div>
		</div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>