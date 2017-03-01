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

        // implement cookie remember me functions here
        // has the user clicked the remember me button
        isset($_POST['remember']) ? $remember = $_POST['remember'] : $remember = "";
        // Check if user exists in the database
        $sqlQuery = "SELECT * FROM users WHERE username = :username";
        $statement = $pdo->prepare($sqlQuery);
        $statement->execute(array(':username' => $user));

        if ($row = $statement->fetch()) {
            $id = $row['id'];
            $hashed_password = $row['password'];
            $username = $row['username'];

            if (password_verify($password, $hashed_password)) {
                // create session when user logs into system
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;

                // store IP address of user trying to log in to the system and concatanate it with
                // string that is produced by the browser itself and sent to the webserverto identify itself
                // so that websites are able to send different content based on the type of browser your using
                // and browser compatibility
                $fingerprint = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
                $_SESSION['last_active'] = time(); // system time of webserver (when user logged into system)
                $_SESSION['fingerprint'] = $fingerprint;

                // if remember me is equal to value we set
                if ($remember === "yes") {
                    rememberMe($id);
                }

                // call sweet alert
                echo $welcome = "<script type=\"text/javascript\">
                                swal({
                                      title: \"Welcome back $username!\",
                                      text: \"You are being logged in.\",
                                      type: 'success',
                                      timer: 2000, /*3 seconds*/
                                      showConfirmButton: false
                                    });
                                    
                                   setTimeout(function(){
                                                window.location.href = 'index.php';
                                              }, 2000);
                            </script>";
                // this php will be processed BEFORE the above javascript
                // redirectTo('index');
            } else {
                // if error store message in result
                $result = flashMessage("You have entered an invalid password");

            }
        } else {
            $result = flashMessage("You have entered an invalid username");
        }
    } else {
        if(count($form_errors) == 1) {
            $result = flashMessage("There was one error in the form");
        } else {
            $result = flashMessage("There was " .count($form_errors). " errors in the form");
        }
    }
}