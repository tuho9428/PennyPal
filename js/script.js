// Home page
// Interactive Accordion
$(".accordion-title").click(function () {
  $(this).next(".accordion-content").slideToggle();
  $(".accordion-content").not($(this).next(".accordion-content")).slideUp();
});

// Tooltip functionality
$(".tooltip").hover(
  function () {
    $(this).find(".tooltip-text").fadeIn();
  },
  function () {
    $(this).find(".tooltip-text").fadeOut();
  }
);

// About page
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

// Contact page
$(document).ready(function () {
  let currentIndex = 0;
  const images = [
    "./images/home1.jpg",
    "./images/home12.jpeg",
    "./images/home13.jpeg",
    "./images/home14.png",
    "./images/contact1.jpg",
  ]; // Add more image paths as needed
  const imgElement = $("#slideshow-img");
  const disappearingImage = $("#disappearing-image");

  function changeImage() {
    imgElement.fadeOut("slow", function () {
      imgElement.attr("src", images[currentIndex]);
      imgElement.fadeIn("slow");
    });

    currentIndex = (currentIndex + 1) % images.length;
  }

  // Hide the disappearing image when the slideshow starts
  imgElement.on("load", function () {
    disappearingImage.hide();
  });

  setInterval(changeImage, 5000); // Change image every 5 seconds
});


// Register page
document.addEventListener("DOMContentLoaded", function () {
  const registerForm = document.getElementById("registerForm");

  registerForm.addEventListener("submit", function (event) {
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
      passwordError.textContent =
        "Password must contain at least 8 characters, including one uppercase letter, one lowercase letter, and one number";
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

function setDateInputValue() {
  // Get today's date in local time zone
  var today = new Date();

  // Adjust to local time zone
  today.setMinutes(today.getMinutes() - today.getTimezoneOffset());

  // Format the date as YYYY-MM-DD (required by the date input type)
  var formattedDate = today.toISOString().slice(0, 10);

  // Set the default value of the input element to the current date
  document.getElementById("dateInput").value = formattedDate;
}

// Call the function to execute the code
setDateInputValue();

