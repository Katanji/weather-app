<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once 'database.php';

// Custom autoloader for App namespace
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Controllers\LocationController;

/**
 * Main entry point of the application
 *
 * This script handles the routing and view rendering for the Weather App.
 */

// @todo remove before push to github
// Error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize database connection
try {
    $db = getDatabaseConnection();
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Initialize LocationController
$locationController = new LocationController($db);

$message = '';
$forecast = null;
$selectedLocation = null;

// Handle form submission for adding a new location
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_location'])) {
    if (!isset($_SESSION['last_location_request']) || $_SESSION['last_location_request'] !== $_POST['add_location']) {
        $name = $_POST['location_name'] ?? '';
        $x_coord = isset($_POST['x_coord']) ? (float)$_POST['x_coord'] : 0;
        $y_coord = isset($_POST['y_coord']) ? (float)$_POST['y_coord'] : 0;

        if ($name && $x_coord && $y_coord) {
            $message = $locationController->addLocation($name, $x_coord, $y_coord);
            $_SESSION['last_location_request'] = $_POST['add_location'];
        } else {
            $message = "Please fill all fields.";
        }
    }
}

// Handle weather forecast request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['forecast'])) {
    $locationId = (int)$_GET['forecast'];
    $selectedLocation = $locationController->getLocationById($locationId);
    if ($selectedLocation) {
        $forecast = $locationController->getWeatherForecast($locationId);
    } else {
        $message = "Location not found.";
    }
}

// Get all locations
$locations = $locationController->getAllLocations();

// Include the view
include 'Views/index.view.php';