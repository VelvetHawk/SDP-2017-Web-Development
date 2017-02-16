<?php
    include_once 'res/session.php'
?>

<!DOCTYPE html>
<html>

<head lang="en">
	<meta charset="UTF-8">
	<title>Homepage</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>

    <h2>User Authentication System</h2><hr>

    <?php
        if(!isset($_SESSION['username'])):
    ?>
    <p>You are currently not signed in<br><a href="login.php">Login</a><br>
        Not yet a member? <a href="signup.php">Sign up here</a>
    </p>
    <?php
        else:
    ?>
    <p>You are logged in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?> <a href="logout.php">Logout</a></p>

    <?php endif ?>

</body>
</html>