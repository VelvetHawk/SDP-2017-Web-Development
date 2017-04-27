<?php
include_once 'res/utils/Functions.php';
// Is the button clicked and not null
if(isset($_POST['createTaskButton'])) {

    // initialize an Array to store any error messages
    $form_errors = array();
    // Find list of elements of the form that are required. Specify each of the items we want user to supply
    $required_fields = array('taskTitle', 'taskType', 'taskDescription', 'taskTags', 'taskPageCount', 'taskWordCount', 'format', 'review_deadline', 'claim_deadline');
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
    $username = $_SESSION['username'];
    $path_to_file = "files/docs/" . $taskType;
    $review_deadline = $_POST['review_deadline'];
    $claim_deadline = $_POST['claim_deadline'];

    if ($review_deadline < date("Y-m-d") || $claim_deadline < date("Y-m-d")) {
        // $result = "<p style='padding:20px; border: 1px solid gray; background-color: #f2dede; color: red;'> Review deadline and Claim deadline must be in the future!</p>";
    } else if ($claim_deadline > $review_deadline) {
        $result = "<p class=\"error\">Claim deadline must be before the review deadline</p>";
    }
    else {
        // Check if the error array is empty. If it is empty then no error has been returned. If yes process form data and insert record
        if (empty($form_errors)) {
            try {
                // Create SQL insert statement
                $sqlInsert = "INSERT INTO Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, page_length, word_length, file_format, path_to_file)
                  VALUES (:username, :taskTitle, :taskType, :taskDescription, :review_deadline, :claim_deadline, :taskTags, " . rand(0,1000000) . ", :taskPageCount, :taskWordCount, :format, :path_to_file)";
                // Prepare a statement for execution and returns a statement object
                $statement = $GLOBALS['pdo']->prepare($sqlInsert);
                // Add the data into the database
                $statement->execute(array(  ':username' => $username,
                    ':taskTitle' => $taskTitle,
                    ':taskType' => $taskType,
                    ':taskDescription' => $taskDescription,
                    ':taskTags' => $taskTags,
                    ':taskPageCount' => $taskPageCount,
                    ':taskWordCount' => $taskWordCount,
                    ':format' => $format,
                    ':path_to_file' => $path_to_file,
                    ':review_deadline' => $review_deadline,
                    ':claim_deadline' => $claim_deadline
                ));
                // Check if one new row was created
                if ($statement->rowCount() == 1) {
                    // when registration is successful flash this message
                    $result = "<script type=\"text/javascript\">
                                swal({
                                      title: \"Congratulations \",
                                      text: \"Task successfully Submitted.\",
                                      type: 'success',
                                      timer: 3000, /*3 seconds*/
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
}