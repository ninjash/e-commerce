<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $attribute_name = $_POST['attribute_name'];

    $query = "INSERT INTO attributes (name) VALUES ('$attribute_name')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: attributes_list.php");
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
    <title>Add Attribute</title>
</head>
<body>

<div class="container">
    <h1 class="mt-4">Add New Attribute</h1>

    <form method="POST" action="attributes_form.php">
        <div class="mb-3">
            <label for="attribute_name" class="form-label">Attribute Name</label>
            <input type="text" class="form-control" id="attribute_name" name="attribute_name" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Attribute</button>
        <a href="attributes_list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
