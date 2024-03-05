<?php

session_start();

$user_id = $_SESSION['user_id'];
$email= $_SESSION['email'];

if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)) {
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
  <title>PennyPal</title>
  <link href="./CSS/index.css" rel="stylesheet">
  <link href="./CSS/login.css" rel="stylesheet">
  <link href="./CSS/report.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        
        button a {
            color: #fff;
            cursor: pointer;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .year-and-month-selection {
            margin-top: 20px;
        }

        label, select, button {
            display: block;
            margin-bottom: 10px;
        }

        select, button {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #99d49c;
            color: white;
          }

        .addExpensesBtn {
            background-color: #28a745;
            color: #fff;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button[name="logout"] {
            background-color: #dc3545;
            color: #fff;
            padding: 8px 15px;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
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
          <li>
            <?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        echo '<span>Hello, ' . $email . '</span>';
    }
    ?>
    </li>
        </ul>
      </nav>
    </div>
</header>
<div class="container">
    <img style="height: 100px; width: 100%;" src="./images/report.webp" alt="Home 1">
</div>

<div class="table-container">
    <?php
    if (isset($_GET['selected_year']) && isset($_GET['selected_month'])) {
      $expenseDetails = isset($expenseDetails) ? $expenseDetails : [];
      $totalMonthlyExpense = isset($totalMonthlyExpense) ? $totalMonthlyExpense : 0;
      
      echo "<table border='1'>
              <tr>
                <th>Expense ID</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Expense Date</th>
              </tr>";
      foreach ($expenseDetails as $expense) {
        echo "<tr>
                <td>" . $expense['expense_id'] . "</td>
                <td>" . $expense['category'] . "</td>
                <td>$" . $expense['amount'] . "</td>
                <td>" . $expense['expense_date'] . "</td>
              </tr>";
      }
      echo "<tr>
              <td colspan='2'>Total Expense for Month " . (isset($selectedMonth) ? $selectedMonth : '') . "</td>
              <td colspan='2'>$" . $totalMonthlyExpense . "</td>
            </tr>";
  
      echo "</table>";


    } else {
      echo "Please pick a month and a year";
  }

    ?>
</div>


<div class="add-container">
<!-- year-and-month-selection -->
<div class="year-and-month-selection">
    <form method="get">
        <label for="selected_year">Select Year:</label>
        <select name="selected_year" id="selected_year">
            <?php
            $currentYear = date("Y");
            $nextYear = date("Y") + 1;
            for ($year = $currentYear; $year >= 2020; $year--) {
              echo "<option value='$year'>$year</option>";
            }
            ?>
        </select>

        <label for="selected_month">Select Month:</label>
        <select name="selected_month" id="selected_month">
            <?php
            for ($month = 1; $month <= 12; $month++) {
              $monthName = date("F", mktime(0, 0, 0, $month, 1));
              echo "<option value='$month'>$monthName</option>";
            }
            ?>
        </select>

        <button type="submit" name="show_monthly_reports">Show Monthly Reports</button>
    </form>
</div>
</div>


<div class="add-container">
  <div class="form-group" onclick="location.href='dashboard.php';" style="cursor: pointer;">
      <button class="addExpensesBtn">User Dashboard</button>
  </div>

  <div class="form-group" onclick="location.href='report.php';" style="cursor: pointer;">
      <button class="addExpensesBtn">Back</button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../script.js"></script>


</body>

</html>
