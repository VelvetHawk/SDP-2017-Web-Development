<?php
/**
 * @param $required_fields_array, an array containing the list of all the required fields
 * @return array, containing all errors
 */
function check_empty_fields($required_fields_array) {
    // initialize an Array to store any error messages
    $form_errors = array();

    /*
     * Loop through the required_fields array with each indexed position being assigned to name_of_field.
     * Condition first checks if email is set OR the value of email is equal to NULL, if that is true we assign
     * email to the form_error array. Next we check if the username is not set or if the value entered by user is
     * equal to null we store username in the form_errors array. Same for password.
     */
    foreach($required_fields_array as $name_of_field) {
        if(!isset($_POST[$name_of_field]) || $_POST[$name_of_field]==NULL) {
            $form_errors[] = $name_of_field . " is a required field";
        }
    }
    return $form_errors;
}
/**
 * @param $fields_to_check_length, an array containing the name of fields
 * for which we want to check min required length e.g array('username => 4, 'email' => 12)
 * @return array, containing all errors
 */
function check_min_length($fields_to_check_length) {
    // Initialize an array to store error messages
    $form_errors = array();

    foreach($fields_to_check_length as $name_of_field => $minimum_length_required) {
        if(strlen(trim($_POST[$name_of_field])) < $minimum_length_required) {
            $form_errors[] = $name_of_field . " is too short, must be {$minimum_length_required} characters long";
        }
    }
    return $form_errors;
}
/**
 * @param $data, store a key/value pair array where key is the name of the control
 * in this case 'email' and value is the entered by the user
 * @return array containing error
 */
function check_email($data) {
    // Initialize an array to store error messages
    $form_errors = array();
    $key = 'email';
    // Check if the key email exists in data array
    if(array_key_exists($key, $data)) {

        // Check if the email field has a value
        if($_POST[$key] != null) {

            // Remove all illegal characters from email
            $key = filter_var($key, FILTER_SANITIZE_EMAIL);

            // Check if input is a value email address
            if(filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) === false) {
                $form_errors[] = $key . " is not a valid email address";
            }
        }
    }
    return $form_errors;
}
/**
 * @param $form_errors_array, the array holding all
 * errors which we want to loop through
 * @return string, list containing all error messages
 */
function show_errors($form_errors_array) {
    $errors = "<p><ul style='color: red;'>";

    // Loop through error array and display all the items in a list
    foreach($form_errors_array as $the_error) {
        $errors .= "<li> {$the_error} </li>";

    }
    $errors .= "</ul></p>";
    return $errors;
}

/**
 * @param $message replace with an error message
 * @param string $passOrFail pass in "pass" with the function if its a positive message
 * @return string
 */
function flashMessage($message, $passOrFail = "Fail") {
    if($passOrFail === "Pass") {
        $data = "<div class='alert alert-success'></div><p>{$message}</p>";
    } else {
        $data = "<div class='alert alert-danger'<p>{$message}</p>";
    }

    return $data;
}

/**
 * @param $page pass in the page to redirect to
 */
function redirectTo($page) {
    header("location: {$page}.php");
}

/**
 * @param $value
 * @param $pdo
 * @return bool
 * UPDATE: now more flexible
 */
function checkDuplicateEntries($table, $column_name, $value, $pdo) {
    try {
        $sqlQuery = "SELECT * FROM " .$table. " WHERE " .$column_name."=:$column_name";
        $statement = $pdo->prepare($sqlQuery);
        $statement->execute(array(":$column_name" => $value));

        if($row = $statement->fetch()) {
            return true;
        }
        return false;
    } catch (PDOException $ex) {
        // handle exemption
    }
}

/**
 * @param $user_id
 */
function rememberMe($user_id) {
    $encryptCookieData = base64_encode("rememberthisstring{$user_id}");
    // cookie set to expire in 15 days, 1 hour would be 3600
    setcookie("rememberUserCookie", $encryptCookieData, time()+60*60*24*15 , "/");
}

/**
 * check if cookie used is same with the encrypted cookie
 * @param $pdo, database connection link
 * @return bool, true if the user cookie is valid
 */
function isCookieValid($pdo) {
    $isValid = false;

    if(isset($_COOKIE['rememberUserCookie'])) {
        /*
         * decode cookies and extract user ID
         */
        $decryptCookieData = base64_decode($_COOKIE['rememberUserCookie']);
        $user_id = explode("rememberthisstring", $decryptCookieData);
        $userID = $user_id[1];

        /*
         * check if ID retrieved from the cookie exists in the database
         */
        $sqlQuery = "SELECT * FROM users WHERE id = :id";
        $statement = $pdo->prepare($sqlQuery);
        $statement->execute(array(':id' => $userID));

        if($row = $statement->fetch()) {
            $id = $row['id'];
            $username = $row['username'];

            /*
             * Create the user session variable
             */
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $isValid = true;
        } else {
            /*
             * cookie ID is invalid destroy session and logout user
             */
            $isValid = false;
            signout();
        }
    }
    return $isValid;
}

/**
 * destroy time of cookie
 */
function signout() {
    unset($_SESSION['username']);
    unset($_SESSION['id']);

    if(isset($_COOKIE['rememberUserCookie'])) {
        unset($_COOKIE['rememberUserCookie']);
        setcookie('rememberUserCookie', null, -1, '/');
    }
    session_destroy();
    session_regenerate_id(true);
    redirectTo('index');
}

function guard() {
    $isValid = true;
    $inactive = 60*2; // 2 mins
    $fingerprint = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

    if((isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] != $fingerprint)) {
        $isValid = false;
        signout();
    } else if((isset($_SESSION['last_active']) && (time() - $_SESSION['last_active']) > $inactive) && $_SESSION['username']) {
        $isValid = false;
        signout();
    } else {
        $_SESSION['last_active'] = time();
    }
    return $isValid;
}
