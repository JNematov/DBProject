document
  .getElementById("profileForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission

    const name = document.getElementById("name").value;
    const address = document.getElementById("address").value;
    const phone = document.getElementById("phone").value;
    const email = document.getElementById("email").value;

    // Input validation
    const phoneRegex = /^\d{10}$/;
    if (!phoneRegex.test(phone)) {
      document.getElementById("profileError").textContent =
        "Phone number must be a 10-digit number.";
      document.getElementById("profileError").style.display = "block";
      return;
    }

    document.getElementById("profileError").style.display = "none";
    console.log("Profile updated:", { name, address, phone, email });
  });

// Mock data for demonstration
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
function renderTable(data, containerId, excludeFields = []) {
  const container = document.getElementById(containerId);
  const table = document.createElement("table");
  const headers = Object.keys(data[0]).filter(
    (header) => !excludeFields.includes(header)
  );

  // Table header
  const headerRow = document.createElement("tr");
  headers.forEach((header) => {
    const th = document.createElement("th");
    th.textContent = header;
    headerRow.appendChild(th);
  });
  table.appendChild(headerRow);

  // Table rows
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
renderTable(transactions, "transactionsTable", ["transactionId"]); // Exclude transactionId
