<?php

	function html($text) {
		return htmlspecialchars($text, ENT_QUOTES);
	}

	function textColour ($background) {

		$total  = hexdec(substr($background, 0, 2));
		$total += hexdec(substr($background, 2, 2));
		$total += hexdec(substr($background, 4, 2));

		if ($total > 230) {
			return '000000';
		} else {
			return 'FFFFFF';
		}

	}



	$army_id = 5;


	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$mysqli = new mysqli('localhost', 'stage', 'st8ge', 's-codeclub-game');
	$mysqli->set_charset('utf8mb4');



	// $new_battalions = rand(50, 100);


	// $query = '
	// 		INSERT world_army (
	// 			id,
	// 			army_colour,
	// 			army_name
	//
	// 		) VALUES (
	// 			16,
	// 			"FFFFFF",
	// 			"Maniacs"
	//
	// 		)';
	//
	// $result = $mysqli->execute_query($query, [
	// ]);




	// $query = '
	// 		UPDATE
	// 			world_army
	// 		SET
	// 			army_colour = "00acff"
	// 		WHERE
	// 			id = 16';
	//
	// $result = $mysqli->execute_query($query,[
	//
	// ]);




	// $query = 'SELECT * FROM world_army WHERE true ORDER BY army_name LIMIT 3';
	//
	// $result = $mysqli->execute_query($query, []);
	//
	// foreach ($result as $row) {
	// 	print_r($row);
	// }


	// echo '--------------------------------------------------' . "\n\n";
	//
	// $query = 'SELECT * FROM world_territories WHERE true ORDER BY army';
	//
	// $result = $mysqli->execute_query($query, []);
	//
	// foreach ($result as $row) {
	// 	print_r($row);
	// }
	//
	// exit();






	if (($_POST['action'] ?? '') == 'Recruit Battalions') {


			$territory_id = intval($_POST['territory'] ?? 0);


			$query = '
					SELECT
						battalions,
						army_id
					FROM
						world_owner
					WHERE
						territory_id = ? AND
						deleted = "0000-00-00 00:00:00"';

			$result = $mysqli->execute_query($query, [
					$territory_id,
				]);

			if ($row = $result->fetch_assoc()) {
				$current_battalions = $row['battalions'];
				$current_army_id = $row['army_id'];
			}
			$current_battalions += 5;





			$query = '
					UPDATE
						world_owner
					SET
						deleted = NOW()
					WHERE
						territory_id = ? AND
						deleted = "0000-00-00 00:00:00"';

			$result = $mysqli->execute_query($query,[
				$territory_id,
			]);



			$query = '
					INSERT world_owner (
						territory_id,
						army_id,
						battalions,
						created,
						deleted
					) VALUES (
						?,
						?,
						?,
						NOW(),
						"0000-00-00 00:00:00"
					)';

			$result = $mysqli->execute_query($query, [
				$territory_id,
				$current_army_id,
				$current_battalions
			]);






			// $query = '
			// 		UPDATE
			// 			world_owner
			// 		SET
			// 			battalions = 35
			// 		WHERE
			// 			army_id = 3 AND
			// 			battalions = 30';
			//
			// $result = $mysqli->execute_query($query,[
			//
			// ]);

			//UPDATE world_owner
			//SET battalions = 35
			//
		//SET


		//exit('Recruited Battalions');

	}






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

	$parameters = [];
	// $parameters[] = intval($var);

	$result = $mysqli->execute_query($sql, [
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
				'owner'      => "MacBookPro",
				'army_id'    => $row['army_id'],
				'army_name'  => $row['army_name'],
			];

	}

?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
	<meta charset="UTF-8" />
	<title>Scratch Pad</title>
	<link rel="stylesheet" type="text/css" href="/a/css/core.css" />
	<script src="/a/js/main.js" async="async"></script>
</head>
<body>

	<h1>Testing</h1>

	<form action="./" method="post">
		<select name="territory">

			<?php foreach ($your_territories as $id => $name) { ?>

				<option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($name) ?></option>

			<?php } ?>

		</select>
		<input type="submit" name="action" value="Recruit Battalions" />
	</form>

	<table>
		<caption>Map Information</caption>
		<thead>
			<tr>
				<th scope="col">Territory</th>
				<th scope="col">Owner</th>
				<th scope="col">Army</th>
				<th scope="col" class="battalions">Battalions</th>
			</tr>
		</thead>
		<tbody id="tableBody">
		<?php

			$k = 0;
			foreach ($territories as $id => $territory) {

				if ($territory['colour'] != '') {
					$mainColour = '#' . $territory['colour'];
					$textColour = '#' . textColour($territory['colour']);
				} else {
					$mainColour = '#000000';
					$textColour = '#FFFFFF';
				}

				echo '
					<tr data-id="' . html($id) . '" data-colour="' . html($mainColour) . '" data-text="' . html($textColour) . '" data-battalions="' . html($territory['battalions']) . '"' . ($k++ % 2 ? ' class="odd"' : '') . '>
						<td>' . html($territory['name']) . '</td>
						<td>' . html($territory['owner']) . '</td>
						<td>' . html($territory['army_name']) . '</td>';
				if ($territory['army_id'] == $army_id) {
					echo '
						<td class="battalions" style="background-color: ' . html($mainColour) . '; color: ' . html($textColour) . ';">' . ($territory['battalions'] > 0 ? intval($territory['battalions']) : '&nbsp;') . '</td>';
				} else if ($territory['colour'] != '') {
					echo '
						<td class="battalions" style="background-color: ' . html($mainColour) . '; color: ' . html($textColour) . ';"> Unavailable</td>';
				} else {
					echo '
						<td>&nbsp;</td>';
				}
				echo '
					</tr>' . "\n";

			}

		?>
		</tbody>
	</table>

	<object id="map" type="image/svg+xml" data="/a/svg/1497636789-world.svg" width="735" height="460"></object>

</body>
</html>