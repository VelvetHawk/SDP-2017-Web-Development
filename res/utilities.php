<?php
/**
 * @param $required_fields_array, an array containing the list of all the required fields
 * @return array, containing all errors
 */
function check_empty_fields($required_fields_array) {
    // initialize an Array to store any error messages
    $form_errors = array();

    // Find list of elements of the form that are required
    // Specify each of the items we want user to supply
    $required_fields = array('email', 'username', 'password');

    /*
     * Loop through the required_fields array with each indexed position being assigned to name_of_field.
     * Condition first checks if email is set OR the value of email is equal to NULL, if that is true we assign
     * email to the form_error array. Next we check if the username is not set or if the value entered by user is
     * equal to null we store username in the form_errors array. Same for password.
     */
    foreach($required_fields as $name_of_field) {
        if(!isset($_POST[$name_of_field]) || $_POST[$name_of_field]==NULL) {
            $form_errors[] = $name_of_field;
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
        if($_POST[$key] != NULL) {

            // Remove all illegal characters from email
            $key = filter_var($key, FILTER_SANITIZE_EMAIL);

            // Check if input is a value email address
            if(filter_var($_POST[$key], FILTER_VALIDATE_EMAIL)===false) {
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

    // Loop through error array and displayall the items in a list
    foreach($form_errors_array as $the_error) {
        $errors .= "<li {$the_error} </li>";
    }
    $errors .= "</ul></p>";
    return $errors;
}
?>