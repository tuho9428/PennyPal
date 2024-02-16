<?php
include_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $name = $_POST['Name'];
  $guests = $_POST['Guests'];
  $date_time = $_POST['date'];
  $special_requests = $_POST['Message'];
  $place = $_POST['place'];

  // Prepare and execute SQL query to insert data into the reservations table
  $sql = "INSERT INTO reservations (name, guests, date_time, special_requests, place) VALUES (?, ?, ?, ?, ?)";

  // Prepare statement
  $stmt = $conn->prepare($sql);

  // Bind parameters
  $stmt->bind_param("sisss", $name, $guests, $date_time, $special_requests, $place);

  // Execute statement
  if ($stmt->execute()) {
    // Close statement and connection
    // Redirect to success page or display success message
    echo "Reservation saved successfully!";
  } else {
    // Redirect to error page or display error message
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $stmt->close();
  $conn->close();
}

?>