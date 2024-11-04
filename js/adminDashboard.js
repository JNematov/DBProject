// Mock data for admin dashboard
const customers = [
  {
    id: 1,
    name: "John Doe",
    address: "123 Main St",
    ssn: "123456789",
    phone: "1234567890",
    email: "john@example.com",
    dob: "1990-01-01",
  },
];
const employees = [
  {
    ssn: "987654321",
    ename: "Jane Smith",
    role: "Manager",
    salary: 50000,
    branchId: 1,
  },
];
const branches = [
  {
    branchId: 1,
    branchName: "Main Branch",
    location: "City Center",
    phoneNumber: "0987654321",
    managerId: 987654321,
  },
];
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

// Function to render tables with "Change Profile" button for customers
function renderTable(data, containerId, isCustomerTable = false) {
  const container = document.getElementById(containerId);
  const table = document.createElement("table");
  const headers = Object.keys(data[0]);

  // Table header
  const headerRow = document.createElement("tr");
  headers.forEach((header) => {
    const th = document.createElement("th");
    th.textContent = header;
    headerRow.appendChild(th);
  });
  if (isCustomerTable) {
    const actionTh = document.createElement("th");
    actionTh.textContent = "Actions";
    headerRow.appendChild(actionTh);
  }
  table.appendChild(headerRow);

  // Table rows
  data.forEach((row) => {
    const rowElement = document.createElement("tr");
    headers.forEach((header) => {
      const td = document.createElement("td");
      td.textContent = row[header];
      rowElement.appendChild(td);
    });
    // Add "Change Profile" button for customers
    if (isCustomerTable) {
      const actionTd = document.createElement("td");
      const changeProfileBtn = document.createElement("button");
      changeProfileBtn.textContent = "Change Profile";
      changeProfileBtn.onclick = () => {
        window.location.href = `clientProfile.html?customerId=${row.id}`;
      };
      actionTd.appendChild(changeProfileBtn);
      rowElement.appendChild(actionTd);
    }
    table.appendChild(rowElement);
  });

  container.innerHTML = ""; // Clear previous content
  container.appendChild(table);
}

// Render tables for each entity
renderTable(customers, "customersTable", true); // Pass `true` to add "Change Profile" button for customers
renderTable(employees, "employeesTable");
renderTable(branches, "branchesTable");
renderTable(loans, "loansTable");
renderTable(creditCards, "creditCardsTable");
renderTable(accounts, "accountsTable");
renderTable(transactions, "transactionsTable");
