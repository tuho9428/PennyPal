<?php
include_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $sql = "INSERT INTO users (email, password) VALUES ('$username', '$password')";

    // Execute the SQL statement
    if (mysqli_query($conn, $sql)) {
      echo "Registration successful. Data saved to the database.";
      
      // Redirect to login page
      header("Location: ../login.html");
      exit();
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  
}

$conn->close(); // Close the database connection
?>
