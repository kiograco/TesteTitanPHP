<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Sessao;
use App\Models\ServiceModel;

class ServiceController extends Controller
{
    public function criar(): void
    {
        Sessao::exigirLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$description, $price, $erro] = $this->validar($_POST);

            if ($erro !== null) {
                Sessao::flash('erro', $erro);
                header('Location: index.php?rota=dashboard');
                exit;
            }

            $idUser = (int) $_SESSION['id_user'];
            (new ServiceModel())->criar($description, $price, $idUser);

            Sessao::flash('sucesso', 'Serviço cadastrado com sucesso.');
            header('Location: index.php?rota=dashboard');
            exit;
        }

        $this->view('service/formulario', ['modo' => 'criar']);
    }

    public function editar(): void
    {
        Sessao::exigirLogin();

        $serviceModel = new ServiceModel();
        $id = (int) ($_GET['id'] ?? 0);
        $servico = $serviceModel->buscarPorId($id);

        if (!$servico) {
            Sessao::flash('erro', 'Serviço não encontrado.');
            header('Location: index.php?rota=dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$description, $price, $erro] = $this->validar($_POST);

            if ($erro !== null) {
                Sessao::flash('erro', $erro);
                header('Location: index.php?rota=dashboard');
                exit;
            }

            $serviceModel->atualizar($id, $description, $price);

            Sessao::flash('sucesso', 'Serviço atualizado com sucesso.');
            header('Location: index.php?rota=dashboard');
            exit;
        }

        $this->view('service/formulario', ['modo' => 'editar', 'servico' => $servico]);
    }

    public function excluir(): void
    {
        Sessao::exigirLogin();

        $id = (int) ($_POST['id'] ?? 0);
        (new ServiceModel())->excluir($id);

        Sessao::flash('sucesso', 'Serviço excluído com sucesso.');
        header('Location: index.php?rota=dashboard');
        exit;
    }

    // Validação dos dados recebidos.
    private function validar(array $dados): array
    {
        $description = trim($dados['description'] ?? '');
        $price = $dados['price'] ?? '';

        if ($description === '' || mb_strlen($description) > 45) {
            return [$description, 0.0, 'Preencha a descrição (até 45 caracteres).'];
        }

        if (!is_numeric($price) || (float) $price <= 0) {
            return [$description, 0.0, 'Informe um valor válido.'];
        }

        return [$description, (float) $price, null];
    }
}
