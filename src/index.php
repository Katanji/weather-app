<?php
declare(strict_types=1);

require_once 'database.php';

/**
 * Adds a new location to the database
 *
 * @param PDO $db Database connection handle
 * @param string $name Location name
 * @param float $x_coord X coordinate
 * @param float $y_coord Y coordinate
 * @return string Success or error message
 */
function addLocation(PDO $db, string $name, float $x_coord, float $y_coord): string
{
    try {
        $stmt = $db->prepare("INSERT INTO locations (name, x_coord, y_coord) VALUES (?, ?, ?)");
        $stmt->execute([$name, $x_coord, $y_coord]);
        return "Location added successfully!";
    } catch(PDOException $e) {
        return "Error adding location: " . $e->getMessage();
    }
}

$message = '';

// Get database connection
try {
    $db_handle = getDatabaseConnection();
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['location_name'];
    $x_coord = (float)$_POST['x_coord'];
    $y_coord = (float)$_POST['y_coord'];

    $message = addLocation($db_handle, $name, $x_coord, $y_coord);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
</head>
<body>
<h1>Weather App</h1>

<?php
// Display message if set
if (!empty($message)) {
    echo "<p>$message</p>";
}
?>

<h2>Add New Location</h2>
<form action="index.php" method="post">
    <label for="x_coord">X Coordinate:</label>
    <input type="number" step="any" id="x_coord" name="x_coord" required>

    <label for="y_coord">Y Coordinate:</label>
    <input type="number" step="any" id="y_coord" name="y_coord" required>

    <label for="location_name">Location Name:</label>
    <input type="text" id="location_name" name="location_name" required>

    <button type="submit">Add Location</button>
</form>

<h2>Saved Locations</h2>
<table>
    <thead>
    <tr>
        <th>Location Name</th>
        <th>X Coordinate</th>
        <th>Y Coordinate</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>

</body>
</html>