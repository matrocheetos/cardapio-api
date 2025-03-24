<?php

namespace App\Service;

use SQLite3;

class DatabaseService
{
    private static ?SQLite3 $instance = null;

    public static function getInstance(): SQLite3
    { 
        if (is_null(self::$instance)) {
            $path = __DIR__ . '/../../var/database.db';
            self::$instance = new SQLite3($path);
            self::$instance->exec('PRAGMA foreign_keys = ON;');
        }
        return self::$instance;
    }
}