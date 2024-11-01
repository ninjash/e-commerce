<?php
session_start();
require 'db_connect.php';
require '../classes/Manufacturer.php'; // Assuming you have a Manufacturer class

$target_dir = "/e-commerce/assets/brands/";

// Initialize manufacturers in session if not set
if (!isset($_SESSION['manufacturers'])) {
    $_SESSION['manufacturers'] = [];
}

// Handle form submission for adding a manufacturer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_manufacturer'])) {
    $manufacturer_name = $_POST['manufacturer_name'];
    $specialty = $_POST['specialty'];

    // Handle logo file upload
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
        $logo = $_FILES['logo'];
        $target_file = $target_dir . basename($logo["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($logo["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $target_file)) {
            // Store manufacturer data in session
            $manufacturer_data = [
                'name' => $manufacturer_name,
                'specialty' => $specialty,
                'logo_path' => $target_file
            ];
            $_SESSION['manufacturers'][] = $manufacturer_data;

            echo "Manufacturer added successfully. Add another manufacturer or save all.";
        } else {
            echo "Sorry, there was an error uploading the logo.";
        }
    }
}

// Handle form submission to save all manufacturers
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_manufacturers'])) {
    $manufacturerClass = new Manufacturer($conn); // Instantiate Manufacturer class

    foreach ($_SESSION['manufacturers'] as $manufacturer) {
        $manufacturerClass->setName($manufacturer['name']);
        $manufacturerClass->setSpecialty($manufacturer['specialty']);
        $manufacturerClass->setLogoPath($manufacturer['logo_path']);

        if (!$manufacturerClass->save()) {
            echo "Error saving manufacturer: " . $conn->error;
        }
    }

    // Clear session after saving
    $_SESSION['manufacturers'] = [];
    echo "All manufacturers have been saved!";
    header("Location: manufacturer_list.php");
    exit;
}

?>

<!-- HTML Form to Add Manufacturer -->
<form method="POST" action="manufacturer_form.php" enctype="multipart/form-data">
    <label>Manufacturer Name</label>
    <input type="text" name="manufacturer_name" required><br>

    <label>Specialty</label>
    <input type="text" name="specialty" required><br>

    <label>Manufacturer Logo</label><br>
    <input type="file" name="logo" required><br>

    <button type="submit" name="add_manufacturer">Add Manufacturer</button><br>
</form>

<!-- Form to Save All Manufacturers -->
<form method="POST" action="manufacturer_form.php">
    <button type="submit" name="save_manufacturers">Save All Manufacturers</button>
</form>

<!-- Display Manufacturers Pending Save -->
<?php if (!empty($_SESSION['manufacturers'])): ?>
    <h2>Manufacturers to be Saved</h2>
    <ul>
        <?php foreach ($_SESSION['manufacturers'] as $manufacturer): ?>
            <li><?php echo htmlspecialchars($manufacturer['name']); ?> - <?php echo htmlspecialchars($manufacturer['specialty']); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
mysqli_close($conn);
?>
