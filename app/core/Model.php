<?php

namespace Core;

use Config\Database;
use PDO;

class Model
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }
}
