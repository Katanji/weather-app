<?php
declare(strict_types=1);

/**
 * Get database connection
 *
 * This function establishes and returns a PDO connection to the database
 * using environment variables for configuration.
 *
 * @return PDO The database connection
 * @throws PDOException If connection fails
 */
function getDatabaseConnection(): PDO
{
    $db_host = getenv('DB_HOST');
    $db_name = getenv('DB_NAME');
    $db_user = getenv('DB_USER');
    $password_file_path = getenv('PASSWORD_FILE_PATH');
    $db_pass = trim(file_get_contents($password_file_path));

    $db_handle = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db_handle;
}

return getDatabaseConnection();