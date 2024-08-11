<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Config\Database;

/**
 * Initializes the database by creating necessary tables
 *
 * @throws PDOException If database initialization fails
 */
function initializeDatabase(): void
{
    $db_handle = Database::getInstance();

    // Create the 'locations' table if it doesn't exist
    $db_handle->exec("CREATE TABLE IF NOT EXISTS locations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        x_coord DECIMAL(9,6) NOT NULL,
        y_coord DECIMAL(9,6) NOT NULL
    )");

    echo "Database initialized successfully.\n";
}

try {
    initializeDatabase();
} catch (PDOException $e) {
    echo "Fatal error: Database initialization failed: " . $e->getMessage() . "\n";
    exit(1);
}