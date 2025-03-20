<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Favorite Animal</title>
</head>
<body>
    <h1>Select Your Favorite Animal</h1>
    <form action="animal_greeting.php" method="POST">
        <label for="animal">Choose an animal:</label>
        <select name="animal" id="animal">
            <option value="lion">Lion</option>
            <option value="tiger">Tiger</option>
            <option value="elephant">Elephant</option>
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
        </select>
        <br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
