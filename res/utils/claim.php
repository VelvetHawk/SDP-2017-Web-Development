<?php
	include_once "Functions.php";

	if (!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo'])))
        redirectTo('../../index');
    else
    {
    	if (isset($_POST['id']))
    	{
    		$id = $_POST['id'];
    		$user = $_SESSION['username'];
    		$query = "INSERT INTO claimed_tasks (`task_id`, `claimant`, `time_claimed`) VALUES ($id, $user, Now());";
    		$GLOBALS['pdo'] -> query($query);
            // Update score: +10 for claiming task
            $query = "UPDATE Users SET score = score + 10 WHERE user_id = $user";
            $GLOBALS['pdo'] -> query($query);
    	}
    	redirectTo('../../home');
    }
?>