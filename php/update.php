<?php
include_once 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from form
    $newCategory = $_POST['newCategory'] ?? '';

    // Validate input (you can add more validation here)

    // Check if the new category name is not empty
    if (!empty($newCategory)) {
        // Prepare and bind SQL statement to insert the new category into the categories table
        $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->bind_param("s", $newCategory);

        // Execute the statement
        if ($stmt->execute()) {
            echo "New category added successfully.";
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Category name cannot be empty.";
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

  <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    h2 {
        text-align: center;
        margin-top: 20px;
    }

    form {
        width: 50%;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        box-sizing: border-box;
    }

    button {
        padding: 8px 16px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 3px;
    }

    button:hover {
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
            <li><a href="login.html">Login</a></li>
            <li><a href="register.html">Register</a></li>
            <li>
            <?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        echo '<span>Welcome, ' . $_SESSION['user_email'] . '</span>';
    }
    ?>
            </li>
          </ul>
        </nav>
        <div class="burger-menu" style="margin-left: 95%">&#9776;</div>
      </div>
    </header>



<body>
    <h2>Add New Category</h2>
    <form method="POST">
        <label for="newCategory">Category Name:</label>
        <input type="text" id="newCategory" name="newCategory" placeholder="Enter new category name" required>
        <button type="submit">Add Category</button>
    </form>
    
    <form method="GET" action="../add.php">
        <button type="submit">Back to ADD</button>
    </form>
</body>

</html>
