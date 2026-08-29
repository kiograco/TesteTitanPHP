<?php

namespace App\Models;

use App\Core\Model;

class ServiceModel extends Model
{
    public function listarTodos(): array
    {
        $stmt = $this->executar(
            'SELECT s.id_service, s.description, s.price, s.finished_at, u.name
             FROM service s
             JOIN user u ON u.id_user = s.user_id
             ORDER BY s.created_at DESC'
        );

        return $stmt->fetchAll();
    }

    public function somarValorPorUsuario(int $idUser): float
    {
        $stmt = $this->executar(
            'SELECT COALESCE(SUM(price), 0) AS total FROM service WHERE user_id = ?',
            [$idUser]
        );

        return (float) $stmt->fetch()['total'];
    }

    public function listarPendentesPorUsuario(int $idUser): array
    {
        $stmt = $this->executar(
            'SELECT id_service, description, price, created_at
             FROM service
             WHERE user_id = ? AND finished_at IS NULL
             ORDER BY created_at DESC
             LIMIT 5',
            [$idUser]
        );

        return $stmt->fetchAll();
    }

    public function buscarPorId(int $id): array|false
    {
        $stmt = $this->executar('SELECT * FROM service WHERE id_service = ?', [$id]);

        return $stmt->fetch();
    }

    public function criar(string $description, float $price, int $idUser): bool
    {
        $stmt = $this->executar(
            'INSERT INTO service (description, price, created_at, updated_at, finished_at, user_id)
             VALUES (?, ?, NOW(), NOW(), NULL, ?)',
            [$description, $price, $idUser]
        );

        return $stmt->rowCount() > 0;
    }

    public function atualizar(int $id, string $description, float $price): bool
    {
        $stmt = $this->executar(
            'UPDATE service SET description = ?, price = ?, updated_at = NOW() WHERE id_service = ?',
            [$description, $price, $id]
        );

        return $stmt->rowCount() > 0;
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->executar('DELETE FROM service WHERE id_service = ?', [$id]);

        return $stmt->rowCount() > 0;
    }
}
