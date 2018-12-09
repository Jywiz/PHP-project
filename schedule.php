<!DOCTYPE html>

<?php
//Forming connection to DB
include "connection.php";

//Starting session
session_start();

//If user is not logged in, redirecting them to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: login.php");
	exit;
}

?>

<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width = device-width, initial-scale = 1.0">

		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<title>Easy Schedules</title>
		<style type="text/css">
			table 
			{
				border-collapse: collapse;
				width: 100%
				color: #AA8C66;
				font-family: Helvetica,Arial,sans-serif;
				font-size: 25px;
				text-align: left;
			}
			
			th 
			{
				background-color: grey;
				color: black;
			}
			
			tr:nth-child(even)
			{
				background-color: #f2f2f2
			}
		</style>
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
					Your Appointments
					</h2>
					<hr class="line">
					
					<table>
					<?php  
					
					
					// Attempting query selection
					$sql = "SELECT * FROM `appointment`";
					if($result = mysqli_query($link, $sql)) {
						if(mysqli_num_rows($result) > 0) {
							//if succesfull, echoing the table titles and data
							echo "<table>";
								echo "<tr>";
									echo "<th>title</th>";
									echo "<th>date</th>";
								echo "<tr>";
							while($row = mysqli_fetch_array($result)){
								echo "<tr>";
									echo "<td>" . $row['title'] . "</td>";
									echo "<td>" . $row['date'] . "</td>";
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

					
					?>
					</table>
				</div>
			</div>
		
			<div class="row">
				<div class="box">
					<h2 class="intro-text text-center">
					Make a new entry
					</h2>
					<hr class="line">
					<br>
					<?php
						
						//Setting empty values to title and date
						$title = $date = "";
						$title_err = $date_err = "";
					
						//Processing form data
						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
							
							//Title validation
							if(empty(trim($_POST["title"]))) {
								$title_err = "Enter a title please.";
							} else {
								$title = trim($_POST["title"]);
							}
							
							//Date validation
							$time = strtotime($_POST["date"]);
							if($time) {
								$date = date("Y-m-d", $time);
							} else {
								$date_err = "Enter a date please.";
							}
							
							//Last check for input errors before inserting data to DB
							if(empty($title_err) && empty($date_err)) {
								
								//insert statement
								$sql = "INSERT INTO appointment (title, date) VALUES (?, ?)";
								
								//Prepared statement
								if($stmt = mysqli_prepare($link, $sql)) {
									//Prepare statement parameters
									mysqli_stmt_bind_param($stmt, "ss", $param_title, $param_date);
									
									//Setting parameters
									$param_title = $title;
									$param_date = $date;
									
									//Executing prepared statement
									if(mysqli_stmt_execute($stmt)) {
										//Keeping user in schedule page
										header("location: index.php");
										exit();
									} else {
										echo "Something went wrong with sending data to the server, try again later.";
									}
								}
								
								//Closing statement
								mysqli_stmt_close($stmt);
							}
							
							//Closing connection
							mysqli_close($link);
						}
							
					
					?>
					<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
						
						<div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
							Title:<br>
							<input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
							<span class="help-block"><?php echo $title_err; ?></span>
						</div>
						
						<div class="form-group <?php echo (!empty($date_err)) ? 'has-error' : ''; ?>">
							Date:<br>
							<input type="date" name="date" class="form-control" value="<?php echo date("Y-m-d"); ?>">
							<span class="help-block"><?php echo $date_err; ?></span>
						</div>
						
						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Submit">
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