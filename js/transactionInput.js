document
  .getElementById("transactionForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevents default form submission
    const income = document.getElementById("income").value;
    const expense = document.getElementById("expense").value;

    console.log("New Transaction:", { income, expense });
    // Add functionality to save transaction data here
  });
