<?php

	//Forming Connection
	require_once "connection.php";
 
	//Defining variables for user username and password with empty values
	$username = $password = $confirm_password = "";
	$username_err = $password_err = $confirm_password_err = "";
 
	//Form data processing
	if($_SERVER["REQUEST_METHOD"] == "POST") {
 
		//username validation
		if(empty(trim($_POST["username"]))) {
			$username_err = "Please enter a valid username.";
		} else {
			//Select statement
			$sql = "SELECT id FROM user WHERE username = ?";
        
			if($stmt = mysqli_prepare($link, $sql)) {
				//Binding variables to prepared statement
				mysqli_stmt_bind_param($stmt, "s", $param_username);
            
				//Setting parameters
				$param_username = trim($_POST["username"]);
            
				//Executing prepared statement
				if(mysqli_stmt_execute($stmt)) {
					//Storing result
					mysqli_stmt_store_result($stmt);
                
					if(mysqli_stmt_num_rows($stmt) == 1) {
						$username_err = "This username is already in use!";
					} else {
						$username = trim($_POST["username"]);
					}
				} else {
					echo "Something's not quite right. Try again later!";
				}
			}
         
			//Closing statement
			mysqli_stmt_close($stmt);
		}
    
		//Validating password
		if(empty(trim($_POST["password"]))) {
			$password_err = "Enter password!";     
		} elseif(strlen(trim($_POST["password"])) < 6) {
			$password_err = "Your password must be at least 6 characters long";
		} else {
			$password = trim($_POST["password"]);
		}
    
		//Validating confirm password
		if(empty(trim($_POST["confirm_password"]))) {
			$confirm_password_err = "Please confirm password.";     
		} else {
			$confirm_password = trim($_POST["confirm_password"]);
		if(empty($password_err) && ($password != $confirm_password)) {
			$confirm_password_err = "Password did not match.";
		}
		}
    
		//Checking for input errors before inserting to DB
		if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        
			//Insert statement
			$sql = "INSERT INTO user (username, password) VALUES (?, ?)";
         
			if($stmt = mysqli_prepare($link, $sql)) {
				//Prepare statement parameters
				mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
				//Set parameters
				$param_username = $username;
				$param_password = password_hash($password, PASSWORD_DEFAULT); //Creating a password hash
            
				//Executing prepared statement
				if(mysqli_stmt_execute($stmt)) {
					//Redirecting user to login page
					header("location: login.php");
				} else {
					echo "Something went wrong with sending data to the server. Try again later!";
				}
			}
         
			//Closing statement
			mysqli_stmt_close($stmt);
		}
    
		//Closing connection
		mysqli_close($link);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Easy Schedules - Sign up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	
	<style type="text/css">
		body{ font: 14px sans-serif; }
		.wrapper{ width: 350px; padding: 20px; }
	</style>
</head>

<body>
	<div class="wrapper">
		<h2>Sign up</h2>
		<p>Please fill this form to create an account</p>
		
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
				<label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
			</div>
			
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
			
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
			
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p>Already have an account? <a href="login.php">Login!</a>.</p>
        </form>
	</div>
</body>

<footer>
<?php
include "footer.php";
?>
</footer>
</html>