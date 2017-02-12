<?php
    /*
        https://phpdelusions.net/pdo#dsn

        PDO - php data objects - available api for connecting to mysql database with php
        In order to connect to mysql db with pdo we need to create new instance of the pdo class
        and specify the dsn (data source name) database username, database password.

        -Database driver(mysql), host, db (schema) name and charset and less frequently port and
        unix_socket go into DSN.
        -Username and Password go to the constructor i.e. new PDO(...)
        -All other options go into the options array i.e. $opt[...]
        -DSN(Data Source Name) is a semicolon-delimited string. Consists of 'param=value' pairs
        that begins with the driver name and a colon.
        -IMPORTANT: no spaces in DSN.

        DATABASE DRIVER , HOST , DB(SCHEMA) NAME , CHARSET

        Initialize variables to hold connection params:
    */

    $host = '127.0.0.1';
    $db   = 'register';
    $user = 'root';
    $pass = 'root';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    //DRIVER^    ^COLON      ^PARAM=VALUE PAIR
    /*
     *  Error handling modes in PDO
     *  "$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);"
     *  or as a connection option.
     *  => assign
     */
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        // Create the instance of the PDO class with the required params
        $pdo = new PDO($dsn, $user, $pass, $opt);
        // Set PDO error mode to Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "connected to the register db";
    } catch (PDOException $ex) {

        // If cant connect a message is displayed
        echo "Connection failed ".$ex->getMessage();
    }


    /*$username = 'roo';
    $dsn = 'mysql:host=localhost; dbname=register';
    $password = 'root';

    try {
        $db = new PDO($dsn, $username, $password);

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected to the register database";
    } catch (PDOException $ex) {
        echo "Connection failed ".$ex->getMessage();
    }*/
?>