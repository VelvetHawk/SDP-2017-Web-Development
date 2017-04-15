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
                                       			$user = $_SESSION['username'];
                                       			$query = "SELECT score FROM Users WHERE user_id = $user";
                                       			$id = $_GET['id'];

                                       			// Check score first to make sure user can actually access this page
						                        foreach ($GLOBALS['pdo'] -> query($query) as $score)
						                            if ($score['score'] < 40)
						                                redirectTo('home');

						                        // User's score is above 40, so continue retrieving task details
                                       			$query = "SELECT task_id FROM Tasks WHERE task_id = $id;";
                                       			$value = array();
                                       			// Check to make sure the task actually exists
                                       			foreach ($GLOBALS['pdo'] -> query($query) as $task)
													if (sizeof($task) < 1)
														redirectTo('flagged-tasks');
												// Task details
												$title;
												$author;
												$type;
												$description;
												$claim_deadline;
												$review_deadline;
												$flagged_on;
												$reason;
												$words;
												$pages;

												// Query
												$query = "SELECT Tasks.*, flagged_tasks.date_time, flagged_tasks.reason FROM Tasks INNER JOIN flagged_tasks ON Tasks.task_id = flagged_tasks.task_id AND Tasks.task_id = $id;";

												// Retrieve Task details
												foreach ($GLOBALS['pdo'] -> query($query) as $task)
												{
													$title = $task['task_title'];
													$author = $task['user_id'];
													$type = $task['task_type'];
													$description = $task['description'];
													$claim_deadline = $task['claim_deadline'];
													$review_deadline = $task['review_deadline']; # Not sure if needed?
													$flagged_on = $task['date_time'];
													$reason = $task['reason'];
													$words = $task['word_length'];
													$pages = $task['page_length'];
												}

												// Retrieve tags
												$tag_values = getTaskTags($id);

												echo "<div id=\"review-task\" class=\"task\"><br />";
												echo "<h2 class=\"task-title\">$title</h2>";
												echo "Claim deadline:  " . date("jS F, Y", strtotime($claim_deadline)) . "<br />";
												echo "Review deadline:  " . date("jS F, Y", strtotime($review_deadline)) . "<br />";
												echo "Type:  $type<br />";
												echo "Words:  $words<br />Pages:  $pages<br />";
												echo "<br /><br />";
												echo "<p>$description</p>";
												// print_r($tag_values);
												echo "<ul class=\"tag-list\">";
												for ($i = 0; $i < sizeof($tag_values); $i++)
													echo "<li>".$tag_values[$i]."</li>";
												echo "</ul>";
												// Flag information
												echo "<strong>Flagged on:  </strong>" . date("jS F, Y", strtotime($flagged_on)) . "<br />";
												echo "<strong>Reason:</strong><br />";
												echo "<p>$reason</p>";

												echo	"<ul class=\"actions\">";
													// echo "<li><a href=\"#\" class=\"button\">View file</a></li>"; // Let the mod see file uploaded for task
													echo "<li><button onClick=\"cancelTask()\" type=\"button\" class=\"button\">Unpublish</button></li>"; // Will unpublish task, but not ban user
													echo "<li><button onClick=\"banAndUnpublish()\" type=\"button\" class=\"button\">Ban & Unpublish</button></li>"; // Will ban user and unpublish task
													echo "<li><button onClick=\"unFlag()\" type=\"button\" class=\"button\">Unflag</button></li>"; // Unflag task, not inappropriate (removes score from flagger -2)
												echo	"</ul>";
												echo "</div>";
											}
											else
											{
												// This will redirect to home.php when no task id is sent to task.php
												redirectTo('home');
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