<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>@<?php echo $_SESSION['username']; ?> | postr</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

<?php include('header.php'); ?>
<br />
 
<!-- BEGIN: Page Content -->
<div id="content" style="width: 900px; display: block; margin: 0 auto; padding-left: 50px;">
	<hr style="background-color: #eee">
	<a class="myButton" style="float: right; margin-right: 25px; margin-top: 25px">FOLLOW</a>
	<h2 style="width: 200px; font-size: 36px; text-align: left">@<?php echo $_SESSION['username']; ?></h2>
	<br />
	<div id="post"> First post on postr! I'm glad I am creating this for Databases! (not)</div>
	<a class="myButton" style="width: 30px; float: left">LIKE</a>
	<div id="likes">
		1 like
		<p style="margin: 0">0 comments</p>
	</div>
	<div id="comments">
		<h2><u>Comments</u></h2>
		<div class="row">
			<div class="floatedCellUsername">@jack: </div>
			<div class="floatedCellComment">This is a really really really really really really really really really really really long sentence.</div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="floatedCellUsername">@reallyobnoxiouslylongusername: </div>
			<div class="floatedCellComment">This is a short sentence.</div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="floatedCellUsername">@bobbytables: </div>
			<div class="floatedCellComment">Lol, SQL injection EVERYWHERE!</div>
			<div class="clear"></div>
		</div>
		<p>Add comment:</p>
		<form action="submit_comment.php" method="POST">
			<p><textarea name="comments" cols="50" rows="5" id="comment-box" name="comment">
			</textarea></p>
			<p><input class="myButton" type="submit" value="ADD COMMENT" style="width: 150px"></div></p>
		</form>
	</div>
</div>
<!-- END: Page Content -->



</body>
</html>