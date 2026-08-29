<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Sessao;
use App\Models\ServiceModel;

class DashboardController extends Controller
{
    public function index(): void
    {
        Sessao::exigirLogin();

        $idUser = (int) $_SESSION['id_user'];
        $serviceModel = new ServiceModel();

        $this->view('dashboard/index', [
            'nomeUsuario' => $_SESSION['name'],
            'dataAtual' => date('d/m/Y'),
            'servicos' => $serviceModel->listarTodos(),
            'valorTotal' => $serviceModel->somarValorPorUsuario($idUser),
            'pendentes' => $serviceModel->listarPendentesPorUsuario($idUser),
            'mensagemSucesso' => Sessao::pegarFlash('sucesso'),
            'mensagemErro' => Sessao::pegarFlash('erro'),
        ]);
    }
}
