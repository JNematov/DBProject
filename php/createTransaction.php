<?php
header('Content-Type: application/json');

require_once 'connectDB.php';

session_start();
if (!isset($_SESSION['customer_id']) || !isset($_SESSION['account_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$customerId = $_SESSION['customer_id'];
$accountId = $_SESSION['account_id'];

// Get input data from the client
$data = json_decode(file_get_contents('php://input'), true);

$transactionType = trim($data['transactionType'] ?? '');
$amount = trim($data['amount'] ?? '');
$date = trim($data['date'] ?? '');
$description = trim($data['description'] ?? '');

// Validate input
$invalid_chars = ["'", '"', ";", "--", "#"];

// Function to check for invalid characters in a string
function contains_invalid_chars($input, $invalid_chars) {
    foreach ($invalid_chars as $char) {
        if (strpos($input, $char) !== false) {
            return true;
        }
    }
    return false;
}

// Validate Transaction Type
if (!in_array($transactionType, ['Deposit', 'Withdrawal'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid transaction type.']);
    exit;
}

if (contains_invalid_chars($transactionType, $invalid_chars)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input detected in Transaction Type.']);
    exit;
}

// Validate Amount
if (!is_numeric($amount) || $amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid transaction amount.']);
    exit;
}

// Validate Date
$date_regex = '/^\d{4}-\d{2}-\d{2}$/';
if (!preg_match($date_regex, $date)) {
    echo json_encode(['success' => false, 'message' => 'Invalid date format.']);
    exit;
}

// Validate Description
if (contains_invalid_chars($description, $invalid_chars)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input detected in Description.']);
    exit;
}

// Convert amount to decimal with 2 decimal places
$amount = round($amount, 2);

// Generate a unique Transaction_ID
$result = $conn->query("SELECT MAX(Transaction_ID) AS max_id FROM Transactions");
$row = $result->fetch_assoc();
$transactionId = $row['max_id'] + 1;
if (is_null($transactionId)) {
    $transactionId = 1; // Start from 1 if table is empty
}
$result->free();

// Get current time
$time = date("H:i:s");

// Begin transaction
$conn->begin_transaction();

try {
    // Prepare and execute the SQL statement to insert the transaction
    $stmt = $conn->prepare("INSERT INTO Transactions (
        Transaction_ID,
        Transaction_Type,
        Amount,
        Date,
        Time,
        Description,
        Account_ID
    ) VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("isdsssi", $transactionId, $transactionType, $amount, $date, $time, $description, $accountId);

    if (!$stmt->execute()) {
        throw new Exception("Failed to create transaction.");
    }

    // Update the account balance
    if ($transactionType == 'Deposit') {
        $updateStmt = $conn->prepare("UPDATE Accounts SET Balance = Balance + ? WHERE Account_ID = ?");
    } else if ($transactionType == 'Withdrawal') {
        // Check if the account has sufficient balance
        $balanceResult = $conn->prepare("SELECT Balance FROM Accounts WHERE Account_ID = ?");
        $balanceResult->bind_param("i", $accountId);
        $balanceResult->execute();
        $balanceResult->bind_result($currentBalance);
        $balanceResult->fetch();
        $balanceResult->close();

        if ($currentBalance < $amount) {
            throw new Exception("Insufficient funds for withdrawal.");
        }

        $updateStmt = $conn->prepare("UPDATE Accounts SET Balance = Balance - ? WHERE Account_ID = ?");
    } else {
        throw new Exception("Invalid transaction type.");
    }

    $updateStmt->bind_param("di", $amount, $accountId);

    if (!$updateStmt->execute()) {
        throw new Exception("Failed to update account balance.");
    }

    $updateStmt->close();

    // Commit transaction
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Transaction created successfully.']);
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    // Log the error message for debugging
    error_log("Transaction Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing your transaction. Please try again later.']);
}

$stmt->close();
$conn->close();
?>