<?php
	include_once "Functions.php";

	if (!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo'])))
        redirectTo('../../index');
    else
    {
    	if (isset($_POST['task']))
    	{
    		$task_id = $_POST['task'];
    		$user = $_SESSION['username'];
            $query = "INSERT INTO cancelled_tasks (task_id, cancelled_by, time_cancelled) VALUES ($task_id, $user, Now());";
            // Don't forget to work on score changes
    		$GLOBALS['pdo'] -> query($query);
            // If task is also flagged, remove from flagged
            $query = "DELETE FROM flagged_tasks WHERE task_id = $task_id";
            $GLOBALS['pdo'] -> query($query);
    	}
    	redirectTo('../../home');
    }
?>