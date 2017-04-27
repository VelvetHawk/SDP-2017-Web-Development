<?php
	include_once "Functions.php";

	if (!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo'])))
        redirectTo('../../index');
    else
    {
    	if (isset($_POST['rating']))
    	{
    		$id = $_POST['id'];
    		$user = $_SESSION['username'];
    		// Mark task as rated in DB
    		$query = "UPDATE Tasks SET rated = true WHERE task_id = $id";
    		$GLOBALS['pdo'] -> query($query);
    		// Update claimant's score
    		$query = "SELECT claimant FROM completed_tasks WHERE task_id = $id";
    		$claimant;
    		foreach ($GLOBALS['pdo'] -> query($query) as $user)
    			$claimant = $user['claimant'];

    		if ($_POST['rating'] == true)
    			$query = "UPDATE Users SET score = score+5 WHERE user_id = $claimant;";
    		else
    			$query = "UPDATE Users SET score = score-5 WHERE user_id = $claimant;";
    		$GLOBALS['pdo'] -> query($query);


    	}
    	redirectTo('../../home');
    }
?>