<?php
    include_once 'res/session.php';
    include_once 'res/utilities.php';

    signout();
    /* DONT NEED, REPLACED BY SIGNOUT FUNCTION
    session_destroy();
    redirectTo('index');*/
?>