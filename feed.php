<?php session_start(); 
include('connect.php');
if(empty($_SESSION['username'])){
	echo '<META HTTP-EQUIV="Refresh" Content="1; URL=login.html#error1">';
	exit;
}
?>
<!DOCTYPE html>


<html>
<head>
<title>My Feed | postr</title>


<link rel="stylesheet" type="text/css" href="style.css">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">

</head>
<body>

	<?php include('header.php'); ?>
	
	<br />
	<div id="container" style="width: 900px; display: block; margin: 0 auto; padding-left: 50px;">
		<hr style="background-color: #eee">
		
		<div id="feed_top">
			<div class="row">
				<div class="floatedCellUsername" style="font-size: 24px">@<?php echo $_SESSION['username'] ?></div>
				<?php
				$uid = $_SESSION['uid'];
				// Query DB and fetch result
				$query = pg_prepare($conn, "numfollowers", 'SELECT * FROM follows WHERE follows.follow_uid = $1');
				$result = pg_execute($conn, "numfollowers", array($uid));
				$arr = pg_fetch_all($result);
				$numFollowers = count($arr);
				echo '<div class="floatedCellFollowers" style="font-size: 24px">Followers: ' . $numFollowers . '</div>';
				$query = pg_prepare($conn, "numfollowing", 'SELECT * FROM follows WHERE follows.follower_uid = $1');
				$result = pg_execute($conn, "numfollowing", array($uid));
				$arr = pg_fetch_all($result);
				$numFollowing = count($arr);
				echo '<div class="floatedCellFollowing" style="font-size: 24px">Following: ' . $numFollowing . '</div>';	
				?>
				<div class="floatedCellNewPost"><a href="new-post.php" class="myButton" style="width: 80px; float:right; margin-top: -5px">NEW POST</a></div>
				<div class="clear"></div>
			</div>
		</div>
	
		<div id="feed">
			<h1>Posts</h1>
			<div class="row">
				<div class="floatedCellUsername"><a href="post.php?username=sam">@Sam</a></div>
				<div class="floatedCellPost"><img src="http://placehold.it/250x250" /></div>
				<div class="clear"></div>
			</div>
			<div class="button_row">
				<div class="floatedCellUsername"></div>
				<div class="buttons" style="margin-left: 290px">
					<a class="myButton" style="width: 30px; padding: 5px 10px">LIKE</a>
					<a class="myButton" style="width: 100px; margin-left: 15px; padding: 5px 10px">COMMENT</a>
				</div>
			</div>
			<div class="row">
				<div class="floatedCellUsername"><a href="post.php?username=andres">@Andres</a></div>
				<div class="floatedCellPost">Ugh, work again!</div>
				<div class="clear"></div>
			</div>
			<div class="button_row">
				<div class="floatedCellUsername"></div>
				<div class="buttons" style="margin-left: 290px">
					<a class="myButton" style="width: 30px; padding: 5px 10px">LIKE</a>
					<a class="myButton" style="width: 100px; margin-left: 15px; padding: 5px 10px">COMMENT</a>
				</div>
			</div>
			<div class="row">
				<div class="floatedCellUsername"><a href="post.php?username=grant">@Grant</a></div>
				<div class="floatedCellPost">I'm definitely giving postr a 100%!</div>
				<div class="clear"></div>
			</div>
			<div class="button_row">
				<div class="floatedCellUsername"></div>
				<div class="buttons" style="margin-left: 290px">
					<a class="myButton" style="width: 30px; padding: 5px 10px">LIKE</a>
					<a class="myButton" style="width: 100px; margin-left: 15px; padding: 5px 10px">COMMENT</a>
				</div>
			</div>
			<div class="row">
				<div class="floatedCellUsername"><a href="post.php?username=grant">@reallyobnoxiouslylongusername</a></div>
				<div class="floatedCellPost">This is a really really really really really really really really really really really long sentence.</div>
				<div class="clear"></div>
			</div>
			<div class="button_row">
				<div class="floatedCellUsername"></div>
				<div class="buttons" style="margin-left: 290px">
					<a class="myButton" style="width: 30px; padding: 5px 10px">LIKE</a>
					<a class="myButton" style="width: 100px; margin-left: 15px; padding: 5px 10px">COMMENT</a>
				</div>
			</div>
		</div>

	</div>
</body>
</html>