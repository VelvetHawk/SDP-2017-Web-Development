<?php
/*  php data objects - available api for connecting to mysql database with php
    In order to connect to mysql db with pdo we need to create new instance of the pdo class
    and specify the dsn (data source name) database username, database password*/
    /* https://phpdelusions.net/pdo#dsn */
    $host = '127.0.0.1';
    $db   = 'register';
    $user = 'root';
    $pass = '';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);
    /*$db = new PDO('mysql:host=localhost; dbname=register', 'root', '');*/
    echo "connected to db";

    /*$username = 'roo';
    $dsn = 'mysql:host=localhost; dbname=register';
    $password = '';

    try {
        $db = new PDO($dsn, $username, $password);

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected to the register database";
    } catch (PDOException $ex) {
        echo "Connection failed ".$ex->getMessage();
    }*/
?>