<?php
// Autoload manual (sem Composer): converte o namespace App\* no caminho do arquivo em app/*
spl_autoload_register(function (string $classe): void {
    $classe = str_replace('App\\', '', $classe);
    $caminho = __DIR__ . '/../' . str_replace('\\', '/', $classe) . '.php';

    if (file_exists($caminho)) {
        require $caminho;
    }
});
