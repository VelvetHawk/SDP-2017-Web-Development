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

												// Add the tasks for this task to the user's profile
												$tags;
												foreach ($GLOBALS['pdo'] -> query("SELECT tags FROM Tasks WHERE task_id = $id;") as $tag_list)
													$tags = explode(",", $tag_list['tags']);
												// Tags
												$assigned_tags;
												foreach ($GLOBALS['pdo'] -> query("SELECT tags FROM assigned_tags WHERE user_id = " . $_SESSION['username'] . ";") as $tag_list)
													$assigned_tags = explode(",", $tag_list['tags']);
												// Frequencies
												$frequencies;
												foreach ($GLOBALS['pdo'] -> query("SELECT frequencies FROM assigned_tags WHERE user_id = " . $_SESSION['username'] . ";") as $tag_list)
													$frequencies = array_map('intval', explode(",", $tag_list['frequencies']));

												if (!isset($assigned_tags))
													$assigned_tags = array();
												// Check if user actually has viewed a task before
												if (sizeof($assigned_tags) == 0 || $assigned_tags[0] == '')
												{
													unset($assigned_tags);
													unset($frequencies);
													for ($i = 0; $i < sizeof($tags); $i++)
														$assigned_tags[$i] = $tags[$i];
													for ($i = 0; $i < sizeof($tags); $i++)
														$frequencies[$i] = 1;

													// Update DB
													$GLOBALS['pdo'] -> query("UPDATE assigned_tags SET tags = '" . implode(",", $assigned_tags) . "';");
													$GLOBALS['pdo'] -> query("UPDATE assigned_tags SET frequencies = '" . implode(",", $frequencies) . "';");
												}
												else // Take tags from current task, and add them to user's assigned tags
												{
													$count;
													for ($i = 0; $i < sizeof($tags); $i++) // Loop through tags in task
													{
														$added = false;
														for ($j = 0; $j < sizeof($assigned_tags) && !$added; $j++) // Loop through all assigned tags
														{
															if ($tags[$i] == $assigned_tags[$j]) // Check if profile tag is within list of tags for task
															{
																$frequencies[$j]++; // Increment the occurence of this tag
																$added = true;
															}
														}
														// Check if user already has this tag in their assigned tags - If not, at it to their assigned tags
														if (!$added)
														{
															$assigned_tags[sizeof($assigned_tags)] = $tags[$i]; // Append tag_id to assigned tags
															$frequencies[sizeof($assigned_tags)] = 1; // Set frequency to 1
														}
													}
													// Query to DB
													$GLOBALS['pdo'] -> query("UPDATE assigned_tags SET tags = '" . implode(",", $assigned_tags) . "';");
													$GLOBALS['pdo'] -> query("UPDATE assigned_tags SET frequencies = '" . implode(",", $frequencies) . "';");
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
												// Claim functionality
												echo "<form id=\"claim-form\" action=\"res/utils/claim.php\" method=\"post\">";
												echo "<input name=\"id\" type=\"hidden\" value=\"$id\"/>";
												echo	"<ul class=\"actions\">";
												echo "<li><button type=\"submit\" id=\"claim\" class=\"button\">Claim</button></li>";
												echo	"</form>";
												// Preview functionality
												echo "<li><a href=\"#\" class=\"button\">Preview</a></li>";
												// Flag functionality
												echo "<li><button id=\"flag\" type=\"button\" onClick=\"flagTask()\" class=\"button\">Flag</button></li>"; # NEED A CHECK ON SCORE HERE
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