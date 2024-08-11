<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Location;
use App\Services\WeatherService;
use PDO;

/**
 * Location Controller
 *
 * This class handles all location-related operations and serves as an intermediary
 * between the Location model and the view.
 */
class LocationController
{
    private Location $locationModel;
    private WeatherService $weatherService;

    /**
     * LocationController constructor
     *
     * @param PDO $db Database connection
     */
    public function __construct(PDO $db)
    {
        $this->weatherService = new WeatherService();
        $this->locationModel = new Location($db, $this->weatherService);
    }

    /**
     * Add a new location
     *
     * @param array $postData POST data containing location details
     * @return string Success or error message
     */
    public function addLocation(array $postData): string
    {
        $name = trim($postData['location_name'] ?? '');
        $x_coord = filter_var($postData['x_coord'] ?? '', FILTER_VALIDATE_FLOAT);
        $y_coord = filter_var($postData['y_coord'] ?? '', FILTER_VALIDATE_FLOAT);

        if (empty($name) || $x_coord === false || $y_coord === false) {
            return "Error: Invalid input. Please check your data and try again.";
        }

        return $this->locationModel->add($name, $x_coord, $y_coord);
    }

    /**
     * Get all locations
     *
     * @return array An array of all locations
     */
    public function getAllLocations(): array
    {
        return $this->locationModel->getAll();
    }

    /**
     * Get weather forecast for a location
     *
     * @param int $id Location ID
     * @return array An array containing forecast data and any error messages
     */
    public function getWeatherForecast(int $id): array
    {
        $forecast = $this->locationModel->getWeatherForecast($id);
        $error = null;

        if ($forecast === null) {
            error_log("Failed to retrieve forecast for location ID: $id");
            $error = "Unable to retrieve forecast. Please check the error logs for more details.";
        }

        return [
            'forecast' => $forecast,
            'error' => $error
        ];
    }

    /**
     * Get a specific location by ID
     *
     * @param int $id Location ID
     * @return array|null Location data
     */
    public function getLocationById(int $id): ?array
    {
        return $this->locationModel->getById($id);
    }
}