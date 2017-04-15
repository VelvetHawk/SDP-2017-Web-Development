<?php
include_once 'res/utils/Functions.php';
//initialiseConnection();
cookie();
$cookie_name = "logins";

// If login button was clicked
if(isset($_POST['loginButton'], $_POST['token'])) {

    // RECAPTCHA
    //$url = 'https://www.google.com/recaptcha/api/siteverify';
    // local $privateKey = '6LfnihwUAAAAAEyRZd_yk2tU8u4_p3lOvddoSKkD';
    // server $privateKey = '6LdyxRwUAAAAABlLlPnjHgPQr5P1YG0wgNQRdg8j';
    //$privateKey = '6LdyxRwUAAAAABlLlPnjHgPQr5P1YG0wgNQRdg8j';
    //$response = file_get_contents($url."?secret=".$privateKey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['http://testweb3.csisad.ul.campus']);

    /*
     * FOR HOME USE
     *
    */
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $privateKey = '6LfnihwUAAAAAEyRZd_yk2tU8u4_p3lOvddoSKkD';
    $response = file_get_contents($url."?secret=".$privateKey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $data = json_decode($response);
    /*
     *
     * */

    // need to validate token
    if (validate_token($_POST['token'])) {
        // Initialise array to hold errors
        $form_errors = array();

        // Validate
        $required_fields = array('username', 'password');

        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

        // If no error found
        if (empty($form_errors)) {

            // Collect form data
            $user = $_POST['username'];
            $password = $_POST['password'];

            // implement cookie remember me functions here
            // has the user clicked the remember me button
            isset($_POST['remember']) ? $remember = $_POST['remember'] : $remember = "";

            $sqlQuery = "SELECT * FROM banned WHERE user_id = :username";
            $statement = $GLOBALS['pdo'] -> prepare($sqlQuery);
            $statement->execute(array(':username' => $user));

            if ($row = $statement->fetch()) {
                $banned = $row['user_id'];

                if ($banned == $user) {
                    $result = "<script type='text/javascript'>
                                    swal({
                                          title: 'BANNED!',
                                          text: 'Please contact an admin on the About page',
                                          type: 'error',
                                          showConfirmButton: true
                                        });
                                </script>";
                } else {
                    $result = flashMessage("You have entered an invalid password");
                }

            } else {
                // Check if user exists in the database
                $sqlQuery = "SELECT * FROM users WHERE user_id = :username";
                $statement = $GLOBALS['pdo'] -> prepare($sqlQuery);
                $statement->execute(array(':username' => $user));

                if ($row = $statement->fetch()) {
                    //$id = $row['id'];
                    $hashed_password = $row['_password'];
                    $username = $row['user_id'];
                    $firstName = $row['first_name'];
                    $activated = $row['activated'];

                    if($activated == "0") {
                        $result = flashMessage("Please activate your account");
                    } else {
                        if (password_verify($password, $hashed_password)) {

                            // create session when user logs into system
                            //$_SESSION['id'] = $id;
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
                                rememberMe($username);
                            }

                            // call sweet alert
                            $result = "<script type='text/javascript'>
                                    swal({
                                          title: 'Welcome to your dashboard $firstName!',
                                          text: 'You are being logged in.',
                                          type: 'success',
                                          timer: 2000, /*2 seconds*/
                                          showConfirmButton: true
                                        });
                                </script>";

                            echo "<script type=\"text/javascript\"> setTimeout(function(){ window.location.href = 'home.php'; }, 2000); </script>";

                            // redirectTo("home"); # FOR LATER USE

                            // this php will be processed BEFORE the above javascript
                            // redirectTo('index');
                        } else {
                            // if error store message in result
                            $result = flashMessage("You have entered an invalid password");
                            setcookie($cookie_name, $_COOKIE[$cookie_name] += 1, time() + (60 * 30), "/");

                        }
                    }
                } else {
                    $result = flashMessage("You have entered an invalid username");
                    setcookie($cookie_name, $_COOKIE[$cookie_name] += 1, time() + (60 * 30), "/");
                }
            }
        } else {
            if(count($form_errors) == 1) {
                $result = flashMessage("There was one error in the form ");
                setcookie($cookie_name, $_COOKIE[$cookie_name] += 1, time() + (60 * 30), "/");
            } else {
                $result = flashMessage("There were " .count($form_errors). " errors in the form");
                setcookie($cookie_name, $_COOKIE[$cookie_name] += 1, time() + (60 * 30), "/");
            }
        }
    } else {
        // error
        $result = "<script type='text/javascript'>
                        swal('Error', 'This request originates from an unknown source, possible attack',
                        'error');
                        </script>";
        setcookie($cookie_name, $_COOKIE[$cookie_name] += 1, time() + (60 * 30), "/");
    }
}
?>