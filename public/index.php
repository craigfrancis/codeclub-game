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

	$territories = [];

	$territories[1] = [
			'name'       => 'Great Britain',
			'colour'     => 'FF0000',
			'battalions' => 10,
			'owner'      => 'Craig',
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