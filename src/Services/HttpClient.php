<?php
declare(strict_types=1);

namespace App\Services;

use Exception;

/**
 * HttpClient class for making API requests
 */
class HttpClient
{
    /**
     * Make a GET request to the API
     *
     * @param string $url API endpoint URL
     * @return array Response data
     * @throws Exception If request fails
     */
    public function makeRequest(string $url): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: WeatherApp/1.0 (po6uh86@email.com)'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception("cURL Error: $error");
        }

        if ($httpCode !== 200) {
            throw new Exception("API request failed with HTTP code $httpCode. Response: $response");
        }

        $data = json_decode($response, true);
        if (!$data) {
            throw new Exception("Failed to decode JSON response: $response");
        }

        return $data;
    }
}