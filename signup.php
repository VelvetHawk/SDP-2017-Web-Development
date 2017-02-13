<?php
// Add database connection script
include_once 'res/Database.php';


// Process the form
// Is the button clicked and not null
if(isset($_POST['signupButton'])) {
    // initialize an Array to store any error messages
    $form_errors = array();

    // Find list of elements of the form that are required
    // Specify each of the items we want user to supply
    $required_fields = array('email', 'username', 'password');

    /*
     * Loop through the required_fields array with each indexed position being assigned to name_of_field.
     * Condition first checks if email is set OR the value of email is equal to NULL, if that is true we assign
     * email to the form_error array. Next we check if the username is not set or if the value entered by user is
     * equal to null we store username in the form_errors array. Same for password.
     */
    foreach($required_fields as $name_of_field) {
        if(!isset($_POST[$name_of_field]) || $_POST[$name_of_field]==NULL) {
            $form_errors[] = $name_of_field;
        }
    }

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
                $result = "<p style='padding: 20px; color: green;'>Registration successful</p>";
            }
        } catch (PDOException $ex) {
            $result = "<p style='padding: 20px; color: red;'>Registration not successful:" . $ex->getMessage() . "</p>";
        }
    } else {
        if(count($form_errors)==1) {
            $result = "<p style='color: red;'>There was one error in the form<br>";
            $result .= "<ul style='color: red;'>";
            // Loop through error array and display item
            foreach ($form_errors as $error) {
                $result .= "<li> {$error} </li>";
            }
            $result .= "</ul></p>";
        } else {
            $result = "<p style='color: red;'>There were ".count($form_errors)." errors in the form <br>";
            $result .= "<ul style='color: red;'>";
            // Loop through error array and display all items
            foreach($form_errors as $error) {
                $result .= "<li> {$error}</li>";
            }
            $result .= "</ul></p>";
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

<?php if(isset($result)) echo $result;?>
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