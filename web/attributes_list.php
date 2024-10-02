<?php
require 'db_connect.php';

$query = "SELECT * FROM attributes";
$result = mysqli_query($conn, $query);

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

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Attribute Name</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No attributes found.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php
mysqli_free_result($result);
mysqli_close($conn);
?>
