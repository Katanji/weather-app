<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Weather App</h1>

<!-- Display messages -->
<?php if (!empty($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<!-- Form to add new location -->
<h2>Add New Location</h2>
<form action="index.php" method="post">
    <label for="x_coord">X Coordinate:</label>
    <input type="number" step="any" id="x_coord" name="x_coord" required>

    <label for="y_coord">Y Coordinate:</label>
    <input type="number" step="any" id="y_coord" name="y_coord" required>

    <label for="location_name">Location Name:</label>
    <input type="text" id="location_name" name="location_name" required>

    <button type="submit" name="add_location">Add Location</button>
</form>

<!-- Display saved locations -->
<h2>Saved Locations</h2>
<?php if (!empty($locations)): ?>
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
                <td>
                    <a href="?forecast=<?= $location['id'] ?>">Get Forecast</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No locations saved yet.</p>
<?php endif; ?>

<!-- Display weather forecast if available -->
<?php if (isset($forecast) && !empty($forecast)): ?>
    <h2>Weather Forecast</h2>
    <p>Temperature: <?= htmlspecialchars($forecast['temperature']) ?> <?= htmlspecialchars($forecast['temperatureUnit']) ?></p>
    <p>Forecast: <?= htmlspecialchars($forecast['shortForecast']) ?></p>
    <p>Detailed Forecast: <?= htmlspecialchars($forecast['detailedForecast']) ?></p>
<?php endif; ?>

</body>
</html>