<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Location;
use PDO;

/**
 * Location Controller
 *
 * This class handles all location-related operations and serves as an intermediary
 * between the Location model and the view.
 */
class LocationController
{
    /**
     * @var Location The Location model instance
     */
    private Location $locationModel;

    /**
     * LocationController constructor
     *
     * @param PDO $db The database connection
     */
    public function __construct(PDO $db)
    {
        $this->locationModel = new Location($db);
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
}