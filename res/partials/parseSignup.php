<?php
    include_once "res/utils/Functions.php";

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
        $response = file_get_contents($url."?secret=".$privateKey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
        $data = json_decode($response);
        if(isset($data->success) AND $data->success==true) {
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
                    'Major',
                    'secretQuestion',
                    'secretAnswer'
                );

                // Call the function to check empty field and merge the return data into form_error array
                $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

                // Fields that require checking for minimum length
                $fields_to_check_length = array('Firstname' => 2,
                    'Lastname' => 2,
                    'secretAnswer' => 3,
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
                $secretQuestion = $_POST['secretQuestion'];
                $secretAnswer = $_POST['secretAnswer'];

                if(checkDuplicateEntries("users", "email", $email, $GLOBALS['pdo'])) {
                    $result = flashMessage("Email is already taken");
                }
                else if(checkDuplicateEntries("users", "username", $username, $GLOBALS['pdo'])) {
                    $result = flashMessage("User ID is already taken");
                }
                // Check if the error array is empty. If it is empty then no error has been returned.
                // If yes process form data and insert record
                else if(empty($form_errors)) {

                    list ($user, $domain) = explode('@', $email);
                    if($domain == 'ul.ie' || $domain == 'studentmail.ul.ie') {

                        $password1 = $_POST['Password'];
                        $password2 = $_POST['confirm_password'];
                        if($password1 != $password2){
                            $result = "<p style='padding:20px; border: 1px solid gray; background-color: #f2dede; color: red;'> New password and confirm password does not match</p>";
                        } else {
                            // Take password variable and apply password_hash function to it
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            $hashed_secretAnswer = password_hash($secretAnswer, PASSWORD_DEFAULT);
                            $hashed_secretQuestion = password_hash($secretAnswer, PASSWORD_DEFAULT);
                            try {

                                // Create SQL insert statement
                                $sqlInsert = "INSERT INTO users (user_id, email, _password, first_name, last_name, major, date_joined, secretQuestion, secretAnswer)
                                VALUES (:username, :email, :password, :first_name, :last_name, :major, now(), :secretQuestion, :secretAnswer)";

                                // Prepare a statement for execution and returns a statement object
                                $statement = $GLOBALS['pdo'] -> prepare($sqlInsert);

                                // Add the data into the database
                                $statement->execute(array(  ':username' => $username,
                                    ':email' => $email,
                                    ':password' => $hashed_password,
                                    ':first_name' => $first_name,
                                    ':last_name' => $last_name,
                                    ':major' => $major,
                                    ':secretQuestion' => $hashed_secretQuestion,
                                    ':secretAnswer' => $hashed_secretAnswer

                                ));


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
                                        setTimeout(function(){
                                                    window.location.href = 'login.php';
                                                  }, 2000);
                                </script>";
                                }
                            } catch (PDOException $ex) {
                                $result = flashMessage("An error occurred: " .$ex->getMessage());
                            }
                        }

                    } else {
                        $result = "<script type=\"text/javascript\">
                                        swal({
                                        title: \"INCORRECT DOMAIN\",
                                        text: \"Only 'ul.ie' and 'studentmail.ul.ie' are accepted domains\",
                                        type: 'error',
                                        confirmButtonText: \"Ok!\",
                                        timer: 2000 /*2 seconds*/});
                                        </script>";
                    }
                } else {
                    if(count($form_errors)==1) {
                        $result = flashMessage("There was 1 error in the form<br>");
                    } else {
                        $result = flashMessage("There were ".count($form_errors)." errors in the form <br>");
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
    }
?>