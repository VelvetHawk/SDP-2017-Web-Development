<?php
    if (file_exists("res/utils/Functions.php"))
        include_once 'res/utils/Functions.php';
    else
        include_once '../utils/Functions.php';

    // check if session id is set or or url user_identity is set and
    // user has not clicked on the update profile button
    if((isset($_SESSION['username']) || isset($_GET['user_identity'])) && !isset($_POST['updateProfileButton']))
    {

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

        // Get current subscribed tags
        $subscribed = "";
        $tag_ids;
        $query_subscribed = "SELECT subscribed_tags FROM assigned_tags WHERE user_id = '" . $_SESSION['username'] . ";'";
        foreach ($GLOBALS['pdo'] -> query($query_subscribed) as $tag_id)
            $tag_ids = $tag_id['subscribed_tags'];
        $tag_ids = explode(",", $tag_ids);
        // Retrieve values from DB
        $size = sizeof($tag_ids);
        for ($i = 0; $i < $size; $i++)
        { 
            foreach ($GLOBALS['pdo'] -> query("SELECT _value FROM Tags WHERE tag_id = '" . $tag_ids[$i] . "';") as $tag_id)
            {
                if ($i < $size-1)
                    $subscribed .= $tag_id['_value'] . ", ";
                else
                    $subscribed .= $tag_id['_value'];
            }
        }

        // Convert to HTML list
        $subscribed_HTML = "";
        if ($subscribed != "")
        {
            $temp = explode(", ", $subscribed);
            for ($i = 0; $i < sizeof($temp); $i++)
            { 
                $subscribed_HTML .= 
                    "<span class=\"tag-wrapper\" id=\"$i\"><span class=\"tag-text\" contenteditable=\"true\" onfocus=\"tagFocused()\" onblur=\"tagBlurred()\">" . $temp[$i] . "</span><span class=\"tag-cancel\" onClick=\"removeTag($i)\">×</span></span>";
            }
        }

        // code run when user clicks update button
    }
    else if (isset($_POST['updateProfileButton']))
    {

        // Initialize an array to store any error message from the form
        $form_errors = array();

        // form validation
        $required_fields = array('email');

        // call the function to check empty field and merge the return data into form_error array
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

        // email validation / merge the return data into form_error array
        $form_errors = array_merge($form_errors, check_email($_POST));

        // validate if file has a valid extension
        isset($_FILES['fileToUpload']['name']) ? $avatar = $_FILES['fileToUpload']['name'] : $avatar = null;

        if ($avatar != null)
        {
            $form_errors = array_merge($form_errors, isValidImage($avatar));
        }

        // collect form data and store in varaibles
        $email = $_POST['email'];
        $username = $_SESSION['username'];
        $hidden_id = $_POST['hidden_id'];

        if (empty($form_errors))
        {
            list ($user, $domain) = explode('@', $email);
            if ($domain == 'ul.ie' || $domain == 'studentmail.ul.ie')
            {
                try
                {
                    // create SQL update statement
                    $sqlUpdate = "UPDATE users SET email =:email WHERE user_id =:id";

                    // use PDO prepared to sanitize data
                    $statement = $GLOBALS['pdo']->prepare($sqlUpdate);

                    // update the record in the database
                    $statement->execute(array(':email' => $email, ':id' => $hidden_id));

                    // check if one new row was created
                    if($statement->rowCount() == 1 || uploadAvatar($username))
                    {
                        $result = "<script type=\"text/javascript\">
                                            swal({
                                            title: \"Updated!\",
                                            text: \"Profile Update Successfully.\",
                                            type: 'success',
                                            confirmButtonText: \"Ok!\",
                                            timer: 2000 /*2 seconds*/});
                                            </script>";
                    }
                    else
                    {
                        $result = "<script type=\"text/javascript\">swal(\"Nothing happened\",\"You have not made any changes.\");</script>";
                    }
                }
                catch (PDOException $ex)
                {
                    $result = flashMessage("An error occurred in : " . $ex->getMessage());
                }

                // Update tags too
                $tag_list = $_POST['tags'];
                try
                {
                    // List of subscribed tags
                    $subscribed_tags = array();
                    // Check which tags don't exist
                    $new_tags = array();
                    $word_list = explode(",", $tag_list); // List of tags as "words"
                    // Query to check _value column
                    $size = sizeof($word_list);
                    echo "Size: $size<br />";
                    for ($i = 0, $j = 0; $i < $size; $i++)
                    { 
                        foreach ($GLOBALS['pdo'] -> query("SELECT tag_id FROM Tags WHERE _value = '" . $word_list[$i] . "';") as $tag)
                        {
                            if (is_int($tag['tag_id']))
                            {
                                echo "$word_list[$i] was found in tags<br />";
                                $subscribed_tags[$j] = $tag['tag_id'];
                                unset($word_list[$i]);
                                $j++;
                            }
                        }
                    }

                    // Update Tags table with new undefined tags
                    foreach ($word_list as $new_value)
                    {
                        echo "New value: $new_value<br />";
                        $query = "INSERT INTO Tags (_value) VALUES ('$new_value');";
                        $GLOBALS['pdo'] -> query($query);
                        foreach ( $GLOBALS['pdo'] -> query("SELECT tag_id FROM tags WHERE _value = '$new_value';") as $tag_id)
                            array_push($subscribed_tags, $tag_id['tag_id']);
                    }

                    $query = "UPDATE assigned_tags SET subscribed_tags = '" . implode(",", $subscribed_tags) ."' WHERE user_id = $username";
                    $GLOBALS['pdo'] -> query($query);
                }
                catch (PDOException $ex)
                {
                    $result = flashMessage("An error occurred in : " . $ex->getMessage());
                }
            }
            else
            {
                $result = "<script type=\"text/javascript\">
                                            swal({
                                            title: \"INCORRECT DOMAIN\",
                                            text: \"Only 'ul.ie' and 'studentmail.ul.ie' are accepted domains\",
                                            type: 'error',
                                            confirmButtonText: \"Ok!\",
                                            timer: 2000 /*2 seconds*/});
                                            </script>";
                redirectTo("../../edit-profile");
            }
            redirectTo("../../profile");
        }
        else
        {
            if (count($form_errors) == 1)
            {
                $result = flashMessage("There was 1 error in the form<br>");
            }
            else
            {
                $result = flashMessage("There were " .count($form_errors). "errors in the form <br>");
            }
            redirectTo("../../profile");
        }
        redirectTo("../../profile");
    }
?>