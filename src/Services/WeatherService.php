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
     * @return array|null Forecast data
     * @throws Exception If API request fails
     */
    public function getForecast(float $x, float $y): ?array
    {
        try {
            $pointsUrl = "{$this->baseUrl}/points/{$y},{$x}";
            $pointsData = $this->makeRequest($pointsUrl);

            if (!isset($pointsData['properties']['forecast'])) {
                error_log("Forecast URL not found in API response for coordinates: $x, $y");
                return null;
            }

            $forecastUrl = $pointsData['properties']['forecast'];
            $forecastData = $this->makeRequest($forecastUrl);

            return $forecastData['properties']['periods'][0] ?? null;
        } catch (Exception $e) {
            error_log("Error in WeatherService: " . $e->getMessage());
            return null;
        }
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
            'User-Agent: WeatherApp/1.0 (po6uh86@email.com)'
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