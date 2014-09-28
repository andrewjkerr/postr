<?php

	session_start(); 

	// Connection variables - change me!
	$host = "localhost";
	$port = 3306;
	$dbname = "postr";
	$user = "postgres";
	$pass = "passw0rd";

	// Connect to MySQL. Don't edit this stuff!
	$conn = mysqli_connect($host, $user, $pass, $dbname) or die("Could not connect.");

?>