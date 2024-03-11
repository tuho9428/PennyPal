<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> PennyPal</title>
  <link href="./CSS/index.css" rel="stylesheet">
  <link href="./CSS/login.css" rel="stylesheet">
  <script src="../script.js" defer></script>
  
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
            <li>
            <?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        echo '<span>Welcome, ' . $_SESSION['user_email'] . '</span>';
    }
    ?>
            </li>
          </ul>
        </nav>
        <div class="burger-menu" style="margin-left: 95%">&#9776;</div>
      </div>
    </header>