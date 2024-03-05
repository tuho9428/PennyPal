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
  header("Location: login.php");
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
    <meta charset="UTF-8" />
    <title>PennyPal</title>
    <link href="./CSS/index.css" rel="stylesheet" />
    <link href="./CSS/login.css" rel="stylesheet" />
    <link href="./CSS/set.css" rel="stylesheet" />
    <script src="js/nav.js" defer></script>
    <style>
.container {
  text-align: center;
  margin-top: 20px;
}

.add-container {
  margin-top: 20px;
}

.budget-form {
  margin-top: 20px;
}

.form-group {
  margin-top: 10px;
}

#set {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px;
}

.addExpensesBtn {
  display: inline-block;
  background-color: #008CBA;
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px;
}

ul {
  list-style-type: none;
}

ul li {
  margin-top: 10px;
}

button {
  background-color: #f44336;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px;
}

button a {
  color: white;
  text-decoration: none;
}

</style>

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

        .budget-form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select, input[type="number"], button {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }

        .form-group {
            margin-top: 20px;
        }

        .addExpensesBtn {
            background-color: #28a745;
            color: #fff;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 3px;
        }

        .logout-container {
            margin-top: 20px;
        }

        button[name="logout"] {
            background-color: #dc3545;
            color: #fff;
            padding: 8px 15px;
            border-radius: 3px;
            cursor: pointer;
        }
        
    </style>
    <style>
            button#set {
          background-color: #007bff;
          color: #fff;
          cursor: pointer;
          transition: background-color 0.3s;
      }

      button#set:hover {
          background-color: #0056b3;
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
    <img style="height: 150px; width: 100%;" src="./images/set.png" alt="Home 1">
</div>

    <div class="add-container">

            <!-- Display messages here -->
            <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="message"><h3>' . $_SESSION['message'] . '</<h3></div>';
            unset($_SESSION['message']); // Clear the message after displaying
        }
        ?>

    <form method="POST" action="php/save_budget.php">
      <div class="budget-form">
        <label for="category">Select Category:</label>
        <select id="category" name="category">
          <option value="" disabled selected>Select a category</option>
          <!-- Loop through categories and generate options -->
          <?php foreach ($categories as $categoryId => $categoryName): ?>
            <option value="<?php echo $categoryName; ?>"><?php echo $categoryName; ?></option>
          <?php endforeach; ?>
        </select>



        <label for="timeframe">Select Timeframe:</label>
        <select id="timeframe" name="timeframe">
          <!--<option value="monthly">Monthly</option> -->
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
        <!--<button onclick="saveBudget()">Save Budget</button> -->
        <button  type="submit" id="set">Set</button>

        </form>
          <div class="form-group">
                <button class="addExpensesBtn"  method="POST" action="update.php"> <a href="update.php">Need to Add a New Category?</a ></button>
            </div>
      </div>

    </div>


    <div class="add-container">
    <!-- Display user's budget settings -->
    <h3>Your Budget Settings</h3>
    <ul>
        <?php foreach ($userBudgetSettings as $category => $budgetLimit): ?>
          <li><?php echo $category . ": $" . $budgetLimit; ?></li>
        <?php endforeach; ?>
    </ul>

    <div class="form-group">
    <div class="form-group" onclick="location.href='dashboard.php';" style="cursor: pointer;">
    <button class="addExpensesBtn">User Dashboard</button>
</div>
    </div>
    </div>

    <div class="add-container">
    <form method="post" action=php/logout.php>
      <button type="submit" name="logout">Logout</button>
    </form>
    </div>
    

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
    <script src="js/script.js"></script>
  </body>
</html>
