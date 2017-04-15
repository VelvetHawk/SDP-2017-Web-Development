<?php
    include_once "res/utils/Functions.php";
    include_once 'res/partials/parsePasswordReset.php';

    // take id from URL
    if(isset($_GET['id'])) {
        $encoded_id = $_GET['id'];
        $decoded_id = base64_decode($encoded_id);
        $id_array = explode("encodeuserid", $decoded_id);
        $id = $id_array[1];

    }
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
                                            <h2>Password Reset</h2>
                                        </header>

                                        <!-- keep error seperate from rest of form -->
                                        <div>
                                            <?php if(isset($result)) echo $result; ?>
                                            <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
                                        </div>
                                        <div class="clearfix"></div>

                                        <!-- bootstrap basic form -->
                                        <form action="" method="post">

                                            <!-- NEW PASSWORD -->
                                            <div class="form-group">
                                                <label for="passwordField">New Password</label>
                                                <input type="password" class="form-control" name="new_password" id="passwordField" placeholder="New Password">
                                            </div>

                                            <!-- CONFIRM PASSWORD -->
                                            <div class="form-group">
                                                <label for="passwordField">Confirm Password</label>
                                                <input type="password" class="form-control" name="confirm_password" id="passwordField" placeholder="Confirm Password">
                                            </div>

                                            <input type="hidden" name="user_id" value="<?php if(isset($id)) echo $id; ?>"

                                            <div class="12u$">
                                                <ul class="actions button-float-right">
                                                    <li><button name="passwordResetBtn" type="submit" class="special">Reset Password</button></li>

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