<?php
// Add database connection script
include_once 'res/Database.php';
include_once 'res/utilities.php';


// Process the form
// Is the button clicked and not null
if(isset($_POST['signupButton'])) {

    // initialize an Array to store any error messages
    $form_errors = array();

    // Find list of elements of the form that are required
    // Specify each of the items we want user to supply
    $required_fields = array('email', 'username', 'password');

    // Call the function to check empty field and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    // Fields that require checking for minimum length
    $fields_to_check_length = array('username' => 4, 'password' => 6);

    // Call the function to check minimum required length and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

    // Email validation / merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_email($_POST));

    // Check if the error array is empty. If it is empty then no error has been returned.
    // If yes process form data and insert record
    if(empty($form_errors)) {
        // Collect form data and store in variables
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Take password variable and apply password_hash function to it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {

            // Create SQL insert statement
            $sqlInsert = "INSERT INTO users (username, email, password, join_date)
                  VALUES (:username, :email, :password, now())";

            // Prepare a statement for execution and returns a statement object
            $statement = $pdo->prepare($sqlInsert);

            // Add the data into the database
            $statement->execute(array(':username' => $username, ':email' => $email, ':password' => $hashed_password));


            // Check if one new row was created
            if ($statement->rowCount() == 1) {
                $result = "<p style='padding: 20px; border: 1px solid gray; color: green;'>Registration successful</p>";
            }
        } catch (PDOException $ex) {
            $result = "<p style='padding: 20px; border: 1px solid gray; color: red;'>Registration not successful:" . $ex->getMessage() . "</p>";
        }
    } else {
        if(count($form_errors)==1) {
            $result = "<p style='color: red;'>There was one error in the form<br>";
        } else {
            $result = "<p style='color: red;'>There were ".count($form_errors)." errors in the form <br>";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <title>Register Page</title>
    <link rel="stylesheet" type="text/css" href="styles.css?<?php echo time(); ?>">
</head>

<body>

<h2>User Authentication System</h2><hr>
<h3>Registration form</h3>

<?php if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors);
?>
<form method="post" action="">
    <table>
        <tr><td>Email:</td> <td><input type="text" value="" name="email"</td></tr>
        <tr><td>Username:</td> <td><input type="text" value="" name="username"</td></tr>
        <tr><td>Password:</td> <td><input type="password" value="" name="password"</td></tr>
        <tr><td></td> <td><input type="submit" value="Signup" name="signupButton"></td></tr>
    </table>
</form>
<p><a href="index.php">Back</a></p>
</body>
</html>