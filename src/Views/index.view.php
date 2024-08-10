<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
</head>
<body>
<h1>Weather App</h1>

<?php if (!empty($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

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
    <?php foreach ($locations as $location): ?>
        <tr>
            <td><?= htmlspecialchars($location['name']) ?></td>
            <td><?= htmlspecialchars($location['x_coord']) ?></td>
            <td><?= htmlspecialchars($location['y_coord']) ?></td>
            <td><!-- Action buttons can be added here --></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>