<?php

use App\Helpers\WeatherHelper;

?>
<div class="current-weather">
    <div class="weather-main">
        <?= WeatherHelper::getWeatherIcon($forecast[0]['shortForecast'], $forecast[0]['isDaytime']) ?>
        <h1><?= htmlspecialchars($forecast[0]['temperature']) ?>
            °<?= htmlspecialchars($forecast[0]['temperatureUnit']) ?></h1>
        <p><?= htmlspecialchars($forecast[0]['shortForecast']) ?></p>
        <p>Wind <?= htmlspecialchars($forecast[0]['windSpeed']) ?>
            <?php if ($forecast[0]['relativeHumidity']['value'] ?? false): ?>
            | Humidity <?= htmlspecialchars($forecast[0]['relativeHumidity']['value']) ?>%</p>
    <?php endif; ?>
    </div>

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