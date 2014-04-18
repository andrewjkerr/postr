<?php

	session_start(); 
	
	// Connection variables - change me!
	$host = "localhost";
	$port = 5432;
	$dbname = "postgres";
	$user = "postgres";
	$pass = "passw0rd";

	// Connect to PostgreSQL. Don't edit this stuff!
	$connection_info = "host=" . $host . " port=" . $port . " dbname=" . " user=" . $user . " password=" . $pass;
	$conn = pg_connect(connection_info) or die("Could not connect.");

?>