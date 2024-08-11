<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .current-weather {
                grid-template-columns: 1fr;
            }

            .search-section {
                flex-direction: column;
            }

            .form-group, .saved-locations {
                width: 100%;
            }

            .weekly-items {
                flex-direction: column;
            }

            .current-weather {
                flex-direction: column;
            }

            .weather-main, .weather-info {
                padding: 10px;
            }
        }

        .current-weather {
            display: flex;
            justify-content: space-around;
            align-items: center;
            gap: 20px;
            background-color: #f9fbff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .weather-main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f0f4ff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            flex: 1;
        }

        .weather-main h1 {
            font-size: 48px;
            margin: 10px 0;
            color: #333;
        }

        .weather-main p {
            font-size: 18px;
            margin: 5px 0;
            color: #333;
        }

        .weather-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f0f4ff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            font-size: 18px;
            color: #333;
            flex: 1;
        }

        .weather-main i,
        .weather-info i {
            font-size: 48px;
            margin-bottom: 10px;
            color: #f39c12;
        }

        .forecast {
            background-color: #e6f3ff;
            border: 1px solid #b8d6ff;
            padding: 15px;
            margin-top: 20px;
            border-radius: 10px;
        }

        .weekly-items {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 0;
            margin-top: 20px;
        }

        .day-forecast {
            border-radius: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            text-align: center;
            flex: 1;
        }

        .day-forecast .weather-icon {
            font-size: 50px;
            margin: 10px 0;
            color: #f39c12; /* Consistent color for icons */
        }

        .temperature {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }

        .day-temp {
            color: red;
        }

        .night-temp {
            color: blue;
        }

        .precipitation, .wind {
            font-size: 14px;
            color: #6c757d;
            margin: 5px 0;
        }

        .day-name {
            font-weight: bold;
            margin-top: 10px;
        }

        h1, h2, h3 {
            color: #333;
        }

        .search-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            margin-right: 20px;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
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

        .saved-locations {
            flex: 2;
        }
    </style>
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
        <div class="form-group">
            <h2>Add New Location</h2>
            <form action="index.php#current-weather" method="post">
                <label for="x_coord">X Coordinate:</label>
                <input type="number" step="any" id="x_coord" name="x_coord" required>

                <label for="y_coord">Y Coordinate:</label>
                <input type="number" step="any" id="y_coord" name="y_coord" required>

                <label for="location_name">Location Name:</label>
                <input type="text" id="location_name" name="location_name" required>

                <input type="hidden" name="add_location" value="<?= uniqid() ?>">
                <button type="submit">Add Location</button>
            </form>
        </div>

        <div class="saved-locations">
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
                                <a href="?forecast=<?= $location['id'] ?? '' ?>#current-weather">Get Forecast</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No locations saved yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php if (isset($selectedLocation) && !empty($forecast)): ?>
        <div id="current-weather" class="forecast">
            <h2>Weather Forecast for <?= htmlspecialchars($selectedLocation['name'] ?? 'Unknown Location') ?></h2>
            <div class="current-weather">
                <!-- Main Weather Information -->
                <div class="weather-main">
                    <?= getWeatherIcon($forecast[0]['shortForecast'], $forecast[0]['isDaytime']) ?>
                    <h1><?= htmlspecialchars($forecast[0]['temperature']) ?>
                        °<?= htmlspecialchars($forecast[0]['temperatureUnit']) ?></h1>
                    <p><?= htmlspecialchars($forecast[0]['shortForecast']) ?></p>
                    <p>Wind <?= htmlspecialchars($forecast[0]['windSpeed']) ?>
                        <?php if ($forecast[0]['relativeHumidity']['value'] ?? false): ?>
                            | Humidity <?= htmlspecialchars($forecast[0]['relativeHumidity']['value']) ?>%</p>
                        <?php endif; ?>
                </div>

                <!-- Additional Information: Wind, Humidity -->
                <div class="weather-info">
                    <i class="fas fa-wind"></i>
                    <p>Wind</p>
                    <p><?= htmlspecialchars($forecast[0]['windSpeed']) ?></p>
                </div>
                <div class="weather-info">
                    <i class="fas fa-tint"></i>
                    <p>Precipitation</p>
                    <p><?= htmlspecialchars($forecast[0]['probabilityOfPrecipitation']['value'] ?? 0) ?>%</p>
                </div>
            </div>

            <!-- Detailed Forecast -->
            <div class="detailed-forecast">
                <p><strong>Detailed Forecast:</strong> <?= htmlspecialchars($forecast[0]['detailedForecast']) ?></p>
            </div>

            <!-- Weekly Weather Forecast -->
            <?php if (count($forecast) > 1): ?>
                <h2>Weekly Weather Forecast</h2>
                <div class="weekly-items">
                    <?php
                    $dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    $processedDays = [];
                    foreach ($forecast as $index => $dayForecast) {
                        try {
                            $date = new DateTime($dayForecast['startTime']);
                            $dateKey = $date->format('Y-m-d');

                            if (in_array($dateKey, $processedDays)) {
                                continue;
                            }

                            $processedDays[] = $dateKey;

                            $nightForecast = $forecast[$index + 1] ?? null;
                            $precipitationValue = $dayForecast['probabilityOfPrecipitation']['value'] ?? 0;
                            $precipitationColor = $precipitationValue > 0 ? 'blue' : 'gray';
                            ?>
                            <div class="day-forecast">
                                <div class="day-name">
                                    <?= $dayNames[$date->format('w')] ?> <?= $date->format('n/j') ?>
                                </div>
                                <div class="weather-icon">
                                    <?= getWeatherIcon($dayForecast['shortForecast'], true) ?>
                                </div>
                                <div class="temperature">
                                    <span class="day-temp"><?= htmlspecialchars($dayForecast['temperature']) ?>°F </span> |
                                    <span class="night-temp"><?= $nightForecast ? htmlspecialchars($nightForecast['temperature']) : '--' ?>°F</span>
                                </div>
                                <div class="precipitation">
                                    <i class="fas fa-tint" style="color: <?= $precipitationColor; ?>;"></i>
                                    <?= $precipitationValue ?>%
                                </div>
                                <div class="wind">
                                    <i class="fas fa-wind"></i>
                                    <?= htmlspecialchars($dayForecast['windSpeed']) ?>
                                </div>
                            </div>
                            <?php
                        } catch (Exception $e) {
                            // Handle or log the error
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    <?php elseif (isset($selectedLocation)): ?>
        <p>Weather forecast currently is unavailable for these coordinates.</p>
    <?php endif; ?>
</div>

<?php
function getWeatherIcon($forecast, $isDaytime): string
{
    $forecast = strtolower($forecast);

    if (str_contains($forecast, 'clear') || str_contains($forecast, 'sunny')) {
        return $isDaytime
            ? '<i class="fas fa-sun" style="color: #f1c40f;"></i>'
            : '<i class="fas fa-moon" style="color: #f39c12;"></i>';
    } elseif (str_contains($forecast, 'cloud')) {
        return $isDaytime
            ? '<i class="fas fa-cloud-sun" style="color: #f1c40f;"></i>'
            : '<i class="fas fa-cloud-moon" style="color: #34495e;"></i>';
    } elseif (str_contains($forecast, 'rain')) {
        return $isDaytime
            ? '<i class="fas fa-cloud-rain" style="color: #3498db;"></i>'
            : '<i class="fas fa-cloud-moon-rain" style="color: #2980b9;"></i>';
    } elseif (str_contains($forecast, 'snow')) {
        return '<i class="fas fa-snowflake" style="color: #2980b9;"></i>';
    } elseif (str_contains($forecast, 'thunder')) {
        return '<i class="fas fa-bolt" style="color: #f39c12;"></i>';
    } elseif (str_contains($forecast, 'fog')) {
        return '<i class="fas fa-smog" style="color: #34495e;"></i>';
    } else {
        return $isDaytime
            ? '<i class="fas fa-cloud-sun" style="color: #f39c12;"></i>'
            : '<i class="fas fa-cloud-moon" style="color: #34495e;"></i>';
    }
}

?>
</body>
</html>
