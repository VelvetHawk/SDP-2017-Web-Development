<?php
    $page_title = "Sign up Form";
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
        <script src='https://www.google.com/recaptcha/api.js'></script>
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

                            <!-- Section CURRENTLY REMOVED TAGS-->

                                    <div class="container flag">
                                        <header class="major">
                                            <h2>Registration Form</h2>
                                        </header>

                                            <!-- keep error seperate from rest of form -->
                                            <div>
                                                <?php if(isset($result)) echo $result; ?>
                                                <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
                                            </div>
                                        <div class="clearfix"></div>

                                        <!-- bootstrap basic form -->
                                        <form action="" method="post">

                                            <div id="parent_div_1">
                                                <!-- FIRST NAME -->
                                                <label for="firstNameField">First Name</label>
                                                <input pattern="[a-zA-Z]{1,32}" type="text" class="form-control" name="Firstname" id="firstNameField" placeholder="First Name"
                                                       title="First name should only contain letters. e.g. John">
                                            </div>
                                            <div id="parent_div_2">
                                                <!-- LAST NAME -->
                                                <label for="lastNameField">Last Name</label>
                                                <input pattern="[a-zA-Z]{1,32}" type="text" class="form-control" name="Lastname" id="lastNameField" placeholder="Last Name">
                                            </div>

                                            <div class="form-group">
                                                <!-- STUDENT ID / STAFF ID USERNAME -->
                                                <label for="usernameField">Student ID / Staff ID</label>
                                                <input pattern="[0-9]{1,10}" type="text" class="form-control" name="ID" id="usernameField" placeholder="ID">
                                            </div>

                                            <div class="form-group">
                                                <!-- EMAIL -->
                                                <label for="emailField">Email</label>
                                                <input type="email" class="form-control" name="Email" id="emailField" placeholder="Email">
                                            </div>
                                            <div class="12u$">
                                                <!-- MAJOR -->
                                                <div class="select-wrapper more-padding">
                                                    <label for="majorField">Major</label>
                                                    <select name="Major" id="majorField">
                                                        <option value="">- Major -</option>
                                                        <option value="Accounting & Finance">Manufacturing</option>
                                                        <option value="Biology">Biology</option>
                                                        <option value="Civil Engineering">Civil Engineering</option>
                                                        <option value="Chemistry">Chemistry</option>
                                                        <option value="Computer Science">Computer Science</option>
                                                        <option value="Electrical & Computer Engineering">Electrical & Computer Engineering</option>
                                                        <option value="Financial Maths">Financial Maths</option>
                                                        <option value="History">History</option>
                                                        <option value="Microbiology">Microbiology</option>
                                                        <option value="Sociology">Sociology</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <!-- PASSWORD -->
                                                <label for="passwordField">Password</label>
                                                <input type="password" class="form-control" name="Password" id="passwordField" placeholder="Password">
                                            </div>
                                            <div class="form-group">
                                                <!-- CONFIRM PASSWORD -->
                                                <label for="passwordField">Confirm Password</label>
                                                <input type="password" class="form-control showpassword" name="confirm_password" id="passwordField" placeholder="Password">
                                            </div>
                                            <!-- reCaptcha -->
											<!-- server: 6LdyxRwUAAAAABjSfPgo3NTV2K3Y3-QGo85XD-0N
												local: 6LfnihwUAAAAABIYB6AsjdrQ_ryFn-3DKaQPDfXn
											-->
                                            <div class="g-recaptcha" data-theme=\"light\" data-sitekey="6LfnihwUAAAAABIYB6AsjdrQ_ryFn-3DKaQPDfXn"></div>
											
                                            <!-- Cross-Site Request Forgery (CSRF)protection -->
                                            <input type="hidden" name="token" value="<?php echo _token(); ?>">
                                            <!-- SUBMIT -->
                                            <button type="submit" name="signupButton" class="special button-float-right">Sign up</button>
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