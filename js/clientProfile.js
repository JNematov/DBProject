document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("profileForm");

  // Get the customerId from the URL parameters
  const urlParams = new URLSearchParams(window.location.search);
  const customerId = urlParams.get("customerId");

  // Fetch profile data from the server
  fetch(
    `/php/getCustomerProfile.php${
      customerId ? `?customerId=${encodeURIComponent(customerId)}` : ""
    }`
  )
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Populate form fields with data
        document.getElementById("name").value = data.name;
        document.getElementById("address").value = data.address;
        document.getElementById("phone").value = data.phone;
        document.getElementById("email").value = data.email;
        document.getElementById("ssn").value = data.ssn;
        document.getElementById("dob").value = data.dob;
      } else {
        alert("Failed to fetch profile data: " + data.message);
      }
    })
    .catch((error) => {
      console.error("Error fetching profile data:", error);
      alert("An error occurred while fetching profile data.");
    });

  form.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission

    const name = document.getElementById("name").value.trim();
    const address = document.getElementById("address").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const email = document.getElementById("email").value.trim();

    // Input validation (same as before)

    // Send updated profile data to the server
    fetch("/php/updateProfile.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ customerId, name, address, phone, email }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          document.getElementById("successMessage").style.display = "block";
          setTimeout(() => {
            document.getElementById("successMessage").style.display = "none";
          }, 3000);
        } else {
          document.getElementById("profileError").textContent = data.message;
          document.getElementById("profileError").style.display = "block";
        }
      })
      .catch((error) => {
        console.error("Error updating profile:", error);
        document.getElementById("profileError").textContent =
          "An error occurred while updating the profile.";
        document.getElementById("profileError").style.display = "block";
      });
  });
});
