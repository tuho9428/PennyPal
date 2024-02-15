<?php

// Start the session
session_start();

// Access user_id from session variable
$user_id = $_SESSION['user_id'];


// db_connection


include_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $expenseAmount = isset($_POST["expenseAmount"]) ? $_POST["expenseAmount"] : "";
    $category = isset($_POST["category"]) ? $_POST["category"] : "";
    $description = isset($_POST["description"]) ? $_POST["description"] : "";
    $expenseDate = isset($_POST["expenseDate"]) ? $_POST["expenseDate"] : "";

    if ($expenseAmount !== "" && $category !== "" && $description !== "" && $expenseDate !== "") {
        $sql = "INSERT INTO expenses (user_id, amount, category, description, expense_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ids", $userId, $expenseAmount, $category, $description, $expenseDate);
            $stmt->execute();
            echo "Expense saved successfully.";
            $stmt->close();
        } else {
            echo "Error: Unable to prepare SQL statement.";
        }
    } else {
        echo "Error: Please fill in all expense details.";
    }
} else {
    http_response_code(405);
    echo "Error: Only POST requests are allowed.";
}
?>