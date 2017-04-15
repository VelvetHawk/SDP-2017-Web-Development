<?php
include_once 'res/utils/Functions.php';

// check if session id is set or or url user_identity is set and
// user has not clicked on the update profile button
if((isset($_SESSION['username']) || isset($_GET['user_identity'])) && !isset($_POST['updateProfileButton'])) {

    // if user identity value is set then decode it then extract id
    // of user using explode to convert string to array
    if(isset($_GET['user_identity'])) {
        $url_encoded_id = $_GET['user_identity'];
        $decode_id = base64_decode($url_encoded_id);
        $user_id_array = explode("encodeuserid", $decode_id);
        $id = $user_id_array[1];
    } else {
        // if user_identity get varaible is not set then we store session id so
        // we can continue to query db and pull out info for user
        $id = $_SESSION['username'];
    }

    $sqlQuery = "SELECT * FROM users WHERE user_id = :id";
    $statement = $GLOBALS['pdo']->prepare($sqlQuery);
    $statement->execute(array(':id' => $id));

    while($rs = $statement->fetch()) {
        $username = $rs['user_id'];
        $email = $rs['email'];
        $date_joined = strftime("%b %d, %Y", strtotime($rs["date_joined"]));
    }

    $user_pic = "res/pictures/".$id."jpg";
    $default = "res/pictures/default-profile.jpg";

    if(file_exists($user_pic)){
        $profile_picture = $user_pic;
    } else {
        $profile_picture = $default;
    }

    $encode_id = base64_encode("encodeuserid{$id}");

    // code run when user clicks update button
} else if(isset($_POST['updateProfileButton'])) {
    // Initialize an array to store any error message from the form
    $form_errors = array();

    // form validation
    $required_fields = array('email', 'username');

    // call the function to check empty field and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    // fields that require checking for minimum length
    $fields_to_check_length = array('username' => 4);

    // call the function to check minimum required length and merge te return data into form_error array
    $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

    // email validation / merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_email($_POST));

    // validate if file has a valid extension
    isset($_FILES['fileToUpload']['name']) ? $avatar = $_FILES['fileToUpload']['name'] : $avatar = null;

    if($avatar != null) {
        $form_errors = array_merge($form_errors, isValidImage($avatar));
    }

    // collect form data and store in varaibles
    $email = $_POST['email'];
    $username = $_POST['username'];
    $hidden_id = $_POST['hidden_id'];

    if(empty($form_errors)) {
        list ($user, $domain) = explode('@', $email);
        if($domain == 'ul.ie' || $domain == 'studentmail.ul.ie') {
            try {
                // create SQL update statement
                $sqlUpdate = "UPDATE users SET user_id =:username, email =:email WHERE user_id =:id";

                // use PDO prepared to sanitize data
                $statement = $GLOBALS['pdo']->prepare($sqlUpdate);

                // update the record in the database
                $statement->execute(array(':username' => $username, ':email' => $email, ':id' => $hidden_id));

                // check if one new row was created
                if($statement->rowCount() == 1 || uploadAvatar($username)) {
                    $result = "<script type=\"text/javascript\">
                                        swal({
                                        title: \"Updated!\",
                                        text: \"Profile Update Successfully.\",
                                        type: 'success',
                                        confirmButtonText: \"Ok!\",
                                        timer: 2000 /*2 seconds*/});
                                        </script>";

                } else {
                    $result = "<script type=\"text/javascript\">swal(\"Nothing happened\",\"You have not made any changes.\");</script>";
                }
            } catch (PDOException $ex) {
                $result = flashMessage("An error occurred in : " . $ex->getMessage());
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
        if(count($form_errors) == 1) {
            $result = flashMessage("There was 1 error in the form<br>");
        } else {
            $result = flashMessage("There were " .count($form_errors). "errors in the form <br>");
        }
    }
}