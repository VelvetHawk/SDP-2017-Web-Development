<!--
Add this header section to all pages
-->


<?php
include_once 'res/session.php'
?>

<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head;
    any other head content must come *after* these tags -->
    <title><?php if(isset($page_title)) echo $page_title; ?></title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css">

    <!-- http://t4t5.github.io/sweetalert/
        BEAUTIFUL POPUPS
    -->
    <script src="js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">

</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">User Authentication</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <!-- show if user logged in -->
                <li><a href="index.php">Home</a></li>
                <?php if(isset($_SESSION['username'])): ?>
                    <li><a href="#">My Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <!-- if user not logged in display menus that were there before -->
                <?php else: ?>
                    <li><a href="#contact">About</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">Sign up</a></li>
                    <li><a href="#contact">Contact</a></li>
                <?php endif ?>


            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>