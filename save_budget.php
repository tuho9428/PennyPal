<?php
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

$sql = "INSERT INTO budgets (budget, category, timeframe) VALUES ('$budget', '$category', '$timeframe')";

if ($conn->query($sql) === TRUE) {
    echo "Budget saved successfully for $category category in $timeframe timeframe";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

