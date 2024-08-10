<?php
declare(strict_types=1);

/******* Instructions *****/
// This script provides a function to get a PDO connection to the MariaDB database.
// Use `require_once 'database.php';` in other PHP scripts and call getDatabaseConnection()
// to get a database connection.

/**
 * Establishes and returns a database connection
 *
 * @return PDO Database connection handle
 * @throws PDOException If connection fails
 */
function getDatabaseConnection(): PDO
{
    // Read database connection parameters from environment variables
    $db_host = getenv('DB_HOST');
    $db_name = getenv('DB_NAME');
    $db_user = getenv('DB_USER');

    // Read the password file path from an environment variable
    $password_file_path = getenv('PASSWORD_FILE_PATH');

    // Read the password from the file
    $db_pass = trim(file_get_contents($password_file_path));

    // Create a new PDO instance
    $db_handle = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    // Set the PDO error mode to exception
    $db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db_handle;
}