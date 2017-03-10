<?php
	# PHP Header code goes here
?>


<!DOCTYPE HTML>
<!--
	
-->
<html>
	<head>
		<title>Proofreadr - For all your grammar needs</title>
		<meta charset="utf-8" />
		<meta name="description" content="This should contain a description about this particular page">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<!-- <meta http-equiv="refresh" content="30"> --> <!-- Uncomment if refreshes are needed -->
		<!-- Links to external resources -->
		<link rel="stylesheet" href="Template_styles.css" />
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
										include_once "Template_Header.php";
									?>
								</header>

							<!-- Banner -->
								<section id="banner">
									
								</section>

							<!-- Section -->
								<section>
									
								</section>

						</div>
					</div>

				<!-- Sidebar -->
					<div id="sidebar">
						<div class="inner">

							<!-- Search -->
								<section id="search" class="alt">
									<form method="post" action="#">
										<input type="text" name="query" id="query" placeholder="Search" />
									</form>
								</section>

							<!-- Menu -->
								<nav id="menu">
									<header class="major">
										<h2>Menu</h2>
									</header>
									<ul>
										<li><a href="#">Home</a></li>
										<li><a href="#">Profile</a></li>
										<li><a href="#">Claimed Tasks</a></li>
										
										<!-- KEEP IF NEEDED, BUT DOUBT IT
										<li>
											<span class="opener">Submenu</span>
											<ul>
												<li><a href="#">Lorem Dolor</a></li>
												<li><a href="#">Ipsum Adipiscing</a></li>
												<li><a href="#">Tempus Magna</a></li>
												<li><a href="#">Feugiat Veroeros</a></li>
											</ul>
										</li>
										-->
								</nav>


							<!-- Footer -->
								<footer id="footer">
									<?php
										include_once "Template_footer.php";
									?>
								</footer>

						</div>
					</div>

			</div>

		<!-- Scripts here if we want them called on last -->

	</body>
</html>