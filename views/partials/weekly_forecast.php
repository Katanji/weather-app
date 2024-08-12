<?php use App\Helpers\WeatherHelper;

if (count($forecast) > 1): ?>
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
                $precipitationColor = $precipitationValue > 0 ? '#3498db' : '#808080';
        ?>
                <div class="day-forecast">
                    <div class="day-name">
                        <?= $dayNames[$date->format('w')] ?> <?= $date->format('n/j') ?>
                    </div>
                    <div class="weather-icon">
                        <?= WeatherHelper::getWeatherIcon($dayForecast['shortForecast'], true) ?>
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
            }
        }
        ?>
    </div>
<?php endif; ?>