<html>
<head>
	<title>Login | postr</title>
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
</head>
<body>
	<div id="content">
		<header>
			<h1>postr</h1>
			<p>Social media - one post at a time.</p>
		</header>
<?php

	include('connect.php');
	
	echo '<br />
		  <br />
		  <h2>Processing login...</h2>';
	
	// Set variable from post
	$username = $_POST['email'];
	
	// Query DB and fetch result
	$query = pg_prepare($conn, "login", 'SELECT * FROM users WHERE email = $1 OR username = $1');
	
	$result = pg_execute($conn, "login", array($username));
	$arr = pg_fetch_all($result);
	
	// **TO-DO**: Set flow and create errors
	if ( $result && crypt($_POST['password'], $arr[0]['password_hash']) == $arr[0]['password_hash'] ) {
		
		$_SESSION['uid'] = $arr[0]['uid'];
		// Forward to feed when feed is done!
		echo '<br />
		  <br />
		  <h2>Login successful!</h2>';
		
	} else {
		echo '<META HTTP-EQUIV="Refresh" Content="1; URL=login.html#error">';
	}
	
?>
	</div>
</body>
</html>