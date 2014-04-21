<?php
	session_start();
	include('connect.php');
	$uid = $_GET['uid'];
	if(!isset($_GET['uid'])){
		echo 'ERROR!';
		exit;
	}
	$query = pg_prepare($conn, "get_feed", 'SELECT * FROM users_posts WHERE uid IN (SELECT uid FROM users, follows WHERE follower_uid = $1  AND uid = follow_uid) ORDER BY date DESC');
	$result = pg_execute($conn, "get_feed", array($uid));
	$arr = pg_fetch_all($result);
	if(pg_num_rows($result) == 0) {
		echo "noposts";
	}
	else {
		echo json_encode($arr);
	}
?>