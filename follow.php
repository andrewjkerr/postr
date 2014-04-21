<?php session_start();
?>
<html>
<head>
	<title>Follow | postr</title>
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
	$uid = $_GET['uid'];
	$uid1 = $_SESSION['uid'];
	$username = $_GET['username'];
	if(!isset($_GET['uid']) || !isset($_GET['username'])){
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
	$query = pg_prepare($conn, "checkiffollow", 'SELECT * FROM follows WHERE follow_uid = $1 AND follower_uid = $2');
	$result = pg_execute($conn, "checkiffollow", array($uid, $uid1)) or die("error with #1");
	$arr = pg_fetch_all($result);
	$rows = pg_num_rows($result);
	if($rows >= 1){
		$query = pg_prepare($conn, "unfollow", 'DELETE FROM follows WHERE follow_uid = $1 AND follower_uid = $2');
		$result = pg_execute($conn, "unfollow", array($uid, $uid1)) or die("error with #2");
		echo '<br />
		  <br />
		  <h2>@' . $_GET['username'] . ' has been unfollowed!</h2>';
		echo '<META HTTP-EQUIV="Refresh" Content="2; URL=post.php?username=' . $_GET['username'] . '">';
	}
	else{
		$query = pg_prepare($conn, "follow", 'INSERT INTO follows (follow_uid, follower_uid) VALUES($1, $2)');
		$result = pg_execute($conn, "follow", array($uid, $uid1)) or die("error with #3");
		echo '<br />
		  <br />
		  <h2>@' . $_GET['username'] . ' has been followed!</h2>';
		echo '<META HTTP-EQUIV="Refresh" Content="2; URL=post.php?username=' . $_GET['username'] . '">';
	}

?>
	</div>
</body>
</html>