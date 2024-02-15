<?php
include 'partials/header.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydata";

// Establish database connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $description = mysqli_real_escape_string($mysqli, $_POST["descriptionInput"]);
    $amount = mysqli_real_escape_string($mysqli, $_POST["expenseAmountInput"]);
    $category = mysqli_real_escape_string($mysqli, $_POST["categoryInput"]);
    $date = mysqli_real_escape_string($mysqli, $_POST["dateInput"]);

    // Insert data into expenses table
    $sql = "INSERT INTO expenses ( amount, category, description, expense_date) 
    VALUES ( $description, $amount, $category, $date)";
    $stmt = $mysqli->prepare($sql);

    // Bind parameters and execute statement
    $stmt->bind_param("idsss", $user_id, $amount, $category, $description, $date);
    $stmt->execute();

    // Check for errors
    if ($stmt->errno) {
        echo "Error: " . $stmt->error;
    } else {
        echo "Expense added successfully!";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$mysqli->close();

// Start the session
session_start();

// Check if the 'logged_in' session variable exists and is set to true
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // User is logged in, display the expenses page content
    echo "Welcome to the expenses page!!!";
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
        <div>
            <label for="expenseNameInput">Description:</label>
            <input type="text" id="descriptionInput" placeholder="Enter expense description">
        </div>

        <div>
            <label for="expenseAmountInput">Expense Amount:</label>
            <input type="text" id="expenseAmountInput" placeholder="Enter expense amount">
        </div>

        <div>
            <label for="expenseNameInput">Category:</label>
            <input type="text" id="categoryInput" placeholder="Enter expense name">
        </div>

        <div>
            <label for="expenseDateInput">Date:</label>
            <input type="date" id="dateInput" placeholder="Enter expense date" value="">
        </div>

        <div>
            <button id="addExpenseBtn" type="submit">Add Expense</button>
        </div>
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