// Get today's date in local time zone
let today = new Date();

// Adjust to local time zone
today.setMinutes(today.getMinutes() - today.getTimezoneOffset());

// Format the date as YYYY-MM-DD (required by the date input type)
let formattedDate = today.toISOString().slice(0, 10);

// Set the default value of the input element to the current date
document.getElementById("dateInput").value = formattedDate;
