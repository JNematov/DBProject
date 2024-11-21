document.addEventListener("DOMContentLoaded", function () {
  // Fetch data from the server
  fetch("/php/readAdmin.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Render tables for each entity
        renderTable(data.customers, "customersTable", true); // Pass `true` to add "Change Profile" button for customers
        renderTable(data.employees, "employeesTable");
        renderTable(data.branches, "branchesTable");
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

  // Function to render tables with "Change Profile" button for customers
  function renderTable(data, containerId, isCustomerTable = false) {
    const container = document.getElementById(containerId);
    container.innerHTML = ""; // Clear previous content

    if (!data || data.length === 0) {
      container.innerHTML = "<p>No data available.</p>";
      return;
    }

    const table = document.createElement("table");
    const headers = Object.keys(data[0]);

    // Table header
    const headerRow = document.createElement("tr");
    headers.forEach((header) => {
      const th = document.createElement("th");
      th.textContent = header.replace(/_/g, " ");
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
          window.location.href = `clientProfile.html?customerId=${encodeURIComponent(
            row.Customer_ID
          )}`;
        };
        actionTd.appendChild(changeProfileBtn);
        rowElement.appendChild(actionTd);
      }
      table.appendChild(rowElement);
    });

    container.appendChild(table);
  }
});
