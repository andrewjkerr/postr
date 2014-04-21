<?php session_start();
?>
<html>
<head>
	<title>Like | postr</title>
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
	if(!isset($_GET['pid']) || !isset($_SESSION['uid'])){
		echo '<br />
		  <br />
		  <h2>Error! Redirecting you...</h2>';
  		if(!isset($_GET['username'])){
  			echo '<META HTTP-EQUIV="Refresh" Content="2; URL=feed.php">';
  		}
  		else{
  			echo '<META HTTP-EQUIV="Refresh" Content="2; URL=post.php?username=' . $_GET['username'] . '">';
  		}
		exit;
	}
	$uid1 = $_SESSION['uid'];
	$query = pg_prepare($conn, "checkifliked", 'SELECT * FROM likes WHERE pid = $1 AND like_uid = $2');
	$result = pg_execute($conn, "checkifliked", array($pid, $uid1)) or die("error with #1");
	$arr = pg_fetch_all($result);
	$rows = pg_num_rows($result);
	if($rows >= 1){
		$query = pg_prepare($conn, "unlike", 'DELETE FROM likes WHERE pid = $1 AND like_uid = $2');
		$result = pg_execute($conn, "unlike", array($pid, $uid1)) or die("error with #2");
		echo '<br />
		  <br />
		  <h2>You have unliked this post!</h2>';
		if(!isset($_GET['username'])){
			echo '<META HTTP-EQUIV="Refresh" Content="2; URL=feed.php">';
		}
		else{
			echo '<META HTTP-EQUIV="Refresh" Content="2; URL=post.php?username=' . $_GET['username'] . '">';
		}
	}
	else{
		$query = pg_prepare($conn, "like", 'INSERT INTO likes VALUES($1, $2)');
		$result = pg_execute($conn, "like", array($pid, $uid1)) or die("error with #3");
		echo '<br />
		  <br />
		  <h2>You have liked this post!</h2>';
  		if(!isset($_GET['username'])){
  			echo '<META HTTP-EQUIV="Refresh" Content="2; URL=feed.php">';
  		}
  		else{
  			echo '<META HTTP-EQUIV="Refresh" Content="2; URL=post.php?username=' . $_GET['username'] . '">';
  		}
	}

?>
	</div>
</body>
</html>