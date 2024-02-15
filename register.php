<?php
include 'partials/header.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydata";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $sql = "INSERT INTO users (email, password) VALUES ('$username', '$password')";

    // Execute the SQL statement
    if (mysqli_query($conn, $sql)) {
      echo "Registration successful. Data saved to the database.";
      
      // Redirect to login page
      header("Location: login.php");
      exit();
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  
}

$conn->close(); // Close the database connection
?>

<div class="container mt-5">
  <h1>Register</h1>

  <div class="row">
    <div class="col-sm-8">
      <div class="card">
        <div class="card-body">

          <!-- Makes POST request to /register route -->
          <form action="/PennyPal3/register.php" method="POST">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-dark">Register</button>
          </form>

        </div>
      </div>
    </div>

        <!-- Makes POST request to /login route
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <a class="btn btn-dark" href="/auth/google" role="button">
            <i class="fab fa-google"></i>
            Sign In with Google
          </a>
        </div>
      </div>
    </div>
    -->

  </div>
</div>

<?php
include 'partials/footer.php';
?>