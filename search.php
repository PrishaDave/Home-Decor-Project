<?php
// Database connection details
$host = 'localhost';
$db_name = 'Financial_management';
$username = 'root'; // Default username for XAMPP
$password = '';     // Default password for XAMPP (usually empty)

// Create a connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to add a financial record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_record'])) {
    $client_name = htmlspecialchars($_POST['client_name']);
    $investment = htmlspecialchars($_POST['investment']);
    $income = htmlspecialchars($_POST['income']);
    $expense = htmlspecialchars($_POST['expense']);
    $date = htmlspecialchars($_POST['date']);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO financial_records (client_name, investment, income, expense, date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $client_name, $investment, $income, $expense, $date);
    $stmt->execute();
    $stmt->close();
}

// Handle search
$search_results = [];
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search_query'])) {
    $query = strtolower(htmlspecialchars($_GET['search_query']));
    $sql = "SELECT * FROM financial_records WHERE client_name LIKE ? OR date LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%$query%";
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $search_results[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Management</title>
    <style>
        /* General Styles */
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background-color: #f1f1f1; /* Light background to complement form */
        }

        /* Container Styling */
        .form-container {
            max-width: 500px;  /* Set max width */
            margin: 80px auto; /* Center the form vertically and horizontally */
            padding: 40px;
            background-color: #001f3f; /* Navy blue form background */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Deeper shadow for emphasis */
            border-radius: 12px;
            color: white; /* White text for contrast */
        }

        /* Form Heading */
        h1 {
            font-family: 'Lora', serif;
            font-size: 2rem;
            color: #ffdd57; /* Yellow for the heading */
            text-align: center;
            margin-bottom: 30px;
        }

        /* Form Fields */
        label {
            font-size: 1.1rem;
            color: #dedcdc; /* Light grey for label text */
            margin-bottom: 8px;
            display: block; /* Make labels block-level for proper spacing */
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%; /* Form fields take 100% of the container width */
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #004080; /* Dark navy border */
            border-radius: 5px;
            font-size: 1rem;
            background-color: #eaeaea; /* Light grey background for inputs */
            color: #001f3f; /* Navy text color */
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus {
            border-color: #ffdd57; /* Yellow border on focus */
            outline: none;
        }

        /* Submit Button */
        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #ffdd57; /* Yellow background for the button */
            color: #001f3f; /* Navy blue text */
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        button[type="submit"]:hover {
            background-color: #ffc107; /* Darker yellow on hover */
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }

        /* Centering Text */
        .center {
            text-align: center;
        }

    </style>
</head>
<body>

    <div class="form-container">
        <h1>Add Financial Record</h1>
        <form method="post" action="">
            <label for="client_name">Client Name:</label>
            <input type="text" id="client_name" name="client_name" required>

            <label for="investment">Investment Amount:</label>
            <input type="number" id="investment" name="investment" required>

            <label for="income">Income Amount:</label>
            <input type="number" id="income" name="income" required>

            <label for="expense">Expense Amount:</label>
            <input type="number" id="expense" name="expense" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <button type="submit" name="add_record">Add Record</button>
        </form>
    </div>

    <div class="form-container">
        <h1>Search Financial Records</h1>
        <form method="get" action="">
            <input type="text" name="search_query" placeholder="Enter client name or date..." required>
            <button type="submit">Search</button>
        </form>

        <?php if (!empty($search_results)): ?>
            <h2>Search Results:</h2>
            <table>
                <tr>
                    <th>Client Name</th>
                    <th>Investment</th>
                    <th>Income</th>
                    <th>Expense</th>
                    <th>Date</th>
                </tr>
                <?php foreach ($search_results as $result): ?>
                    <tr>
                        <td><?= $result['client_name']; ?></td>
                        <td><?= $result['investment']; ?></td>
                        <td><?= $result['income']; ?></td>
                        <td><?= $result['expense']; ?></td>
                        <td><?= $result['date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif (isset($_GET['search_query'])): ?>
            <p>No results found.</p>
        <?php endif; ?>
    </div>

    <h2 class="center">All Financial Records</h2>
    <table>
        <tr>
            <th>Client Name</th>
            <th>Investment</th>
            <th>Income</th>
            <th>Expense</th>
            <th>Date</th>
        </tr>
        <?php
        // Fetch all financial records from the database
        $result = $conn->query("SELECT * FROM financial_records");
        while ($record = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $record['client_name']; ?></td>
                <td><?= $record['investment']; ?></td>
                <td><?= $record['income']; ?></td>
                <td><?= $record['expense']; ?></td>
                <td><?= $record['date']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php $conn->close(); // Close the database connection ?>

</body>
</html>