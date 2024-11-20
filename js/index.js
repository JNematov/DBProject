document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".form");

  if (form) {
    form.addEventListener("submit", (event) => {
      event.preventDefault(); // Prevent the form from submitting
      const passwordInput = document.getElementById("password");
      const errorMessage = document.getElementById("errorMessage");

      // Check if elements are found
      if (!passwordInput || !errorMessage) {
        console.error("Password input or error message element is missing.");
        return;
      }

      const password = passwordInput.value;

      // Check if password contains invalid characters
      if (
        password.includes("'") ||
        password.includes("-") ||
        password.includes("#") ||
        password.includes("=") ||
        password.includes('"')
      ) {
        errorMessage.style.display = "block"; // Show error message
      } else {
        errorMessage.style.display = "none"; // Hide error message
        // Redirect to client dashboard
        window.location.href = "/html/clientDashboard.html";
      }
    });
  } else {
    console.error("Form element not found.");
  }
});
