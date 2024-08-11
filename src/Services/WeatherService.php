<?php
declare(strict_types=1);

namespace App\Services;

use Exception;

/**
 * Service for interacting with the National Weather Service API
 */
class WeatherService
{
    /** @var string Base URL for the NWS API */
    private string $baseUrl = 'https://api.weather.gov';

    /** @var HttpClient */
    private HttpClient $httpClient;

    /**
     * WeatherService constructor
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient();
    }

    /**
     * Get weather forecast for a specific location
     *
     * @param float $x X coordinate (longitude)
     * @param float $y Y coordinate (latitude)
     * @return array|null Forecast data
     */
    public function getForecast(float $x, float $y): ?array
    {
        // Ensure coordinates are floats and rounded to 4 decimal places (api requires a maximum of 4 digits after the dot)
        $x = round($x, 4);
        $y = round($y, 4);

        try {
            $pointsUrl = "{$this->baseUrl}/points/{$y},{$x}";
            error_log("Requesting points data from: $pointsUrl");
            $pointsData = $this->httpClient->makeRequest($pointsUrl);

            if (!isset($pointsData['properties']['forecast'])) {
                error_log("Forecast URL not found in API response for coordinates: $x, $y");
                error_log("Points API response: " . json_encode($pointsData));
                return null;
            }

            $forecastUrl = $pointsData['properties']['forecast'];
            error_log("Requesting forecast data from: $forecastUrl");
            $forecastData = $this->httpClient->makeRequest($forecastUrl);

            if (!isset($forecastData['properties']['periods'])) {
                error_log("Periods data not found in forecast response");
                error_log("Forecast API response: " . json_encode($forecastData));
                return null;
            }

            return $forecastData['properties']['periods'];
        } catch (Exception $e) {
            error_log("Error in WeatherService: " . $e->getMessage());
            return null;
        }
    }
}