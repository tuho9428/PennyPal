<?php

include_once 'php/db_connection.php';


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

    header("Location: dashboard.php");
    
    exit();
  } else {
    // Invalid login, display error message
    $_SESSION['message'] = "Invalid username or password. Please try again.";
  }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>PennyPal</title>
    <link href="./CSS/index.css" rel="stylesheet" />
    <link href="./CSS/login.css" rel="stylesheet" />
  </head>

  <body>
    <header>
      <div class="top-container">
        <div class="logo-container">
          <img src="./images/logo.png" alt="Logo" />
          <h1>PennyPal</h1>
        </div>
      </div>

      <div class="nav-container">
        <nav>
          <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="dashboard.php">User Dashboard</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
          </ul>
        </nav>
        <div class="burger-menu" style="margin-left: 95%">&#9776;</div>
      </div>
    </header>

    <div class="container mt-5">
      <h1 class="login">Login</h1>

      <div class="row">
        <div class="col-sm-8">
          <div class="card">
            <div class="card-body">

                <!-- Display messages here -->
                <?php
                if (isset($_SESSION['message'])) {
                    echo '<div class="message">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']); // Clear the message after displaying
                }
                ?><br>
              <!-- Makes POST request to /login route -->
              <form method="POST" id="login-form">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" name="username" id="email"/>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="password" id="password" />
                </div>
                <div class="error-container">
                  <ul class="error-list"></ul>
                </div>
                <button type="submit" class="btn btn-dark">Login</button>
              </form><br>

              <div class="form-group" onclick="location.href='register.php';" style="cursor: pointer;">
                <button class="addExpensesBtn">Don't have an account. <br> Register Here</button>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer" id="sec-f268">
      <div class="footer-content">
        <div class="footer-info">
          <h3>About Us</h3>
          <p>
            At TechTide, our mission is to empower individuals and businesses to take control of their finances and achieve their financial goals.
            </p>
        </div>
        <div class="footer-links">
          <h3>Quick Links</h3>
          <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
        </div>
        <div class="footer-contact">
          <h3>Contact Us</h3>
          <p>Email: info@example.com</p>
          <p>Phone: +1 123 456 789</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p class="small-text">
          Copyright &copy; 2024 PennyPal. All rights reserved.
        </p>
      </div>
    </footer>

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/nav.js"></script>
  </body>

</html>
