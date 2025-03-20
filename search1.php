<?php
// Database connection details
$host = 'localhost';
$username = 'root'; // change this to your database username
$password = ''; // change this to your database password
$dbname = 'timeless_art'; // change this to your database name

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the search term is provided
if (isset($_GET['query'])) {
    $search = $_GET['query'];

    // Prepare the SQL query to search products starting with the query
    $sql = "SELECT * FROM products WHERE name LIKE ? LIMIT 10";
    $stmt = $conn->prepare($sql);
    $searchTerm = $search . '%'; // Start with the search term
    $stmt->bind_param('s', $searchTerm);
    $stmt->execute();

    // Fetch the results
    $result = $stmt->get_result();
    $suggestions = [];

    // Collect the suggestions
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row;
    }

    // Return the suggestions as a JSON response
    echo json_encode($suggestions);
}

// Close the database connection
$conn->close();
?>
