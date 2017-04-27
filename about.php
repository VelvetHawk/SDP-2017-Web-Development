<?php
$page_title = "About";
include_once "res/utils/Functions.php";
include_once 'res/partials/parseLogin.php';
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


                <section>
                    <header class="major">
                        <h2>About</h2>
                    </header>
                    <div class="posts">
                        <article>
                            <!-- <a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a> -->
                            <h3>The Idea</h3>
                            <p>Proofreadr is a community founded in Ireland by Artem, Brian and James.
                                Unlike other services available we are entirely subscription and cost free.
                                Each day our community and user base grows.
                                Why is this good for you? Because as the community grows the variety of subjects covered grows too!</p>
                        </article>
                        <article>
                            <h3>Our Location</h3>
                            <p>Our offices are located in the University of Limerick with all servers hosted on site on the testweb3 server.
                                Located on the banks of the scenic river shannon in Limerick City, Ireland.</p>
                        </article>
                        <article>
                            <h2>The Team</h2>
                            <h3>Artem Semenov</h3>
                            <p>Co-Founder and Developer. ID: 15164748 </p>
                            <h3>Brian Dooley</h3>
                            <p>Co-Founder and Developer. ID: 15123529 </p>
                            <h3>James Gillatt-Haughton</h3>
                            <p>Co-Founder and Developer. ID: 15157776 </p>
                        </article>

                    </div>
                </section>


        </div>
    </div>
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