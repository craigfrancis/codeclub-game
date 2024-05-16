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



	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$mysqli = new mysqli('localhost', 'stage', 'st8ge', 's-codeclub-game');
	$mysqli->set_charset('utf8mb4');



	$new_battalions = rand(50, 100);


	// $query = '
	// 		INSERT world_game_army (
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




	$query = '
			UPDATE
				world_game_army
			SET
				army_colour = "00acff"
			WHERE
				id = 16';

	$result = $mysqli->execute_query($query,[

	]);


	exit('uvytvtyfty?');



	$query = 'SELECT * FROM world_game_army WHERE true ORDER BY army_name LIMIT 3';

	$result = $mysqli->execute_query($query, []);

	foreach ($result as $row) {
		print_r($row);
	}


	echo '--------------------------------------------------' . "\n\n";

	$query = 'SELECT * FROM world_territories WHERE true ORDER BY army';

	$result = $mysqli->execute_query($query, []);

	foreach ($result as $row) {
		print_r($row);
	}

	exit();







	$territories = [];

	$territories[1] = [
			'name'       => 'Great Britan',
			'colour'     => 'F07857',
			'battalions' => 10,
			'owner'      => 'Craig',
			'army'       => 'MyArmy',
		];
	$territories[2] = [
			'name'       => 'Western Europe',
			'colour'     => 'F287F5',
			'battalions' => 1234,
			'owner'      => 'Nicolau',
			'army'       => 'MyArmy',
		];

	$territories[3] = [
			'name'       => 'Southern Europe',
			'colour'     => '5FF2F6',
			'battalions' => 987654321,
			'owner'      => 'Thea',
			'army'       => 'MyArmy',
		];
	$territories[31] = [
			'name'       => 'Queubec',
			'colour'     => 'D49137',
			'battalions' => 314159265,
			'owner'      => 'Someone',
			'army'       => 'MyArmy',
		];

	$territories[20] = [
			'name'       => 'Egypt',
			'colour'     => '53BDA5',
			'battalions' => 7364528901,
			'owner'      => 'Hatshepsut',
			'army'       => 'MyArmy',
		];
	$territories[25] = [
			'name'       => 'Madagascar',
			'colour'     => 'F5C26B',
			'battalions' => 7364528901,
			'owner'      => 'Alex',
			'army'       => 'MyArmy',
		];
	$territories[18] = [
			'name'       => 'Japan',
			'colour'     => 'BF2C34',
			'battalions' => 500,
			'owner'      => 'Japan Person',
			'army'       => 'MyArmy',
		];


	$territories[11] = [
			'name'       => 'China',
			'colour'     => '5C62D6',
			'battalions' => 500098,
			'owner'      => 'Ninja',
			'army'       => 'MyArmy',
		];
	$territories[21] = [
			'name'       => 'North Africa',
			'colour'     => '3d2b24',
			'battalions' => 9999999999,
			'owner'      => 'Kealitile',
			'army'       => 'MyArmy',
		];
	$territories[22] = [
			'name'       => 'East Africa',
			'colour'     => '66FF00',
			'battalions' => 10000000000000000,
			'owner'      => 'Anna',
			'army'       => 'MyArmy',
		];



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
						<td>' . html($territory['army']) . '</td>';
				if ($territory['colour'] != '') {
					echo '
						<td class="battalions" style="background-color: ' . html($mainColour) . '; color: ' . html($textColour) . ';">' . ($territory['battalions'] > 0 ? intval($territory['battalions']) : '&nbsp;') . '</td>';
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