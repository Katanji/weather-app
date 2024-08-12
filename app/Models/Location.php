<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use PDOException;

/**
 * Location model for managing location data
 */
class Location extends Model
{
    /**
     * Location constructor
     *
     * @param PDO $db Database connection
     */
    public function __construct(PDO $db)
    {
        parent::__construct($db);
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
}