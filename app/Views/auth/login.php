<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - JM Informática</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="caixa-login">
        <h1>JM Informática</h1>

        <?php if (!empty($erro)): ?>
            <p class="mensagem mensagem-erro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <?php if (!empty($cadastroOk)): ?>
            <p class="mensagem mensagem-sucesso">Cadastro realizado com sucesso! Faça login.</p>
        <?php endif; ?>

        <form id="form-login" method="post" action="index.php?rota=auth/login" novalidate>
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Entrar</button>
        </form>

        <a href="index.php?rota=auth/cadastro">Cadastrar usuário</a>
    </main>

    <script src="assets/js/auth.js"></script>
</body>
</html>