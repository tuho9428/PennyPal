// Login page
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("login-form");
  
    form.addEventListener("submit", function (event) {
      event.preventDefault(); // Prevent form submission
  
      // Get form inputs
      const emailInput = document.getElementById("email");
      const passwordInput = document.getElementById("password");
      
  
      // Regular expressions for email and password formats
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
  
      // Error messages
      const errors = {};
  
      // Validate email format
      if (!emailRegex.test(emailInput.value)) {
        errors.email = "Please enter a valid email address";
      }
  
      // Validate password format
      if (!passwordRegex.test(passwordInput.value)) {
        errors.password =
          "Password must contain at least 8 characters, including one uppercase letter, one lowercase letter, and one number";
      }
  
      // Display error messages
      const errorList = document.querySelector(".error-list");
      errorList.innerHTML = ""; // Clear previous errors
  
      if (Object.keys(errors).length > 0) {
        Object.values(errors).forEach((message) => {
          const li = document.createElement("li");
          li.textContent = message;
          errorList.appendChild(li);
        });
      } else {
        form.submit(); // Submit the form if no errors
      }
    });
  });