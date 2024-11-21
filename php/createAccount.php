<?php
session_start();

require_once 'connectDB.php'; // This file should establish the $conn variable

// Get form data
$SSNorTax_ID = $_POST['social'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone_number = $_POST['phonenumber'];
$email = $_POST['email'];
$date_of_birth = $_POST['dateofbirth'];
$user = $_POST['username'];
$pass = $_POST['password'];
$today = date("Y-m-d");

// Server-side validation to prevent SQL injection
$invalid_chars = ["'", ",", "-", "#", "=", '"'];
foreach ($invalid_chars as $char) {
    if (
        strpos($SSNorTax_ID, $char) !== false ||
        strpos($name, $char) !== false ||
        strpos($address, $char) !== false ||
        strpos($phone_number, $char) !== false ||
        strpos($email, $char) !== false ||
        strpos($user, $char) !== false ||
        strpos($pass, $char) !== false
    ) {
        die("Invalid input detected.");
    }
}

// Hash the password for security
$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

// Begin a transaction
$conn->begin_transaction();

try {
    // Check if SSNorTax_ID already exists
    $stmt = $conn->prepare("SELECT SSNorTax_ID FROM Customer WHERE SSNorTax_ID = ?");
    $stmt->bind_param("s", $SSNorTax_ID);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        throw new Exception("SSNorTax_ID already exists. Please use a different Social Security Number.");
    }
    $stmt->close();

    // Check if Customer_ID (username) already exists
    $stmt = $conn->prepare("SELECT Customer_ID FROM Customer WHERE Customer_ID = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        throw new Exception("Username already exists. Please choose a different username.");
    }
    $stmt->close();

    // Insert into Customer table
    $stmt = $conn->prepare("INSERT INTO Customer (
        SSNorTax_ID,
        Customer_ID,
        Name,
        Address,
        Phone_Number,
        Email,
        Date_of_Birth,
        CustomerType
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $customerType = 'Client'; // Set customer type accordingly
    $stmt->bind_param(
        "ssssssss",
        $SSNorTax_ID,
        $user,
        $name,
        $address,
        $phone_number,
        $email,
        $date_of_birth,
        $customerType
    );
    $stmt->execute();
    $stmt->close();

    // Generate a unique Account_ID
    $result = $conn->query("SELECT MAX(Account_ID) AS max_id FROM Accounts");
    $row = $result->fetch_assoc();
    $account_id = $row['max_id'] + 1;
    if (is_null($account_id)) {
        $account_id = 1; // Start from 1 if table is empty
    }
    $result->free();

    // Insert into Accounts table
    $stmt = $conn->prepare("INSERT INTO Accounts (
        Account_ID,
        Account_Type,
        Balance,
        Interest_Rate,
        Opening_Date,
        Acc_Status,
        Branch_ID,
        Customer_ID,
        password
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $account_type = 'Checking'; // Adjust account type as needed
    $balance = 0.0;
    $interest_rate = 0.2;
    $acc_status = 'Open';
    $branch_id = 1; // Adjust based on your branches
    $stmt->bind_param(
        "isddsisss",
        $account_id,
        $account_type,
        $balance,
        $interest_rate,
        $today,
        $acc_status,
        $branch_id,
        $user,
        $hashed_password
    );
    $stmt->execute();
    $stmt->close();

    // Insert into CustomerAccount table
    $stmt = $conn->prepare("INSERT INTO CustomerAccount (Customer_ID, Account_ID) VALUES (?, ?)");
    $stmt->bind_param("si", $user, $account_id);
    $stmt->execute();
    $stmt->close();

    // Commit transaction
    $conn->commit();

    // Store user information in session variables
    $_SESSION['customer_id'] = $user;
    $_SESSION['account_id'] = $account_id;

    // Redirect to client dashboard
    header("Location: ../../html/clientDashboard.html");
    exit();
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    die("Registration failed: " . $e->getMessage());
}

// Close the connection
$conn->close();
?>