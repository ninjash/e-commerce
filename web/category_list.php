<?php
require 'db_connect.php';

// Fetch categories with their product counts and image path
$query = "SELECT c.id, c.name, c.description, c.featured, ci.image_path, COUNT(pc.product_id) AS product_count
          FROM categories c
          LEFT JOIN product_categories pc ON c.id = pc.category_id
          LEFT JOIN category_images ci ON c.id = ci.category_id
          GROUP BY c.id";
$result = mysqli_query($conn, $query);
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Featured</th>
            <th>Image</th>
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
                <td><?php echo $category['featured'] ? 'Yes' : 'No'; ?></td>
                <td>
                    <?php if (!empty($category['image_path'])) { ?>
                        <img src="<?php echo $category['image_path']; ?>" alt="Category Image" width="50">
                    <?php } else { ?>
                        No image
                    <?php } ?>
                </td>
                <td><?php echo $category['product_count']; ?></td>
                <td>
                    <a href="category.php?id=<?php echo $category['id']; ?>">View</a>
                    <a href="edit_category.php?id=<?php echo $category['id']; ?>">Edit</a>
                    <a href="delete_category.php?id=<?php echo $category['id']; ?>" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
mysqli_close($conn);
?>