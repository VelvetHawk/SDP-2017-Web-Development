<?php
	include_once "Functions.php";

	if (!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo'])))
        redirectTo('index');
    else
    {
    	if (isset($_POST['task']))
    	{
    		$task_id = $_POST['task'];
    		$user = $_SESSION['username'];
            $reason = $_POST['reason'];
            // Get the id of user to ban
            $query = "SELECT user_id FROM Tasks WHERE task_id = $task_id";
            $user_to_ban;
            foreach ($GLOBALS['pdo'] -> query($query) as $ban_id)
                $user_to_ban = $ban_id['user_id'];

            // Queries
            $query_cancel = "INSERT INTO cancelled_tasks (task_id, cancelled_by, time_cancelled) VALUES ($task_id, $user, Now());";
            $query_ban = "INSERT INTO banned (user_id, banned_by, date_time, reason) VALUES ($user_to_ban, $user, Now(), '$reason');";
            $query_unflag = "DELETE FROM flagged_tasks WHERE task_id = $task_id";

            // Execute queries
            $GLOBALS['pdo'] -> query($query_cancel);
            $GLOBALS['pdo'] -> query($query_unflag);
            $GLOBALS['pdo'] -> query($query_ban);
    	}
    	redirectTo('home');
    }
?>