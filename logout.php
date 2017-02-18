<?php
    include_once 'res/session.php';
    include_once 'res/utilities.php';

    session_destroy();
    redirectTo('index');
?>