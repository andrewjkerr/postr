<div id = "header">
	<div id = "logo">
		<a href="feed.php" style="color:#fff">postr</a>
	</div>
	<div id = "menu">
		<?php
			if(isset($_SESSION['username'])){
				echo 'Hi <a href="post.php?username=' . $_SESSION['username'] . '">@' . $_SESSION['username'] . '</a>!';
			}
			else{
				echo 'Hi Guest! You should <a href="index.html">register</a> or <a href="login.html">login!</a>';
			}
		?>
		| <a href="feed.php">Home</a> | <a href="about.php">About</a> | <a href="search.php">Search</a> | <a href="logout.php">Logout</a>
	</div>
</div>