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

    public static function fetch(\SQLite3Result $results, $mode = SQLITE3_ASSOC) : array
    {
        $arr = [];
        while($result = $results->fetchArray($mode)) {
            $arr[] = $result;
        }
        return $arr;
    }

    public static function bind(\SQLite3Stmt $stmt, array $params): \SQLite3Stmt
    {
        foreach ($params as $key => $value) {
            if (is_int($value)) {
                $stmt->bindValue($key, $value, SQLITE3_INTEGER);
            } elseif (is_float($value)) {
                $stmt->bindValue($key, $value, SQLITE3_FLOAT);
            } else {
                $stmt->bindValue($key, $value, SQLITE3_TEXT);
            }
        }
        return $stmt;
    }
}