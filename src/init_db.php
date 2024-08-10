<?php
declare(strict_types=1);

require_once 'database.php';

/**
 * Initializes the database by creating necessary tables
 *
 * @throws PDOException If database initialization fails
 */
function initializeDatabase(): void
{
    $db_handle = getDatabaseConnection();

    // Create the 'locations' table if it doesn't exist
    $db_handle->exec("CREATE TABLE IF NOT EXISTS locations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        x_coord FLOAT NOT NULL,
        y_coord FLOAT NOT NULL
    )");

    echo "Database initialized successfully.\n";
}

try {
    initializeDatabase();
} catch (PDOException $e) {
    echo "Fatal error: Database initialization failed: " . $e->getMessage() . "\n";
    exit(1);
}