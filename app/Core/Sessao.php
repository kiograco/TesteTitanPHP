<?php

namespace App\Core;

class Sessao
{
    public static function iniciar(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function autenticado(): bool
    {
        return isset($_SESSION['id_user']);
    }

    // Redireciona usuários não autenticados para o login.
    public static function exigirLogin(): void
    {
        if (!self::autenticado()) {
            header('Location: index.php?rota=auth/login');
            exit;
        }
    }

    public static function flash(string $chave, string $mensagem): void
    {
        $_SESSION[$chave] = $mensagem;
    }

    // Lê a mensagem e já apaga, pra não aparecer de novo num F5.
    public static function pegarFlash(string $chave): ?string
    {
        $mensagem = $_SESSION[$chave] ?? null;
        unset($_SESSION[$chave]);

        return $mensagem;
    }
}