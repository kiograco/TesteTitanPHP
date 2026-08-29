<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Mailer;
use App\Core\Sessao;
use App\Models\ServiceModel;
use App\Models\UserModel;

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

    public function finalizar(): void
    {
        Sessao::exigirLogin();

        $serviceModel = new ServiceModel();
        $id = (int) ($_POST['id'] ?? 0);
        $servico = $serviceModel->buscarPorId($id);

        if (!$servico || $servico['finished_at'] !== null) {
            Sessao::flash('erro', 'Serviço não encontrado ou já finalizado.');
            header('Location: index.php?rota=dashboard');
            exit;
        }

        $comissao = self::calcularComissao((float) $servico['price']);
        $serviceModel->finalizar($id, $comissao);

        $usuario = (new UserModel())->buscarPorId((int) $servico['user_id']);

        if ($usuario) {
            $enviado = (new Mailer())->enviarComissao(
                $usuario['email'],
                $servico['description'],
                (float) $servico['price'],
                $comissao
            );

            // O serviço já está finalizado; falha no e-mail só vira log, não desfaz nada.
            if (!$enviado) {
                error_log("Falha ao enviar e-mail de comissão do serviço #{$id} para {$usuario['email']}");
            }
        }

        Sessao::flash('sucesso', 'Serviço finalizado com sucesso.');
        header('Location: index.php?rota=dashboard');
        exit;
    }

    private static function calcularComissao(float $valor): float
    {
        if ($valor > 10000) {
            return $valor * 0.20;
        }

        if ($valor > 1000) {
            return $valor * 0.10;
        }

        return $valor * 0.05;
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
