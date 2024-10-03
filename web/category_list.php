<?php
require 'db_connect.php';

$query = "SELECT * FROM categories";
$result = mysqli_query($conn, $query);
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($category = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $category['id']; ?></td>
                <td><?php echo $category['name']; ?></td>
                <td><?php echo $category['description']; ?></td>
                <td>
                    <a href="category.php?id=<?php echo $category['id']; ?>">View</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>