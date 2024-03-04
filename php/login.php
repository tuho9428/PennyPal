<?php

include_once 'db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepare the SQL statement to fetch user data
  $sql = "SELECT * FROM users WHERE email='$username' AND password='$password'";
  $result = mysqli_query($conn, $sql);

  // Start the session
  session_start();

  // Check if user with given credentials exists
  if (mysqli_num_rows($result) == 1) {

    // Valid login, fetch user_id and store it in session variable
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['email'] = $row['email'];

    
    // Valid login, redirect to expenses.php
    $_SESSION['logged_in'] = true;

    header("Location: ../dashboard.php");
    
    exit();
  } else {
    // Invalid login, display error message
    echo "Invalid username or password. Please try again.";
  }
}
?>
