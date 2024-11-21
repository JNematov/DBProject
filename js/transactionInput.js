document.addEventListener("DOMContentLoaded", () => {
  document
    .getElementById("transactionForm")
    .addEventListener("submit", async function (event) {
      event.preventDefault(); // Prevent form submission

      const invalidChars = ["'", ",", "-", "#", "=", '"'];
      let isValid = true;

      const transactionType = document.getElementById("transactionType").value;
      const amountValue = document.getElementById("amount").value;
      const amount = parseFloat(amountValue);
      const date = document.getElementById("date").value;
      const description = document.getElementById("description").value;

      // Validate Transaction Type
      const transactionTypeError = document.getElementById(
        "transactionTypeError"
      );
      if (!["Deposit", "Withdrawal"].includes(transactionType)) {
        isValid = false;
        transactionTypeError.style.display = "block";
      } else {
        transactionTypeError.style.display = "none";
      }

      // Validate Amount
      const amountError = document.getElementById("amountError");
      if (
        isNaN(amount) ||
        amount <= 0 ||
        invalidChars.some((char) => amountValue.includes(char))
      ) {
        isValid = false;
        amountError.style.display = "block";
      } else {
        amountError.style.display = "none";
      }

      // Validate Date
      const dateError = document.getElementById("dateError");
      if (!date) {
        isValid = false;
        dateError.style.display = "block";
      } else {
        dateError.style.display = "none";
      }

      // Validate Description
      const descriptionError = document.getElementById("descriptionError");
      if (invalidChars.some((char) => description.includes(char))) {
        isValid = false;
        descriptionError.style.display = "block";
      } else {
        descriptionError.style.display = "none";
      }

      if (!isValid) {
        return; // Do not proceed if validation fails
      }

      try {
        const response = await fetch("/php/createTransaction.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ transactionType, amount, date, description }),
        });

        const data = await response.json();

        if (data.success) {
          alert("Transaction created successfully!");
          document.getElementById("transactionForm").reset(); // Reset form
        } else {
          alert(data.message || "Failed to create transaction.");
        }
      } catch (error) {
        console.error("Error:", error);
        alert("An error occurred while submitting the transaction.");
      }
    });
});
