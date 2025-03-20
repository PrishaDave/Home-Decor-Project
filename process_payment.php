<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "Dave2003";
$dbname = "payment_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect data from POST request
$payment_method = $_POST['payment-method'];
$first_name = $_POST['first-name'] ?? null;
$last_name = $_POST['last-name'] ?? null;
$card_number = $_POST['card-number'] ?? null;
$cvc = $_POST['cvc'] ?? null;
$expiration = $_POST['expiration'] ?? null;

// Insert data into the database
$sql = "INSERT INTO payment_methods (payment_method, first_name, last_name, card_number, cvc, expiration) 
        VALUES ('$payment_method', '$first_name', '$last_name', '$card_number', '$cvc', '$expiration')";

if ($conn->query($sql) === TRUE) {
    echo "Payment information saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
