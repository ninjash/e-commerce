<?php
require 'db_connect.php';

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>SKU</th>
            <th>Price</th>
            <th>Feature Product</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($product = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo $product['sku']; ?></td>
                <td><?php echo $product['price']; ?></td>
                <td><?php echo $product['feature_product'] ? 'Yes' : 'No'; ?></td>
                <td>
                    <a href="product.php?id=<?php echo $product['id']; ?>">View</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
