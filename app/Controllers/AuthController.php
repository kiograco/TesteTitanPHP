<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\UserModel;

class AuthController extends Controller
{
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';

            $usuario = (new UserModel())->buscarPorEmail($email);

            if (!$usuario || !password_verify($senha, $usuario['password'])) {
                $this->view('auth/login', ['erro' => 'Ops, Email ou Senha inválido']);
                return;
            }

            $_SESSION['id_user'] = $usuario['id_user'];
            $_SESSION['name'] = $usuario['name'];

            header('Location: index.php?rota=dashboard');
            exit;
        }

        $this->view('auth/login', ['cadastroOk' => isset($_GET['cadastro'])]);
    }

    public function cadastro(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';

            if ($name === '' || $email === '' || $senha === '') {
                $this->view('auth/cadastro', ['erro' => 'Preencha todos os campos.']);
                return;
            }

            $userModel = new UserModel();

            if ($userModel->buscarPorEmail($email)) {
                $this->view('auth/cadastro', ['erro' => 'Este e-mail já está cadastrado.']);
                return;
            }

            $userModel->cadastrar($name, $email, $senha);

            header('Location: index.php?rota=auth/login&cadastro=1');
            exit;
        }

        $this->view('auth/cadastro');
    }

    public function logout(): void
    {
        session_destroy();

        header('Location: index.php?rota=auth/login');
        exit;
    }
}