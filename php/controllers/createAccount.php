<?php

$host = 'g6-bankdb.mysql.database.azure.com';
$dbname = 'bankdb';
$dbusername = 'G6_Admin';
$dbpassword = 'admin@utdallasg6';
echo $user;

// Create a connection
$user = $_POST['username'];
$pass = $_POST['password'];
$today = date("Y-m-d");
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

$sql = "insert into customer (SSNorTax_ID,
Customer_ID,
Name,
Address,
Phone_Number,
Email,
Date_of_Birth,
CustomerType) values (0,'$user', 'X', '5', '4', '3', '$today', 'checking')";

$result = $conn->query($sql);

$sql = "INSERT INTO accounts (Account_ID
,Account_Type
,Balance
,Interest_Rate
,Opening_Date
,Acc_Status
,Branch_ID
,Customer_ID
,password) VALUES (3,'customer',0, .2, '$today','open', 1,'$user', '$pass')";

$result = $conn->query($sql);

$sql = "insert into customeraccount (Customer_ID, Account_ID) values ('$user', 3)";

$result = $conn->query($sql);


if (!$result) {
    die("Query failed: " . $conn->error);
}


// Close the connection
$conn->close();
header("Location: ../../html/clientDashboard.html");

?> 