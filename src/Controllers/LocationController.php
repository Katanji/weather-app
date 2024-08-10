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
    /** @var Location */
    private Location $locationModel;

    /**
     * LocationController constructor
     *
     * @param PDO $db Database connection
     */
    public function __construct(PDO $db)
    {
        $weatherService = new WeatherService();
        $this->locationModel = new Location($db, $weatherService);
    }

    /**
     * Add a new location
     *
     * @param string $name The name of the location
     * @param float $x_coord The X coordinate of the location
     * @param float $y_coord The Y coordinate of the location
     * @return string Success or error message
     */
    public function addLocation(string $name, float $x_coord, float $y_coord): string
    {
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
     * @return array Weather forecast data
     */
    public function getWeatherForecast(int $id): array
    {
        return $this->locationModel->getWeatherForecast($id);
    }
}