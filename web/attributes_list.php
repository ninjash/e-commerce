<?php
require 'db_connect.php';
require_once 'ProductAttribute.php'; // Include the ProductAttribute class

// Instantiate the ProductAttribute class
$productAttribute = new ProductAttribute($conn);

// Fetch all attributes using the ProductAttribute class
$attributes = $productAttribute->getAllAttributes($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attributes List</title>
</head>
<body>

<div class="container mt-4">
    <h1>Attributes List</h1>

    <a href="attributes_form.php" class="btn btn-primary mb-4">Add New Attribute</a>

    <?php if (count($attributes) > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Attribute Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attributes as $attribute): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($attribute['id']); ?></td>
                        <td><?php echo htmlspecialchars($attribute['name']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No attributes found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
