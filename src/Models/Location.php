<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use PDOException;

/**
 * Location model
 *
 * This class handles all database operations related to locations.
 */
class Location extends Model
{
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
            $stmt->execute([$name, $x_coord, $y_coord]);
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
}