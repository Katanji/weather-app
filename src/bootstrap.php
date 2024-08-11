<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

// Custom autoloader for App namespace
spl_autoload_register(function (string $class): void {
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

// Initialize database connection
function getDatabaseConnection(): PDO
{
    $db_host = getenv('DB_HOST');
    $db_name = getenv('DB_NAME');
    $db_user = getenv('DB_USER');
    $password_file_path = getenv('PASSWORD_FILE_PATH');
    $db_pass = trim(file_get_contents($password_file_path));

    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db;
}