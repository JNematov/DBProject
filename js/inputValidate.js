export const validate = (input, location) => {
  if (
    input.includes("'") ||
    input.includes("-") ||
    input.includes("#") ||
    input.includes("=") ||
    input.includes('"')
  ) {
    errorMessage.style.display = "block"; // Show error message
  } else {
    errorMessage.style.display = "none"; // Hide error message
    // Redirect to client dashboard
    window.location.href = location;
  }
};
