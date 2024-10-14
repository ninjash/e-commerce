<?php
require 'db_connect.php';

if (!isset($_GET['id'])) {
    echo "Main Category ID is missing.";
    exit;
}

$main_category_id = $_GET['id'];

// Fetch the name and description of the main category
$main_category_query = "
    SELECT mc.name AS main_category_name, mc.description 
    FROM main_categories mc 
    WHERE mc.id = $main_category_id";
$main_category_result = mysqli_query($conn, $main_category_query);

if (mysqli_num_rows($main_category_result) == 0) {
    echo "Main Category not found.";
    exit;
}

$main_category = mysqli_fetch_assoc($main_category_result);

// Fetch second categories under this main category with their descriptions, images, and count of third categories
$second_category_query = "
    SELECT sc.id AS second_category_id, sc.name AS second_category_name, sc.description AS second_category_description, 
           ci.image_path, 
           (SELECT COUNT(*) FROM third_categories tc WHERE tc.second_category_id = sc.id) AS third_category_count
    FROM second_categories sc
    LEFT JOIN category_images ci ON sc.id = ci.second_category_id
    WHERE sc.main_category_id = $main_category_id";
$second_category_result = mysqli_query($conn, $second_category_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Categories for <?php echo htmlspecialchars($main_category['main_category_name']); ?></title>
</head>
<body>

<h1>Second Categories for: <?php echo htmlspecialchars($main_category['main_category_name']); ?></h1>
<p><strong>Description:</strong> <?php echo htmlspecialchars($main_category['description']); ?></p>

<table>
    <thead>
        <tr>
            <th>Second Category</th>
            <th>Description</th>
            <th>Image</th>
            <th>Number of Third Categories</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($second_category = mysqli_fetch_assoc($second_category_result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($second_category['second_category_name']); ?></td>
                <td><?php echo htmlspecialchars($second_category['second_category_description']); ?></td>
                <td>
                    <?php if (!empty($second_category['image_path'])) { ?>
                        <img src="<?php echo $second_category['image_path']; ?>" alt="Category Image" width="50">
                    <?php } else { ?>
                        No image
                    <?php } ?>
                </td>
                <td><?php echo $second_category['third_category_count']; ?></td>
                <td>
                    <a href="view_second_category.php?second_id=<?php echo $second_category['second_category_id']; ?>">View</a>
                    <a href="edit_second_category.php?id=<?php echo $second_category['second_category_id']; ?>">Edit</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Add the Create Second Category button with the main_category_id passed in the URL -->
<a href="second_category_form.php?main_category_id=<?php echo $main_category_id; ?>" class="btn btn-primary">Create Second Category</a>
<a href="category_list.php" class="btn btn-secondary">Back to Main Category List</a>

</body>
</html>

<?php
mysqli_close($conn);
?>