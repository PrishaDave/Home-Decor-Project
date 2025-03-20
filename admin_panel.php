<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.html'); // Redirect to login page if not logged in
    exit;
}

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'your_database_name';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission to add new product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    
    // Handle image upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $image_name = $_FILES['product_image']['name'];
        $image_tmp = $_FILES['product_image']['tmp_name'];
        $image_path = 'uploads/' . $image_name;

        // Move uploaded file to the 'uploads' directory
        if (move_uploaded_file($image_tmp, $image_path)) {
            // Insert product details into the database
            $sql = "INSERT INTO products (name, description, price, image) VALUES ('$product_name', '$product_description', '$product_price', '$image_path')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Product added successfully!'); window.location.href = 'admin_panel.html';</script>";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Failed to upload image.";
        }
    }
}

// Close the connection
$conn->close();
?>
