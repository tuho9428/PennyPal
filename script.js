$(document).ready(function () {
  // Hide the "Add Expense" button initially
  $("#add-section").hide();
  // ... (your existing code)

  $("#addExpenseBtn").click(function () {
    const expenseName = $("#descriptionInput").val().trim();
    const expenseAmount = $("#expenseAmountInput").val().trim();
    const category = $("#categoryInput").val().trim();
    const date = $("#dateInput").val().trim();

    if (
      expenseName !== "" &&
      expenseAmount !== "" &&
      category !== "" &&
      date !== ""
    ) {
      const expense = `${expenseName} - $${expenseAmount} - ${category} - ${date}`;

      // Append expense to the list (for immediate display)
      appendExpenseToList(expense);


    } else {
      alert("Please enter expense details.");
    }
  });

  $(".yearBtn").click(function () {
    const year = $(this).data("year");
    let selectedYear = "";

    const currentYear = new Date().getFullYear();
    const lastYear = currentYear - 1;

    if (year === "currentYear") {
      selectedYear = currentYear;
    } else if (year === "lastYear") {
      selectedYear = lastYear;
    }

    $("#year").html("You picked " + selectedYear);

    const months = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    $("#month").empty();

    const monthSelect = $("<select>");

    if (year === "currentYear") {
      const currentMonth = new Date().getMonth();
      monthSelect.append($("<option>").val("").text("Select Month")); // Dummy selection
      for (let i = 0; i <= currentMonth; i++) {
        monthSelect.append($("<option>").val(months[i]).text(months[i]));
      }
      $("#month")
        .append(selectedYear + ": ")
        .append(monthSelect);
    } else if (year === "lastYear") {
      monthSelect.append($("<option>").val("").text("Select Month")); // Dummy selection
      for (let i = 0; i < months.length; i++) {
        monthSelect.append($("<option>").val(months[i]).text(months[i]));
      }
      $("#month")
        .append(selectedYear + ": ")
        .append(monthSelect);
    }

    // Show the "Add Expense" section once a month has been selected
    monthSelect.on("change", function () {
      $("#add-section").show();
      $("#expenseList").empty();
    });

    // Clear the expense list when a year is selected
    $(".yearBtn").on("click", function () {
      $("#expenseList").empty();
    });
  });
});

function appendExpenseToList(expense) {
  const listItem = $("<li>").text(expense);
  $("#expenseList").append(listItem);
}

// Get today's date in local time zone
let today = new Date();

// Adjust to local time zone
today.setMinutes(today.getMinutes() - today.getTimezoneOffset());

// Format the date as YYYY-MM-DD (required by the date input type)
let formattedDate = today.toISOString().slice(0, 10);

// Set the default value of the input element to the current date
document.getElementById("dateInput").value = formattedDate;
