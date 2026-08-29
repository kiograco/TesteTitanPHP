<?php

namespace App\Models;

use App\Core\Model;

class UserModel extends Model
{
    public function buscarPorEmail(string $email): array|false
    {
        $stmt = $this->executar(
            'SELECT * FROM user WHERE email = ? AND ativo = 1',
            [$email]
        );

        return $stmt->fetch();
    }

    public function buscarPorId(int $id): array|false
    {
        $stmt = $this->executar('SELECT * FROM user WHERE id_user = ?', [$id]);

        return $stmt->fetch();
    }

    public function cadastrar(string $name, string $email, string $senha): bool
    {
        $stmt = $this->executar(
            'INSERT INTO user (name, email, password, created_at, updated_at, ativo)
             VALUES (?, ?, ?, NOW(), NOW(), 1)',
            [$name, $email, password_hash($senha, PASSWORD_DEFAULT)]
        );

        return $stmt->rowCount() > 0;
    }
}
