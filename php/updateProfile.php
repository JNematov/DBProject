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
$sessionCustomerId = $_SESSION['customer_id'];

// Get input data from the client
$data = json_decode(file_get_contents('php://input'), true);

$customerId = $sessionCustomerId; // Default to the logged-in customer
if ($isAdmin && isset($data['customerId'])) {
    $customerId = $data['customerId']; // Admin can update other customers
}

$name = trim($data['name'] ?? '');
$address = trim($data['address'] ?? '');
$phone = trim($data['phone'] ?? '');
$email = trim($data['email'] ?? '');

// Server-side validation (same as before)

// Update customer profile in the database
try {
    $stmt = $conn->prepare("UPDATE Customer SET Name = ?, Address = ?, Phone_Number = ?, Email = ? WHERE Customer_ID = ?");
    $stmt->bind_param("sssss", $name, $address, $phone, $email, $customerId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
    } else {
        throw new Exception("Failed to update profile.");
    }
    $stmt->close();
} catch (Exception $e) {
    error_log('Error updating customer profile: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while updating the profile.']);
}

$conn->close();
?>