<?php
	include_once "Functions.php";

	if (!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo'])))
        redirectTo('../../index');
    else
    {
    	if (isset($_POST['review']))
    	{
    		$id = $_POST['id'];
    		$user = $_SESSION['username'];
    		$review = $_POST['review'];
    		$query = "INSERT INTO completed_tasks (`task_id`, `claimant`, `time_completed`, `review`) VALUES ($id, $user, Now(), '$review');";
    		$GLOBALS['pdo'] -> query($query);
    		$query = "DELETE FROM `claimed_tasks` WHERE task_id = $id;";
    		$GLOBALS['pdo'] -> query($query);
    	}
    	redirectTo('../../claimed-tasks');
    }
?>