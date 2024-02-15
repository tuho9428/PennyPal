<?php
include 'partials/header.php';
include_once 'db_connection.php';

// Start the session
session_start();

// Access user_id from session variable
$user_id = $_SESSION['user_id'];

// Check if the 'logged_in' session variable exists and is set to true
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // User is logged in, display the expenses page content
    echo "Welcome to the expenses page!";
} else {
    // User is not logged in, redirect them to the login page
    header("Location: login.php");
    exit();
}

// Logout functionality
if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page after logout
    header("Location: login.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from form
    $expenseName = $_POST['expenseName'] ?? '';
    $expenseAmount = $_POST['expenseAmount'] ?? '';
    $category = $_POST['category'] ?? '';
    $date = $_POST['date'] ?? '';

    // Validate input (you can add more validation here)

    // Check if amount is not null
    if (!empty($expenseAmount)) {
        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO expenses (user_id, amount, category, description, expense_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("idsss", $user_id, $expenseAmount, $category, $expenseName, $date);



        // Execute the statement
        if ($stmt->execute()) {
            echo "Expense saved successfully.";
        } else {
            echo "Error: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Amount cannot be empty.";
    }
}

// Close the connection
$conn->close();
?>





<div class="a-container">
    <h2>Add Expenses</h2>
    <p>Keep track of your money!</p>

    <img id="add" src="./images/add.jpg" alt="Home 1">

</div>


<div class="add-container">
    <!-- Add buttons to pick a specific year -->
    <div>
        <button class="yearBtn" data-year="currentYear">Current Year</button>
        <button class="yearBtn" data-year="lastYear">Last Year</button>
        <!-- Add more buttons for other years as needed -->
    </div>

    <!-- Display selected year -->
    <ul id="year"></ul>

    <!-- Display selected month -->
    <ul id="month"></ul>

    <div id="add-section">
        <form action="expenses.php" method="POST">
            <div>
                <label for="expenseNameInput">Description:</label>
                <input type="text" id="descriptionInput" name="expenseName" placeholder="Enter expense description">
            </div>

            <div>
                <label for="expenseAmountInput">Expense Amount:</label>
                <input type="text" id="expenseAmountInput" name="expenseAmount" placeholder="Enter expense amount">
            </div>

            <div>
                <label for="categoryInput">Category:</label>
                <select id="categoryInput" name="category">
                    <option value="food">Food</option>
                    <option value="transportation">Transportation</option>
                    <option value="housing">Housing</option>
                    <!-- Add more options as needed -->
                </select>
            </div>


            <div>
                <label for="expenseDateInput">Date:</label>
                <input type="date" id="dateInput" name="date" placeholder="Enter expense date" value="">
            </div>

            <div>
                <button type="submit" id="addExpenseBtn">Add Expense</button>
            </div>
        </form>
    </div>

    <!-- Display added expenses -->
    <ul id="expenseList"></ul>


</div>


<form method="post">
    <button type="submit" name="logout">Logout</button>
</form>


<?php
include 'partials/footer.php';
?>