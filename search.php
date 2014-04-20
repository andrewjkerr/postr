<!DOCTYPE html>


<html>
<head>
	
	<title>Search | postr</title>

	<link rel="stylesheet" type="text/css" href="style.css"/>
	
	<style>
	#email {
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
	}
	</style>

</head>
<body>
	<!-- Include header -->
	<?php include('header.php'); ?>
	<h1>Search for a user by email:</h1>
	<form action="search.php" method="POST">
		<p><input type="text" id="email" name="email" placeholder="Email"/>
		<p><input type="submit" id="search_button" text="Search" />
	</form>
	
	

</body>
</html>
