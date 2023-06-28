<?php

declare(strict_types=1);

namespace App\Core;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidFileException;
use PDO;
use PDOException;

class CreateConnectionPDO
{
    public static function CreateConnection(): PDO
    {
        try {
            Dotenv::createImmutable(paths: __DIR__)->load();
            $host = $_ENV['HOST'];
            $db = $_ENV['DATABASE'];
            $user = $_ENV['USERNAME'];
            $pass = $_ENV['PASSWORD'];
            $port = $_ENV['PORT'];
            $dsn = "pgsql:host=$host;port=$port;dbname=$db;user=$user;password=$pass";
        } catch (InvalidFileException $e) {
            throw new InvalidFileException($e->getMessage(), (int)$e->getCode());
        }
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            return new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}