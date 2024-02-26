<?php
// Retrieve budget data from POST request
$budget = $_POST['budget'];
$currency = $_POST['currency'];

// Save budget data to MariaDB
// Replace the database connection details with your own
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydata";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Hello";
}

$sql = "INSERT INTO budgets (budget, currency) VALUES ('$budget', '$currency')";

if ($conn->query($sql) === TRUE) {
    echo "Budget saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
