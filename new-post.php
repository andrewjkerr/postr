<?php session_start(); 
if(empty($_SESSION['username'])){
	echo '<META HTTP-EQUIV="Refresh" Content="1; URL=login.html#error1">';
	exit;
}
?>
<html>
<head>
	<title>New Post | postr</title>
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#new-post-picture").hide();
			$("#new-post-picture-header").click(function()
			{
				$("#new-post-text").hide();
				$("#new-post-picture").slideToggle(500);
			})
			$("#new-post-text-header").click(function()
			{
				$("#new-post-picture").hide();
				$("#new-post-text").slideToggle(500);
			})
		});
	</script>
</head>
<body>
	<?php include('header.php'); ?>
	<br />
	<div id="container" style="width: 900px; display: block; margin: 0 auto; padding-left: 50px;">
		<hr style="background-color: #eee">
		<h2 style="text-align: left"><?php echo '<a href="post.php?username=' . $_SESSION['username'] . '"style="color:#fff">'; ?><?php echo '@' . $_SESSION['username']; ?></a></h2>
	
<?php

if(!empty($_POST)) {

	$dummyID = $_SESSION['uid'];
	$dummyUser = $_SESSION['username'];
	
	$content;
	$contentType;

	if(empty($_POST['post-type'])) {
		showForm();
	}
	
	//Which form was submitted?
	$type = trim($_POST['post-type']);
		
	//Try to prevent people from messing with the HTML source
	//Not secure enough
	if (($type == "text" && trim($_POST['text-post'] != "")) 
		|| ($type == "image") 
		|| ($type == "link" && trim($_POST['link-post'] != "")))  {
				
		if ($type == "text") {
			$contentType = 0;
			//Sanitize
			$content = $_POST['text-post'];
			
			if (strlen($content) > 160) {
				showForm('Posts must be no more than 160 characters.');
			}
			
		}
		elseif ($type == "image") {
			$contentType = 1;
		
			//Check to see if GIF, JPEG, or PNG
			//File must be below 10 MB
			$mime = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif');
 
            if (!isset($_FILES['image-post']) || ($_FILES['image-post']['error'] !== UPLOAD_ERR_OK) || $_FILES['image-post']['size'] > 10485760 || (in_array($_FILES['image-post']['type'], $mime) != TRUE)) {
				//Bad upload. Try again
				showForm('A picture must be uploaded that is below 10MB.');
            }	
			
			//To-Do
			//Create file path to store in DB ($content)
			//Upload file onto server
			$content = 'Desktop/image.png';
		}
		else {
			$contentType = 1;
			//Sanitize
			$content = $_POST['link-post'];
		}

		$postExists = false;
		
		try {
			$connection = new PDO('pgsql:host=akerr.me;dbname=postr_dev', 'postgres', '@NDR0!D');
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
			//Check to see if user has an existing post
			$stmt = $connection->prepare('SELECT * FROM posts WHERE uid = ?');
			$stmt->bindParam(1, $dummyID, PDO::PARAM_INT);
			$stmt->execute();
				
			$result = $stmt->fetchAll();
			if (count($result) == 1) {
				$postExists = true;
			}
				
			//UPDATE OLD POST
			if ($postExists) {
				$timeStamp = date('Y-m-d H:i:s');
				$stmt = $connection->prepare('UPDATE posts SET date = ?, content_type = ?, content = ? WHERE uid = ?');
				$stmt->bindParam(1, $timeStamp, PDO::PARAM_STR);
				$stmt->bindParam(2, $contentType, PDO::PARAM_STR);
				$stmt->bindParam(3, $content, PDO::PARAM_STR);
				$stmt->bindParam(4, $dummyID, PDO::PARAM_INT);
				$stmt->execute();
					
				if ($stmt->rowCount() == 1) {
					showForm('Posted!');
				}
				else {
					showForm('Post failed. Please try again.');
				}
			}
			//INSERT NEW POST
			else {
				$timeStamp = date('Y-m-d H:i:s');
				$stmt = $connection->prepare('INSERT INTO posts (uid, date, content_type, content) VALUES (?,?,?,?)');
				$stmt->bindParam(1, $dummyID, PDO::PARAM_INT);
				$stmt->bindParam(2, $timeStamp, PDO::PARAM_STR);
				$stmt->bindParam(3, $contentType, PDO::PARAM_STR);
				$stmt->bindParam(4, $content, PDO::PARAM_INT);
				$stmt->execute();
					
				if ($stmt->rowCount() == 1) {
					showForm('Posted!');
				}
				else {
					showForm('Post failed. Please try again.');
				}
			}	
		} catch (PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
			showForm();
		}
	}
	else {
		showForm();
	}
}
else {
	showForm();
}

function showForm($message="") {

	if ($message != "") {
		echo $message;
	}

?>
		<h1 style="margin-bottom: 50px">Create New Post</h1>
		<div id="new-post-buttons">
			<div id="new-post-text-header">TEXT</div><div id="new-post-picture-header">PICTURE</div>	
		</div>
		<form method="post" id="new-post-text">
			<input type="hidden" name="post-type" value="text">
			<p><textarea id="text-post" name="text-post" cols=40 rows=5 placeholder="Post anything - limited to 160 characters!"></textarea></p>
			<input type="submit" class="post_button" value="Post">
		</form>
		<form method="post" id="new-post-picture">
			<input type="hidden" name="post-type" value="link">
			<p>Need to host an image? Try <a href="https://imgur.com/">imgur!</a></p>
			<p><input type="text" name="link-post" placeholder="http://" /></p>
			<input type="submit" class="post_button"value="Post">
		</form>
<?php } ?>
	</div>
</body>
</html>

