<?php
require 'db_connect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];

    $query = "INSERT INTO categories (name) VALUES ('$category_name')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: category_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
</head>
<body>

<div class="container">
    <h1 class="mt-4">Add New Category</h1>

    <form method="POST" action="category_form.php">
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Category</button>
        <a href="category_list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>