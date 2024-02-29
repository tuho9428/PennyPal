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
  <script src="../script.js" defer></script>

</head>
<header>
  <div class="top-container">
    <div class="logo-container">
      <img src="./images/logo.png" alt="Logo">
      <h1>PennyPal</h1>
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
    <h2>Reports</h2>
    <p>Look at your journey here!</p>

    <img id="add" src="./images/report.webp" alt="Home 1">

</div>

<div> 

<div class="table-container">


</div>

<div class="add-container">
<?php

// Assuming you have a database connection established with mysqli

// Initialize an array to store total expenses per category for each month and total amount per month
$totalExpensesPerCategoryPerMonth = [];
$totalAmountPerMonth = [];

// Query to fetch total expenses for each category per month
$sqlExpensesPerMonth = "SELECT c.category_name, SUM(e.amount) AS total_expense, MONTH(e.expense_date) AS expense_month
                        FROM expenses e
                        JOIN categories c ON e.category = c.category_name
                        WHERE e.user_id = '$user_id'
                        GROUP BY c.category_name, MONTH(e.expense_date)";
$resultExpensesPerMonth = $mysqli->query($sqlExpensesPerMonth);

// Fetch total expenses per category for each month and store them in the array
while ($rowExpenseMonth = $resultExpensesPerMonth->fetch_assoc()) {
  $totalExpensesPerCategoryPerMonth[$rowExpenseMonth['category_name']][$rowExpenseMonth['expense_month']] = $rowExpenseMonth['total_expense'];
  $totalAmountPerMonth[$rowExpenseMonth['expense_month']] = isset($totalAmountPerMonth[$rowExpenseMonth['expense_month']]) ? $totalAmountPerMonth[$rowExpenseMonth['expense_month']] + $rowExpenseMonth['total_expense'] : $rowExpenseMonth['total_expense'];
}

// Display total expenses per category for each month and total amount per month in a table format
echo "<table border='1'>
        <tr>
          <th>Category</th>";
// Generating table headers for months dynamically
for ($month = 1; $month <= 12; $month++) {
  echo "<th>Month " . $month . "</th>";
}
echo "<th>Total Amount</th></tr>";
foreach ($totalExpensesPerCategoryPerMonth as $category => $expensesPerMonth) {
  echo "<tr>
            <td>" . $category . "</td>";
  // Displaying expenses for each month under respective category and calculating total amount per month
  $totalCategoryAmount = 0;
  for ($month = 1; $month <= 12; $month++) {
    $expenseForMonth = isset($expensesPerMonth[$month]) ? $expensesPerMonth[$month] : 0;
    $totalCategoryAmount += $expenseForMonth;
    echo "<td>$" . $expenseForMonth . "</td>";
  }
  echo "<td>$" . $totalCategoryAmount . "</td>";
  echo "</tr>";
}

// Displaying total amount for each month even if there is no expense for that month
echo "<tr>
        <td>Total</td>";
// Displaying total amount for each month or 0 if there is no expense for that month
for ($month = 1; $month <= 12; $month++) {
  $totalAmount = isset($totalAmountPerMonth[$month]) ? $totalAmountPerMonth[$month] : 0;
  echo "<td>$" . $totalAmount . "</td>";
}
echo "</tr>";

?>

<div class="form-group">
    <button class="addExpensesBtn"  > <a href="dashboard.php">User Dashboard</a ></button>
</div>

<form method="post">
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

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../script.js"></script>

</body>
</html>