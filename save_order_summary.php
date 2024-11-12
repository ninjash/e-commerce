<?php
session_start();

ini_set('display_errors', 1); // Enable error display for debugging
error_reporting(E_ALL);

// Check if required data is received in POST
if (isset($_POST['subtotal'], $_POST['taxes'], $_POST['total'])) {
    // Sanitize and validate the inputs
    $subtotal = filter_var($_POST['subtotal'], FILTER_VALIDATE_FLOAT);
    $taxes = filter_var($_POST['taxes'], FILTER_VALIDATE_FLOAT);
    $total = filter_var($_POST['total'], FILTER_VALIDATE_FLOAT);

    // Validate data
    if ($subtotal === false || $taxes === false || $total === false) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid numeric data received. Ensure the inputs are valid numbers.',
        ]);
        exit;
    }

    try {
        // Save order summary to the session
        $_SESSION['order_summary'] = [
            'subtotal' => $subtotal,
            'taxes' => $taxes,
            'total' => $total,
        ];

        // Send success response
        echo json_encode([
            'status' => 'success',
            'message' => 'Order summary saved successfully.',
        ]);
        exit;
    } catch (Exception $e) {
        // Log any session save error
        error_log("Failed to save order summary: " . $e->getMessage());

        // Send failure response
        echo json_encode([
            'status' => 'error',
            'message' => 'An error occurred while saving the order summary. Please try again.',
        ]);
        exit;
    }
}

// Return error response if required data is missing
echo json_encode([
    'status' => 'error',
    'message' => 'Invalid data received. Subtotal, taxes, and total are required.',
]);
exit;