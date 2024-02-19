<?php
// Database credentials
$hostname = "localhost"; // or your database host
$dbname = "mydata";
$username = "root";
$password = "";

// Attempt to establish a connection
try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
}

//<!-- PHP code to fetch categories from the database -->

// Assuming you have a database connection established
// Connect to the database and fetch categories
$categories = []; // Initialize an empty array to store categories
$sql = "SELECT category_id, category_name FROM categories";
$result = $pdo->query($sql);

// Fetch categories and store them in an array
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $categories[$row['category_id']] = $row['category_name'];
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> PennyPal</title>
  <link href="./CSS/index.css" rel="stylesheet">
  <link href="./CSS/login.css" rel="stylesheet">
  <script src="script.js" defer></script>
  
</head>
<header>
  <div class="top-container">
    <div class="logo-container">
      <img src="./images/logo.png" alt="Logo">
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
      </ul>
    </nav>
  </div>

</header>

<div class="a-container">
    <h2>Add Expenses</h2>
    <p>Keep track of your money!</p>

    <img id="add" src="./images/add.jpg" alt="Home 1">

</div>


<div class="add-container">

    <div id="add-section">
        <form method="POST" action="php/expenses1.php" >
            <div>
                <label for="expenseNameInput">Description:</label>
                <input type="text" id="descriptionInput" name="expenseName" placeholder="Enter expense description">
            </div>

            <div>
                <label for="expenseAmountInput">Expense Amount:</label>
                <input type="text" id="expenseAmountInput" name="expenseAmount" placeholder="Enter expense amount">
            </div>

<!-- HTML code with PHP to generate dynamic options -->
<div>
    <label for="categoryInput">Category:</label>
    <select id="categoryInput" name="category">
        <option value="" disabled selected>Select a category</option>
        <!-- Loop through categories and generate options -->
        <?php foreach ($categories as $categoryId => $categoryName): ?>
            <option value="<?php echo $categoryName; ?>"><?php echo $categoryName; ?></option>
        <?php endforeach; ?>
    </select>
</div>


            <div class="form-group">
                <button class="addExpensesBtn"  method="POST" action="update.php"> <a href="update.php">Add a New Category </a ></button>
            </div>


            <div>
                <label for="expenseDateInput">Date:</label>
                <input type="date" id="dateInput" name="date" placeholder="Enter expense date" value="">
            </div>

            <div>
                <button type="submit" id="addExpenseBtn">Add Expense</button>
            </div>
        </form>
    </div>




</div>

<div class="form-group">
    <button class="addExpensesBtn"  > <a href="dashboard.php">User Dashboard</a ></button>
</div>

<form method="post">
    <button type="submit" name="logout">Logout</button>
</form>



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

<script src="script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="script.js"></script>
<script>

</script>

</body>
</html>