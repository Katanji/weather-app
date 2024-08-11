<?php
declare(strict_types=1);

namespace Config;

use PDO;
use PDOException;

/**
 * Database configuration and connection handling
 */
class Database
{
    private static ?PDO $instance = null;

    /**
     * Private constructor to prevent direct creation of object
     */
    private function __construct() {}

    /**
     * Get database connection instance
     *
     * This method establishes a PDO connection to the database if it doesn't exist,
     * or returns the existing connection. It uses environment variables for configuration.
     *
     * @return PDO The database connection
     * @throws PDOException If connection fails
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $db_host = getenv('DB_HOST');
            $db_name = getenv('DB_NAME');
            $db_user = getenv('DB_USER');
            $password_file_path = getenv('PASSWORD_FILE_PATH');
            $db_pass = trim(file_get_contents($password_file_path));

            self::$instance = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }

    /**
     * Prevent cloning of the instance
     */
    private function __clone() {}

    /**
     * Prevent unserializing of the instance
     */
    public function __wakeup() {}
}