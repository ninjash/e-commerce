<?php
require 'db_connect.php';

// Check if a category ID is provided via GET request
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $category_id = $_GET['id'];

    // SQL query to delete the category by its ID
    $delete_query = "DELETE FROM categories WHERE id = ?";
    
    // Prepare the statement
    if ($stmt = mysqli_prepare($conn, $delete_query)) {
        // Bind the category ID to the query
        mysqli_stmt_bind_param($stmt, "i", $category_id);
        
        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to the categories list after deletion
            header("Location: category_list.php?message=Category+Deleted+Successfully");
            exit;
        } else {
            // If the query fails, show an error message
            echo "Error: Could not execute the query. " . mysqli_error($conn);
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // If the query preparation fails, show an error message
        echo "Error: Could not prepare the query. " . mysqli_error($conn);
    }
} else {
    // If no valid ID is provided, redirect to the categories list
    header("Location: category_list.php?error=Invalid+Category+ID");
    exit;
}

// Close the database connection
mysqli_close($conn);
