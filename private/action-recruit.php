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

	if ($account_info['last_recruit'] !== '0000-00-00 00:00:00') {

		$last_recruit = new DateTime($account_info['last_recruit']);

		$diff = ($now->getTimestamp() - $last_recruit->getTimestamp());

		if ($diff < 5) {

			$errors[] = 'You need to wait at least 5 seconds before recruiting more battalions!';

		}

	}

//--------------------------------------------------
// Update

	if (count($errors) == 0) {

		//--------------------------------------------------
		// New battalion count

			$current_battalions += 5;

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