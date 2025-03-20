<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Store the selected animal in the session
    $_SESSION["animal"] = $_POST["animal"];
}

// Retrieve the selected animal from the session
$animal = $_SESSION["animal"] ?? "none";

// Generate a personalized greeting
$greeting = "";
switch ($animal) {
    case "lion":
        $greeting = "You picked a lion, the king of the jungle!";
        break;
    case "tiger":
        $greeting = "You picked a tiger, the mighty predator of the forest!";
        break;
    case "elephant":
        $greeting = "You picked an elephant, the gentle giant!";
        break;
    case "dog":
        $greeting = "You picked a dog, the loyal companion!";
        break;
    case "cat":
        $greeting = "You picked a cat, the graceful and independent friend!";
        break;
    default:
        $greeting = "You didn't pick an animal!";
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Favorite Animal</title>
</head>
<body>
    <h1>Your Favorite Animal</h1>
    <p><?php echo htmlspecialchars($greeting); ?></p>
    <a href="animal_form.php">Go Back</a>
</body>
</html>
