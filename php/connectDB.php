<?php
$host = 'g6-bankdb.mysql.database.azure.com'; // Your database host
$dbname = 'bankdb'; // Your database name
$username = 'G6_Admin'; // Your database username
$password = 'admin@utdallasg6'; // Your database password

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch the Account_ID
$sql = "SELECT * FROM customer;";
$result = $conn->mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Fetch and display results
    $row = $result->mysqli_fetch_assoc($result);
    echo $row["Name"] . "<br>";
    
} else {
    echo "Error in query: " . $conn->error;
}

// Close the connection
$conn->close();
?>