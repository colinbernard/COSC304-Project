<!DOCTYPE html>
<html>
<head>
<title>Login - 2Kyle16</title>
</head>
<body>

<h1>Login</h1>
<form action="home.html">
	<input type="submit" value="Home" />
</form>
<p></p>
<form method="get" action="login.php">
	Username <input type="text" name="username" size="15">
	Password <input type="password" name="password" size="15">
	<input type="submit" value="Login">
</form>
<p></p>
<form action="createacc.php">
	<input type="submit" value="Create Account" />
</form>

<?php
	error_reporting(-1); // report all PHP errors 
	ini_set('display_errors', 1);
	
	if(!empty($_GET["username"]) && !empty($_GET["password"])) {
		/* Read in parameters */
		$username = $_GET["username"];
		$password = $_GET["password"];
		
		$query = "SELECT cid FROM AccountHolder WHERE username = ? AND password = ?";
		
		// connection information
		$server = "cosc304.ok.ubc.ca";
		$uid = "group6";
		$pw = "group6";
		$db = "db_group6";
		
		// connect
		$conn = new mysqli($server, $uid, $pw, $db);
		
		// check connection
		if($conn->connect_error)
			echo "Failed to connect to server: " . $conn->connect_error;
		
		$stmt = $conn->stmt_init();
		if(!$stmt->prepare($query)) {
			echo "Failed to prepare statement.";
		} else {
			$stmt->bind_param("ss", $username, $password); // bind params
			$stmt->execute(); // execute the statement
			$stmt->bind_result($cid); // bind result variable
			
			/* Query should only return 1 row if the username and password are correct. */
			$count = 0;
			while($stmt->fetch()) {
				$count++;
			}
			
			if($count == 1) {
				header("location: welcome.html"); // redirect browser to welcome page
			} else {
				echo "Your Username or Password is invalid.";
			}
		}
		$stmt->close();
		$conn->close();
		
		/*******************TODO: add code to check if user is an admin ***************/
		
		
	} else { // if the user provided no input
		echo "Please input a username and password.";
	}
	

?>

</body>
</html>