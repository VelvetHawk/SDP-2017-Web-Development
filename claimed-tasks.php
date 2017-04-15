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
		<title>Claimed Tasks - Proofreadr</title>
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
										<h2>Claimed Tasks</h2>
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
												printTasks(getUserClaimedTasks($_SESSION['username']), true);
												# HAVE CHECK TO ADD REVIEW OPTION TO USER TO ALLOW THE TO GIVE FEEDBACK ONCE TASK IS COMPLETED
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