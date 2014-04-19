<html>
<head>
	<title>Sign Up | postr</title>
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
		  <h2>Processing registration...</h2>';
	
	// The following functions come from: http://css-tricks.com/snippets/php/sanitize-database-inputs/
	function cleanInput($input) {

		$search = array(
		'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
		'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
		);

		$output = preg_replace($search, '', $input);
		return $output;
		
	}
	
	function sanitize($input) {
	    if (is_array($input)) {
	        foreach($input as $var=>$val) {
	            $output[$var] = sanitize($val);
	        }
	    }
	    else {
	        if (get_magic_quotes_gpc()) {
	            $input = stripslashes($input);
	        }
	        $temp = cleanInput($input);
			$output = $temp;
	    }
	    return $output;
	}
	
	// Sanitize!
	$_POST = sanitize($_POST);
	
	if (isset($_POST['email']) || isset($_POST['username']) | isset($_POST['password'])) {
		if (empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password'])) {
			echo '<META HTTP-EQUIV="Refresh" Content="1; URL=index.html#error-input-missing">';
			exit;
		}
	}
	
	// Set variables from post
	$username = $_POST['username'];
	$email = $_POST['email'];
	
	// Check for email
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	   	echo '<META HTTP-EQUIV="Refresh" Content="1; URL=index.html#error-email">';
		exit();
	}
	
	if(strlen($email) > 30){
	   	echo '<META HTTP-EQUIV="Refresh" Content="1; URL=index.html#error-username">';
		exit();
	}
	
	// Check to see whether the user already exists
	$checkQuery = pg_prepare($conn, "register_check", 'SELECT email FROM users WHERE email = $1 or username = $2');
	
	$result = pg_execute($conn, "register_check", array($email, $username)) or die("Database error!");
	$arr = pg_fetch_all($result);
	
	if (strcmp($email, $arr[0]['email']) == 0) {
		echo '<META HTTP-EQUIV="Refresh" Content="1; URL=index.html#error-email-exists">';
	} else {
		
		$query = pg_prepare($conn, "register", 'INSERT INTO users (username, email, password_hash) VALUES ($1, $2, $3)');
		$password = crypt($_POST['password']);
		$result = pg_execute($conn, "register", array($username, $email, $password)) or die('Registration error! Please try again.');
		// Forward to login
		echo '<br />
		  <br />
		  <h2>Registration successful - please login!</h2>';
		echo '<META HTTP-EQUIV="Refresh" Content="1; URL=login.html">';
		
	}
?>
	</div>
</body>
</html>