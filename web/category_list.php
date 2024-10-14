<?php
require 'db_connect.php';

// Fetch all main categories along with the count of second categories
$query = "
    SELECT mc.id AS main_category_id, mc.name AS main_category_name, mc.description, ci.image_path,
           (SELECT COUNT(*) FROM second_categories sc WHERE sc.main_category_id = mc.id) AS second_category_count
    FROM main_categories mc
    LEFT JOIN category_images ci ON mc.id = ci.main_category_id
";
$result = mysqli_query($conn, $query);
?>

<table>
    <thead>
        <tr>
            <th>Main Category</th>
            <th>Description</th>
            <th>Image</th>
            <th>Second Categories</th> <!-- Added column for second category count -->
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($category = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $category['main_category_name']; ?></td>
                <td><?php echo $category['description']; ?></td>
                <td>
                    <?php if (!empty($category['image_path'])) { ?>
                        <img src="<?php echo $category['image_path']; ?>" alt="Category Image" width="50">
                    <?php } else { ?>
                        No image
                    <?php } ?>
                </td>
                <td><?php echo $category['second_category_count']; ?></td> <!-- Display count -->
                <td>
                    <a href="view_main_category.php?id=<?php echo $category['main_category_id']; ?>">View</a>
                    <a href="edit_main_category.php?id=<?php echo $category['main_category_id']; ?>">Edit</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Add a "Create Main Category" button -->
<div class="mt-4">
    <a href="main_category_form.php" class="btn btn-primary">Create Main Category</a>
</div>

<?php
mysqli_close($conn);
?>