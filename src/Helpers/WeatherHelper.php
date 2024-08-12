<?php

declare(strict_types=1);

namespace App\Helpers;

class WeatherHelper
{
    /**
     * Get the appropriate weather icon based on the forecast and time of day.
     *
     * @param string $forecast The weather forecast description
     * @param bool $isDaytime Whether it's daytime or not
     * @return string HTML string for the weather icon
     */
    public static function getWeatherIcon(string $forecast, bool $isDaytime): string
    {
        $forecast = strtolower($forecast);

        if (str_contains($forecast, 'clear') || str_contains($forecast, 'sunny')) {
            return $isDaytime
                ? '<i class="fas fa-sun" style="color: #f39c12;"></i>'
                : '<i class="fas fa-moon" style="color: #f39c12;"></i>';
        } elseif (str_contains($forecast, 'cloud')) {
            return $isDaytime
                ? '<i class="fas fa-cloud-sun" style="color: #f39c12;"></i>'
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
}