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
			<?php
				$url = "http://akerr.me/postr/get-feed.php?uid=" . $_SESSION['uid'];
				$json = file_get_contents($url);
				$obj = json_decode($json);
				if(isset($_GET['page'])) {
					$page = $_GET['page'];
					$page = $page * 10;
					if($page + 10 < count($obj)){
						$end = count($obj) % $page;
					}
					else{
						$end = $page + 10;
					}
				}
				else {
					$page = 0;
					$end = count($obj);
				}
				for($i = $page; $i < $end; $i++){
					echo '<div class="row">
						<div class="floatedCellUsername"><a href="post.php?username='. $obj[$i]->username . '">@' . $obj[$i]->username . '</a></div>';
					if($obj[$i]->content_type == 1) {
						echo '<div class="floatedCellPost"><img src="' . $obj[$i]->content . '" style="width: 250px; height: 250px" /></div>';
					}
					else{
						echo '<div class="floatedCellPost">' . $obj[$i]->content . '</div>';
					}
					echo '<div class="clear"></div>
					</div>
					<div class="button_row">
						<div class="floatedCellUsername"></div>
						<div class="buttons" style="margin-left: 290px">
							<a class="myButton" style="width: 30px; padding: 5px 10px">LIKE</a>
							<a class="myButton" style="width: 100px; margin-left: 15px; padding: 5px 10px">COMMENT</a>
						</div>
					</div>';
				}
			?>
		</div>

	</div>
</body>
</html>