<?php
	include_once "../utils/Functions.php";

	$id = $_POST['id'];
	$query = "SELECT user_id FROM Sessions WHERE user_id = $id";
	$present = false;
	foreach ($GLOBALS['pdo'] -> query($query) as $user)
		if (sizeof($user['user_id'] == $id))
			$present = true;

	if (!$present) // User has just signed in for the first time
	{
		$query = "INSERT INTO sessions(user_id, date_time, last_active) VALUES ($id, Now(), 0);";
		$GLOBALS['pdo'] -> query($query);
	}
	else // User is still present on website
	{
		$query = "UPDATE `sessions` SET `last_active` = 0 WHERE user_id = $id";
		$GLOBALS['pdo'] -> query($query);
	}

	/*
		- Add a new column (last_active) to  sessions which is currently changing (increments from 0 -> 1 -> 2)
		- Create event that checks every minute if the last_active value is 2 (last_active represents minutes since last ping)
			: If 2, move session to total_sessions and use Now() as logout date
			: Otherwise, leave as is
		- Create even that increments the still_active column of every session
		- Let php script reset value to 0 each minute, showing user is still connected

	*/
?>