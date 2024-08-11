<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/bootstrap.php';

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
$locations = $locationController->getAllLocations();

// Simple routing
$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'addLocation':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = $locationController->addLocation($_POST);
            // Redirect to prevent form resubmission
            header('Location: index.php');
            exit;
        }
        break;

    case 'getForecast':
        if (isset($_GET['id'])) {
            $forecastId = (int)$_GET['id'];
            $forecast = $locationController->getWeatherForecast($forecastId);
            $selectedLocation = $locationController->getLocationById($forecastId);
        }
        break;

    case 'home':
    default:
        // No action needed for home page
        break;
}

// Include the view
include 'Views/index.view.php';