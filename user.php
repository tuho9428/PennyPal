<?php

session_start();

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

if (!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)) {
  header("Location: login.php");
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

// Retrieve user data from the database
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $age = $row['age'];
    $address = $row['address'];
    $phone = $row['phone'];
} else {
    echo "User data not found in the database.";
}

$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>PennyPal - User Information</title>
    <meta charset="UTF-8">
    <title> PennyPal</title>
    <link href="./CSS/index.css" rel="stylesheet">
    <link href="./CSS/login.css" rel="stylesheet">
    <link href="./CSS/report.css" rel="stylesheet">
    <script src="js/nav.js" defer></script>
    <script src="js/script.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .user-info {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .user-info p {
            margin: 10px 0;
        }

        button[name="logout"] {
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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

    <h1>User Information</h1>
    <div class="user-info">
        <p><strong>ID:</strong> <?php echo $user_id; ?></p>
        <p><strong>Name:</strong> <?php echo $name; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Age:</strong> <?php echo $age; ?></p>
        <p><strong>Address:</strong> <?php echo $address; ?></p>
        <p><strong>Phone:</strong> <?php echo $phone; ?></p>
    </div>

<div class="add-container">
  <form  id="updateForm" method="POST" action="php/update-info.php" >
    <button type="submit" class="update-info">Update User Info</button>
  </form> <br>


  <div class="form-group" onclick="location.href='dashboard.php';" style="cursor: pointer;">
      <button class="addExpensesBtn">Back</button>
  </div>

  <form method="post" action=php/logout.php>
    <button type="submit" name="logout">Logout</button>
  </form>

</div>

    <?php
include 'php/footer.php';
?>
