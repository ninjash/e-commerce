<?php
session_start();
require 'db_connect.php';

$target_dir = "/e-commerce/assets/brands/";

// Initialize manufacturers in session if not set
if (!isset($_SESSION['manufacturers'])) {
    $_SESSION['manufacturers'] = [];
}

// Handle form submission for adding a manufacturer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_manufacturer'])) {
    $manufacturer_name = $_POST['manufacturer_name'];
    $specialty = $_POST['specialty'];

    // Handle logo file upload
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_manufacturers'])) {
    foreach ($_SESSION['manufacturers'] as $manufacturer) {
        $name = $manufacturer['name'];
        $specialty = $manufacturer['specialty'];
        $logo_path = $manufacturer['logo_path'];

        // Insert manufacturer into manufacturers table
        $query = "INSERT INTO manufacturers (name, specialty, logo_path) 
                  VALUES ('$name', '$specialty', '$logo_path')";
        if (!mysqli_query($conn, $query)) {
            echo "Error: " . mysqli_error($conn);
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
            <li><?php echo $manufacturer['name']; ?> - <?php echo $manufacturer['specialty']; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
mysqli_close($conn);
?>
