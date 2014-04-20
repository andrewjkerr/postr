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

session_start();

session_destroy();
echo '<h1>Logging you out. See you soon!</h1>';
echo '<META HTTP-EQUIV="Refresh" Content="1; URL=index.html">';
?>