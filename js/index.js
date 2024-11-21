document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".form");

  if (form) {
    form.addEventListener("submit", (event) => {
      let isValid = true;
      const invalidChars = ["'", ",", "-", "#", "=", '"'];

      // Username validation
      const usernameInput = document.getElementById("username");
      const usernameError = document.getElementById("usernameError");
      if (invalidChars.some((char) => usernameInput.value.includes(char))) {
        isValid = false;
        usernameError.style.display = "block";
      } else {
        usernameError.style.display = "none";
      }

      // Password validation
      const passwordInput = document.getElementById("password");
      const passwordError = document.getElementById("passwordError");
      if (invalidChars.some((char) => passwordInput.value.includes(char))) {
        isValid = false;
        passwordError.style.display = "block";
      } else {
        passwordError.style.display = "none";
      }

      if (!isValid) {
        event.preventDefault(); // Prevent the form from submitting
      }
    });
  } else {
    console.error("Form element not found.");
  }
});
