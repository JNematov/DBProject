<?php
header('Content-Type: application/json');
session_start();

require_once 'connectDB.php';

if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$customerId = $_SESSION['customer_id'];

// Initialize response array
$response = ['success' => true];

try {
    // Fetch accounts
    $stmt = $conn->prepare("SELECT Account_ID, Account_Type, Balance, Interest_Rate, Acc_Status, Opening_Date FROM Accounts WHERE Customer_ID = ?");
    $stmt->bind_param("s", $customerId);
    $stmt->execute();
    $result = $stmt->get_result();
    $accounts = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Fetch loans
    $stmt = $conn->prepare("SELECT Loan_ID, Loan_Type, Amount, Interest_Rate, Issue_Date, Duration FROM Loan WHERE Customer_ID = ?");
    $stmt->bind_param("s", $customerId);
    $stmt->execute();
    $result = $stmt->get_result();
    $loans = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Fetch credit cards
    $stmt = $conn->prepare("SELECT Card_Number, CardLimit, Interest_Rate, Expiration_Date FROM Credit_Card WHERE Customer_ID = ?");
    $stmt->bind_param("s", $customerId);
    $stmt->execute();
    $result = $stmt->get_result();
    $creditCards = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Fetch transactions
    // Get the customer's account IDs
    $accountIds = array_column($accounts, 'Account_ID');

    $transactions = [];
    if (!empty($accountIds)) {
        // Since account IDs are integers from the database, we can safely build the IN clause
        $ids = implode(',', array_map('intval', $accountIds));
        $query = "SELECT Transaction_ID, Transaction_Type, Amount, Date, Time, Description, Account_ID FROM Transactions WHERE Account_ID IN ($ids)";
        $result = $conn->query($query);
        if ($result) {
            $transactions = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $transactions = [];
        }
    }

    // Calculate income and expenses from transactions
    $income = 0.0;
    $expenses = 0.0;
    foreach ($transactions as $transaction) {
        if (strtolower($transaction['Transaction_Type']) == 'deposit') {
            $income += $transaction['Amount'];
        } elseif (strtolower($transaction['Transaction_Type']) == 'withdrawal') {
            $expenses += $transaction['Amount'];
        }
    }

    // For simplicity, set budget status based on income and expenses
    $budget = ($income >= $expenses) ? 'On Track' : 'Over Budget';

    // Prepare response data
    $response['income'] = $income;
    $response['expenses'] = $expenses;
    $response['budget'] = $budget;
    $response['accounts'] = $accounts;
    $response['loans'] = $loans;
    $response['creditCards'] = $creditCards;
    $response['transactions'] = $transactions;

    echo json_encode($response);

} catch (Exception $e) {
    // Log error
    error_log('Error fetching customer data: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while fetching data.']);
}

$conn->close();
?>