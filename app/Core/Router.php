<?php

namespace App\Core;

// Roteador simples baseado no parâmetro GET "rota" (formato controlador/acao).
// Evita depender de mod_rewrite/.htaccess, então funciona em qualquer servidor sem configuração extra.
class Router
{
    private const ROTA_PADRAO = 'auth/login';

    public static function despachar(): void
    {
        $rota = $_GET['rota'] ?? self::ROTA_PADRAO;
        [$controlador, $acao] = array_pad(explode('/', $rota, 2), 2, 'index');

        $classe = 'App\\Controllers\\' . ucfirst($controlador) . 'Controller';

        if (!class_exists($classe) || !method_exists($classe, $acao)) {
            http_response_code(404);
            echo 'Página não encontrada.';
            return;
        }

        (new $classe())->$acao();
    }
}
