<?php

// Start the session
session_start();

// Access user_id from session variable
$user_id = $_SESSION['user_id'];

// Check if the 'logged_in' session variable exists and is set to true
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // User is logged in, display the expenses page content
    //echo "Welcome to the expenses page!";
    $email= $_SESSION['email'];
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

// Fetch budget settings for the user from the database
$userBudgetSettings = [];
$sqlBudget = "SELECT c.category_name, bs.budget_limit FROM budget_settings bs
              JOIN categories c ON bs.category_id = c.category_id
              WHERE bs.user_id = '$user_id'";
$resultBudget = $mysqli->query($sqlBudget);

if ($resultBudget->num_rows > 0) {
    while ($rowBudget = $resultBudget->fetch_assoc()) {
        $userBudgetSettings[$rowBudget['category_name']] = $rowBudget['budget_limit'];
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> PennyPal</title>
  <link href="./CSS/index.css" rel="stylesheet">
  <link href="./CSS/login.css" rel="stylesheet">
  <script src="script.js" defer></script>
  <script src="nav.js" defer></script>

  <style>
    .container {
    max-width: 800px;
    margin: 0 auto;
}

img#add {
    width: 100%;
    height: auto;
}

.add-container {
    margin-top: 20px;
}

#add-section {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 5px;
}

form {
    margin-bottom: 20px;
}

label {
    font-weight: bold;
}

input[type="text"],
select,
button {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

select {
    cursor: pointer;
}

ul {
    list-style-type: none;
    padding: 0;
}

.addExpensesBtn {
    background-color: #28a745;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.addExpensesBtn a {
    color: white;
    text-decoration: none;
}

#addExpenseBtn {
    background-color: #28a745;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.form-group {
    margin-bottom: 20px;
}

button[name="logout"] {
    background-color: #dc3545;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
#addExpenseBtn:hover{
    background-color: #dc3545;
}

    </style>
  
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
            <li>
            <?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        echo '<span>Hello, ' . $email . '</span>';
    }
    ?>
    </li>
          </ul>
        </nav>
        <div class="burger-menu" style="margin-left: 95%">&#9776;</div>
      </div>
    </header>


<div class="container">
    <img id="add" src="./images/add.jpg" style="height: 250px" alt="Home 1">



<div class="add-container">

    <div id="add-section">
        <form method="POST" action="php/expenses.php" >
            <div>
                <label for="expenseNameInput">Description:</label>
                <input type="text" id="descriptionInput" name="expenseName" placeholder="Enter expense description">
            </div>

            <div>
                <label for="expenseAmountInput">Expense Amount:</label>
                <input type="text" id="expenseAmountInput" name="expenseAmount" placeholder="Enter expense amount">
            </div>

<!-- HTML code with PHP to generate dynamic options -->
<div>
    <label for="categoryInput">Category:</label>
    <select id="categoryInput" name="category">
        <option value="" disabled selected>Select a category</option>
        <!-- Loop through categories and generate options -->
        <?php foreach ($categories as $categoryId => $categoryName): ?>
                    <option value="<?php echo $categoryName; ?>"><?php echo $categoryName; ?></option>
        <?php endforeach; ?>
    </select>
</div>

            <div>
                <label for="expenseDateInput">Date:</label>
                <input type="date" id="dateInput" name="date" placeholder="Enter expense date" value=""><br><br><br>
            </div>

            <div>
                <button type="submit" >Add Expense</button>
            </div>
        </form>
    </div>

</div>

</div>
<div class="add-container">
<!-- Display budget limits for the user -->
<div>
    <h3>Your Budget Settings:</h3>
    <ul>
        <?php foreach ($userBudgetSettings as $category => $budgetLimit): ?>
                    <li><?php echo $category . ": $" . $budgetLimit; ?></li>
        <?php endforeach; ?>
    </ul>
</div> <br><br>

<div class="form-group">
                <button class="addExpensesBtn"  method="POST" action="update.php"> <a href="update.php">Add a New Category? </a ></button>
            </div>
</div>

<div class="add-container">
<div class="form-group">
<div class="form-group" onclick="location.href='dashboard.php';" style="cursor: pointer;">
    <button class="addExpensesBtn">User Dashboard</button>
</div>
</div>

<form method="post" action= "php/logout.php">
    <button type="submit" name="logout">Logout</button>
</form>
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

<script src="script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="script.js"></script>
<script>

</script>

</body>
</html>