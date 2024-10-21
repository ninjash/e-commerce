<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch second-level categories based on main category selection
    if (isset($_POST['main_category_id'])) {
        $main_category_id = $_POST['main_category_id'];
        
        $second_category_query = "SELECT id, name FROM categories WHERE parent_id = $main_category_id";
        $second_category_result = mysqli_query($conn, $second_category_query);

        if (mysqli_num_rows($second_category_result) > 0) {
            echo '<option value="">Select Second Category</option>';
            while ($row = mysqli_fetch_assoc($second_category_result)) {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
        } else {
            echo '<option value="">No second categories found</option>';
        }
    }

    // Fetch third-level categories based on second category selection
    if (isset($_POST['second_category_id'])) {
        $second_category_id = $_POST['second_category_id'];
        
        $third_category_query = "SELECT id, name FROM categories WHERE parent_id = $second_category_id";
        $third_category_result = mysqli_query($conn, $third_category_query);

        if (mysqli_num_rows($third_category_result) > 0) {
            echo '<option value="">Select Third Category</option>';
            while ($row = mysqli_fetch_assoc($third_category_result)) {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
        } else {
            echo '<option value="">No third categories found</option>';
        }
    }
}