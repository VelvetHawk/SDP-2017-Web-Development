<?php

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

    // Collect form data and store in variables
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(checkDuplicateEntries("users", "email", $email, $pdo)) {
        $result = flashMessage("Email is already taken");
    }
    else if(checkDuplicateEntries("users", "username", $username, $pdo)) {
        $result = flashMessage("Username is already taken");
    }
    // Check if the error array is empty. If it is empty then no error has been returned.
    // If yes process form data and insert record
    else if(empty($form_errors)) {


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
                // when registration is successful flash this message
                $result = "<script type=\"text/javascript\">
                                swal({
                                      title: \"Congratulations $username!\",
                                      text: \"Registration completed successfully.\",
                                      type: 'success',
                                      confirmButtonText: \"Thank you!\"
                                    });
                            </script>";
            }
        } catch (PDOException $ex) {
            $result = flashMessage("An error occurred: " .$ex->getMessage());
        }
    } else {
        if(count($form_errors)==1) {
            $result = flashMessage("There was 1 error in the form<br>");
        } else {
            $result = flashMessage("There were ".count($form_errors)." errors in the form <br>");
        }
    }
}