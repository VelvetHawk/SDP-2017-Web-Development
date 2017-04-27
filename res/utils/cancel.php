<?php
	include_once "Functions.php";

	if (!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo'])))
        redirectTo('../../index');
    else
    {
    	if (isset($_POST['task'])) // Unpublish by owner when task is not claimed
    	{
    		$task_id = $_POST['task'];
    		$user = $_SESSION['username'];
            $query = "INSERT INTO cancelled_tasks (task_id, cancelled_by, time_cancelled) VALUES ($task_id, $user, Now());";
    		$GLOBALS['pdo'] -> query($query);
            // If task is also flagged, remove from flagged
            $query = "DELETE FROM flagged_tasks WHERE task_id = $task_id";
            $GLOBALS['pdo'] -> query($query);
    	}
        else if (isset($_POST['unclaim'])) // Cancel by claimant
        {
            $task_id = $_POST['unclaim'];
            $user = $_SESSION['username'];
            $query = "INSERT INTO cancelled_tasks (task_id, cancelled_by, time_cancelled) VALUES ($task_id, $user, Now());";
            $GLOBALS['pdo'] -> query($query);
            // Remove task from claimed tasks
            $query = "DELETE FROM Claimed_tasks WHERE task_id = $task_id";
            $GLOBALS['pdo'] -> query($query);
            // Score -15 for cancelling task after claiming
            $query = "UPDATE Users SET score = score-15 WHERE user_id = $user;";
            $GLOBALS['pdo'] -> query($query); 
        }
    	redirectTo('../../home');
    }
?>