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
		<title>Proofreadr - For all your grammar needs</title>
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

												echo "<div id=\"view-task\" class=\"task\"><br />";
												echo "<h2 class=\"task-title\">$test</h2>";
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
												echo	"<ul class=\"actions\">";
												echo 		"<li><button onClick=\"appendArea()\" class=\"button\">Mark as complete</button></li>";
												echo 		"<li><a href=\"#\" class=\"button\">Request file</a></li>";
												echo 		"<li><a id=\"\" href=\"#\" class=\"button\">Cancel</a></li>";
												echo	"</ul>";
												echo "</div>";
												echo "<input id=\"task_id\" type=\"hidden\" value=\"$id\">";
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