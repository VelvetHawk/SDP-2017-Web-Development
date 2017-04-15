<?php

include_once 'res/Database.php';
include_once 'res/utilities.php';

// Is the button clicked and not null
if(isset($_POST['createTaskButton'])) {

    // initialize an Array to store any error messages
    $form_errors = array();

    // Find list of elements of the form that are required. Specify each of the items we want user to supply
    $required_fields = array('taskTitle', 'taskType', 'taskDescription', 'taskTags', 'taskPageCount', 'taskWordCount', 'format');

    // Call the function to check empty field and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    // Fields that require checking for minimum length
    $fields_to_check_length = array('taskTitle' => 4, 'taskDescription' => 12);

    // Call the function to check minimum required length and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

    // Collect form data and store in variables
    $taskTitle = $_POST['taskTitle'];
    $taskType = $_POST['taskType'];
    $taskDescription = $_POST['taskDescription'];
    $taskTags = $_POST['taskTags'];
    $taskPageCount = $_POST['taskPageCount'];
    $taskWordCount = $_POST['taskWordCount'];
    $format = $_POST['format'];

    // Check if the error array is empty. If it is empty then no error has been returned. If yes process form data and insert record
    if (empty($form_errors)) {
        try {

            // Create SQL insert statement
            $sqlInsert = "INSERT INTO Tasks (task_title, task_type, description, tags, page_length, word_length, file_format)
                  VALUES (:taskTitle, :taskType, :taskDescription, :taskTags, :taskPageCount, :taskWordCount, :format)";

            // Prepare a statement for execution and returns a statement object
            $statement = $pdo->prepare($sqlInsert);

            // Add the data into the database
            $statement->execute(array(':taskTitle' => $taskTitle, ':taskType' => $taskType, ':taskDescription' => $taskDescription, ':taskTags' => $taskTags, ':taskPageCount' => $taskPageCount, ':taskWordCount' => $taskWordCount, ':format' => $format));


            // Check if one new row was created
            if ($statement->rowCount() == 1) {
                // when registration is successful flash this message
                $result = "<script type=\"text/javascript\">
                                swal({
                                      title: \"Congratulations \",
                                      text: \"Task successfully Submitted.\",
                                      type: 'success',
                                      confirmButtonText: \"Thank you!\"
                                    });
                            </script>";
            }
        } catch (PDOException $ex) {
            $result = flashMessage("An error occurred: " .$ex->getMessage());
        }
    } else {
        if(count($form_errors)==1) {
            $result = flashMessage("There was 1 error in the form<br>");
        } else {
            $result = flashMessage("There were ".count($form_errors)." errors in the form <br>");
        }
    }
}