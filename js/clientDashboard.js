document.addEventListener("DOMContentLoaded", function () {
  // Fetch data from the server
  fetch("/php/readCustomer.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Display financial summary
        document.getElementById(
          "income"
        ).textContent = `Income: $${data.income.toFixed(2)}`;
        document.getElementById(
          "expenses"
        ).textContent = `Expenses: $${data.expenses.toFixed(2)}`;
        document.getElementById(
          "budget"
        ).textContent = `Budget Status: ${data.budget}`;

        // Render tables
        renderTable(data.loans, "loansTable");
        renderTable(data.creditCards, "creditCardsTable");
        renderTable(data.accounts, "accountsTable");
        renderTable(data.transactions, "transactionsTable");
      } else {
        alert("Failed to fetch data: " + data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
      alert("An error occurred while fetching data.");
    });

  // Function to render tables
  function renderTable(data, containerId) {
    const container = document.getElementById(containerId);
    container.innerHTML = ""; // Clear previous content

    if (!data || data.length === 0) {
      container.innerHTML = "<p>No data available.</p>";
      return;
    }

    const table = document.createElement("table");
    const headers = Object.keys(data[0]);

    // Create table header
    const headerRow = document.createElement("tr");
    headers.forEach((header) => {
      const th = document.createElement("th");
      // Format header names (e.g., 'Account_ID' to 'Account ID')
      th.textContent = header.replace(/_/g, " ");
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

    container.appendChild(table);
  }
});
