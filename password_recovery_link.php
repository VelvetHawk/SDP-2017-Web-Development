<?php
include_once "res/utils/Functions.php";
include_once 'res/partials/parsePasswordReset.php';
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
                    <h2>Password Recovery</h2>
                </header>

                <!-- keep error seperate from rest of form -->
                <div>
                    <?php if(isset($result)) echo $result; ?>
                    <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
                </div>
                <div class="clearfix"></div>

                <form action="" method="post">

                    <!-- EMAIL -->
                    <div class="form-group">
                        <label for="emailField">Email Address</label>
                        <input type="text" class="form-control" name="email" id="emailField" placeholder="Email">
                    </div>

                    <div class="12u$">
                        <ul class="actions button-float-right">
                            <li><button name="passwordResetButton" type="submit" class="special">Recover Password</button></li>

                        </ul>
                    </div>
                    <a class="child_div_1" href="index.php">Back</a>
                </form>
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