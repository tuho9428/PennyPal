<?php

// Start the session
session_start();

// Access user_id from session variable
$user_id = $_SESSION['user_id'];

// Check if the 'logged_in' session variable exists and is set to true
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
  // User is logged in, display the expenses page content
  echo "Welcome to the expenses page!";
} else {
  // User is not logged in, redirect them to the login page
  header("Location: login.html");
  exit();
}

// Database credentials
$hostname = "localhost"; // or your database host
$dbname = "mydata";
$username = "root";
$password = "";

// Attempt to establish a connection using mysqli
$mysqli = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}

//<!-- PHP code to fetch categories from the database using mysqli -->

// Assuming you have a database connection established with mysqli
// Connect to the database and fetch categories
$categories = []; // Initialize an empty array to store categories
$sql = "SELECT category_id, category_name FROM categories";
$result = $mysqli->query($sql);

// Fetch categories and store them in an array
while ($row = $result->fetch_assoc()) {
  $categories[$row['category_id']] = $row['category_name'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>PennyPal</title>
    <link href="./CSS/index.css" rel="stylesheet" />
    <link href="./CSS/login.css" rel="stylesheet" />
    <link href="./CSS/set.css" rel="stylesheet" />
    <script src="set.js" defer></script>
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
            <li><a href="login.html">Login</a></li>
            <li><a href="register.html">Register</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <div class="a-container">
      <h2>Set Budget</h2>
      <p>Set your goal here!</p>

      <img id="add" src="./images/set.png" alt="Home 1" />
    </div>

    <div class="add-container">
      <div class="budget-form">
        <label for="category">Select Category:</label>
        <select id="category" name="category">
          <option value="" disabled selected>Select a category</option>
          <!-- Loop through categories and generate options -->
          <?php foreach ($categories as $categoryId => $categoryName): ?>
            <option value="<?php echo $categoryName; ?>"><?php echo $categoryName; ?></option>
          <?php endforeach; ?>
        </select>

        <div class="form-group">
                <button class="addExpensesBtn"  method="POST" action="update.php"> <a href="update.php">Need to Add a New Category?</a ></button>
            </div>

        <label for="timeframe">Select Timeframe:</label>
        <select id="timeframe" name="timeframe">
          <option value="weekly">Weekly</option>
          <option value="monthly">Monthly</option>
          <option value="yearly">Yearly</option>
        </select>

        <label for="budget">Set Budget:</label>
        <input
          type="number"
          id="budget"
          name="budget"
          step="0.01"
          placeholder="Enter budget amount"
        />
        <button onclick="saveBudget()">Save Budget</button>
      </div>
    </div>

    <div class="form-group">
      <button class="addExpensesBtn">
        <a href="dashboard.php">User Dashboard</a>
      </button>
    </div>

    <form method="post">
      <button type="submit" name="logout">Logout</button>
    </form>

    <footer class="footer" id="sec-f268">
      <div class="footer-content">
        <div class="footer-info">
          <h3>About Us</h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
            mauris lorem, dignissim ut odio vitae, vehicula ultrices nisi.
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
    <script src="script.js"></script>
  </body>
</html>
