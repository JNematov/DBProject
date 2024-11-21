<?php
header('Content-Type: application/json');
session_start();

require_once 'connectDB.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['customer_id']) || strtolower($_SESSION['customer_type']) != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

$response = ['success' => true];

try {
    // Fetch Customers
    $query = "SELECT Customer_ID, Name, Address, SSNorTax_ID, Phone_Number, Email, Date_of_Birth FROM Customer";
    $result = $conn->query($query);
    $customers = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();

    // Fetch Employees
    $query = "SELECT SSN, EName, Role, Salary, Branch_ID FROM Employee";
    $result = $conn->query($query);
    $employees = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();

    // Fetch Branches
    $query = "SELECT Branch_ID, Branch_Name, Location, Phone_Number, Manager_ID FROM Branch";
    $result = $conn->query($query);
    $branches = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();

    // Fetch Loans
    $query = "SELECT Loan_ID, Loan_Type, Amount, Interest_Rate, Issue_Date, Duration, Customer_ID FROM Loan";
    $result = $conn->query($query);
    $loans = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();

    // Fetch Credit Cards
    $query = "SELECT Card_Number, CardLimit, Interest_Rate, Expiration_Date, Customer_ID FROM Credit_Card";
    $result = $conn->query($query);
    $creditCards = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();

    // Fetch Accounts
    $query = "SELECT Account_ID, Account_Type, Balance, Interest_Rate, Acc_Status, Opening_Date, Customer_ID FROM Accounts";
    $result = $conn->query($query);
    $accounts = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();

    // Fetch Transactions
    $query = "SELECT Transaction_ID, Transaction_Type, Amount, Date, Time, Description, Account_ID FROM Transactions";
    $result = $conn->query($query);
    $transactions = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();

    // Prepare response data
    $response['customers'] = $customers;
    $response['employees'] = $employees;
    $response['branches'] = $branches;
    $response['loans'] = $loans;
    $response['creditCards'] = $creditCards;
    $response['accounts'] = $accounts;
    $response['transactions'] = $transactions;

    echo json_encode($response);

} catch (Exception $e) {
    error_log('Error fetching admin data: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while fetching data.']);
}

$conn->close();
?>