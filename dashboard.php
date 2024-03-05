<?php
include_once 'php/db_connection.php';

// Start the session
session_start();

// Access user_id from session variable
$user_id = $_SESSION['user_id'];



// Check if the 'logged_in' session variable exists and is set to true
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
  // User is logged in, display the expenses page content
  //echo "Welcome to the expenses page!";
  $email= $_SESSION['email'];
  // Now you can use $userEmail for further processing
  //echo "Logged-in user email: " . $email;
} else {
  // User is not logged in, redirect them to the login page
  header("Location: login.html");
  exit();
}

// Logout functionality
if (isset($_POST['logout'])) {
  // Unset all session variables
  $_SESSION = array();

  // Destroy the session
  session_destroy();

  // Redirect to login page after logout
  header("Location: login.html");
  exit();
}

$hostname = "localhost";
$dbname = "mydata";
$username = "root";
$password = "";

$mysqli = new mysqli($hostname, $username, $password, $dbname);

if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['selected_year']) && isset($_GET['selected_month'])) {
  $selectedYear = $_GET['selected_year'];
  $selectedMonth = $_GET['selected_month'];

  $selectedDate = $selectedYear . '-' . str_pad($selectedMonth, 2, '0', STR_PAD_LEFT);

  $expenseDetails = [];
  $sqlExpenseDetails = "SELECT e.expense_id, e.category, e.amount, e.expense_date
                        FROM expenses e
                        JOIN categories c ON c.category_name = e.category
                        WHERE e.user_id = '$user_id' AND DATE_FORMAT(e.expense_date, '%Y-%m') = '$selectedDate'";
  $resultExpenseDetails = $mysqli->query($sqlExpenseDetails);

  if ($resultExpenseDetails === false) {
    echo "Error: " . $mysqli->error;
  } else {
    $totalMonthlyExpense = 0;
    if ($resultExpenseDetails->num_rows > 0) {
      while ($rowExpenseDetail = $resultExpenseDetails->fetch_assoc()) {
        $expenseDetails[] = $rowExpenseDetail;
        $totalMonthlyExpense += $rowExpenseDetail['amount'];
      }
    }
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
  <link href="./CSS/report.css" rel="stylesheet">
  <script src="js/nav.js" defer></script>
  <script src="js/script.js" defer></script>

  <style>
  /* Styling for buttons */
button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    margin-top: 10px;
    cursor: pointer;
    text-decoration: none;
}

button:hover {
    background-color: #0056b3;
}

/* Additional styling for form buttons */
.form-group {
    text-align: center;
}

</style>
<style>
  #logout-button {
    background-color: #c82333; /* Red background color */
    color: white; /* White text color */
    padding: 8px 16px; /* Padding around the text */
    border: none; /* No border */
    border-radius: 4px; /* Rounded corners */
    cursor: pointer; /* Show pointer cursor on hover */
}

#logout-button:hover {
    background-color: blue; /* Darker red background color on hover */
}

  </style>

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
    <img id="add" src="./images/user1.jpg" style="height: 300px" alt="Home 1">

</div>

<div class="add-container">

    <div class="table-container">
    <?php
    // Assuming you have already connected to the database and stored the user ID in $user_id
    
    // Query to fetch recent transactions for the logged-in user
    $sqlRecentTransactions = "SELECT expense_id, category, amount, expense_date 
                            FROM expenses 
                            WHERE user_id = '$user_id' 
                            ORDER BY expense_date DESC 
                            LIMIT 10"; // Retrieve the latest 10 transactions
    
    $resultRecentTransactions = $mysqli->query($sqlRecentTransactions);

    if ($resultRecentTransactions === false) {
      echo "Error: " . $mysqli->error;
    } else {
      echo "<h3>Recent Transactions</h3>";
      echo "<table border='1'>
                <tr>
                <th>Expense ID</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Expense Date</th>
                </tr>";
      while ($row = $resultRecentTransactions->fetch_assoc()) {
        echo "<tr>
                    <td>" . $row['expense_id'] . "</td>
                    <td>" . $row['category'] . "</td>
                    <td>$" . $row['amount'] . "</td>
                    <td>" . $row['expense_date'] . "</td>
                </tr>";
      }
      echo "</table>";
    }
    ?>
    </div>

</div>

<div class="container mt-5">
            <div class="row">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-body">
                            <!-- Buttons Section -->
                            <div class="form-group">
                                <form method="get" action="add.php">
                                    <button type="submit" name="logout">Add Expenses</button>
                                </form>
                            </div>
                            <div class="form-group">
                                <form method="get" action="set.php">
                                    <button type="submit" name="logout">Set Budget</button>
                                </form>
                            </div>
                            <div class="form-group">
                                <form method="get" action="report.php">
                                    <button type="submit" name="logout">Reports</button>
                                </form>
                            </div>
                            <div class="form-group">
                                <form method="get" action="user.php">
                                    <button type="submit" name="logout">User Information</button>
                                </form>
                            </div>
                            <div class="form-group">
                                <form method="post">
                                    <button type="submit" name="logout" id="logout-button">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php
include 'php/footer.php';
?>