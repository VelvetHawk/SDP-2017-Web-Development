<?php
	include_once "utils/Functions.php";
?> 

<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html lang="en">
	<head>
		<title>Proofreadr - For all your grammar needs</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<meta name="description" content="This should contain a description about this particular page">
		<script src="#"></script>
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
										include_once "utils/Header.php";
									?>
								</header>

							<!-- Section -->
								<section>
									<!-- Task information -->
									<div class="posts">
										<?php
											if (isset($_GET['id']))
											{
												initialiseConnection();
												$id = $_GET['id'];

												/*
													-DECLARE PDO
													-CREATE CONNECTION
													-RETRIEVE DATA FOR THIS POST
													-PRESENT ON PAGE
													-GIVE OPTION TO CLAIM TASK
													-IF MOD, GIVE OPTION TO FLAG TASK
												*/

												$title;
												$description;
												// Retrieve Title, Description
												foreach ($GLOBALS['dbh'] -> query("SELECT * FROM Tasks WHERE task_id = $id") as $task)
												{
													$test = $task['task_title'];
													$description = $task['description'];
												}

												$tags = array();
												// Retrieve tags
												// foreach ($GLOBALS['dbh'] -> query("SELECT * FROM Tasks WHERE task_id = $id") as $tag)
												// {
												// 	# code...
												// 	array_push($tags, $tag['value']);
												// }

												echo "<div class=\"task\"><br />";
												echo "<h2>$test</h2><br />";
												echo "<br />";
												echo "<p>$description</p><br />";
												echo "Tag 1, tag 2, tag 3, tag 4<br /><br />";
												echo	"<ul class=\"actions\">";
												echo "<li><a href=\"#\" class=\"button\">Claim</a></li>";
												echo "<li><a href=\"#\" class=\"button\">Flag</a></li>";
												echo	"</ul>";
												echo "</div>";
											}
											else
												echo "ID not set";
										?>
									</div>
								</section>

						</div>
					</div>

				<!-- Sidebar -->
					<?php
						include_once "utils/Sidebar.php";
					?>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>