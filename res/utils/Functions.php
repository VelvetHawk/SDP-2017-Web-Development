<?php
	// echo "BBBBBBBBBBBBBLLLLLLLLLLLLLLLLLLEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH";

		// start session allow us to store users information using php superglobal variables
		// enable us to keep track of user logged in and remember the users information
		session_start();

		// Opens connection to DB by default when included
		try
		{
			// PDO
 			$host = "localhost";
			$db = "group17";
			$username = "root";
			$password = "root";
			$charset = "utf8";
			
			/*$host = "localhost";
			$db = "group17";
			$username = "group17";
			$password = "FELL-husband-SNOW-welcome";
			$charset = "utf8";*/

			$options = [	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
							PDO::ATTR_EMULATE_PREPARES   => false,
							PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
			];

			$GLOBALS['pdo'] = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $username, $password, $options);
		}
		catch (PDOException $e)
		{
			echo "<p class=\"error\"> There was an error!</p>";
		}

	// This will be called on all pages
	setIdCookie();

	# TO DO #

	// - Get user major
	// - Retrieve task list with students in same major
	// - Retrieve task list containing user's subscribed tags
	// - Retrieve task list containing user's assigned tags
	// - Remove duplicates2
	// - Sort list by review date
	// - Load a certain quantity only
	// - As user scrolls, enable infinite scroll
	
	#######

	function cookie()
	{
		$cookie_name = "logins";
		setcookie($cookie_name, 0, time() + (60 * 30), "/");
	}

	function setIdCookie()
	{
		if (isset($_SESSION['username']))
		{
			$cookie_name = "id";
			// Cookie will exist for 5 secs (), accessible at all points in site
			setcookie($cookie_name, $_SESSION['username'], time() + 5, "/");
		}
	}

	function deleteIdCookie()
	{
		$cookie_name = "id";
		setcookie($cookie_name, $_SESSION['username'], time() - 80000, "/");
	}

	function getUserMajor($user_number)
	{
		// Calls procedure on server
		$query_getMajor = "CALL getUserMajor(" . $user_number . ");";
		$test = array();
		// Cycles through the result of the query and returns the major of the user (always a single value)
		foreach ($GLOBALS['pdo'] -> query($query_getMajor) as $row) {
			array_push($test, $row['major']); // Array with single entry
		}
		return $test[0];

	}

	// function generateToken()
	// {
	// 	// Return a random string of size 12
	// 	$string = "";
	// 	for ($i = 0; $i < 64; $i++) { 
	// 		$string .= chr(rand(33, 126));
	// 	}
	// 	return $string;
	// }

	function getTasksByUser($user_number)
	{
		$query = "SELECT task_id FROM Tasks WHERE user_id = $user_number ORDER BY review_deadline ASC;";
		$tasks_by_user = array();
		$i = 0;
		foreach ($GLOBALS['pdo'] -> query($query) as $id_list)
		{
			$tasks_by_user[$i] = $id_list['task_id'];
			$i++;
		}
		return $tasks_by_user;
	}

	function getStudentsInSameMajor($major, $user_number)
	{
		# "user_id <> $user_number" prevents tasks by the user appearing
		$query_getSameMajors = "SELECT task_id FROM Tasks WHERE user_id IN (SELECT user_id FROM Users WHERE major = '$major' AND user_id <> $user_number) AND task_id NOT IN (SELECT task_id FROM claimed_tasks);";
		$tasks_sameMajor = array();
		$i = 0;
		// Cycles through all the task_id's returned, inserts into $tasks_sameMajor, incrementing from starting index/key 0
		foreach ($GLOBALS['pdo'] -> query($query_getSameMajors) as $task)
		{
			$tasks_sameMajor[$i] = $task['task_id'];
			$i++;
		}
		// Returns array of task_id's by students in the same major
		return $tasks_sameMajor;
	}

	function getSubscribedTags($user_number)
	{
		$tags_subscribed = array();
		$tasks_subscribed = array();
		// Returns the tags the user is subscribed to and converts to array
		foreach ($GLOBALS['pdo'] -> query("SELECT subscribed_tags FROM Assigned_tags WHERE user_id = $user_number;") as $tag_list) 
			$tags_subscribed = explode(",", $tag_list['subscribed_tags']);
		
		// Retrieves task_id and the tags of each task and then check if the tags for the task are contained within $tags_subscribed
		// If they are, adds task_id to $tasks_subscribed
		$query = "SELECT task_id, tags FROM Tasks;";
		$continue;
		foreach ($GLOBALS['pdo'] -> query($query) as $task_list)
		{
			$tags = explode(",", $task_list['tags']);
			$continue = true;
			for ($i = 0; $i < sizeof($tags) && $continue; $i++) // Cycles through the tags belonging to task
			{ 
				for ($j = 0; $j < sizeof($tags_subscribed) && $continue; $j++) // Cycles through tags the user is subscribed to
				{ 
					if ($tags[$i] == $tags_subscribed[$j]) // Tag in task = tag in tags user is subscribed to
					{
						array_push($tasks_subscribed, $task_list['task_id']); // Add task_id to list
						$continue = false;
					}
				}
			}
		}
		// Returns array of task_id's based on user's subscribed tags
		return $tasks_subscribed;
	}

	
	function getAssignedTags($user_number)
	{
		$tags_assigned = array();
		$tasks_assigned = array();

		// Returns the tags the user has been assigned and converts to array
		# May later rework to only account for the first 15 tags, etc
		foreach ($GLOBALS['pdo'] -> query("SELECT tags FROM Assigned_tags WHERE user_id = $user_number;") as $tag_list) 
			$tags_assigned = explode(",", $tag_list['tags']);


		// Retrieves task_id and the tags of each task and then check if the tags for the task are contained within $tags_assgined
		// If they are, adds task_id to $tasks_assigned
		$query = "SELECT task_id, tags FROM Tasks;";
		$continue;
		foreach ($GLOBALS['pdo'] -> query($query) as $task_list)
		{
			$tags = explode(",", $task_list['tags']);
			$continue = true;
			for ($i = 0; $i < sizeof($tags) && $continue; $i++) // Cycles through the tags belonging to task
			{ 
				for ($j = 0; $j < sizeof($tags_assigned) && $continue; $j++) // Cycles through tags the user is subscribed to
				{ 
					if ($tags[$i] == $tags_assigned[$j]) // Tag in task = tag in tags user is subscribed to
					{
						array_push($tasks_assigned, $task_list['task_id']); // Add task_id to list
						$continue = false;
					}
				}
			}
		}
		// Returns array of task_id's based on user's assigned tags
		return $tasks_assigned;
	}
	
	function getFlaggedTasks()
	{
		$query = "SELECT task_id FROM Tasks WHERE task_id IN (SELECT task_id FROM Flagged_tasks ORDER BY date_time ASC)";
		$tasks = array();
		foreach($GLOBALS['pdo'] -> query($query) as $task)
			array_push($tasks, $task['task_id']);
		// Check if it's empty
		if (sizeof($tasks) == 0)
			throw new Exception("No tasks have been flagged!");
			 
		return $tasks;
	}

	function formatArrays($same_majors, $subscribed_tags, $assigned_tags, $user_number)
	{
		$temp_array = array();
		// Merge all 3 arrays
		foreach ($same_majors as $value)
			array_push($temp_array, $value);
		foreach ($subscribed_tags as $value)
			array_push($temp_array, $value);
		foreach ($assigned_tags as $value)
			array_push($temp_array, $value);

		// Remove any duplicates
		$temp_array = array_unique($temp_array);

		/*
			CAN LATER MAKE THIS MORE EFFICIENT BY ADDING $i VARIABLE
			ABOVE AND INCREMENTING IT THROUGHT ALL 3 LOOPS, GIVING
			EACH INDEX A NUMERIC VALUE, BUT THEN USING A FOREACH LOOP
			TO PRINT IT AND ACCESS EACH INDEX AFTER SORTING
		*/

		// Convert array keys incrementing from 0
		$i = 0;
		$formatted_array = array();
		foreach ($temp_array as $key)
		{
			$formatted_array[$i] = $key;
			$i++;
		}
		unset($temp_array);

		// Checks to make sure there are tasks to display
		if (sizeof($formatted_array) == 0)
			throw new Exception("No task information to return!");
		
		// Sort by date
		// Creates a query containing the tag_ids
		$query = "SELECT task_id FROM Tasks WHERE task_id IN (" . $formatted_array[0];
		for ($i = 1; $i < sizeof($formatted_array); $i++)
			$query .= "," . $formatted_array[$i];
		$query .= ") AND user_id <> $user_number AND task_id NOT IN (SELECT task_id FROM claimed_tasks) "
			. " AND task_id NOT IN (SELECT task_id FROM completed_tasks)"
			. " AND task_id NOT IN (SELECT task_id FROM cancelled_tasks)"
			. " AND task_id NOT IN (SELECT task_id FROM flagged_tasks)"
			. " ORDER BY claim_deadline ASC;";

		unset($formatted_array);
		$formatted_array = array();
		$i = 0;
		foreach ($GLOBALS['pdo'] -> query($query) as $id_list)
		{
			$formatted_array[$i] = $id_list['task_id'];
			$i++;
		}

		// Going to need to optimise a bit later
		if (sizeof($formatted_array) == 0)
			throw new Exception("No task information to return!");

		return $formatted_array;
	}
	/*
		-Store the current number of posts loaded as a cookie
		-Access cookie via JavaScript
		-Have a check for when user is as bottom of screen
		-Send PHP request to start from that index and keep going
		-Append to bottom of page
		=Profit
	*/
	function printTasks($task_array, $task_edit = false)
	{
		for ($i = 0; $i < sizeof($task_array); $i++)
		{
			$q = "SELECT task_id, task_title, description, claim_deadline FROM Tasks WHERE task_id = " . $task_array[$i];
			foreach ($GLOBALS['pdo'] -> query($q) as $task)
			{
				// Variables
				$id = $task['task_id'];
				// HTML
				echo "<article>";
				echo	"<h3>" . $task['task_title'] . "</h3>";
				// echo 	"<span style=\"float: top; margin-top: -1em; padding-top: -1em;\">" . $task['claim_deadline'] . "</span>";
				echo 	"<span><strong>Deadline</strong>:  " . date("jS F, Y", strtotime($task['claim_deadline'])) . "</span>";
				if (strlen($task['description']) > 200)
					echo	"<p>" . substr($task['description'], 0, 200) . "..." . "</p>";
				else
					echo	"<p>" . $task['description'] . "</p>";
				echo	"<ul class=\"actions\">";
				if ($task_edit)
					echo "<li><a href=\"view-task.php?id=$id\" class=\"button\">View</a></li>";
				else
					echo "<li><a href=\"task.php?id=$id\" class=\"button\">View</a></li>";
				echo	"</ul>";
				echo "</article>";
			}
		}
	}

	function getTaskStatus($task_number)
	{
		$status = array();
		// Check if task is claimed
		$query = "SELECT task_id FROM Claimed_tasks WHERE task_id = $task_number;";
		foreach ($GLOBALS['pdo'] -> query($query) as $task)
			$status[0] = $task['task_id'];
		if (sizeof($status) == 1)
			return "Claimed";

		// Check if task is completed
		$query = "SELECT task_id FROM Completed_tasks WHERE task_id = $task_number;";
		foreach ($GLOBALS['pdo'] -> query($query) as $task)
			$status[0] = $task['task_id'];
		if (sizeof($status) == 1)
			return "Completed";

		// Check if task is cancelled
		$query = "SELECT task_id FROM Cancelled_tasks WHERE task_id = $task_number;";
		foreach ($GLOBALS['pdo'] -> query($query) as $task)
			$status[0] = $task['task_id'];
		if (sizeof($status) == 1)
			return "Cancelled";

		// Check if task is expired
		// $query = "SELECT task_id FROM Tasks WHERE task_id = $task_number AND (review_deadline < Now() OR claim_deadline < Now());";
		// Query below is more efficient as there's no actual need to check claim_deadline
		$query = "SELECT task_id FROM Tasks WHERE task_id = $task_number AND review_deadline < Now();";
		foreach ($GLOBALS['pdo'] -> query($query) as $task)
			$status[0] = $task['task_id'];
		if (sizeof($status) == 1)
			return "Expired";

		// Else, task is Unclaimed, since it failed all previous checks
		return "Unclaimed";
	}

	function getTaskTags($task_number)
	{
		// Retrieve tag ids
		$tags;
		foreach ($GLOBALS['pdo'] -> query("SELECT tags FROM Tasks WHERE task_id = $task_number;") as $tag_list)
			$tags = explode(",", $tag_list['tags']);
		// Retrieve tag values
		$i = 0;
		$tag_values = array();
		for ($i = 0; $i < sizeof($tags); $i++)
		{ 
			foreach ($GLOBALS['pdo'] -> query("SELECT _value FROM Tags WHERE tag_id = $tags[$i]") as $tag)
			{
				$tag_values[$i] = $tag['_value'];
			}
		}
		// Returns array with tag values for given task
		return $tag_values;
	}

	function getUserClaimedTasks($user_number)
	{
		$query = "SELECT task_id FROM claimed_tasks WHERE claimant = $user_number";
		$tasks = array();
		foreach ($GLOBALS['pdo'] -> query($query) as $task)
			array_push($tasks, $task['task_id']);

		if (sizeof($tasks) == 0)
			throw new Exception("You haven't claimed any tasks yet!");

		return $tasks;
	}

	function printMyTasks($task_array)
	{
		for ($i = 0; $i < sizeof($task_array); $i++)
		{
			$q = "SELECT task_id, task_title, description, claim_deadline, review_deadline FROM Tasks WHERE task_id = " . $task_array[$i];
			foreach ($GLOBALS['pdo'] -> query($q) as $task)
			{
				// Variables
				$id = $task['task_id'];
				// HTML
				echo "<article>";
				echo	"<h3>" . $task['task_title'] . "</h3>";
				echo 	"<span><strong>Claim deadline</strong>:  " . date("jS F, Y", strtotime($task['claim_deadline'])) . "</span><br />";
				echo 	"<span><strong>Review deadline</strong>:  " . date("jS F, Y", strtotime($task['review_deadline'])) . "</span><br />";
				echo	"<span><strong>Status</strong>:  " . getTaskStatus($id) . "</span>";
				echo	"<br /><br />";
				if (strlen($task['description']) > 200)
					echo	"<p>" . substr($task['description'], 0, 200) . "..." . "</p>";
				else
					echo	"<p>" . $task['description'] . "</p>";
				echo	"<ul class=\"actions\">";
				echo "<li><a href=\"manage-task.php?id=$id\" class=\"button\">View</a></li>";
				echo	"</ul>";
				echo "</article>";
			}
		}
	}

	function printFlaggedTasks($task_array)
	{
		for ($i = 0; $i < sizeof($task_array); $i++)
		{
			$q = "SELECT T.task_id, T.task_title, T.claim_deadline, T.review_deadline, F.date_time, F.reason FROM Tasks as T INNER JOIN flagged_tasks as F ON T.task_id = F.task_id AND T.task_id = " . $task_array[$i] . ";";
			foreach ($GLOBALS['pdo'] -> query($q) as $task)
			{
				// Variables
				$id = $task['task_id'];
				// HTML
				echo "<article>";
				echo	"<h3>" . $task['task_title'] . "</h3>";
				echo 	"<span><strong>Claim deadline</strong>:  " . date("jS F, Y", strtotime($task['claim_deadline'])) . "</span><br />";
				echo 	"<span><strong>Review deadline</strong>:  " . date("jS F, Y", strtotime($task['review_deadline'])) . "</span><br />";
				echo 	"<span><strong>Flagged on</strong>:  " . date("jS F, Y", strtotime($task['date_time'])) . "</span><br />";
				echo 	"<span><strong>Reason</strong>:<br />";
				if (strlen($task['reason']) > 200)
					echo	"<p>" . substr($task['reason'], 0, 200) . "..." . "</p>";
				else
					echo	"<p>" . $task['reason'] . "</p>";
				echo	"<ul class=\"actions\">";
				echo "<li><a href=\"review-task.php?id=$id\" class=\"button\">View</a></li>";
				echo	"</ul>";
				echo "</article>";
			}
		}
	}

