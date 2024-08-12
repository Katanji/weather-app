<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../bootstrap.php';


use App\Controllers\LocationController;
use Config\Database;

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
    $db = Database::getInstance();
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
            if (str_starts_with($message, 'Error')) {
                // If there's an error, don't redirect
                break;
            }
            // Redirect to prevent form resubmission on success
            header('Location: index.php?message=' . urlencode($message));
            exit;
        }
        break;

    case 'getForecast':
        if (isset($_GET['id'])) {
            $forecastId = (int)$_GET['id'];
            $result = $locationController->getWeatherForecast($forecastId);
            $forecast = $result['forecast'];
            $selectedLocation = $locationController->getLocationById($forecastId);
            if ($result['error']) {
                $message = $result['error'];
            }
        }
        break;

    case 'home':
    default:
        // Check for message from redirect
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
        }
        break;
}

// Include the view
include __DIR__ . '/../src/Views/index.view.php';
