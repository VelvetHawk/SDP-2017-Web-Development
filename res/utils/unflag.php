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
            // Don't forget to work on score changes
    		$GLOBALS['pdo'] -> query($query);
    	}
    	redirectTo('../../flagged-tasks');
    }
?>