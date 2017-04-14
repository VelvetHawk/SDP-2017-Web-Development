<?php
    $page_title = "User Authentication";
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
                            <?php

                            // print_r($_COOKIE);

                            ?>

                            <!-- Section CURRENTLY REMOVED TAGS-->

                                    <div class="flag">
                                        <header class="major">
                                            <h1 class="logo">Welcome to <strong>Proof</strong><span style="color: darkgrey;">readr</span></h1>
                                        </header>
                                        <p class="lead">The goal of this service is simple: through a careful review,
                                            your peers can eliminate errors while also improving the language and academic tone of your dissertation/thesis.
                                            We aim to provide suggestions on how you can improve or develop the content/argument to achieve a better grade.</p>
                                        <?php if(!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo']))): ?>
                                            <p class="lead">You are currently not signed in<br><a href="login.php">Login</a><br>
                                                Not yet a member? <a href="signup.php">Sign up here</a><br>
                                            </p>
                                        <?php else: ?>
                                            <p class="lead">You are logged in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?><br>
                                            You can return to your dashboard <a href="home.php">here</a></p>
                                        <?php endif ?>
                                    </div>


                        </div>
                    </div>
            </div>

        <!-- Scripts -->
            <?php
                include_once "res/partials/script-calls.php";
            ?>
    </body>
</html>