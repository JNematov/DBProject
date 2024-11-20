<?php
$host = 'g6-bankdb.mysql.database.azure.com';
$dbname = 'bankdb';
$dbusername = 'G6_Admin';
$dbpassword = 'admin@utdallasg6';

// Create a connection
$user = $_GET['username'];
$pass = $_GET['password'];
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
$sql = "INSERT INTO accounts (Account_ID
,Account_Type
,Balance
,Interest_Rate
,Acc_Status
,Branch_ID
,Customer_ID
,password) VALUES ('$user','checking',0, .2,'open', 1,'$user', '$pass')";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}


// Close the connection
$conn->close();
?> 