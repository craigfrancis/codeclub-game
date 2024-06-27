<?php

//--------------------------------------------------
// Config

	require_once('../private/config.php');

	$action = trim($_POST['action'] ?? '');

//--------------------------------------------------
// Account

	// print_r($_SESSION);

	$account_id = intval($_SESSION['account_id'] ?? 0);
	$account_info = NULL;

	if ($account_id > 0) {

		$sql = 'SELECT
					username,
					last_recruit
				FROM
					world_account
				WHERE
					id = ? AND
					deleted = "0000-00-00 00:00:00"';

		$result = $db->execute_query($sql, [
				$account_id,
			]);

		$account_info = $result->fetch_assoc();

		if (!$account_info) {

			echo '
				<p>Please <a href="./login.php">Login Again</a></p>';

			exit();

		}

	} else {

		echo '
			<p>Please <a href="./login.php">Login</a> or <a href="./register.php">Register</a></p>';

		exit();


	}

//--------------------------------------------------
// Army

	$army_id = 5;

//--------------------------------------------------
// Recruit

	if ($action === 'Recruit') {

		require_once('../private/action-recruit.php');

	}

//--------------------------------------------------
// Conquer

	if ($action === 'Conquer') {

		exit('No you a bolognese eater bye bye');

	}

//--------------------------------------------------
// Current territory ownership

	$territories = [];
	$your_territories = [];

	$sql = 'SELECT
				o.territory_id,
				t.name AS territory_name,
				o.army_id,
				a.army_colour,
				a.army_name,
				o.battalions
			FROM
				world_owner AS o
			LEFT JOIN
				world_territories AS t ON t.id = o.territory_id
			LEFT JOIN
				world_army AS a ON a.id = o.army_id
			WHERE
				o.deleted = "0000-00-00 00:00:00"
			ORDER BY
				IF(o.army_id = ?, 1, 0) DESC,
				o.army_id ASC';

	$result = $db->execute_query($sql, [
			$army_id,
		]);

	while ($row = $result->fetch_assoc()) {

		if ($row['army_id'] == $army_id) {

			$your_territories[$row['territory_id']] = $row['territory_name'];

		}

		$territories[$row['territory_id']] = [
				'name'       => $row['territory_name'],
				'colour'     => $row['army_colour'],
				'battalions' => $row['battalions'],
				'army_id'    => $row['army_id'],
				'army_name'  => $row['army_name'],
			];

	}

//--------------------------------------------------
// Function to determine text colour

	function text_colour($background) {

		$total  = hexdec(substr($background, 0, 2));
		$total += hexdec(substr($background, 2, 2));
		$total += hexdec(substr($background, 4, 2));

		if ($total > 230) {
			return '000000';
		} else {
			return 'FFFFFF';
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

	<div id="page_wrapper">

		<header>

			<p>The Game</p>

		</header>

		<div id="page_content">

			<nav>

				<ul>
					<li><a href="#">Link 1</a></li>
					<li><a href="#">Link 2</a></li>
					<li><a href="#">Link 3</a></li>
					<li><a href="#">Link 4</a></li>
					<li><a href="#">Link 5</a></li>
				</ul>

			</nav>

			<main>

				<h1>Play</h1>

				<p>Hi <strong><?= html($account_info['username']) ?></strong>! (<a href="./logout.php">logout</a>)</p>

				<?php if (count($errors) > 0) { ?>

					<ul class="error_list">

						<?php foreach ($errors as $error) { ?>

							<li><?= html($error) ?></li>

						<?php } ?>

					</ul>

				<?php } ?>

				<form action="./" method="post">
					<fieldset>
						<legend>Recruit Battalions</legend>
						<select name="territory">

							<?php foreach ($your_territories as $id => $name) { ?>

								<option value="<?= html($id) ?>"><?= html($name) ?></option>

							<?php } ?>

						</select>
						<input type="submit" name="action" value="Recruit" />
					</fieldset>
				</form>

				<table id="map_table">
					<thead>
						<tr>
							<th scope="col">Territory</th>
							<th scope="col">Army</th>
							<th scope="col" class="battalions">Battalions</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody id="tableBody">
					<?php

						$k = 0;
						foreach ($territories as $id => $territory) {

							if ($territory['colour'] != '') {
								$main_colour = '#' . $territory['colour'];
								$text_colour = '#' . text_colour($territory['colour']);
							} else {
								$main_colour = '#000000';
								$text_colour = '#FFFFFF';
							}

							echo '
								<tr data-id="' . html($id) . '" data-colour="' . html($main_colour) . '" data-text="' . html($text_colour) . '" data-battalions="' . html($territory['battalions']) . '"' . ($k++ % 2 ? ' class="odd"' : '') . '>
									<td>' . html($territory['name']) . '</td>
									<td>' . html($territory['army_name']) . '</td>';

							if ($territory['army_id'] == $army_id) {

								echo '
									<td class="battalions" style="background-color: ' . html($main_colour) . '; color: ' . html($text_colour) . ';">' . html($territory['battalions']) . '</td>
									<td>
										<form action="./" method="post">
											<input type="number" name="battalions" value="1" min="1" step="1" max="' . html($territory['battalions']) . '" />
											<input type="hidden" name="territory_from" value="' . html($id) . '" />
											<select name="territory">
												<option></option>
												<optgroup label="Empty">
													<option value="1">Neighbour 1</option>
													<option value="2">Neighbour 2</option>
													<option value="3">Neighbour 3</option>
												</optgroup>
												<optgroup label="Occupied">
													<option value="4">Neighbour 4</option>
													<option value="5">Neighbour 5</option>
													<option value="6">Neighbour 6</option>
												</optgroup>
											</select>
											<input type="submit" name="action" value="Conquer" />
										</form>
									</td>';

							} else if ($territory['colour'] != '') {

								echo '
									<td class="battalions" style="background-color: ' . html($main_colour) . '; color: ' . html($text_colour) . ';"> Unavailable</td>
									<td>&nbsp;</td>';

							} else {

								echo '
									<td>&nbsp;</td>
									<td>&nbsp;</td>';

							}

							echo '
								</tr>' . "\n";

						}

					?>
					</tbody>
				</table>

				<object id="map" type="image/svg+xml" data="/a/svg/1497636789-world.svg" width="735" height="460"></object>

			</main>

		</div>

	</div>

</body>
</html>