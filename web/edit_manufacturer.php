<?php
// Include necessary files
include 'db_connect.php';
require_once '../classes/Manufacturer.php';

// Check if the manufacturer ID is provided
if (!isset($_GET['id'])) {
    die('Manufacturer ID not provided.');
}

$manufacturer_id = (int)$_GET['id'];

// Instantiate the Manufacturer class and load details
$manufacturer = new Manufacturer($conn, $manufacturer_id);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];

    // Handle logo upload if provided
    $logo_path = $manufacturer->getLogoPath(); // Existing logo path
    if (!empty($_FILES['logo']['name'])) {
        // Set the target directory and file path
        $target_dir = "uploads/manufacturer_logos/";
        $target_file = $target_dir . basename($_FILES["logo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES["logo"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            exit();
        }

        // Allow only certain formats (jpg, png, jpeg, gif)
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            exit();
        }

        // Move the uploaded file to the server
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            $logo_path = $target_file; // Update logo path if upload is successful
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    }

    // Set updated details and save
    $manufacturer->setName($name);
    $manufacturer->setSpecialty($specialty);
    $manufacturer->setLogoPath($logo_path);

    try {
        $manufacturer->save();
        echo "Manufacturer updated successfully!";
    } catch (Exception $e) {
        echo "Error updating manufacturer: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Manufacturer</title>
</head>
<body>
    <h2>Edit Manufacturer</h2>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Manufacturer Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($manufacturer->getName()); ?>" required><br><br>

        <label for="specialty">Specialty:</label><br>
        <input type="text" id="specialty" name="specialty" value="<?php echo htmlspecialchars($manufacturer->getSpecialty()); ?>"><br><br>

        <label for="logo">Logo:</label><br>
        <?php if ($manufacturer->getLogoPath()): ?>
            <img src="<?php echo htmlspecialchars($manufacturer->getLogoPath()); ?>" alt="Manufacturer Logo" width="100"><br>
        <?php endif; ?>
        <input type="file" id="logo" name="logo"><br><br>

        <input type="submit" value="Update Manufacturer">
    </form>

    <a href="manufacturer_list.php">Back to Manufacturer List</a>
</body>
</html>