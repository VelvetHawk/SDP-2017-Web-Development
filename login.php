<?php
    include_once 'res/session.php';
    include_once 'res/Database.php';
    include_once 'res/utilities.php';

    // If login button was clicked
    if(isset($_POST['loginButton'])) {

        // Initialise array to hold errors
        $form_errors = array();

        // Validate
        $required_fields = array('username', 'password');

        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

        // If no error found
        if(empty($form_errors)) {
            // Collect form data
            $user = $_POST['username'];
            $password = $_POST['password'];
            // Check if user exists in the database
            $sqlQuery = "SELECT * FROM users WHERE username = :username";
            $statement = $pdo->prepare($sqlQuery);
            $statement->execute(array(':username' => $user));

            while($row = $statement->fetch()) {
                $id = $row['id'];
                $hashed_password = $row['password'];
                $username = $row['username'];

                if(password_verify($password, $hashed_password)) {
                    $_SESSION['id'] = $id;
                    $_SESSION['username'] = $username;
                    header("location: index.php");
                } else {
                    // if error store message in result
                    $result = "<p style='padding: 20px; color: red; border: 1px solid gray;'> Invalid username or password</p>";

                }
            }
        } else {
            if(count($form_errors) == 1) {
                $result = "<p style='color:red'>There was one error in the form</p>";
            } else {
                $result = "<p style='color:red'>There was " .count($form_errors). " errors in the form</p>";
            }
        }
    }
?>


<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="styles.css?<?php echo time(); ?>">
</head>

<body>

    <h2>User Authentication System</h2>
    <h3>Login Form</h3>
    <?php if(isset($result)) echo $result; ?>
    <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
    <form method="post" action="">
        <table>
            <tr><td>Username:</td> <td><input type="text" value="" name="username"></td></tr>
            <tr><td>Password:</td> <td><input type="password" value="" name="password"></td></tr>
            <tr><td><a href="forgot_password.php">Forgot Password?</a></td></td> <td><input type="submit" name="loginButton" value="Login button"></td></tr>
        </table>
    </form>
<p><a href="index.php">Back</a></p>
</body>
</html>