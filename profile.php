<?php
include_once "res/utils/Functions.php";
include_once "res/partials/parseProfile.php";
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
                    <h2>Profile</h2>
                </header>
                <?php if(!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo']))): ?>
                    <?php redirectTo('index'); ?>
                    <!--<p class="lead">You are currently not signed in<br><a href="login.php">Login</a><br>
                        Not yet a member? <a href="signup.php">Sign up here</a><br>
                    </p>-->
                <?php else: ?>
                    <img src="<?php if(isset($profile_picture)) echo $profile_picture ?>" class="img img-rounded" width="200">

                <table class="table table-bordered table-condensed">
                    <!-- username retrieved from parseProfile -->
                    <tr><th style="width: 20%;">Username</th><td><?php if(isset($username)) echo $username; ?></td></tr>
                    <tr><th>Email:</th><td><?php if(isset($email)) echo $email; ?></td></tr>
                    <tr><th>Date Joined:</th><td><?php if(isset($date_joined)) echo $date_joined; ?></td></tr>
                    <!-- sending user_identity paramemter into url-->
                    <tr><th></th><td><a class="pull-right" href="edit-profile.php?user_identity=<?php if(isset($encode_id)) echo $encode_id; ?>">
                                <span class="glyphicon glyphicon-edit"></span>Edit Profile</a></td></tr>
                    <tr><th></th><td><a class="pull-right" href="update-password.php?user_identity=<?php if(isset($encode_id)) echo $encode_id; ?>">
                                <span class="glyphicon glyphicon-edit"></span>Change Password</a></td></tr>
                </table>
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