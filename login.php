<?php
    $page_title = "Login Form";
    include_once "res/utils/Functions.php";
    //startSession();
    include_once 'res/partials/parseLogin.php';
    //initialiseConnection();
    cookie();
/* 	$w = stream_get_wrappers();
echo 'openssl: ',  extension_loaded  ('openssl') ? 'yes':'no', "\n";
echo 'http wrapper: ', in_array('http', $w) ? 'yes':'no', "\n";
echo 'https wrapper: ', in_array('https', $w) ? 'yes':'no', "\n";
echo 'wrappers: ', var_export($w); */
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
                                            <h2>Login Form</h2>
                                        </header>

                                    <!-- keep error seperate from rest of form -->
                                       <div>
                                            <?php if (isset($result)) echo $result; ?>
                                            <?php if (!empty($form_errors)) echo show_errors($form_errors); ?>
                                        </div>

                                        <!-- bootstrap basic form -->
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <!-- USERNAME -->
                                                <label for="usernameField">Student ID / Staff ID</label>
                                                <input type="text" class="form-control" name="username" id="usernameField" placeholder="ID">
                                            </div>
                                            <div class="form-group">
                                                <!-- PASSWORD -->
                                                <label for="passwordField">Password</label>
                                                <input type="password" class="form-control" name="password" id="passwordField" placeholder="Password">
                                            </div>
                                            <div class="12u$">
                                                <a class="child_div_1" href="password_recovery_link.php">Forgot password?</a>
                                            </div></br>

                                            <!--<div class="form-group">
                                                FILE
                                                <label for="exampleInputFile">File input</label>
                                                <input type="file" id="exampleInputFile">
                                                <p class="help-block">Example block-level help text here.</p>
                                            </div>
                                            -->
                                            <div class="checkbox child_div_1">
                                                <input type="checkbox" id="rememberMe" name="remember" value="yes">
                                                <label for="rememberMe">Remember me?</label></br>
                                            </div>
                                            </br></br>
											<!-- reCaptcha -->
											<!-- server: 6LdyxRwUAAAAABjSfPgo3NTV2K3Y3-QGo85XD-0N
												local: 6LfnihwUAAAAABIYB6AsjdrQ_ryFn-3DKaQPDfXn
											-->
                                            <?php /*if (isset($GLOBALS['logins']) && $GLOBALS['logins'] == true)
                                                echo "<div class=\"g-recaptcha-response\" data-theme=\"light\" data-sitekey=\"6LfnihwUAAAAABIYB6AsjdrQ_ryFn-3DKaQPDfXn\"></div>";
                                            */?>
                                            <!-- local key 6LdEER4UAAAAAAXZr1D9U2Z_JhHCeo6JyVAt_R2R -->
                                            <div class="g-recaptcha" data-sitekey="6LdEER4UAAAAAAXZr1D9U2Z_JhHCeo6JyVAt_R2R"></div>
                                            <input type="hidden" name="token" value="<?php echo _token(); ?>">
                                            <div class="12u$">
                                                <ul class="actions button-float-right">
                                                    <li><button name="loginButton" type="submit" value="Submit" class="special">Sign in</button></li>

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
