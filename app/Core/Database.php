<?php

namespace App\Core;

use PDO;
// Mantém uma única conexão PDO durante a requisição.
class Database
{
    private static ?PDO $instancia = null;

    private function __construct()
    {
    }

    public static function conexao(): PDO
    {
        if (self::$instancia === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

            self::$instancia = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return self::$instancia;
    }
}
