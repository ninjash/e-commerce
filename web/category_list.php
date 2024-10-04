<?php
require 'db_connect.php';

// Fetch categories with their product counts
$query = "SELECT c.id, c.name, c.description, COUNT(pc.product_id) as product_count 
          FROM categories c
          LEFT JOIN product_categories pc ON c.id = pc.category_id
          GROUP BY c.id";
$result = mysqli_query($conn, $query);
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Product Count</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($category = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $category['id']; ?></td>
                <td><?php echo $category['name']; ?></td>
                <td><?php echo $category['description']; ?></td>
                <td><?php echo $category['product_count']; ?></td>
                <td>
                    <a href="category.php?id=<?php echo $category['id']; ?>">View</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
