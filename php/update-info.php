<?php
// update-info.php
session_start();
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are set in $_POST before accessing them
    if (isset($_POST['name'], $_POST['age'], $_POST['address'], $_POST['phone'])) {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        // Prepare an SQL statement to update the user's information in the database
        $sql = "UPDATE users SET name = '$name', age = '$age', address = '$address', phone = '$phone' WHERE user_id = $user_id";

        if ($mysqli->query($sql) === TRUE) {
            $_SESSION['message'] = "Data updated successfully";
            header("Location: update-info.php"); // Redirect back to the form page
            exit();
        } else {
            $_SESSION['message'] = "Error updating data: " . $mysqli->error;
            header("Location: update-info.php"); // Redirect back to the form page
            exit();
        }
    } else {
        $_SESSION['message'] = "";
        header("Location: update-info.php"); // Redirect back to the form page
        exit();

    }
}

// Close the database connection
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>PennyPal - User Information</title>
    <meta charset="UTF-8">
    <title> PennyPal</title>
    <link href="../CSS/index.css" rel="stylesheet">
    <link href="../CSS/login.css" rel="stylesheet">
    <link href="../CSS/report.css" rel="stylesheet">
    <script src="../js/nav.js" defer></script>
    <script src="../js/script.js" defer></script>
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
          <img src="../images/logo.png" alt="Logo" />
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

<div class="add-container">
    <h1>Update User Information</h1>

    <form method="POST" action="update-info.php">
    <!-- Display messages here -->
    <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="message">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']); // Clear the message after displaying
    }
    ?>
    <br><br>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required><br><br>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required><br><br>

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" required><br><br>

    <button type="submit">Submit</button>
</form>
</div>

<div class="add-container">

    <div class="form-group" onclick="location.href='../user.php';" style="cursor: pointer;">
      <button class="addExpensesBtn">Back</button>
    </div>

    <div class="form-group" onclick="location.href='../dashboard.php';" style="cursor: pointer;">
      <button class="addExpensesBtn">Dashboard</button>
    </div>
</div>

<?php
include 'footer.php';
?>
