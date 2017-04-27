<?php
	include_once "res/utils/Functions.php";
	//initialiseConnection();
?> 

<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html lang="en">
	<head>
		<?php
			include_once "res/partials/head.php";
		?>
		<title>My Tasks</title>
		<meta name="description" content="">
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">

							<!-- Header -->
								<header id="header">
									<?php
										include_once "res/partials/Header.php";
									?>
								</header>

							<!-- Section -->
								<section>
									<!-- Task information -->
									<div class="posts">
										<?php
											if (!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo'])))
                                       			redirectTo('index');
                                       		elseif (isset($_GET['id']))
                                       		{
                                       			$id = $_GET['id'];
                                       			$username = $_SESSION['username'];
                                       			$query = "SELECT task_id FROM Tasks WHERE user_id = $username AND task_id = $id;";
                                       			$value = array();
                                       			// Make sure task is owned by this user
                                       			foreach ($GLOBALS['pdo'] -> query($query) as $task)
												{
													if (sizeof($task) < 1)
														redirectTo('my-tasks');
												}

												$title;
												$type;
												$description;
												$claim_deadline;
												$review_deadline;
												$words;
												$pages;
												// Retrieve Task details
												foreach ($GLOBALS['pdo'] -> query("SELECT * FROM Tasks WHERE task_id = $id") as $task)
												{
													$test = $task['task_title'];
													$type = $task['task_type'];
													$description = $task['description'];
													$claim_deadline = $task['claim_deadline'];
													$review_deadline = $task['review_deadline']; # Not sure if needed?
													$words = $task['word_length'];
													$pages = $task['page_length'];
												}

												// Retrieve tags
												$tag_values = getTaskTags($id);

												$status = getTaskStatus($_GET['id']);

												echo "<div id=\"manage-task\" class=\"task\"><br />";
												echo "<h2 class=\"task-title\">$test</h2>";
												echo "Claim deadline:  " . date("jS F, Y", strtotime($claim_deadline)) . "<br />";
												echo "Review deadline:  " . date("jS F, Y", strtotime($review_deadline)) . "<br />";
												echo "Type:  $type<br />";
												echo "Words:  $words<br />Pages:  $pages<br />";
												echo "Status:  " . $status . "<br />";
												if ($status == "Claimed")
												{
													$query = "SELECT first_name, last_name, email FROM Users WHERE user_id = (SELECT claimant FROM Claimed_Tasks WHERE task_id = $id);";
													foreach ($GLOBALS['pdo'] -> query($query) as $task)
														echo "Claimed by:  " . $task['first_name'] . " " . $task['last_name'] . "  (" . $task['email'] . ")<br />";
												}
												echo "<br /><br />";
												echo "<p>$description</p>";
												// print_r($tag_values);
												echo "<ul class=\"tag-list\">";
												for ($i = 0; $i < sizeof($tag_values); $i++)
													echo "<li>".$tag_values[$i]."</li>";
												echo "</ul>";
												echo	"<ul class=\"actions\">";
												$query = "SELECT rated FROM tasks WHERE task_id = $id";
												$rated;
												foreach ($GLOBALS['pdo'] -> query($query) as $rating)
													$rated = $rating['rated'];
												if ($status == "Completed" && !$rated)
													echo "<li><button type=\"button\" onClick=\"rateTask()\" class=\"button\">Rate</button></li>"; // FIX ABILITY TO RATE COMPLETED TASK
												elseif ($status != "Claimed" && !$rated) // Make sure that if task is claimed, owner can't do anything
													echo "<li><button onClick=\"cancelTask()\" type=\"button\" class=\"button\">Unpublish</button></li>";
												/*
													GOING TO NEED TO BE A RATING BUTTON INSTEAD OF EDIT/UNPUBLISH IF TASK IS COMPLETED
												*/
												echo	"</ul>";
												echo "</div>";
											}
											else
											{
												// This will redirect to home.php when no task id is sent to task.php
												redirectTo('my-tasks');
												// echo "ID not set";
											}
										?>
									</div>
								</section>

						</div>
					</div>

				<!-- Sidebar -->
					<?php
						include_once "res/utils/Sidebar.php";
					?>
			</div>

		<!-- Scripts -->
		<?php
			include_once "res/partials/script-calls.php";
		?>

	</body>
</html>