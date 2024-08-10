<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
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
        .message {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }
        .forecast {
            background-color: #e6f3ff;
            border: 1px solid #b8d6ff;
            padding: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<h1>Weather App</h1>

<?php if (!empty($message)): ?>
    <div class="message">
        <p><?= htmlspecialchars($message) ?></p>
    </div>
<?php endif; ?>

<h2>Add New Location</h2>
<form action="index.php" method="post">
    <label for="x_coord">X Coordinate:</label>
    <input type="number" step="any" id="x_coord" name="x_coord" required>

    <label for="y_coord">Y Coordinate:</label>
    <input type="number" step="any" id="y_coord" name="y_coord" required>

    <label for="location_name">Location Name:</label>
    <input type="text" id="location_name" name="location_name" required>

    <input type="hidden" name="add_location" value="<?= uniqid() ?>">
    <button type="submit">Add Location</button>
</form>

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
                <td><?= htmlspecialchars($location['name'] ?? '') ?></td>
                <td><?= number_format($location['x_coord'] ?? 0, 4, '.', '') ?></td>
                <td><?= number_format($location['y_coord'] ?? 0, 4, '.', '') ?></td>
                <td>
                    <a href="?forecast=<?= $location['id'] ?? '' ?>">Get Forecast</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No locations saved yet.</p>
<?php endif; ?>

<?php if (isset($selectedLocation) && isset($forecast)): ?>
    <div class="forecast">
        <h2>Weather Forecast for <?= htmlspecialchars($selectedLocation['name'] ?? 'Unknown Location') ?></h2>
        <?php if (!empty($forecast)): ?>
            <p><strong>Temperature:</strong> <?= htmlspecialchars($forecast['temperature'] ?? 'N/A') ?>
                <?= htmlspecialchars($forecast['temperatureUnit'] ?? '') ?>
            </p>
            <p><strong>Forecast:</strong> <?= htmlspecialchars($forecast['shortForecast'] ?? 'N/A') ?></p>
            <p><strong>Detailed Forecast:</strong> <?= htmlspecialchars($forecast['detailedForecast'] ?? 'N/A') ?></p>
        <?php else: ?>
            <p>Weather forecast is currently unavailable for this location.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

</body>
</html>