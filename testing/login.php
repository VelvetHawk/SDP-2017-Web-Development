<?php
    $page_title = "User authentication - Login Page";
    include_once 'partials/headers.php';
    include_once 'partials/parseLogin.php';
    ?>

<div class="container">
    <section class="col col-lg-7">

        <h2>Login Form</h2><hr>

        <!-- keep error seperate from rest of form -->
        <div>
            <?php if(isset($result)) echo $result; ?>
            <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
        </div>

        <div class="clearfix"></div>


        <!-- bootstrap basic form -->
        <form action="" method="post">
            <div class="form-group">
                <!-- USERNAME -->
                <label for="usernameField">Username</label>
                <input type="text" class="form-control" name="username" id="usernameField" placeholder="Username">
            </div>
            <div class="form-group">
                <!-- PASSWORD -->
                <label for="passwordField">Password</label>
                <input type="password" class="form-control" name="password" id="passwordField" placeholder="Password">
            </div>
            <div class="form-group">
                <!-- FILE -->
                <label for="exampleInputFile">File input</label>
                <input type="file" id="exampleInputFile">
                <p class="help-block">Example block-level help text here.</p>
            </div>
            <div class="checkbox">
                <!-- REMEMBER ME CHECKBOX -->
                <label>
                    <input name="remember" value="yes" type="checkbox"> Remember me?
                </label>
            </div>
            <a href="forgot_password.php">F0rg07 p@55w0rd?</a>
            <button type="submit" name="loginButton" class="btn btn-primary pull-right">Sign in</button>
        </form>
    </section>
    <p><a href="index.php">Back</a></p>
</div>
    <?php
    include_once 'partials/footers.php'
    ?>
