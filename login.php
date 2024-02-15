<?php
include 'partials/header.php';
include_once 'db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepare the SQL statement to fetch user data
  $sql = "SELECT * FROM users WHERE email='$username' AND password='$password'";
  $result = mysqli_query($conn, $sql);

  // Start the session
  session_start();

  // Check if user with given credentials exists
  if (mysqli_num_rows($result) == 1) {

    // Valid login, fetch user_id and store it in session variable
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $row['user_id'];
    
    // Valid login, redirect to expenses.php
    $_SESSION['logged_in'] = true;

    header("Location: expenses.php");
    
    exit();
  } else {
    // Invalid login, display error message
    echo "Invalid username or password. Please try again.";
  }
}
?>

<div class="container mt-5">
  <h1 class="login">Login</h1>

  <div class="row">
    <div class="col-sm-8">
      <div class="card">
        <div class="card-body">

          <!-- Makes POST request to /login route -->
          <form action="/PennyPal3/login.php" method="POST">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-dark">Login</button>
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