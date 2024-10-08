<?php
require 'db_connect.php';

// Update the query to join the manufacturers table
$query = "SELECT p.id, p.name, p.sku, p.price, p.feature_product, m.name AS manufacturer_name
          FROM products p
          LEFT JOIN manufacturers m ON p.manufacturer_id = m.id";
$result = mysqli_query($conn, $query);
?>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>SKU</th>
            <th>Price</th>
            <th>Manufacturer</th>
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
                <td><?php echo $product['manufacturer_name'] ? $product['manufacturer_name'] : 'Unknown'; ?></td>
                <td><?php echo $product['feature_product'] ? 'Yes' : 'No'; ?></td>
                <td>
                    <a href="product.php?id=<?php echo $product['id']; ?>">View</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
