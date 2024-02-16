<?php
// Database credentials
$servername = "localhost"; // Change this if your MariaDB server is hosted elsewhere
$username = "root"; // Change this if you have a different username
$password = ""; // Change this if you have set a password for your MariaDB server
$database = "mydata"; // Change this to the name of your database

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo("Good");
};
?>
