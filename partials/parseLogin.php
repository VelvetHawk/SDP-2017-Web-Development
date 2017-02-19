<?php
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

                // call sweet alert
                echo $welcome = "<script type=\"text/javascript\">
                                swal({
                                      title: \"Welcome back $username!\",
                                      text: \"You are being logged in.\",
                                      type: 'success',
                                      timer: 6000, /*6 seconds*/
                                      showConfirmButton: false
                                    });
                                    
                                   setTimeout(function(){
                                                window.location.href = 'index.php';
                                              }, 5000);
                            </script>";
                // this php will be processed BEFORE the above javascript
                // redirectTo('index');
            } else {
                // if error store message in result
                $result = flashMessage("Invalid username or password");

            }
        }
    } else {
        if(count($form_errors) == 1) {
            $result = flashMessage("There was one error in the form");
        } else {
            $result = flashMessage("There was " .count($form_errors). " errors in the form");
        }
    }
}