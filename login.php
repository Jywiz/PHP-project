<?php
	
	//Starting a session
	session_start();
	
	
	//If user is already logged in, they are directed to main page
	if(isset($_SESSION["username"]))
	{
		header("location: index.php");
		exit;
	}
	
	//Including connection file
	require_once "connection.php";
	
	//Making variables with empty values for user username and password
	$username = $password = "";
	$username_err = $password_err = "";
	
	//Form data processing when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		//Checking if username field is empty
		if(empty(trim($_POST["username"]))){
			$username_err = "Please enter username.";
		} else{
			$username = trim($_POST["username"]);
		}
		
		//Check for password
		if(empty(trim($_POST["password"]))){
			$password_err = "Please enter your password.";
		} else{
			$password = trim($_POST["password"]);
		}
		
		//Validating credentials
		if(empty($username_err) && empty($password_err)){
			//Select statement
			$sql = "SELECT id, username, password FROM user WHERE username = ?";
			
			if($stmt = mysqli_prepare($link, $sql)){
				//Binding variables to prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_username);
				
				//Set parameters
				$param_username = $username;
				
				//Executing prepared statement
				if(mysqli_stmt_execute($stmt)){
					//Storing result
					mysqli_stmt_store_result($stmt);
					
					//Checking if username already exists, if so then verifying password
					if(mysqli_stmt_num_rows($stmt) == 1){
						//Binding result variables
						mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
						if(mysqli_stmt_fetch($stmt)){
							if(password_verify($password, $hashed_password)){
								//If password is correct, starting new session
								session_start();
								
								//Storing data to session variables
								$_SESSION["loggedin"] = true;
								$_SESSION["id"] = $id;
								$_SESSION["username"] = $username; 

								//Redirecting user to main page
								header("location: index.php");
							} else {
								$password_err = "The password you entered was not valid.";
								
							}
						}
					} else {
						//If username is incorrect, display an error message
						$username_err = "No account found with that username.";
					}
				} else {
					echo "Something went wrong, try again later!";
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
    <title>Easy Schedules - Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>

<body>
	<div class="wrapper">
		<h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
		
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		
		<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
		
		<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
		
		<div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
		
		<p>Don't have an account? <a href="register.php">Sign up!</a>.</p>
        </form>
	</div>		
</body>

<footer>
<?php
include "footer.php";
?>
</footer>

</html>