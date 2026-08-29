<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar usuário - JM Informática</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="caixa-login">
        <h1>Cadastrar usuário</h1>

        <?php if (!empty($erro)): ?>
            <p class="mensagem mensagem-erro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form id="form-cadastro" method="post" action="index.php?rota=auth/cadastro" novalidate>
            <label for="name">Nome</label>
            <input type="text" id="name" name="name" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Cadastrar</button>
        </form>

        <a href="index.php?rota=auth/login">Voltar ao login</a>
    </main>

    <script src="assets/js/auth.js"></script>
</body>
</html>
