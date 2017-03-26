<?php
	function initialiseConnection()
	{
		try
		{
			// PDO
			$host = "localhost";
			$db = "group17";
			$username = "root";
			$password = "";
			$charset = "utf8";

			$options = [	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
							PDO::ATTR_EMULATE_PREPARES   => false,
							PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
			];

			$GLOBALS['dbh'] = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $username, $password, $options);
		}
		catch (PDOException $e)
		{
			echo "<p class=\"error\"> Uh oh! Looks like there was an error! <br /><br /> Now take your shit and leave.</p>";
		}
	}

	function getTasksForCurrentUser()
	{
		try
		{
			// SQL
			$user_number = 15164748;
			$user_major = null;
			// $users_same_major = array();

			$query_getMajor = "CALL getUserMajor(" . $user_number . ");"; # CHANGE LATER TO GET ONLY RELEVANT POSTS

			// $stmnt = $dbh -> prepare($query_getMajor);
			// $stmnt -> execute();
			// $major_name = $stmnt -> fetchAll(PDO::FETCH_ASSOC);

			$test = array();

			foreach ($GLOBALS['dbh'] -> query($query_getMajor) as $row) {
				array_push($test, $row['major']);
			}

			$user_major = $test[0];
			// echo "User major: " . $user_major;
			//$query_getSameMajors = "CALL getUsersWithSameMajor($user_major);"; # CHANGE LATER TO GET ONLY RELEVANT POSTS
			//$query_getSameMajors = "SET @p0='$user_major'; CALL getUsersWithSameMajor(@p0);";
			$query_getSameMajors = "SELECT user_id FROM Users WHERE major = '$user_major';";

			// $stmnt -> closeCursor();

				// $stmnt_2 = $dbh -> query($query_getSameMajors);
				// $users_with_same_major = $stmnt_2 -> fetchAll(PDO::FETCH_ASSOC);

				// $bleh = array();
				// $i = 0;
				// foreach ($users_with_same_major as $user)
				// {
				// 	# Iterates for every user
				// 	array_push($bleh, $user['user_id']);
				// }

			$q = "SELECT task_id, task_title, description FROM Tasks WHERE user_id IN (SELECT user_id FROM Users WHERE major = '$user_major') AND task_id NOT IN (SELECT task_id FROM claimed_tasks) ORDER BY claim_deadline ASC;";
			foreach ($GLOBALS['dbh'] -> query($q) as $task)
			{
				// Variables
				$id = $task['task_id'];
				// HTML
				echo "<article>";
				echo	"<h3>".$task['task_title']."</h3>";
				if (strlen($task['description']) > 200)
					echo	"<p>" . substr($task['description'], 0, 200) . "..." . "</p>";
				else
					echo	"<p>".$task['description']."</p>";
				echo	"<ul class=\"actions\">";
				echo "<li><a href=\"http://localhost/SDP-2017/task.php?id=$id\" class=\"button\">View</a></li>";
				echo	"</ul>";
				echo "</article>";
			}



		}
		catch (PDOException $exception)
		{
			# printf("Connection error: %s", $exception->getMessage());
			echo "<p class=\"error\"> Uh oh! Looks like there was an error! <br /><br /> Now take your shit and leave.</p>";
		}
	}
?>