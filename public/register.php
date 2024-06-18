<?php

//--------------------------------------------------
// Config

	require_once('../private/config.php');

	$action = trim($_POST['action'] ?? '');

	$username = trim($_POST['username'] ?? '');
	$password_1 = trim($_POST['password_1'] ?? '');
	$password_2 = trim($_POST['password_2'] ?? '');

//--------------------------------------------------
// Perform Register

	if ($action === 'Register') {

		//--------------------------------------------------
		// Check username

			if (strlen($username) < 3) {

				$errors[] = 'Your username needs to be at least 4 characters long.';

			} else if (strlen($username) > 30) {

				$errors[] = 'Your username cannot be longer than 30 characters long.';

			} else {

				$sql = 'SELECT
							1
						FROM
							world_account
						WHERE
							username = ? AND
							deleted = "0000-00-00 00:00:00"';

				$result = $db->execute_query($sql, [
						$username,
					]);

				if ($row = $result->fetch_assoc()) {

					$errors[] = 'The username "' . $username . '" already exists.';

				}

			}

		//--------------------------------------------------
		// Check password

			if (strlen($password_1) < 6) {

				$errors[] = 'Your password needs to be at least 6 characters long.';

			} else if ($password_1 !== $password_2) {

				$errors[] = 'When repeating your password, it is not the same.';

			}

		//--------------------------------------------------
		// Register

			if (count($errors) == 0) {

				$password_hash = password_hash($password_1, PASSWORD_DEFAULT);

				$sql = 'INSERT INTO world_account (
							id,
							username,
							password_hash,
							created,
							deleted
						) VALUES (
							0,
							?,
							?,
							NOW(),
							"0000-00-00 00:00:00"
						)';

				$result = $db->execute_query($sql, [
						$username,
						$password_hash,
					]);

				$login_url = './login.php?username=' . urlencode($username);

				echo '
					<p>You have registered as <strong>' . html($username) . '</strong></p>
					<p><a href="' . html($login_url) . '">Login</a></p>';

				exit();

			}

	}

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

	<h1>Register</h1>

	<form action="./register.php" method="post">

		<?php if (count($errors) > 0) { ?>

			<ul class="error_list">

				<?php foreach ($errors as $error) { ?>

					<li><?= html($error) ?></li>

				<?php } ?>

			</ul>

		<?php } ?>

		<div>
			<label for="username">Username</label>
			<input type="text" name="username" id="username" value="<?= html($username) ?>" />
		</div>

		<div>
			<label for="password_1">Password</label>
			<input type="password" name="password_1" id="password_1" value="<?= html($password_1) ?>" />
		</div>

		<div>
			<label for="password_2">Repeat Password</label>
			<input type="password" name="password_2" id="password_2" value="<?= html($password_2) ?>" />
		</div>

		<input type="submit" name="action" value="Register" />

	</form>

</body>
</html>