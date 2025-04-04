<?php

namespace App\Service;

use PDO;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DatabaseService
{
    private static ?PDO $instance = null;

    public function __construct(ParameterBagInterface $params)
    {
        if (is_null(self::$instance)) {
            $databaseUrl = $_ENV['DATABASE_URL'] ?? getenv('DATABASE_URL');
            $dsn = $this->parseDatabaseUrl($databaseUrl);

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            self::$instance = new PDO($dsn['dsn'], $dsn['user'], $dsn['pass'], $options);
        }
    }

    public function getInstance(): PDO
    {
        return self::$instance;
    }

    private function fetch(\PDOStatement $stmt): array
    {
        return $stmt->fetchAll();
    }

    private function bind(\PDOStatement $stmt, array $params): \PDOStatement
    {
        foreach ($params as $key => $value) {
            $type = match (true) {
                is_int($value)   => PDO::PARAM_INT,
                is_bool($value)  => PDO::PARAM_BOOL,
                is_null($value)  => PDO::PARAM_NULL,
                default          => PDO::PARAM_STR,
            };
            $stmt->bindValue(is_string($key) ? $key : $key + 1, $value, $type);
        }

        return $stmt;
    }

    public function consulta(string $sql, array $params = null): array
    {
        $stmt = self::$instance->prepare($sql);

        if ($params) {
            $stmt = $this->bind($stmt, $params);
        }

        $stmt->execute();
        return $this->fetch($stmt);
    }

    public function insere(string $sql, array $params): array
    {
        $stmt = self::$instance->prepare($sql);
        $stmt = $this->bind($stmt, $params);
        $stmt->execute();

        return ['lastInsertId' => self::$instance->lastInsertId()];
    }

    private function parseDatabaseUrl(string $url): array
    {
        $components = parse_url($url);

        if (!$components) {
            throw new \InvalidArgumentException('DATABASE_URL inválida');
        }

        $scheme = $components['scheme'];
        $host = $components['host'] ?? '127.0.0.1';
        $port = $components['port'] ?? 3306;
        $user = $components['user'] ?? 'root';
        $pass = $components['pass'] ?? '';
        $dbname = ltrim($components['path'], '/');
        $query = isset($components['query']) ? '?' . $components['query'] : '';
        $charset = 'utf8mb4';

        $dsn = "$scheme:host=$host;port=$port;dbname=$dbname;charset=$charset";

        return [
            'dsn'  => $dsn,
            'user' => $user,
            'pass' => $pass,
        ];
    }
}
