<?php
require 'db_connect.php';

// Fetch manufacturers with their associated product counts
$query = "SELECT m.id, m.name, m.specialty, m.logo_path, COUNT(p.id) as product_count 
          FROM manufacturers m
          LEFT JOIN products p ON m.id = p.manufacturer_id
          GROUP BY m.id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manufacturers List</title>
</head>
<body>

<div class="container mt-4">
    <h1>Manufacturers List</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Manufacturer Name</th>
                <th>Specialty</th>
                <th>Logo</th>
                <th>Product Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($manufacturer = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $manufacturer['id']; ?></td>
                    <td><?php echo $manufacturer['name']; ?></td>
                    <td><?php echo $manufacturer['specialty']; ?></td>
                    <td>
                        <img src="<?php echo $manufacturer['logo_path']; ?>" alt="<?php echo $manufacturer['name']; ?> Logo" style="max-width: 100px;">
                    </td>
                    <td><?php echo $manufacturer['product_count']; ?></td>
                    <td>
                        <a href="manufacturer.php?id=<?php echo $manufacturer['id']; ?>" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="manufacturer_form.php" class="btn btn-success">Add New Manufacturer</a>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
