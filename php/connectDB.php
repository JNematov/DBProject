<?php
$host = 'g6-bankdb.mysql.database.azure.com';
$dbname = 'bankdb';
$username = 'G6_Admin';
$password = 'admin@utdallasg6';

// Create a connection

$conn = mysqli_connect($host, $username, $password, $dbname);


// Query to fetch the Account_ID
$sql = "SELECT * FROM loan";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["Loan_ID"] . "<br>";
    }
} else {
    echo "0 results<br>";
}

// Close the connection
$conn->close();
?> 