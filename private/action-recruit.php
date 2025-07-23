<?php

//--------------------------------------------------
// Selected territory

	$territory_id = intval($_POST['territory'] ?? 0);

	$sql = 'SELECT
				battalions,
				army_id
			FROM
				world_owner
			WHERE
				army_id = ? AND
				territory_id = ? AND
				deleted = "0000-00-00 00:00:00"';

	$result = $db->execute_query($sql, [
			$army_id,
			$territory_id,
		]);

	if ($row = $result->fetch_assoc()) {

		$current_battalions = $row['battalions'];

	} else {

		$errors[] = 'You do not own this territory!';

	}

//--------------------------------------------------
// Not too frequently

	// if ($account_info['last_recruit'] !== '0000-00-00 00:00:00') {
	//
	// 	$last_recruit = new DateTime($account_info['last_recruit']);
	//
	// 	$diff = ($now->getTimestamp() - $last_recruit->getTimestamp());
	//
	// 	if ($diff < 60) {
	//
	// 		$errors[] = 'You need to wait at least 1 minute before recruiting more battalions!';
	//
	// 	}
	//
	// }

	$sql = 'SELECT
				created,
				account_id,
				action_type
			FROM
				world_account_move
			WHERE
				created = ? AND
				account_id = ? AND
				action_type = ? AND
				variable = ?';

	$result = $db->execute_query($sql, [
			$variable,
		]);

	if ($row = $result->fetch_assoc()) {

		$field1 = $row['field_1'];

	} else {

		$errors[] = 'Example Error.';

	}

//--------------------------------------------------
// Update

	if (count($errors) == 0) {

		//--------------------------------------------------
		// New battalion count

			$new_battalions = 10;

			$current_battalions += $new_battalions;

		//--------------------------------------------------
		// Delete old record

			$sql = 'UPDATE
						world_owner
					SET
						deleted = NOW()
					WHERE
						territory_id = ? AND
						deleted = "0000-00-00 00:00:00"';

			$db->execute_query($sql,[
					$territory_id,
				]);

		//--------------------------------------------------
		// Add new record

			$sql = 'INSERT INTO world_owner (
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

			$db->execute_query($sql, [
					$territory_id,
					$army_id,
					$current_battalions
				]);

		//--------------------------------------------------
		// Add new record

			$sql = 'INSERT INTO world_account_move (
						account_id,
						action_type,
						action_from,
						action_to,
						action_battalions,
						created
					) VALUES (
						?,
						?,
						?,
						?,
						?,
						?
					)';

			$db->execute_query($sql, [
					$account_id,
					'recruit',
					$territory_id,
					0,
					$new_battalions,
					$now->format('Y-m-d H:i:s')
				]);

		//--------------------------------------------------
		// Update account

			$sql = 'UPDATE
						world_account
					SET
						last_recruit = ?
					WHERE
						id = ? AND
						deleted = "0000-00-00 00:00:00"';

			$db->execute_query($sql,[
					$now->format('Y-m-d H:i:s'),
					$account_id,
				]);

		//--------------------------------------------------
		// Reload page (so it's no longer a POST request)

			header('Location: ./', true, 302);
			exit();

	}

?>