<?php
// Include your database connection or establish a connection here

// Query to fetch categories from the database
$query = "SELECT category_id, category_name FROM categories";
$result = mysqli_query($your_db_connection, $query);

// Check if the query was successful
if ($result) {
    // Fetch categories and generate HTML options
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Generate HTML options for select input
    foreach ($categories as $category) {
        echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
    }
} else {
    echo "<option value=''>Error fetching categories</option>";
}

// Close the database connection
mysqli_close($your_db_connection);
