<?php
    //add our database connection script
    include_once 'res/utils/Functions.php';

    //process the form if the change password button is clicked and token is sent
    if(isset($_POST['changePasswordButton'], $_POST['token'])) {

        if (validate_token($_POST['token'])) {
            //initialize an array to store any error message from the form
            $form_errors = array();

            //Form validation
            $required_fields = array('current_password', 'new_password', 'confirm_password');

            //call the function to check empty field and merge the return data into form_error array
            $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

            //Fields that requires checking for minimum length
            $fields_to_check_length = array('new_password' => 6, 'confirm_password' => 6);

            //call the function to check minimum required length and merge the return data into form_error array
            $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

            //email validation / merge the return data into form_error array
            $form_errors = array_merge($form_errors, check_email($_POST));

            //check if error array is empty, if yes process form data and insert record
            if(empty($form_errors)) {
                $id = $_POST['hidden_id'];
                $current_password = $_POST['current_password'];
                //collect form data and store in variables
                $password1 = $_POST['new_password'];
                $password2 = $_POST['confirm_password'];

                //check if new password and confirm password is same
                if($password1 != $password2){
                    /*$result = "<p style='padding:20px; border: 1px solid gray; color: red;'> New password and confirm password does not match</p>";*/
                    $result = flashMessage("New password and confirm password does not match");
                }else{
                    try{
                        // is current password what we have in db
                        $sqlQuery = "SELECT _password FROM users WHERE user_id = :id";
                        $statement = $GLOBALS['pdo']->prepare($sqlQuery);
                        $statement->execute(array(':id' => $id));
                        // is record found
                        if ($row = $statement->fetch()) {
                            $passwordFromDatabase = $row['_password'];

                            if (password_verify($current_password, $passwordFromDatabase)) {
                                // has new password
                                $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
                                // sql STATEMENT TO UPDATE PASSWORD
                                $sqlUpdate = "UPDATE users SET _password = :password WHERE user_id = :id";
                                $statement = $GLOBALS['pdo']->prepare($sqlUpdate);
                                $statement->execute(array(':password' => $hashed_password, ':id' => $id));

                                if($statement->rowCount() === 1) {
                                    $result = "<script type=\"text/javascript\">
                                        swal({
                                        title: \"SUCCESSFUL\",
                                        text: \"You updated your password\",
                                        type: 'success',
                                        confirmButtonText: \"Thank you!\" });
                                        </script>";
                                } else {
                                    $result = flashMessage("No changes have been saved");
                                }
                            } else {

                                $result = "<script type=\"text/javascript\">
                                        swal({
                                        title: \"THERE IS A PROBLEM\",
                                        text: \"Old password is not correct, please try again\",
                                        type: 'error',
                                        confirmButtonText: \"Ok!\" });
                                        </script>";
                            }
                        } else {
                            // not valid user
                            signout();
                        }

                    } catch (PDOException $ex) {

                    }
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
}