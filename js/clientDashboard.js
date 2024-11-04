// Sample data for financial summary
const income = 5000;
const expenses = 2000;
const budget = "On Track";

// Display financial summary
document.getElementById("income").textContent = `Income: $${income}`;
document.getElementById("expenses").textContent = `Expenses: $${expenses}`;
document.getElementById("budget").textContent = `Budget Status: ${budget}`;

// Mock data for client financial details
const loans = [
  {
    loanType: "Home Loan",
    amount: 50000,
    interestRate: 3.5,
    duration: 10,
    issueDate: "2022-01-01",
  },
];
const creditCards = [
  {
    cardNumber: "1234567890123456",
    limit: 10000,
    interestRate: 15.0,
    expirationDate: "2025-12-31",
  },
];
const accounts = [
  {
    accountType: "Checking",
    balance: 2000,
    interestRate: 1.5,
    status: "Active",
    openingDate: "2021-06-01",
  },
];
const transactions = [
  {
    transactionType: "Deposit",
    amount: 100.0,
    date: "2024-01-01",
    time: "10:30",
    description: "Monthly Deposit",
  },
];

// Function to render tables
function renderTable(data, containerId) {
  const container = document.getElementById(containerId);
  const table = document.createElement("table");
  const headers = Object.keys(data[0]);

  // Create table header
  const headerRow = document.createElement("tr");
  headers.forEach((header) => {
    const th = document.createElement("th");
    th.textContent = header;
    headerRow.appendChild(th);
  });
  table.appendChild(headerRow);

  // Create table rows
  data.forEach((row) => {
    const rowElement = document.createElement("tr");
    headers.forEach((header) => {
      const td = document.createElement("td");
      td.textContent = row[header];
      rowElement.appendChild(td);
    });
    table.appendChild(rowElement);
  });

  container.innerHTML = ""; // Clear previous content
  container.appendChild(table);
}

// Render tables
renderTable(loans, "loansTable");
renderTable(creditCards, "creditCardsTable");
renderTable(accounts, "accountsTable");
renderTable(transactions, "transactionsTable");
