<?php
$host = 'g6-bankdb.mysql.database.azure.com';
$dbname = 'bankdb';
$dbusername = 'G6_Admin';
$dbpassword = 'admin@utdallasg6';

// Create a connection
$user = $_GET['username'];
$pass = $_GET['password'];
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
$sql = "select * from accounts where (select * from customers where (select * from customers where Customer_ID = '$user''";

// Close the connection
$conn->close();
?> 