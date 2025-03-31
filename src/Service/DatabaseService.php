<?php

namespace App\Service;

use SQLite3;
use SQLite3Result;
use SQLite3Stmt;

class DatabaseService
{
    private static ?SQLite3 $instance = null;

    public function __construct()
    { 
        if (is_null(self::$instance)) {
            self::$instance = new SQLite3(__DIR__ . '/../../var/database.db');
            self::$instance->exec('PRAGMA foreign_keys = ON;');
        }
    }

    public function getInstance(): SQLite3
    {
        return self::$instance;
    }

    private function fetch(SQLite3Result $results, $mode = SQLITE3_ASSOC): array
    {
        $arr = [];
        while($result = $results->fetchArray($mode)) {
            $arr[] = $result;
        }
        return $arr;
    }

    private function bind(SQLite3Stmt $stmt, array $params): SQLite3Stmt
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

    public function consulta(string $sql, array $params = null): array
    {
        $stmt = self::$instance->prepare($sql);

        if(isset($params)) {
            $stmt = self::bind($stmt, $params);
        }

        return self::fetch($stmt->execute());
    }

    public function insere(string $sql, array $params)
    {
        $stmt = self::$instance->prepare($sql);
        $stmt = self::bind($stmt, $params);
        
        return $stmt->execute()->fetchArray();
    }
}