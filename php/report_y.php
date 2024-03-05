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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['selected_year'])) {
  $selectedYear = $_GET['selected_year'];

  $categories = [];
  $sqlCategories = "SELECT category_id, category_name FROM categories";
  $resultCategories = $mysqli->query($sqlCategories);

  while ($row = $resultCategories->fetch_assoc()) {
    $categories[$row['category_id']] = $row['category_name'];
  }

  $userBudgetSettings = [];
  $sqlBudget = "SELECT c.category_name, bs.budget_limit FROM budget_settings bs
                JOIN categories c ON bs.category_id = c.category_id
                WHERE bs.user_id = '$user_id'";
  $resultBudget = $mysqli->query($sqlBudget);

  if ($resultBudget === false) {
    echo "Error: " . $mysqli->error;
  } else {
    while ($rowBudget = $resultBudget->fetch_assoc()) {
      $userBudgetSettings[$rowBudget['category_name']] = $rowBudget['budget_limit'];
    }

    $totalExpensesPerCategoryPerMonth = [];
    $totalAmountPerMonth = [];

    $sqlExpensesPerYear = "SELECT c.category_name, SUM(e.amount) AS total_expense, MONTH(e.expense_date) AS expense_month
                          FROM expenses e
                          JOIN categories c ON e.category = c.category_name
                          WHERE e.user_id = '$user_id' AND YEAR(e.expense_date) = '$selectedYear'
                          GROUP BY c.category_name, MONTH(e.expense_date)";
    $resultExpensesPerYear = $mysqli->query($sqlExpensesPerYear);

    if ($resultExpensesPerYear === false) {
      echo "Error: " . $mysqli->error;
    } else {
      while ($rowExpenseMonth = $resultExpensesPerYear->fetch_assoc()) {
        $totalExpensesPerCategoryPerMonth[$rowExpenseMonth['category_name']][$rowExpenseMonth['expense_month']] = $rowExpenseMonth['total_expense'];
        $totalAmountPerMonth[$rowExpenseMonth['expense_month']] = isset($totalAmountPerMonth[$rowExpenseMonth['expense_month']]) ? $totalAmountPerMonth[$rowExpenseMonth['expense_month']] + $rowExpenseMonth['total_expense'] : $rowExpenseMonth['total_expense'];
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
  <link href="../CSS/index.css" rel="stylesheet">
  <link href="../CSS/login.css" rel="stylesheet">
  <link href="../CSS/report.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="../js/script.js" defer></script>
  <script src="../js/nav.js" defer></script>

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

        img {
            height: 100px;
            width: 100%;
        }

        .year-selection {
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

        .table-container {
            margin-top: 20px;
            overflow-x: auto; /* Add horizontal scroll for small screens */
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

        .chart-container {
            margin-top: 20px;
            display: flex; /* Use flexbox for responsive layout */
            flex-wrap: wrap; /* Allow charts to wrap to the next line */
            justify-content: space-around; /* Spread items evenly */
        }


        .bar-chart-container {
            width: calc(100% - 10px); /* Bar chart takes full width on the first line */
        }

        .pie-chart-container,
        .line-chart-container {
            width: calc(50% - 10px); /* Pie and Line charts take half width on the second line */
        }

        canvas {
            width: 100%; /* Make canvas responsive */
            height: auto; /* Allow canvas to adjust its height proportionally */
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
  
</head>
<body>

<header>
      <div class="top-container">
        <div class="logo-container">
          <img src="../images/logo.png" alt="Logo" />
          <h1>PennyPal</h1>
        </div>
      </div>
  
      <div class="nav-container">
        <nav>
          <ul>
            <li><a href="../home.html">Home</a></li>
            <li><a href="../about.html">About</a></li>
            <li><a href="../contact.html">Contact</a></li>
            <li><a href="../dashboard.php">User Dashboard</a></li>
            <li><a href="../login.html">Login</a></li>
            <li><a href="../register.html">Register</a></li>
            <?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        echo '<span>Hello, ' . $email . '</span>';
    }
    ?>
          </ul>
        </nav>
        <div class="burger-menu" style="margin-left: 95%">&#9776;</div>
      </div>
    </header>

<div class="container">
    <img style="height: 100px; width: 100%;" src="../images/report.webp" alt="Home 1">
</div>

<div class="add-container">

<!-- year-selection -->
<div class="add-container">

  <div class="year-selection">
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

          <button type="submit" name="show_yearly_reports">Show Yearly Reports</button>
      </form>
  </div>

</div>

<div class="table-container">
    <?php
    if (isset($_GET['selected_year'])) {
        echo "<table border='1'>
            <tr>
                <th>Category</th>";
        for ($month = 1; $month <= 12; $month++) {
            echo "<th>Month " . $month . "</th>";
        }
        echo "<th>Total Amount</th></tr>";

        // Check if $totalExpensesPerCategoryPerMonth is set and is an array
        if (isset($totalExpensesPerCategoryPerMonth) && is_array($totalExpensesPerCategoryPerMonth)) {
            // Iterate through $totalExpensesPerCategoryPerMonth
            foreach ($totalExpensesPerCategoryPerMonth as $category => $expensesPerMonth) {
                echo "<tr>
                    <td>" . $category . "</td>";
                $totalCategoryAmount = 0;
                for ($month = 1; $month <= 12; $month++) {
                    $expenseForMonth = isset($expensesPerMonth[$month]) ? $expensesPerMonth[$month] : 0;
                    $totalCategoryAmount += $expenseForMonth;
                    echo "<td>$" . $expenseForMonth . "</td>";
                }
                echo "<td>$" . $totalCategoryAmount . "</td>";
                echo "</tr>";
            }

            echo "<tr>
                <td>Total</td>";
            for ($month = 1; $month <= 12; $month++) {
                $totalAmount = isset($totalAmountPerMonth[$month]) ? $totalAmountPerMonth[$month] : 0;
                echo "<td>$" . $totalAmount . "</td>";
            }
            echo "</tr>";
        } else {
            echo "No data available for the selected year.";
        }

        echo "</table>";
    } else {
        echo "";
    }
    ?>
</div>

<div class="add-container">

<div class="chart-container">
    <?php
    if (isset($_GET['selected_year'])) {
        echo "<div class='bar-chart-container'>
            <canvas id='myChart'></canvas>
        </div>
        <div class='pie-chart-container'>
            <canvas id='myPieChart'></canvas>
        </div>
        <div class='line-chart-container'>
            <canvas id='myLineChart'></canvas>
        </div>";
    } else {
        echo "Please select a year ";
    }
    ?>
</div>
</div>
</div>

<div class="add-container">

<div class="form-group" onclick="location.href='../dashboard.php';" style="cursor: pointer;">
    <button class="addExpensesBtn">User Dashboard</button>
</div>
<div class="form-group" onclick="location.href='../report.php';" style="cursor: pointer;">
    <button class="addExpensesBtn">Back</button>
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


<script>
  var ctxPie = document.getElementById('myPieChart').getContext('2d');
  var myPieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
      labels: <?php echo json_encode(array_keys($totalAmountPerMonth)); ?>,
      datasets: [{
        label: 'Total Expenses Per Month',
        data: <?php echo json_encode(array_values($totalAmountPerMonth)); ?>,
        backgroundColor: [
          'rgba(255, 99, 132, 0.6)',
          'rgba(54, 162, 235, 0.6)',
          'rgba(255, 206, 86, 0.6)',
          'rgba(75, 192, 192, 0.6)',
          'rgba(153, 102, 255, 0.6)',
          'rgba(255, 159, 64, 0.6)',
          'rgba(255, 99, 132, 0.6)',
          'rgba(54, 162, 235, 0.6)',
          'rgba(255, 206, 86, 0.6)',
          'rgba(75, 192, 192, 0.6)',
          'rgba(153, 102, 255, 0.6)',
          'rgba(255, 159, 64, 0.6)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]
    }
});
</script>


<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode(array_keys($totalAmountPerMonth)); ?>,
      datasets: [{
        label: 'Total Expenses Per Month',
        data: <?php echo json_encode(array_values($totalAmountPerMonth)); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<script>
  var ctxLine = document.getElementById('myLineChart').getContext('2d');
  var myLineChart = new Chart(ctxLine, {
    type: 'line',
    data: {
      labels: <?php echo json_encode(array_keys($totalAmountPerMonth)); ?>,
      datasets: [{
        label: 'Total Expenses Per Month',
        data: <?php echo json_encode(array_values($totalAmountPerMonth)); ?>,
        fill: false,
        borderColor: 'rgba(75, 192, 192, 1)',
        tension: 0.4
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>

</html>
