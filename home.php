<?php
    $page_title = "Homepage";
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
		<title>Proofreadr - For all your grammar needs</title>
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
										<h2>Dashboard</h2>
									</header>
                                    <?php if(!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo']))): ?>
                                        <?php redirectTo('index'); ?>
                                    <!--<p class="lead">You are currently not signed in<br><a href="login.php">Login</a><br>
                                        Not yet a member? <a href="signup.php">Sign up here</a><br>
                                    </p>-->
                                    <?php else: ?>
									<!-- Posts -->
									<div class="posts">
										<?php
											try
											{
												$major = getUserMajor($_SESSION['username']);
												$tasks_sameMajor = getStudentsInSameMajor($major, $_SESSION['username']);
												$tasks_subscribed = getSubscribedTags($_SESSION['username']);
												$tasks_assigned = getAssignedTags($_SESSION['username']);
												$formatted_array = formatArrays($tasks_sameMajor, $tasks_subscribed, $tasks_assigned, $_SESSION['username']);
												printTasks($formatted_array);
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