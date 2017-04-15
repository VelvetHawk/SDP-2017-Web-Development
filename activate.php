<?php
include_once "res/utils/Functions.php";
include_once 'res/partials/parseSignup.php';


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

            <!-- Section REMOVED -->

            <div class="container flag">
                <header class="major">
                    <h2>Activate your account</h2>
                </header>
                <p><?php if(isset($result)) echo $result; ?></p>
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