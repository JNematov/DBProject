<?php
session_start();

require_once 'connectDB.php'; // Ensure this file defines $conn

// Get username and password from POST
$user = $_POST['username'];
$pass = $_POST['password'];

// Server-side validation to prevent SQL injection
$invalid_chars = ["'", ",", "-", "#", "=", '"'];
foreach ($invalid_chars as $char) {
    if (strpos($user, $char) !== false || strpos($pass, $char) !== false) {
        die("Invalid input detected.");
    }
}

// Prepare and bind
$stmt = $conn->prepare("SELECT Accounts.Account_ID, Accounts.Customer_ID, Customer.CustomerType, Accounts.password FROM Accounts JOIN Customer ON Accounts.Customer_ID = Customer.Customer_ID WHERE Accounts.Customer_ID = ?");
$stmt->bind_param("s", $user);

$stmt->execute();

$stmt->store_result();

if ($stmt->num_rows > 0) {
    // User exists
    $stmt->bind_result($account_id, $customer_id, $customer_type, $hashed_password);
    $stmt->fetch();

    // Verify password
    if (password_verify($pass, $hashed_password)) {
        // Password is correct

        // Store user info in session variables
        $_SESSION['account_id'] = $account_id;
        $_SESSION['customer_id'] = $customer_id;
        $_SESSION['customer_type'] = $customer_type;

        // Redirect based on customer type
        if (strtolower($customer_type) == 'admin') {
            header("Location: /html/adminDashboard.html");
            exit();
        } else {
            header("Location: /html/clientDashboard.html");
            exit();
        }
    } else {
        // Invalid password
        echo "Invalid username or password.";
    }
} else {
    // User not found
    echo "Invalid username or password.";
}

$stmt->close();
$conn->close();
?>