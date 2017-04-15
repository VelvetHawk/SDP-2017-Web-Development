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
            $reason = $_POST['reason'];
    		$query = "INSERT INTO `flagged_tasks`(`task_id`, `flagged_by`, `date_time`, `reason`) VALUES ($id, $user, Now(), '$reason');";
    		$GLOBALS['pdo'] -> query($query);
    	}
    	redirectTo('../../home');
    }
?>