CREATE DATABASE restaurant;
USE restaurant;

CREATE TABLE dishes (
    dish_id INT PRIMARY KEY,
    dish_name VARCHAR(255),
    price DECIMAL(4,2),
    is_spicy INT
);

INSERT INTO dishes VALUES 
    (1, 'Walnut Bun', 1.00, 0),
    (2, 'Cashew Nuts and White Mushrooms', 4.95, 0),
    (3, 'Dried Mulberries', 3.00, 0),
    (4, 'Eggplant with Chili Sauce', 6.50, 1),
    (5, 'Red Bean Bun', 1.00, 0),
    (6, 'General Tso''s Chicken', 5.50, 1);





<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "restaurant";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch dishes sorted by price
$sql = "SELECT dish_id, dish_name, price, is_spicy FROM dishes ORDER BY price";
$result = $conn->query($sql);

echo "<h1>Dishes Sorted by Price</h1>";

if ($result->num_rows > 0) {
    // Output table structure
    echo "<table border='1'>
            <tr>
                <th>Dish ID</th>
                <th>Dish Name</th>
                <th>Price</th>
                <th>Is Spicy</th>
            </tr>";
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["dish_id"] . "</td>
                <td>" . $row["dish_name"] . "</td>
                <td>" . number_format($row["price"], 2) . "</td>
                <td>" . ($row["is_spicy"] ? "Yes" : "No") . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>