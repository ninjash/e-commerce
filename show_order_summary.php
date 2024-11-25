<?php
function show_order_summary($orderId, $conn) {
    // Fetch order items from the database
    $orderItems = [];
    if ($orderId) {
        $sessionId = session_id(); // Assign session ID to a variable
        $stmt = $conn->prepare("
            SELECT c.product_id, p.name, c.quantity, p.price
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.session_id = ?
        ");
        $stmt->bind_param('s', $sessionId); // Use the variable here
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $orderItems[] = $row;
        }
        $stmt->close();
    }

    // Display order summary
    echo '<h3 class="mt-4">Order Items</h3>';
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Product</th>';
    echo '<th>Quantity</th>';
    echo '<th>Price</th>';
    echo '<th>Total</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($orderItems as $item) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($item['name']) . '</td>';
        echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
        echo '<td>$' . number_format($item['price'], 2) . '</td>';
        echo '<td>$' . number_format($item['price'] * $item['quantity'], 2) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}