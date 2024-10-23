<?php
// Include database connection
include('db_connect.php');

// Check if the manufacturer ID is provided
if (!isset($_GET['id'])) {
    die('Manufacturer ID not provided.');
}

$manufacturer_id = $_GET['id'];

// Fetch manufacturer details
$sql = "SELECT * FROM manufacturers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $manufacturer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Manufacturer not found.');
}

$manufacturer = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];

    // Handle logo upload if provided
    $logo_path = $manufacturer['logo_path']; // Existing logo path
    if (!empty($_FILES['logo']['name'])) {
        // Upload the new logo
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
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
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

    // Update the manufacturer details in the database
    $update_sql = "UPDATE manufacturers SET name = ?, logo_path = ?, specialty = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssi", $name, $logo_path, $specialty, $manufacturer_id);
    
    if ($stmt->execute()) {
        echo "Manufacturer updated successfully!";
    } else {
        echo "Error updating manufacturer: " . $conn->error;
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
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($manufacturer['name']); ?>" required><br><br>

        <label for="specialty">Specialty:</label><br>
        <input type="text" id="specialty" name="specialty" value="<?php echo htmlspecialchars($manufacturer['specialty']); ?>"><br><br>

        <label for="logo">Logo:</label><br>
        <?php if ($manufacturer['logo_path']): ?>
            <img src="<?php echo $manufacturer['logo_path']; ?>" alt="Manufacturer Logo" width="100"><br>
        <?php endif; ?>
        <input type="file" id="logo" name="logo"><br><br>

        <input type="submit" value="Update Manufacturer">
    </form>

    <a href="manufacturer_list.php">Back to Manufacturer List</a>
</body>
</html>