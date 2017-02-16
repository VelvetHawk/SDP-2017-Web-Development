<?php
    include_once 'res/session.php';

    session_destroy();
    header('location: index.php');
?>