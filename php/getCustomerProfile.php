<?php
header('Content-Type: application/json');
session_start();

require_once 'connectDB.php';

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$isAdmin = strtolower($_SESSION['customer_type']) == 'admin';
$customerId = $_SESSION['customer_id'];

// If customerId is provided and user is admin, allow access to other customer's profiles
if ($isAdmin && isset($_GET['customerId'])) {
    $customerId = $_GET['customerId'];
}

try {
    // Fetch customer profile data
    $stmt = $conn->prepare("SELECT Name, Address, Phone_Number, Email, SSNorTax_ID, Date_of_Birth FROM Customer WHERE Customer_ID = ?");
    $stmt->bind_param("s", $customerId);
    $stmt->execute();
    $stmt->bind_result($name, $address, $phone, $email, $ssn, $dob);
    if ($stmt->fetch()) {
        echo json_encode([
            'success' => true,
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'ssn' => $ssn,
            'dob' => $dob,
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Customer not found.']);
    }
    $stmt->close();
} catch (Exception $e) {
    error_log('Error fetching customer profile: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while fetching profile data.']);
}

$conn->close();
?>