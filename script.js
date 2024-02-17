

// Home page

// Tooltip functionality
$(".tooltip").hover(
  function () {
    $(this).find(".tooltip-text").fadeIn();
  },
  function () {
    $(this).find(".tooltip-text").fadeOut();
  }
);

// Interactive Accordion
$(".accordion-title").click(function () {
  $(this).next(".accordion-content").slideToggle();
  $(".accordion-content").not($(this).next(".accordion-content")).slideUp();
});

// Image Lightbox
$(".lightbox-image").click(function () {
  let imageUrl = $(this).attr("src");
  $("body").append(
    '<div class="lightbox-overlay"><img src="' +
      imageUrl +
      '" class="lightbox-displayed-image"></div>'
  );
  $(".lightbox-overlay").click(function () {
    $(this).remove();
  });
});

document.addEventListener("DOMContentLoaded", function() {
    const registerForm = document.getElementById("registerForm");
  
    registerForm.addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent form submission
  
      // Get form inputs and error message elements
      const emailInput = document.getElementById("email");
      const passwordInput = document.getElementById("password");
      const emailError = document.getElementById("emailError");
      const passwordError = document.getElementById("passwordError");
  
      // Regular expressions for email and password formats
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
  
      // Flag to track form validity
      let isValid = true;
  
      // Validate email format
      if (!emailRegex.test(emailInput.value)) {
        emailError.textContent = "Please enter a valid email address";
        isValid = false;
      } else {
        emailError.textContent = ""; // Clear error message
      }
  
      // Validate password format
      if (!passwordRegex.test(passwordInput.value)) {
        passwordError.textContent = "Password must contain at least 8 characters, including one uppercase letter, one lowercase letter, and one number";
        isValid = false;
      } else {
        passwordError.textContent = ""; // Clear error message
      }
  
      // Submit the form if valid
      if (isValid) {
        registerForm.submit();
      }
    });
  });