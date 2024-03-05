<?php
include 'php/header.php';
include_once 'php/db_connection.php';

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

<link href="./CSS/report.css" rel="stylesheet">

<div class="a-container">
    <h2>User Dashboard</h2>
    <p>Explore more here!</p>

    <img id="add" src="./images/user.jpg" style="height: 200px" alt="Home 1">

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

          <!-- Makes POST request to /login route -->
        
            <div class="form-group">
        
                <button class="addExpensesBtn"  > <a href="add.php">Add Expenses</a ></button>

            </div>

            <div class="form-group">
        
                <button class="addExpensesBtn"  > <a href="set.php">Set Budget</a ></button>

            </div>
            <div class="form-group">
        
                <button class="addExpensesBtn"  > <a href="report.php">Reports</a ></button>

            </div>
            <div class="form-group">
            <form method="post">
                <button type="submit" name="logout">Logout</button>
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