<?php
require 'db_connect.php';

if (!isset($_GET['second_id'])) {
    echo "Second Category ID is missing.";
    exit;
}

$second_category_id = $_GET['second_id'];

// Fetch the name and description of the second category
$second_category_query = "
    SELECT sc.name AS second_category_name, sc.description AS second_category_description, sc.main_category_id
    FROM second_categories sc
    WHERE sc.id = $second_category_id";
$second_category_result = mysqli_query($conn, $second_category_query);

if (mysqli_num_rows($second_category_result) == 0) {
    echo "Second Category not found.";
    exit;
}

$second_category = mysqli_fetch_assoc($second_category_result);
$main_category_id = $second_category['main_category_id'];

// Fetch third categories under this second category with product counts, images, and featured status
$third_category_query = "
    SELECT tc.id AS third_category_id, tc.name AS third_category_name, tc.description AS third_category_description, 
           tc.is_featured, ci.image_path, COUNT(p.id) AS product_count
    FROM third_categories tc
    LEFT JOIN product_categories pc ON tc.id = pc.third_category_id
    LEFT JOIN products p ON p.id = pc.product_id
    LEFT JOIN category_images ci ON tc.id = ci.third_category_id
    WHERE tc.second_category_id = $second_category_id
    GROUP BY tc.id";
$third_category_result = mysqli_query($conn, $third_category_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Third Categories for <?php echo htmlspecialchars($second_category['second_category_name']); ?></title>
</head>
<body>

<h1>Third Categories for: <?php echo htmlspecialchars($second_category['second_category_name']); ?></h1>
<p><strong>Description:</strong> <?php echo htmlspecialchars($second_category['second_category_description']); ?></p>

<table>
    <thead>
        <tr>
            <th>Third Category</th>
            <th>Description</th>
            <th>Featured</th> <!-- Added this column to display if the category is featured -->
            <th>Image</th>
            <th>Product Count</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($third_category = mysqli_fetch_assoc($third_category_result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($third_category['third_category_name']); ?></td>
                <td><?php echo htmlspecialchars($third_category['third_category_description']); ?></td>
                <td><?php echo $third_category['is_featured'] ? 'Yes' : 'No'; ?></td> <!-- Displaying if featured -->
                <td>
                    <?php if (!empty($third_category['image_path'])) { ?>
                        <img src="<?php echo $third_category['image_path']; ?>" alt="Category Image" width="50">
                    <?php } else { ?>
                        No image
                    <?php } ?>
                </td>
                <td><?php echo htmlspecialchars($third_category['product_count']); ?></td>
                <td>
                    <a href="view_third_category.php?third_id=<?php echo $third_category['third_category_id']; ?>">View</a>
                    <a href="edit_third_category.php?id=<?php echo $third_category['third_category_id']; ?>">Edit</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Add "Create Third Category" Button -->
<a href="third_category_form.php?second_category_id=<?php echo $second_category_id; ?>" class="btn btn-primary">Create Third Category</a>

<a href="view_main_category.php?id=<?php echo $main_category_id; ?>" class="btn btn-secondary">Back to Second Category List</a>

</body>
</html>

<?php
mysqli_close($conn);
?>