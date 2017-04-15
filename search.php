<?php
	include_once "res/utils/Functions.php";
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
		<title>Search Results - Proofreadr</title>
		<meta name="description" content="This should contain a description about this particular page">
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
									<header class="major">
										<h2>Search Results</h2>
									</header>
                                    <?php if (!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo']))): ?>
                                        <?php redirectTo('index'); ?>
                                    <?php else: ?>
									<!-- Posts -->
									<div class="posts">
										<?php
											if (!isset($_POST['query']))
												redirectTo('home');
											// Queery string exists, begin search
											try
											{
												$search = htmlspecialchars($_POST['query']);

												// Global array key
												$i = 0;

												// Array to house matching tag_ids
												$task_matches = array();

												// Search titles
												$query = "SELECT task_id FROM Tasks WHERE task_title LIKE '%$search%';";
												foreach ($GLOBALS['pdo'] -> query($query) as $task)
												{
													$task_matches[$i] = $task['task_id'];
													$i++;
												}

												// Search descriptions
												$query = "SELECT task_id FROM Tasks WHERE description LIKE '%$search%';";
												foreach ($GLOBALS['pdo'] -> query($query) as $task)
												{
													$task_matches[$i] = $task['task_id'];
													$i++;
												}

												// Search tag lists
												$query = "SELECT tag_id FROM Tags WHERE _value LIKE '%$search%' OR _value = '$search';";
												$tag_id_array = array();
												$j = 0;
												foreach ($GLOBALS['pdo'] -> query($query) as $tag)
												{
													$tag_id_array[$j] = $tag['tag_id'];
													$j++;
												}

												// If $tag_id_array isn't empty, search tasks that contain this tag(s)
												if (sizeof($tag_id_array) > 0)
												{
													for ($j = 0; $j < sizeof($tag_id_array); $j++)
													{ 
														$query = "SELECT task_id FROM Tasks WHERE tags LIKE '%".$tag_id_array[$j].",%' OR tags LIKE '%,".$tag_id_array[$j].",%' OR tags LIKE '%,".$tag_id_array[$j]."%';";
														foreach ($GLOBALS['pdo'] -> query($query) as $task)
														{
															$task_matches[$i] = $task['task_id'];
															$i++;
														}
													}
												}

												if (sizeof($task_matches) < 1)
													throw new Exception("Your search query didn't match anything!");

												// Remove any duplicates
												$task_matches = array_unique($task_matches);

												// Display results
												printTasks($task_matches);
											}
											catch (Exception $e)
											{
												// Later on, fix this to not be error but general message
												echo "<p class=\"error\">" . $e -> getMessage() ."</p>";
											}
										?>

									</div>
                                    <?php endif ?>
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