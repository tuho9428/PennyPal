<?php
include_once 'php/db_connection.php';

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
    <title>Add New Category</title>
    <link href="./CSS/styles.css" rel="stylesheet">
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

h2 {
    text-align: center;
}

form {
    width: 50%;
    margin: 0 auto;
}

label {
    font-weight: bold;
}

input[type="text"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
}

button {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

    </style>


<body>
    <h2>Add New Category</h2>
    <form method="POST">
        <label for="newCategory">Category Name:</label>
        <input type="text" id="newCategory" name="newCategory" placeholder="Enter new category name" required>
        <button type="submit">Add Category</button>
    </form>
</body>

</html>
