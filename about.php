<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>About | postr</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
	</head>
	<body>

	<?php include('header.php'); ?>
	<br />
	<div id="container" style="width: 900px; display: block; margin: 0 auto; padding-left: 50px; text-align: left">
		<hr style="background-color: #eee">
		<h1 style="margin-bottom:2px">About</h2>
		<hr style="background-color: #eee; width: 400px; height: 5px; margin: 0 0">
		<p>postr is a temporary social media site that was created for CIS4301 at the University of Florida during the Spring 2014 semester. The goal of postr is, by limiting each user to one post, to create an experience that forces users to only post important things and allows users to see what others thing is important.</p>
		<br />
		<h2 style="margin-bottom:2px">Tech Stack</h2>
		<hr style="background-color: #eee; width: 300px; margin: 0 0;">
		<p>To deliver our users the best experience, we use the following to power postr:
		<ul>
			<li>Ubuntu Server 12.04 LTS</li>
			<li>nginx</li>
			<li>php-fpm</li>
			<li>PostgreSQL</li>
			<li>OpenSSL</li>
		</ul>
		<h2 style="margin-bottom:2px">Team</h2>
		<hr style="background-color: #eee; width: 300px; margin: 0 0;">
		<p>postr has only the best! This is the team that twerks (... I mean works...) around the clock to make sure that postr is up and running:</p>
		<div id="postr_team">
			<div id="andrew">
				<img src="https://fbcdn-sphotos-f-a.akamaihd.net/hphotos-ak-frc1/t31.0-8/906409_4889969602599_760274327_o.jpg">
				<h3><a href="http://www.andrewjkerr.com">Andrew Kerr (@andrew)</a><h3>
				<p>sysadmin guru, php wizard, and ui master</p>
			</div>
			<div id="andres">
				<img src="https://i.imgur.com/oYxPAYk.png">
				<h3><a href="https://www.akerr.me/post.php?username=andres">Andres Hernandez (@andres)</a><h3>
				<p>php wizard</p>
			</div>
			<div id="omeed">
				<img src="https://scontent-a-iad.xx.fbcdn.net/hphotos-frc3/t1.0-9/10001528_618938044826369_1470922998_n.jpg">
				<h3><a href="https://www.akerr.me/post.php?username=omeed">Omeed Familie (@omeed)</a><h3>
				<p>ui master</p>
			</div>
			<div id="sam">
				<img src="https://scontent-b-iad.xx.fbcdn.net/hphotos-frc3/t1.0-9/1661037_10151952175275881_434514589_n.jpg">
				<h3><a href="http://www.akerr.me/post.php?username=samuel">Samuel Lin (@samuel)</a><h3>
				<p>ui master</p>
			</div>
		</div>
	</div>
	</body>
</html>