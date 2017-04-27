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
            $query = "DELETE FROM flagged_tasks WHERE task_id = $task_id";
    		$GLOBALS['pdo'] -> query($query);
            // Update score: -3 for a mod unflagging your task
            $query = "UPDATE Users SET score = score - 3 WHERE user_id = $user";
            $GLOBALS['pdo'] -> query($query);
    	}
    	redirectTo('../../flagged-tasks');
    }
?>