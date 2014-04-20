<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>@<?php echo $_GET['username']; ?> | postr</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
	</head>
	<body>

<?php include('header.php'); ?>
<br />
<?php
	$username;

	if(!empty($_GET['username'])) {
		//sanitize please
		$username = $_GET['username'];
		
		$connection = new PDO('pgsql:host=akerr.me;dbname=postr_dev', 'postgres', '@NDR0!D');
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
		//Check to see if user exists
		$stmt = $connection->prepare('SELECT * FROM users WHERE username = ?');
		$stmt->bindParam(1, $username, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		
		//User does not exist, redirect
		if ($stmt->rowCount() != 1) {
			echo '<META HTTP-EQUIV="Refresh" Content="1; URL=search.php">';
			exit;
		}
		
		$uid = 0;
		foreach ($result as $row) {
			$uid = $row['uid'];
		}
		
		//Check to see if they have a post
		$stmt = $connection->prepare('SELECT * FROM posts WHERE uid = ?');
		$stmt->bindParam(1, $uid, PDO::PARAM_INT);
		$stmt->execute();
		$post = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		//Post does not exist, redirect
		if ($stmt->rowCount() != 1) {
			echo '<META HTTP-EQUIV="Refresh" Content="1; URL=search.php">';
			exit;
		}
		
		$pid = 0;
		$content = "";
		foreach ($post as $row) {
			$pid = $row['pid'];
			$content = $row['content'];
		}
			
		//Count how many likes this post has
		$stmt = $connection->prepare('SELECT * FROM likes WHERE pid = ?');
		$stmt->bindParam(1, $pid, PDO::PARAM_INT);
		$stmt->execute();
		
		$likes = $stmt->rowCount();
		
		//Count how many comments this post has
		$stmt = $connection->prepare('SELECT * FROM comments, users WHERE pid=? AND uid=comment_uid');
		$stmt->bindParam(1, $pid, PDO::PARAM_INT);
		$stmt->execute();
		
		$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$commentCount = $stmt->rowCount();
		
		showContent($pid, $content, $likes, $commentCount, $comments, $uid);
	}
	else {
		echo '<META HTTP-EQUIV="Refresh" Content="1; URL=search.php">';
		exit;
	}
	
function showContent($pid, $post, $likes, $commentCount, $comments, $uid) {
?>
	<!-- BEGIN: Page Content -->
	<div id="content" style="width: 900px; display: block; margin: 0 auto; padding-left: 50px;">
		<hr style="background-color: #eee">
		<?php echo '<a href="follow.php?uid=' . $uid . '&uid1=' . $_SESSION['uid'] . '&username=' . $_GET['username'] . '" class="myButton" style="float: right; margin-right: 25px; margin-top: 25px">';?>FOLLOW</a>
		<h2 style="width: 200px; font-size: 36px; text-align: left">@<?php echo $_GET['username']; ?></h2>
		<br />
		<div id="post"><?php echo $post;?></div>
		<?php echo '<a href="like.php?pid=' . $pid . '&uid1=' . $_SESSION['uid'] . '&username=' . $_GET['username'] . '" class="myButton" style="width: 30px; float: left">' ?>LIKE</a>
		<div id="likes">
			<?php echo "{$likes} likes"; ?>
			<p style="margin: 0"><?php echo "{$commentCount} comments";?></p>
		</div>
		<div id="comments">
			<h2><u>Comments</u></h2>
			<?php
				foreach($comments as $comment) {
					echo '<div class="row">';
					echo 	'<div class="floatedCellUsername">' .$comment['username']. '</div>';
					echo 	'<div class="floatedCellComment">' .$comment['comment']. '</div>';
					echo 	'<div class="clear"></div>';
					echo '</div>';
				}
			?>
			<p>Add comment:</p>
			<?php echo '<form action="comment.php?pid='. $pid . '&uid1=' . $_SESSION['uid'] . '&username=' . $_GET['username'] . '" method="POST">' ?>
				<p><textarea cols="50" rows="5" id="comment-box" name="comment"></textarea></p>
				<p><input class="myButton" type="submit" value="ADD COMMENT" style="width: 150px"></div></p>
			</form>
		</div>
	</div>
	<!-- END: Page Content -->
<?php } ?>
	</body>
</html>