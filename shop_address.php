<?php
require_once 'web/db_connect.php';
require_once 'classes/Address.php';

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$userId = $_SESSION['user_id'] ?? null;
$isGuest = $userId === null;

$addressData = null;
if (!$isGuest) {
    try {
        $address = new Address($pdo);
        $addressData = $address->getUserAddress($userId);
    } catch (Exception $e) {
        error_log("Error fetching address: " . $e->getMessage());
    }
}

if (!isset($_SESSION['order_summary'])) {
    header('Location: shop_cart.php');
    exit;
}

$orderSummary = $_SESSION['order_summary'];
$subtotal = $orderSummary['subtotal'];
$taxes = $orderSummary['taxes'];
$total = $orderSummary['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Parts E-Commerce - Address</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/e-commerce/styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <?php include 'global/header.php'; ?>
</header>

<main>
    <div class="container-fluid oe_website_sale py-4 mb-3">
        <div class="row w-100">
            <div class="col-12 col-xl-8 oe_cart">
                <!-- Progress Indicator -->
                <div class="container my-4">
                    <div class="progress-bar-wrapper d-flex justify-content-between align-items-center">
                        <div class="progress-step completed">
                            <div class="circle">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <span class="step-label">Review Order</span>
                        </div>
                        <div class="progress-line"></div>
                        <div class="progress-step completed">
                            <div class="circle">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <span class="step-label">Billing & Shipping</span>
                        </div>
                        <div class="progress-line"></div>
                        <div class="progress-step">
                            <div class="circle"></div>
                            <span class="step-label">Payment</span>
                        </div>
                        <div class="progress-line"></div>
                        <div class="progress-step">
                            <div class="circle"></div>
                            <span class="step-label">Confirmation</span>
                        </div>
                    </div>
                </div>

                <!-- Address Form -->
                <h2 class="pb-3">Fill in your address or <a href="/login" class="text-primary">Sign in</a></h2>
                <form action="save_address.php" method="post" class="mb-4">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($addressData['name'] ?? '') ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($addressData['email'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="+1" value="<?= htmlspecialchars($addressData['phone_number'] ?? '') ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="street1" class="form-label">Street and Number</label>
                        <input type="text" class="form-control" id="street1" name="street1" value="<?= htmlspecialchars($addressData['address_line_1'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="street2" class="form-label">Street 2</label>
                        <input type="text" class="form-control" id="street2" name="street2" value="<?= htmlspecialchars($addressData['address_line_2'] ?? '') ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="<?= htmlspecialchars($addressData['city'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="zip" class="form-label">Zip Code</label>
                            <input type="text" class="form-control" id="zip" name="zip" value="<?= htmlspecialchars($addressData['postal_code'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="state" class="form-label">State / Province</label>
                            <select class="form-control" id="state" name="state" required>
                                <option value="">Select a state</option>
                                <option value="Armed Forces Americas" <?= isset($addressData['state']) && $addressData['state'] === 'Armed Forces Americas' ? 'selected' : '' ?>>Armed Forces Americas</option>
                                <!-- Add other states -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-control" id="country" name="country" required>
                                <option value="United States" <?= isset($addressData['country']) && $addressData['country'] === 'United States' ? 'selected' : '' ?>>United States</option>
                                <!-- Add other countries -->
                            </select>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sameAddress" name="sameAddress">
                                <label class="form-check-label" for="sameAddress">Ship to the same address</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="shop_cart.php" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Next</button>
                    </div>
                </form>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="col-12 col-xl-4 mt-4 mt-xl-0">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Order Total</h3>
                        <hr>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <span id="subtotal">$<?= number_format($subtotal, 2); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Taxes:</span>
                                <span>$<?= number_format($taxes, 2); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong id="total">$<?= number_format($total, 2); ?></strong>
                            </li>
                        </ul>
                        <a href="shop_address.php" class="btn btn-success mt-4 w-100">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer>
    <?php include 'global/footer.php'; ?>
</footer>

<div class="text-center text-white footer-secondary py-2">
    <div class="container">
        <p class="mb-0">© 2024 Car Parts E-Commerce. All Rights Reserved. English | Francais</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>