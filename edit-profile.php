<?php
$page_title = "Edit Profile";
include_once "res/utils/Functions.php";
include_once "res/partials/parseProfile.php";
include_once "res/partials/parseChangePassword.php";
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
        <script src="res/js/profile-tags.js"></script>
    </head>
    <body onload="addOnClick()">

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
                            <h2>Edit Profile</h2>
                        </header>

                        <?php if(!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo']))): ?>
<!--                             <p class="lead">You are currently not signed in<br><a href="login.php">Login</a><br>
                                Not yet a member? <a href="signup.php">Sign up here</a><br>
                            </p> -->
                            <?php redirectTo("index"); ?>
                        <?php else: ?>
                            <div>
                                <script>
                                    setTimeout(fade_out, 5000);

                                    function fade_out() {
                                        $("#fadeOut").fadeOut();
                                    }
                                </script>
                                <?php if(isset($result)) echo $result; ?>
                                <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
                            </div>
                        <!-- need to let server know sending file-->
                            <form id="first_form" method="post" action="res/partials/parseProfile.php" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="emailField">Email</label>
                                    <input type="text" name="email" class="form-control" id="emailField" value="<?php if(isset($email)) echo $email; ?>">
                                </div>

                                <div class="form-group">
                                    <!-- Add code to load subscribed tags from memory via PHP -->
                                    <label for="usernameField">Your Tags (Press Enter to add new tag fields)</label>
                                    <input type="hidden" name="tags" id="tags" value="0">
                                    <div id="entry-area" contenteditable="false" class="entry-area">
                                        <?php if (isset($subscribed_HTML)) echo $subscribed_HTML; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fileField">Avatar</label>
                                    <input type="file" name="fileToUpload" id="fileField">
                                </div>

                                <input type="hidden" name="hidden_id" value="<?php if(isset($id)) echo $id; ?>">
                                <input type="hidden" name="token" value="<?php if(function_exists('_token')) echo _token(); ?>">
                                <div class="12u$">
                                    <ul class="actions button-float-right">
                                        <li><button id="updateProfileButton" name="updateProfileButton" type="submit value="Submit" class="special">Update Profile</button></li>

                                    </ul>
                                </div>
                            </form><br><br>
                            <!-- CHANGE PASSWORD -->
                            <header class="major">
                                <h2>Password Management</h2>
                            </header>
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="curentpasswordField">Current Password</label>
                                    <input type="password" name="current_password" class="form-control"
                                           id="currentpasswordField" placeholder="Current Password">
                                </div>

                                <div class="form-group">
                                    <label for="newpasswordField">New Password</label>
                                    <input type="password" name="new_password" class="form-control"
                                           id="newpasswordField" placeholder="New Password">
                                </div>

                                <div class="form-group">
                                    <label for="confirmpasswordField">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control"
                                           id="confirmpasswordField" placeholder="Confirm new Password">
                                </div>
                                <input type="hidden" name="hidden_id" value="<?php if(isset($id)) echo $id; ?>">
                                <input type="hidden" name="token" value="<?php if(function_exists('_token')) echo _token(); ?>">
                                <div class="12u$">
                                    <ul class="actions button-float-right">
                                        <li><button name="changePasswordButton" type="submit" value="Submit" class="special">Change Password</button></li>

                                    </ul>
                                </div>
                            </form>
                        <p><a href="profile.php">Back</a></p>
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
        <script>
            document.getElementById("entry-area").setAttribute("onmouseover", "mouseOn()");
            document.getElementById("entry-area").setAttribute("onmouseout", "mouseOff()");
            document.getElementById("updateProfileButton").setAttribute("onClick", "addTagsToSubmit()");
        </script>
</body>
</html>