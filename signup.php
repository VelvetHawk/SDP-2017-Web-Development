
<?php
$page_title = "User authentication - Registration page";
include_once 'partials/headers.php';
include_once 'partials/parseSignup.php';
?>

<div class="container">
    <section class="col col-lg-7">

        <h2>Registration form</h2><hr>

        <!-- keep error seperate from rest of form -->
        <div>
            <?php if(isset($result)) echo $result; ?>
            <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
        </div>

        <div class="clearfix"></div>

        <!-- bootstrap basic form -->
        <form action="" method="post">
            <div class="form-group">
                <!-- EMAIL -->
                <label for="emailField">Email</label>
                <input type="email" class="form-control" name="email" id="emailField" placeholder="Email">
            </div>
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
            <button type="submit" name="signupButton" class="btn btn-primary pull-right">Sign up</button>
        </form>
    </section>
    <p><a href="index.php">Back</a></p>
</div>
<?php
include_once 'partials/footers.php'
?>
</body>
</html>