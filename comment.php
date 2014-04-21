<?php session_start();
?>
<html>
<head>
	<title>Comment | postr</title>
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
	session_start();
	
	// Currently GET requests for debugging
	$pid = $_GET['pid'];
	$username = $_GET['username'];
	$comment = $_POST['comment'];
	if(!isset($_GET['pid']) || !isset($_GET['username']) || !isset($_POST['comment'])){
		echo '<br />
		  <br />
		  <h2>Error! Redirecting you...</h2>';
  		if(!isset($_GET['username'])){
  			echo '<META HTTP-EQUIV="Refresh" Content="2; URL=search.php">';
  		}
  		else{
  			echo '<META HTTP-EQUIV="Refresh" Content="2; URL=post.php?username=' . $_GET['username'] . '">';
  		}
		exit;
	}
	$uid1 = $_SESSION['uid'];
	$query = pg_prepare($conn, "comment", 'INSERT INTO comments (pid, comment_uid, comment) VALUES ($1, $2, $3)');
	$result = pg_execute($conn, "comment", array($pid, $uid1, $comment)) or die("error with query");
	echo '<br />
	  <br />
	  <h2>Your comment has been submitted!</h2>';
	echo '<META HTTP-EQUIV="Refresh" Content="2; URL=post.php?username=' . $_GET['username'] . '">';

?>
	</div>
</body>
</html>