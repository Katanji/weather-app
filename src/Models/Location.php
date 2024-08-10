<?php
declare(strict_types=1);

namespace App\Models;

use App\Services\WeatherService;
use PDO;
use PDOException;

/**
 * Location model for managing location data and weather forecasts
 */
class Location extends Model
{
    private WeatherService $weatherService;

    /**
     * Location constructor
     *
     * @param PDO $db Database connection
     * @param WeatherService $weatherService Weather service for forecasts
     */
    public function __construct(PDO $db, WeatherService $weatherService)
    {
        parent::__construct($db);
        $this->weatherService = $weatherService;
    }

    /**
     * Add a new location to the database
     *
     * @param string $name The name of the location
     * @param float $x_coord The X coordinate of the location
     * @param float $y_coord The Y coordinate of the location
     * @return string Success or error message
     */
    public function add(string $name, float $x_coord, float $y_coord): string
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO locations (name, x_coord, y_coord) VALUES (?, ?, ?)");
            $stmt->execute([
                $name,
                number_format($x_coord, 4, '.', ''),
                number_format($y_coord, 4, '.', '')
            ]);
            return "Location added successfully!";
        } catch(PDOException $e) {
            return "Error adding location: " . $e->getMessage();
        }
    }

    /**
     * Get all locations from the database
     *
     * @return array An array of all locations
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM locations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get weather forecast for a location
     *
     * @param int $id Location ID
     * @return array|null Weather forecast data
     */
    public function getWeatherForecast(int $id): ?array
    {
        // Fetch location coordinates from the database
        $stmt = $this->db->prepare("SELECT x_coord, y_coord FROM locations WHERE id = ?");
        $stmt->execute([$id]);
        $location = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$location) {
            return [];
        }

        try {
            // Get forecast from the weather service
            return $this->weatherService->getForecast($location['x_coord'], $location['y_coord']);
        } catch (\Exception $e) {
            // Log the error and return an empty array
            error_log("Weather forecast error: " . $e->getMessage());
            return [];
        }
    }
}