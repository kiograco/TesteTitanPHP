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

        $filtros = [
            'data_inicial' => $_GET['data_inicial'] ?? '',
            'data_final' => $_GET['data_final'] ?? '',
            'description' => trim($_GET['description'] ?? ''),
            'status' => $_GET['status'] ?? '',
            'nome_usuario' => trim($_GET['nome_usuario'] ?? ''),
        ];

        $this->view('dashboard/index', [
            'nomeUsuario' => $_SESSION['name'],
            'dataAtual' => date('d/m/Y'),
            'servicos' => $serviceModel->listar($filtros),
            'valorTotal' => $serviceModel->somarValorPorUsuario($idUser),
            'pendentes' => $serviceModel->listarPendentesPorUsuario($idUser),
            'mensagemSucesso' => Sessao::pegarFlash('sucesso'),
            'mensagemErro' => Sessao::pegarFlash('erro'),
            'filtros' => $filtros,
        ]);
    }
}