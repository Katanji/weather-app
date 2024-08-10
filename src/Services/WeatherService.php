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

    /**
     * Get weather forecast for a specific location
     *
     * @param float $x X coordinate (longitude)
     * @param float $y Y coordinate (latitude)
     * @return array Forecast data
     * @throws Exception If API request fails
     */
    public function getForecast(float $x, float $y): array
    {
        // First, get the forecast URL for the given coordinates
        $pointsUrl = "{$this->baseUrl}/points/{$y},{$x}";
        $pointsData = $this->makeRequest($pointsUrl);

        if (!isset($pointsData['properties']['forecast'])) {
            throw new Exception("Forecast URL not found in API response");
        }

        // Then, get the actual forecast data
        $forecastUrl = $pointsData['properties']['forecast'];
        $forecastData = $this->makeRequest($forecastUrl);

        // Return the first period of the forecast (current conditions)
        return $forecastData['properties']['periods'][0] ?? [];
    }

    /**
     * Make a GET request to the API
     *
     * @param string $url API endpoint URL
     * @return array Response data
     * @throws Exception If request fails
     */
    private function makeRequest(string $url): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: WeatherApp/1.0 (your@email.com)'
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception("cURL Error: $error");
        }

        $data = json_decode($response, true);
        if (!$data) {
            throw new Exception("Failed to decode JSON response");
        }

        return $data;
    }
}