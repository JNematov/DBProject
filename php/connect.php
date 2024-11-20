<?php
    $serverName = "g6-bankdb.mysql.database.azure.com"; 
    $userName = "G6_Admin";
    $password = "admin@utdallasg6";
    $dbName = "bankdb";
    //create connection
    $con = mysqli_connect($serverName, $userName, $password, $dbName);
    if(mysqli_connect_errno()){
    echo "Failed to connect!";
    exit();
    }
    echo "Connection success!";
?>