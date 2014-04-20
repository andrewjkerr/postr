<?php session_start(); 
if(empty($_SESSION['username'])){
	echo '<META HTTP-EQUIV="Refresh" Content="1; URL=login.html#error1">';
	exit;
}
?>
<!DOCTYPE html>


<html>
<head>
	
	<title>Search | postr</title>

	<link rel="stylesheet" type="text/css" href="style.css"/>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	
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
	<h1>Search for a user by email/username:</h1>
	<form action="search.php" method="POST">
		<p><input type="text" id="email" name="email" placeholder="Email"/>
		<p><input type="submit" id="search_button" text="Search" />
	</form>
	<?php
		include('connect.php');
		
		if(isset($_POST['email'])){
			$search_term = $_POST['email'];
			$query = pg_prepare($conn, "search", 'SELECT * FROM users WHERE email = $1 OR username = $1');
			$result = pg_execute($conn, "search", array($search_term));
			$arr = pg_fetch_all($result);
			if(pg_num_rows($result) == 1) {
				echo '<br />
					<br />';
				echo '<h2>User found! Redirecting.</h2>';
				echo '<META HTTP-EQUIV="Refresh" Content="2; URL=post.php?username=' . $arr[0]['username'] . '">';
			}
			else {
				echo '<br />';
				echo '<h2>User not found! Please try again.</h2>';
			}
		}
	?>
</body>
</html>
