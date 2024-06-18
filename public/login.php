<?php

//--------------------------------------------------
// Config

	require_once('../private/config.php');

	$action = trim($_POST['action'] ?? '');

	$username = trim($_POST['username'] ?? '');
	$password = trim($_POST['password'] ?? '');

	if ($username == '') {
		$username = trim($_GET['username'] ?? '');
	}

//--------------------------------------------------
// Perform Login

	if ($action === 'Login') {

		//--------------------------------------------------
		// Check username

			$account_id = 0;
			$password_hash = NULL;

			if ($username === '') {

				$errors[] = 'Please provide your username.';

			} else {

				$sql = 'SELECT
							id,
							password_hash
						FROM
							world_account
						WHERE
							username = ? AND
							deleted = "0000-00-00 00:00:00"';

				$result = $db->execute_query($sql, [
						$username,
					]);

				if ($row = $result->fetch_assoc()) {

					$account_id = $row['id'];
					$password_hash = $row['password_hash'];

				} else {

					$errors[] = 'The username "' . $username . '" does not exist.';

				}

			}

		//--------------------------------------------------
		// Check password

			if ($password === '') {

				$errors[] = 'Please provide your password.';

			} else if ($password_hash !== NULL && password_verify($password, $password_hash) !== true) {

				$errors[] = 'Your password is wrong.';

			}

		//--------------------------------------------------
		// Register

			if (count($errors) == 0) {

				if (password_needs_rehash($password_hash, PASSWORD_DEFAULT)) {

					$password_hash = password_hash($password, PASSWORD_DEFAULT);

					$sql = 'UPDATE
								world_account
							SET
								password_hash = ?
							WHERE
								id = ? AND
								deleted = "0000-00-00 00:00:00"';

					$db->execute_query($sql,[
							$password_hash,
							$account_id,
						]);

				}

				$_SESSION['account_id'] = $account_id;

				// header('Location: ./', true, 302);
				// exit();

				echo '
					<p>You have logged in as <strong>' . html($username) . '</strong></p>
					<p><a href="./">Begin Game</a></p>';

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

	<h1>Login</h1>

	<form action="./login.php" method="post">

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
			<label for="password">Password</label>
			<input type="password" name="password" id="password" value="<?= html($password) ?>" />
		</div>

		<input type="submit" name="action" value="Login" />

	</form>

</body>
</html>