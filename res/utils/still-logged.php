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
?>