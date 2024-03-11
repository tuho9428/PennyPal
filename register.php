<?php
include_once 'php/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $sql = "INSERT INTO users (email, password) VALUES ('$username', '$password')";

    // Execute the SQL statement
    if (mysqli_query($conn, $sql)) {
      $_SESSION['message'] = "Registration successful. Please Try to log in";

  } else {
    $_SESSION['message'] = "Error: " . $username . "already exists <br> Try to Log in";
  }
  
}



$conn->close(); // Close the database connection
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> PennyPal</title>
  <link href="./CSS/index.css" rel="stylesheet">
  <link href="./CSS/login.css" rel="stylesheet">
  <script src="js/script.js" defer></script>
  <script src="js/nav.js" defer></script>
  
</head>
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
  

  <div class="row">
    <div class="col-sm-8">
      <div class="card">
        <h1 class="login">Register</h1>
        <div class="card-body">

                <!-- Display messages here -->
                <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="message">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']); // Clear the message after displaying
        }
        ?><br>

          <!-- Makes POST request to /register route -->
          <form method="POST" id="registerForm">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="username" id="email">
              <span class="error-msg" id="emailError"></span>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" id="password">
              <span class="error-msg" id="passwordError"></span>
            </div>
            <button type="submit" class="btn btn-dark">Register</button>
          </form><br>

          <div class="form-group" onclick="location.href='login.php';" style="cursor: pointer;">
            <button class="addExpensesBtn">Login Here</button>
        </div>

        </div>
      </div>
    </div>

        <!-- Makes POST request to /login route
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <a class="btn btn-dark" href="/auth/google" role="button">
            <i class="fab fa-google"></i>
            Sign In with Google
          </a>
        </div>
      </div>
    </div>
    -->

  </div>
</div>

<footer class="footer" id="sec-f268">
  <div class="footer-content">
      <div class="footer-info">
          <h3>About Us</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla mauris lorem, dignissim ut odio vitae, vehicula ultrices nisi.</p>
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
      <p class="small-text">Copyright &copy; 2024 PennyPal. All rights reserved.</p>
  </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>
</html>