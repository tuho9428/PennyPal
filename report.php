<?php

session_start();

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)) {
  header("Location: login.php");
  exit();
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
  <script src="js/nav.js" defer></script>

  <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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

        .mt-5 {
            margin-top: 5px;
        }

        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        button {
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        button a {
            color: #fff;
            cursor: pointer;
        }


        .addExpensesBtn {
            background-color: #28a745;
            color: #fff;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 3px;s
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
    <img style="height: 150px; width: 100%;" src="./images/report.webp" alt="Home 1">
</div>

<div class="add-container">
  <div class="container mt-5">
    <div class="row">
      <div class="col-sm-8">
        <div class="card">
          <div class="card-body">
            <!-- Makes GET request -->
            <div class="form-group">
                <form action="php/report_m.php"  method="GET">
                  <button type="submit">Monthly Reports</button>
                </form>
              </div>

              <div class="form-group">
                <form action="php/report_y.php"  method="GEt">
                  <button type="submit">Yearly Reports</button>
                </form>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="add-container">

    <div class="form-group" onclick="location.href='dashboard.php';" style="cursor: pointer;">
        <button class="addExpensesBtn">User Dashboard</button>
    </div>

    <form method="post" action=php/logout.php>
        <button type="submit" name="logout">Logout</button>
    </form>
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
<script src="js/script.js"></script>


</body>

</html>
