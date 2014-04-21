<div id = "header">
	<div id = "logo">
		<a href="feed.php" style="color:#fff">postr</a>
	</div>
	<div id = "menu">
		Hi <?php echo '<a href="post.php?username=' . $_SESSION['username'] . '">@' . $_SESSION['username'] . '</a>!' ?> | <a href="feed.php">Home</a> | <a href="about.php">About</a> | <a href="search.php">Search</a> | <a href="logout.php">Logout</a>
	</div>
</div>