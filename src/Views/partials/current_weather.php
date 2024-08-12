<?php

use App\Helpers\WeatherHelper;

?>
<div class="current-weather">
    <div class="weather-main">
        <?= WeatherHelper::getWeatherIcon($forecast[0]['shortForecast'], $forecast[0]['isDaytime']) ?>
        <h2><?= htmlspecialchars($forecast[0]['temperature']) ?>
            °<?= htmlspecialchars($forecast[0]['temperatureUnit']) ?></h2>
        <p><?= htmlspecialchars($forecast[0]['shortForecast']) ?></p>
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
    <div class="detailed-forecast">
        <p><strong>Detailed Forecast:</strong> <?= htmlspecialchars($forecast[0]['detailedForecast']) ?></p>
    </div>
</div>