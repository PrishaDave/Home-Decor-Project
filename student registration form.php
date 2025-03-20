CREATE DATABASE student_db;

USE student_db;

CREATE TABLE std (
    student_id INT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    department VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
);
<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "student_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = intval($_POST['student_id']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $age = intval($_POST['age']);
    $department = trim($_POST['department']);
    $email = trim($_POST['email']);

    // Validation
    if (empty($student_id) || empty($first_name) || empty($last_name) || empty($age) || empty($department) || empty($email)) {
        echo "<script>alert('All fields are required!');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!');</script>";
    } else {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO std (student_id, first_name, last_name, age, department, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississ", $student_id, $first_name, $last_name, $age, $department, $email);

        if ($stmt->execute()) {
            echo "<script>alert('Record saved successfully!');</script>";
        } else {
            echo "<script>alert('Error saving record: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
</head>
<body>
    <h2>Student Registration Form</h2>
    <form method="POST" action="student_form.php">
        Student ID: <input type="number" name="student_id" required><br><br>
        First Name: <input type="text" name="first_name" required><br><br>
        Last Name: <input type="text" name="last_name" required><br><br>
        Age: <input type="number" name="age" required><br><br>
        Department: <input type="text" name="department" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        <button type="submit">Submit</button>
    </form>

    <h3>Student Records</h3>
    <table border="1">
        <tr>
            <th>Student ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>Department</th>
            <th>Email</th>
        </tr>
        <?php
        // Display saved records
        $result = $conn->query("SELECT * FROM std");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['student_id']}</td>
                    <td>{$row['first_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['age']}</td>
                    <td>{$row['department']}</td>
                    <td>{$row['email']}</td>
                </tr>";
        }
        ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
