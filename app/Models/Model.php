<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

/**
 * Abstract base model class
 *
 * This class serves as a base for all model classes in the application.
 * It provides a database connection to all derived classes.
 */
abstract class Model
{
    /**
     * @var PDO The database connection
     */
    protected PDO $db;

    /**
     * Model constructor
     *
     * @param PDO $db The database connection
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}