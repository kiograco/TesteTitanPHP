<?php

namespace App\Core;

use PDO;
use PDOStatement;

abstract class Model
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::conexao();
    }

    protected function executar(string $sql, array $parametros = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($parametros);

        return $stmt;
    }
}