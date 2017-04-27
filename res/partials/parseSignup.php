<?php
include_once "res/utils/Functions.php";
include_once "res/utils/send-email.php";

// Process the form
// Is the button clicked and not null
if (isset($_POST['signupButton'], $_POST['token'])) {
    // testing
    /*$fields_string = '';
    $fields = array(
        'secret' => '6LdyxRwUAAAAABlLlPnjHgPQr5P1YG0wgNQRdg8j',
        'response' => $_POST['g-recaptcha-response']
    );
    foreach($fields as $key=>$value)
    $fields_string .= $key . '=' . $value . '&';
    $fields_string = rtrim($fields_string, '&');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);


    */

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $privateKey = '6LfnihwUAAAAAEyRZd_yk2tU8u4_p3lOvddoSKkD';
    $response = file_get_contents($url . "?secret=" . $privateKey . "&response=" . $_POST['g-recaptcha-response'] . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
    $data = json_decode($response);
    if (isset($data->success) AND $data->success == true) {
        if (validate_token($_POST['token'])) {
            // initialize an Array to store any error messages
            $form_errors = array();

            // Find list of elements of the form that are required
            // Specify each of the items we want user to supply
            // $required_fields = array(str_replace("first_","First ","first_name"), str_replace("last_","Last  ","last_name"), str_replace("Username","Student ID / Staff ID","Username"), 'Email', 'password');
            $required_fields = array('Email',
                'ID',
                'Password',
                'Firstname',
                'Lastname',
                'Major'
            );

            // Call the function to check empty field and merge the return data into form_error array
            $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

            // Fields that require checking for minimum length
            $fields_to_check_length = array('Firstname' => 2,
                'Lastname' => 2,
                'ID' => 4,
                'Password' => 6
            );

            // Call the function to check minimum required length and merge the return data into form_error array
            $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

            // Email validation / merge the return data into form_error array
            $form_errors = array_merge($form_errors, check_email($_POST));

            // Collect form data and store in variables
            $email = $_POST['Email'];
            $username = $_POST['ID'];
            $password = $_POST['Password'];
            $first_name = $_POST['Firstname'];
            $last_name = $_POST['Lastname'];
            $major = $_POST['Major'];

            if (checkDuplicateEntries("users", "email", $email, $GLOBALS['pdo'])) {
                $result = flashMessage("Email is already taken");
            } else if (checkDuplicateEntries("users", "username", $username, $GLOBALS['pdo'])) {
                $result = flashMessage("User ID is already taken");
            }
            // Check if the error array is empty. If it is empty then no error has been returned.
            // If yes process form data and insert record
            else if (empty($form_errors)) {

                list ($user, $domain) = explode('@', $email);
                if ($domain == 'ul.ie' || $domain == 'studentmail.ul.ie' || $domain == 'gmail.com') {

                    $password1 = $_POST['Password'];
                    $password2 = $_POST['confirm_password'];
                    if ($password1 != $password2) {
                        $result = "<p style='padding:20px; border: 1px solid gray; background-color: #f2dede; color: red;'> New password and confirm password does not match</p>";
                    } else {
                        // Take password variable and apply password_hash function to it
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        try {

                            // Create SQL insert statement
                            $sqlInsert = "INSERT INTO users (user_id, email, _password, first_name, last_name, major, date_joined)
                                VALUES (:username, :email, :password, :first_name, :last_name, :major, now())";

                            // Prepare a statement for execution and returns a statement object
                            $statement = $GLOBALS['pdo']->prepare($sqlInsert);

                            // Add the data into the database
                            $statement->execute(array(':username' => $username,
                                ':email' => $email,
                                ':password' => $hashed_password,
                                ':first_name' => $first_name,
                                ':last_name' => $last_name,
                                ':major' => $major
                            ));


                            // Check if one new row was created PDO rowCount function
                            if ($statement->rowCount() == 1) {

                                // get id of user that account has been created for
                                $user_id = $username;
                                $encode_id = base64_encode("encodeuserid{$user_id}");

                                // fill mail body //  set $mail-IsHTML(true);
                                $mail_body = '<html>
                                                <body style="background-color:#CCCCCC; color:#000; font-family Arial, Helvetica, sans-serif
                                                line-height:1.8em;">
                                                <h2>Proofreadr Sign up activation</h2>
                                                <p>Dear ' . $first_name . '<br><br>Thank you for signing up, please click on the link below to confirm your email.</p>
                                                <p><a href="http://localhost/SDP-2017/activate.php?id='.$encode_id.'"> Confirm</a></p>
                                                </body>
                                                </html>';

                                // who are we sending email to
                                $mail->addAddress($email, $username);
                                $mail->Subject = "Proofreadr Signup";
                                $mail->Body = $mail_body;

                                // check if mail sent
                                if (!$mail->send()) {
                                    $result = "<script type=\"text/javascript\">
                                                    swal(\"Error\",\" Email sending failed: $mail->ErrorInfo \",\"error\");
                                                    </script>";
                                } else {
                                    $result = "<script type=\"text/javascript\">
                                                    swal({
                                          title: \"Congratulations $username!\",
                                          text: \"Registration completed successfully, please check your email address . \",
                                          type: 'success',
                                          confirmButtonText: \"Thank you!\",
                                          closeOnConfirm: true
                                          //timer: 2000
                                        });
                                                                         setTimeout(function(){
                                                    window.location.href = 'login.php';
                                                  }, 5000);
                                                    </script>";
                                }
                            }
                        } catch (PDOException $ex) {
                            $result = flashMessage("An error occurred: " . $ex->getMessage());
                        }
                    }

                } else {
                    $result = "<script type=\"text/javascript\">
                                        swal({
                                        title: \"INCORRECT DOMAIN\",
                                        text: \"Only 'ul.ie' and 'studentmail.ul.ie' are accepted domains\",
                                        type: 'error',
                                        confirmButtonText: \"Ok!\",
                                        timer: 3000 /*2 seconds*/});
                                        </script>";
                }
            } else {
                if (count($form_errors) == 1) {
                    $result = flashMessage("There was 1 error in the form<br>");
                } else {
                    $result = flashMessage("There were " . count($form_errors) . " errors in the form <br>");
                }
            }
        } else {
            // error
            $result = "<script type='text/javascript'>
                        swal('Error', 'This request originates from an unknown source, possible attack',
                        'error');
                        </script>";
        }
    } else {
        $result = "<script type='text/javascript'>
                        swal('Error', 'Please use the reCaptcha before submitting',
                        'error');
                        </script>";
    }
} else if (isset($_GET['id'])){
    $encoded_id = $_GET['id'];
    $decode_id = base64_decode($encoded_id);
    $user_id_array = explode("encodeuserid", $decode_id);
    $id = $user_id_array[1];

    $sql = "UPDATE users SET activated =:activated WHERE user_id=:user_id AND activated='0'";

    $statement = $GLOBALS['pdo']->prepare($sql);
    $statement->execute(array(':activated' => "1", ':user_id' => $id));

    if ($statement->rowCount() == 1) {
        $result = '<h2>Email Confirmed</h2>
        <p>Your email address has been verified, you can now click <a href="login.php">here</a> to login with your email and password.</p>
        ';
    } else {
        $result = "<p>No changes have been made. Please confirm your email</p>";
    }
}
?>