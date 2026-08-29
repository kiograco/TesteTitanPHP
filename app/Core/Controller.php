<?php

namespace App\Core;

abstract class Controller
{
    protected function view(string $view, array $dados = []): void
    {
        extract($dados, EXTR_SKIP);

        require __DIR__ . '/../Views/' . $view . '.php';
    }
}