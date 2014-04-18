<?php

	include('connect.php');
	
	// Set variables from post
	// **TO-DO**: SANITIZE AND VERIFY
	$username = $_POST['username'];
	$email = $_POST['email'];
	
	// Check to see whether the user already exists
	$checkQuery = pg_prepare($conn, "register_check", 'SELECT email FROM users WHERE email = $1 or username = $2');
	
	$result = pg_execute($conn, "register_check", array($email, $username)) or die("Database error!");
	$arr = pg_fetch_all($result);
	
	if (strcmp($email, $arr[0]['email']) == 0) {
		
		// **TO-DO**: Implement error
		//echo '<META HTTP-EQUIV="Refresh" Content="1; URL=index.php#error2">';
		echo 'HEY someone already exists!';
		
	} else {
		
		$query = pg_prepare($conn, "register", 'INSERT INTO users (username, email, password_hash) VALUES ($1, $2, $3)');
		$password = crypt($_POST['password']);
		$result = pg_execute($conn, "register", array($username, $email, $password)) or die('Registration error! Please try again.');
		echo '<p>Registration successful!</p>';
		echo '<META HTTP-EQUIV="Refresh" Content="1; URL=login.html">';
		
	}
	
?>