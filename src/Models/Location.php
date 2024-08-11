<?php
declare(strict_types=1);

namespace App\Models;

use App\Services\WeatherService;
use Exception;
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
            // Validate input
            if (strlen($name) > 255) {
                return "Error: Location name is too long (max 255 characters)";
            }

            // Check if the coordinates are within the DECIMAL(9,6) range
            if ($x_coord < -999.999999 || $x_coord > 999.999999 ||
                $y_coord < -999.999999 || $y_coord > 999.999999) {
                return "Error: Coordinates are out of range (must be between -999.999999 and 999.999999)";
            }

            // Format coordinates to 6 decimal places
            $formatted_x = number_format($x_coord, 6, '.', '');
            $formatted_y = number_format($y_coord, 6, '.', '');

            $stmt = $this->db->prepare("INSERT INTO locations (name, x_coord, y_coord) VALUES (?, ?, ?)");
            $stmt->execute([
                $name,
                $formatted_x,
                $formatted_y
            ]);
            return "Location added successfully!";
        } catch (PDOException $e) {
            // Log the full error for debugging
            error_log("Database error in add location: " . $e->getMessage());
            return "Error adding location. Please try again or contact support if the problem persists.";
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
     * Get a specific location by ID
     *
     * @param int $id Location ID
     * @return array|null Location data or null if not found
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM locations WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Get weather forecast for a location
     *
     * @param int $id Location ID
     * @return array|null Weather forecast data
     */
    public function getWeatherForecast(int $id): ?array
    {
        $location = $this->getById($id);

        if (!$location) {
            error_log("Location not found for ID: $id");
            return null;
        }

        try {
            // Get forecast from the weather service
            return $this->weatherService->getForecast((float)$location['x_coord'], (float)$location['y_coord']);
        } catch (Exception $e) {
            // Log the error and return null
            error_log("Weather forecast error for location {$location['name']}: " . $e->getMessage());
            return null;
        }
    }
}