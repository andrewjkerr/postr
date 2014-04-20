<?php session_start(); ?>
<html>
<head>
	<title>New Post | postr</title>
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
</head>
<body>
	<?php include('header.php'); ?>
	<br />
	<div id="container" style="width: 900px; display: block; margin: 0 auto; padding-left: 50px;">
		<hr style="background-color: #eee">
		<h2 style="text-align: left"><?php echo '@' . $_SESSION['username']; ?></h2>
	
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
			$contentType = 2;
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
		<!-- Testing Text Post -->
		<h2>Text</h2>
		<form method="post">
			<input type="hidden" name="post-type" value="text">
			<p><textarea id="text-post" name="text-post">Post anything!</textarea></p>
			<input type="submit" value="Post">
		</form>
		
		<br />
		
		<!-- Testing Image Post -->
		<!-- enctype for uploads -->
		<!--h2>Image</h2>
		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="post-type" value="image">
			<p><input type="file" name="image-post" /></p>
			<input type="submit" value="Post and Upload">
		</form-->
		
		<br />
		
		<!-- Testing Link Post -->
		<h2>Link</h2>
		<form method="post">
			<input type="hidden" name="post-type" value="link">
			<p><input type="text" name="link-post" placeholder="http://" /></p>
			<input type="submit" value="Post and Upload">
		</form>	
<?php } ?>
	</div>
</body>
</html>

