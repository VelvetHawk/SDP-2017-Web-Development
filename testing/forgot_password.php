

<?php
$page_title = "User authentication - Password Reset";
include_once 'partials/headers.php';
include_once 'partials/parsePasswordReset.php';
?>

<div class="container">
    <section class="col col-lg-7">

        <h2>Password Reset Form</h2><hr>

        <!-- keep error seperate from rest of form -->
        <div>
            <?php if(isset($result)) echo $result; ?>
            <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
        </div>

        <div class="clearfix"></div>



        <!-- bootstrap basic form -->
        <form action="" method="post">

            <!-- EMAIL -->
            <div class="form-group">
                <label for="emailField">Email Address</label>
                <input type="text" class="form-control" name="email" id="emailField" placeholder="Email">
            </div>

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

            <button type="submit" name="passwordResetBtn" class="btn btn-primary pull-right">Reset Password</button>
        </form>
    </section>
    <p><a href="index.php">Back</a></p>
</div>
<?php
include_once 'partials/footers.php'
?>
</body>
</html>