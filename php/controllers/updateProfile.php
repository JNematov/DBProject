<?php
$host = 'g6-bankdb.mysql.database.azure.com';
$dbname = 'bankdb';
$username = 'G6_Admin';
$password = 'admin@utdallasg6';

// Create a connection

$conn = mysqli_connect($host, $username, $password, $dbname);


// Close the connection
$conn->close();
?> 