/*
##########################################################################################################################################
##########################################################################################################################################
##########################################################################################################################################
##########################################################################################################################################
##########################################################################################################################################
##########################################################################################################################################
##########################################################################################################################################
##########################################################################################################################################
##########################################################################################################################################
*/
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

	    $errors = "<div id='mydiv'><ul style='color: red;'>";

	    // Loop through error array and display all the items in a list
	    foreach($form_errors_array as $the_error) {
	        $errors .= "<li> {$the_error} </li>";

	    }
	    $errors .= "</ul></div>";
	    return $errors;
	}

	/**
	 * @param $message replace with an error message
	 * @param string $passOrFail pass in "pass" with the function if its a positive message
	 * @return string
	 */
	function flashMessage($message, $passOrFail = "Fail") {
	    if($passOrFail === "Pass") {
	        $data = "<div id='fadeOut' class='alert alert-success'></div><p>{$message}</p>";
	    } else {
	        $data = "<div id='fadeOut' class='alert alert-danger'<p>{$message}</p>";
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
	 * @param $username
	 */
	function rememberMe($username) {
	    $encryptCookieData = base64_encode("rememberthisstring{$username}");
	    // cookie set to expire in 15 days, 1 hour would be 3600
	    setcookie("rememberUserCookie", $encryptCookieData, time()+10 , "/");
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
	        $username = explode("rememberthisstring", $decryptCookieData);
	        $userID = $username[1];

	        /*
	         * check if ID retrieved from the cookie exists in the database
	         */
	        $sqlQuery = "SELECT * FROM users WHERE user_id = :username";
	        $statement = $pdo->prepare($sqlQuery);
	        $statement->execute(array(':username' => $userID));

	        if($row = $statement->fetch()) {
	            //$id = $row['id'];
	            $username = $row['user_id'];

	            /*
	             * Create the user session variable
	             */
	            //$_SESSION['id'] = $id;
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
		deleteIdCookie();
	    unset($_SESSION['username']);
	    //unset($_SESSION['id']);

        // KEEP THIS COMMENTED OUT
        //**************************
	    //if(isset($_COOKIE['rememberUserCookie'])) {
	    //    unset($_COOKIE['rememberUserCookie']);
        //   setcookie('rememberUserCookie', null, -1, '/');
	    //}
	    session_destroy();
	    session_regenerate_id(true);
	    redirectTo('index');
	}

	function guard() {
	    $isValid = true;
	    $inactive = 60*10; // 10 mins
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

	function isValidImage($file) {
	    $form_errors = array();
	    // split at extension
	    $part = explode(".", $file);

	    // target the last element in the array
	    $extension = end($part);

	    switch(strtolower($extension)) {
	        case 'jpg':
	        case 'gif':
	        case 'bmp':
	        case 'png':

	        return $form_errors;
	    }
	    $form_errors[] = $extension . " is not a valid image extension";
	    return $form_errors;
	}

	function uploadAvatar($username) {
	    $isImageMoved = false;
	    if($_FILES['fileToUpload']['tmp_name']) {

	        // file in the templocation
	        $temp_file = $_FILES['fileToUpload']['tmp_name'];
	        $ds = DIRECTORY_SEPARATOR; // uploads/
	        $avatar_name = $username.".jpg";

	        $path = "res/pictures".$ds.$avatar_name; //uploads/demo.jpg

	        if(move_uploaded_file($temp_file, $path)) {
	            $isImageMoved = true;
	        }
	    }
	    return $isImageMoved;
	}
	function confirmPassword() {
	    $password1 = $_POST['Password'];
	    $password2 = $_POST['confirm_password'];
	    if($password1 != $password2) {
	        $result = flashMessage("Password and confirm password do not match");
	    }
	}
	// store token in session of logged in user
    // Cross-Site Request Forgery (CSRF)protection
	function _token() {
	    // generate random token, pass in number of bytes, higher the better, open ssl better than md5
	    // $randomToken = base64_encode(openssl_random_pseudo_bytes(32));
	    $randomToken = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));//base64_encode(openssl_random_pseudo_bytes(32));
	    // store in user session
	    return $_SESSION['token'] = $randomToken;
	}
	// validate token, check if the token that is sent through the form is equal to the
	// token that was stored in the session then it is a valid request
	// requestToken is what is sent in form
	function validate_token($requestToken) {
	    // do we have $_session token
	    // if we dont have $_SESSION token then request is coming from other application
	    if (isset($_SESSION['token']) && $requestToken === $_SESSION['token']) {
	        unset($_SESSION['token']);
	        return true;
	    }
	    return false;
	}
	function isUserBanned($user) {

	    $isBanned = false;

        $sqlQuery = "SELECT * FROM banned WHERE user_id = :username";
        $statement = $GLOBALS['pdo'] -> prepare($sqlQuery);
        $statement->execute(array(':username' => $user));



        return $isBanned;
    }
	
?>