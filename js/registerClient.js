document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".form");

  form.addEventListener("submit", (event) => {
    let isValid = true;
    const invalidChars = ["'", ",", "-", "#", "=", '"'];

    // Validate Social Security Number
    const socialInput = document.getElementById("social");
    const socialError = document.getElementById("socialError");
    if (invalidChars.some((char) => socialInput.value.includes(char))) {
      isValid = false;
      socialError.style.display = "block";
    } else {
      socialError.style.display = "none";
    }

    // Validate Name
    const nameInput = document.getElementById("name");
    const nameError = document.getElementById("nameError");
    if (invalidChars.some((char) => nameInput.value.includes(char))) {
      isValid = false;
      nameError.style.display = "block";
    } else {
      nameError.style.display = "none";
    }

    // Validate Address
    const addressInput = document.getElementById("address");
    const addressError = document.getElementById("addressError");
    if (invalidChars.some((char) => addressInput.value.includes(char))) {
      isValid = false;
      addressError.style.display = "block";
    } else {
      addressError.style.display = "none";
    }

    // Validate Phone Number
    const phoneInput = document.getElementById("phonenumber");
    const phoneError = document.getElementById("phoneError");
    if (invalidChars.some((char) => phoneInput.value.includes(char))) {
      isValid = false;
      phoneError.style.display = "block";
    } else {
      phoneError.style.display = "none";
    }

    // Validate Email
    const emailInput = document.getElementById("email");
    const emailError = document.getElementById("emailError");
    if (invalidChars.some((char) => emailInput.value.includes(char))) {
      isValid = false;
      emailError.style.display = "block";
    } else {
      emailError.style.display = "none";
    }

    // Validate Date of Birth
    // (No invalid character check needed for date input)

    // Validate Username
    const usernameInput = document.getElementById("username");
    const usernameError = document.getElementById("usernameError");
    if (invalidChars.some((char) => usernameInput.value.includes(char))) {
      isValid = false;
      usernameError.style.display = "block";
    } else {
      usernameError.style.display = "none";
    }

    // Validate Password
    const passwordInput = document.getElementById("password");
    const passwordError = document.getElementById("passwordError");
    if (invalidChars.some((char) => passwordInput.value.includes(char))) {
      isValid = false;
      passwordError.style.display = "block";
    } else {
      passwordError.style.display = "none";
    }

    if (!isValid) {
      event.preventDefault();
    }
  });
});
