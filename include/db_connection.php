<?php

$servername = DB_SERVER_NAME;
$username = DB_USER;
$password = DB_PASSWORD;



$msg_db_connection = "";
try {
    $db = new PDO("mysql:host=$servername;dbname=institution", $username, $password, array(PDO::ATTR_PERSISTENT => true));
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $msg_db_connection = "Connected successfully";
    }
catch(PDOException $e)
    {
    $msg_db_connection =  "Connection failed: " . $e->getMessage();
    }
?>
