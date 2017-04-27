<?php
    //add our database connection script
    include_once 'res/utils/Functions.php';
    include_once 'res/utils/send-email.php';

    //process the form if the reset password button is clicked
    if(isset($_POST['passwordResetBtn'])){
        //initialize an array to store any error message from the form
        $form_errors = array();

        //Form validation
        $required_fields = array('new_password', 'confirm_password');

        //call the function to check empty field and merge the return data into form_error array
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

        //Fields that requires checking for minimum length
        $fields_to_check_length = array('new_password' => 6, 'confirm_password' => 6);

        //call the function to check minimum required length and merge the return data into form_error array
        $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

        //check if error array is empty, if yes process form data and insert record
        if(empty($form_errors)){
            //collect form data and store in variables
            $id = $_POST['user_id'];
            $password1 = $_POST['new_password'];
            $password2 = $_POST['confirm_password'];

            //check if new password and confirm password is same
            if($password1 != $password2){
                $result = flashMessage("New password and confirm password does not match");
            }else{
                try{
                    //create SQL select statement to verify if email address input exist in the database
                    $sqlQuery = "SELECT user_id FROM users WHERE user_id =:user_id";

                    //use PDO prepared to sanitize data
                    $statement = $GLOBALS['pdo'] -> prepare($sqlQuery);

                    //execute the query
                    $statement->execute(array(':user_id' => $id));

                    //check if record exist
                    if($statement->rowCount() == 1){
                        //hash the password
                        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

                        //SQL statement to update password
                        $sqlUpdate = "UPDATE users SET _password =:password WHERE user_id=:id";

                        //use PDO prepared to sanitize SQL statement
                        $statement = $GLOBALS['pdo'] -> prepare($sqlUpdate);

                        //execute the statement
                        $statement->execute(array(':password' => $hashed_password, ':id' => $id));

                        $result = "<script type=\"text/javascript\">
                                    swal({
                                          title: \"Updated!\",
                                          text: \"Password Reset Successful.\",
                                          type: 'success',
                                          confirmButtonText: \"Thank you\"
                                        });
                                        setTimeout(function(){
                                                    window.location.href = 'login.php';
                                                  }, 1000);
                                </script>";


                    }
                    else{
                        $result = "<script type=\"text/javascript\">
                                    swal({
                                          title: \"Oops!\",
                                          text: \"The email address provided does not exist in our database, please try again.\",
                                          type: 'error',
                                          confirmButtonText: \"Ok\"
                                        });
                                </script>";
                    }
                }catch (PDOException $ex){
                    $result = flashMessage("An error occurred: ".$ex->getMessage());
                }
            }
        }
        else{
            if(count($form_errors) == 1){
                $result = flashMessage("There was 1 error in the form<br>");
            }else{
                $result = flashMessage("There were " .count($form_errors). " errors in the form <br>");
            }
        }
        // password_recovery_link
    } else if (isset($_POST['passwordResetButton'])) {
        $form_errors = array();
        $required_fields = array('email');
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
        $form_errors = array_merge($form_errors, check_email($_POST));
        if(empty($form_errors)) {
            $email = $_POST['email'];
            try {
                $sqlQuery = "SELECT * FROM users WHERE email =:email";
                $statement = $GLOBALS['pdo']->prepare($sqlQuery);
                $statement->execute(array('email' => $email));
                if($rs = $statement->fetch()) {
                    $username = $rs['user_id'];
                    $first_name = $rs['first_name'];
                    $email = $rs['email'];
                    $encode_id = base64_encode("encodeuserid{$username}");

                    // prepare email body
                    //  set $mail-IsHTML(true);
                    $mail_body = '<html>
                    <body style="background-color:#CCCCCC; color:#000; font-family Arial, Helvetica, sans-serif
                    line-height:1.8em;">
                    <h2>Proofreadr Password Recovery</h2>
                    <p>Dear '.$first_name.'<br><br>to reset your password, please click on the link below</p>
                    <p><a href="http://localhost/SDP-2017/forgot_password.php?id='.$encode_id.'">Reset Password</a></p>
                    </body>
                    </html>';

                    $mail->addAddress($email, $username);
                    $mail->Subject = "Password Recovery from Proofreadr";
                    $mail->Body = $mail_body;

                    // Error handling for phpmailer
                    if(!$mail->send()) {
                        $result = "<script type=\"text/javascript\">
                        swal(\"Error\",\" Email sending failed: $mail->ErrorInfo \",\"error\");
                        </script>";
                    } else {
                        $result = "<script type=\"text/javascript\">
                        swal({
                        title: \"Password  Recovery !\",
                        text: \"Password Reset link sent succesfully, please check your email address.\",
                        type: 'success',
                        confirmButtonText: \"Thank You!\"
                        });                        
                        </script>";
                    }
                } else {
                    $result = "<script type=\"text/javascript\">
                    swal({
                    title: \"ERROR!\",
                    text: \"The email address provided does not exist in our database, please try again.\",
                    type: 'error',
                    confirmButtonText: \"Ok!\"
                    });
                    </script>";
                }
            } catch (PDOException $ex) {

            }
        } else{
            if(count($form_errors) == 1){
                $result = flashMessage("There was 1 error in the form<br>");
            }else{
                $result = flashMessage("There were " .count($form_errors). " errors in the form <br>");
            }
        }
    }
?>