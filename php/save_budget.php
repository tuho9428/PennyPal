<?php
// Start the session
session_start();

// Access user_id from session variable
$user_id = $_SESSION['user_id'];

// Check if the 'logged_in' session variable exists and is set to true
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
  // User is logged in, display the expenses page content
  //echo "Welcome to the expenses page!";
} else {
  // User is not logged in, redirect them to the login page
  header("Location: login.html");
  exit();
}


// Retrieve budget data from POST request
$budget = $_POST['budget'];
$category = $_POST['category'];
$timeframe = $_POST['timeframe'];

// Save budget data to MariaDB
// Replace the database connection details with your own
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydata";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch category_id from categories table based on category name
$categoryQuery = "SELECT category_id FROM categories WHERE category_name = '$category'";
$categoryResult = $conn->query($categoryQuery);

if ($categoryResult->num_rows > 0) {
    $row = $categoryResult->fetch_assoc();
    $category_id = $row['category_id'];

    // Prepare SQL statement to insert budget data into budget_settings table
    $stmt = $conn->prepare("INSERT INTO budget_settings (user_id, category_id, budget_limit, timeframe) VALUES (?, ?, ?, ?)");
    //$user_id = 1; // Assuming a static user_id for demonstration

    // Bind parameters and execute the statement
    $stmt->bind_param("iiis", $user_id, $category_id, $budget, $timeframe);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Budget saved successfully for $category category in $timeframe timeframe";
        header("Location: ../set.php"); // Redirect back to the form page
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        header("Location: ../set.php"); // Redirect back to the form page
    }

    // Close the statement
    $stmt->close();
} else {
    $_SESSION['message'] = "Category not found.";
    header("Location: ../set.php"); // Redirect back to the form page
    exit();
}

$conn->close();