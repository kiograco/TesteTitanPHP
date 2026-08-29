<?php

namespace App\Core;

class Mailer
{
    public function enviarComissao(string $emailDestino, string $descricaoServico, float $valor, float $comissao): bool
    {
        $assunto = 'Serviço finalizado - JM Informática';

        $corpo = "Serviço: {$descricaoServico}\n"
            . 'Valor: R$ ' . number_format($valor, 2, ',', '.') . "\n"
            . 'Comissão: R$ ' . number_format($comissao, 2, ',', '.') . "\n";

        $cabecalhos = 'From: ' . MAIL_FROM_NAME . ' <' . MAIL_FROM . '>';

        return mail($emailDestino, $assunto, $corpo, $cabecalhos);
    }
}