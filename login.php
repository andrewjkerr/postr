<?php

	include('connect.php');
	
	// Set variables from post
	// **TO-DO**: SANITIZE AND VERIFY
	$username = $_POST['email'];
	
	$query = pg_prepare($conn, "login", 'SELECT * FROM users WHERE email = $1 OR username = $1');
	
	$result = pg_execute($conn, "login", array($username));
	$arr = pg_fetch_all($result);
	
	// **TO-DO**: Set flow and create errors
	if ( $result && crypt($_POST['password'], $arr[0]['password_hash']) == $arr[0]['password_hash'] ) {
		
		$_SESSION['uid'] = $arr[0]['uid'];
		echo '<p>Login successful!';
		
	} else {
		echo '<p>Incorrect login!';
	}
	
?>