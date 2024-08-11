<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Assets/css/styles.css">
</head>
<body>
<div class="container">
    <h1>Weather App</h1>

    <?php if (!empty($message)): ?>
        <div class="message">
            <p><?= htmlspecialchars($message) ?></p>
        </div>
    <?php endif; ?>

    <div class="search-section">
        <?php include __DIR__ . '/partials/add_location_form.php'; ?>
        <?php include __DIR__ . '/partials/saved_locations_table.php'; ?>
    </div>

    <?php if (isset($selectedLocation) && !empty($forecast)): ?>
        <div id="current-weather" class="forecast">
            <h2>Weather Forecast for <?= htmlspecialchars($selectedLocation['name'] ?? 'Unknown Location') ?></h2>
            <?php include __DIR__ . '/partials/current_weather.php'; ?>
            <?php include __DIR__ . '/partials/detailed_forecast.php'; ?>
            <?php include __DIR__ . '/partials/weekly_forecast.php'; ?>
        </div>
    <?php elseif (isset($selectedLocation)): ?>
        <div id="current-weather" class="forecast">
            <p>Weather forecast currently is unavailable for these coordinates.</p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>