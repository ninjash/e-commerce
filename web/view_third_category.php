<?php
require 'db_connect.php';

if (!isset($_GET['third_id'])) {
    echo "Third Category ID is missing.";
    exit;
}

$third_category_id = $_GET['third_id'];

// Fetch the name and description of the third category
$third_category_query = "
    SELECT tc.name AS third_category_name, tc.description AS third_category_description, sc.main_category_id, sc.id AS second_category_id
    FROM third_categories tc
    JOIN second_categories sc ON tc.second_category_id = sc.id
    WHERE tc.id = $third_category_id";
$third_category_result = mysqli_query($conn, $third_category_query);

if (mysqli_num_rows($third_category_result) == 0) {
    echo "Third Category not found.";
    exit;
}

$third_category = mysqli_fetch_assoc($third_category_result);

// Fetch products under this third category
$product_query = "
    SELECT p.id AS product_id, p.name AS product_name, p.sku, p.price, p.feature_product
    FROM products p
    INNER JOIN product_categories pc ON p.id = pc.product_id
    WHERE pc.third_category_id = $third_category_id";
$product_result = mysqli_query($conn, $product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products for <?php echo htmlspecialchars($third_category['third_category_name']); ?></title>
</head>
<body>

<h1>Products for: <?php echo htmlspecialchars($third_category['third_category_name']); ?></h1>
<p><strong>Description:</strong> <?php echo htmlspecialchars($third_category['third_category_description']); ?></p>

<?php if (mysqli_num_rows($product_result) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = mysqli_fetch_assoc($product_result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['sku']); ?></td>
                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo $product['feature_product'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <a href="product.php?id=<?php echo $product['product_id']; ?>">View</a>
                        <a href="edit_product.php?id=<?php echo $product['product_id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No products found in this category.</p>
<?php endif; ?>

<a href="view_second_category.php?second_id=<?php echo $third_category['second_category_id']; ?>" class="btn btn-secondary">Back to Third Category List</a>

</body>
</html>

<?php
mysqli_close($conn);
?>