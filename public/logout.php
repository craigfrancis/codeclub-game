<?php

	require_once('../private/config.php');

	$_SESSION['account_id'] = 0;

?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
	<meta charset="UTF-8" />
	<title>Code Club Game</title>
	<link rel="stylesheet" type="text/css" href="/a/css/core.css" />
	<script src="/a/js/main.js" async="async"></script>
</head>
<body>

	<h1>Logout</h1>

	<p>You have successfully logged out.</p>

	<p>Would you like to <a href="./login.php">Login Again</a>, or <a href="./register.php">Register a New Account</a>?</p>

</body>
</html>