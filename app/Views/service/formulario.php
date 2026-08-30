<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $modo === 'editar' ? 'Editar Serviço' : 'Cadastrar Serviço' ?> - JM Informática</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="caixa-login">
        <h1><?= $modo === 'editar' ? 'Editar Serviço' : 'Cadastrar Serviço' ?></h1>

        <form id="form-servico" method="post"
              action="index.php?rota=service/<?= $modo ?><?= $modo === 'editar' ? '&id=' . $servico['id_service'] : '' ?>"
              novalidate>
            <label for="description">Descrição</label>
            <input type="text" id="description" name="description" maxlength="45" required
                   value="<?= htmlspecialchars($servico['description'] ?? '') ?>">

            <label for="price">Preço</label>
            <input type="number" id="price" name="price" step="0.01" min="0.01" required
                   value="<?= htmlspecialchars($servico['price'] ?? '') ?>">

            <button type="submit"><?= $modo === 'editar' ? 'Salvar alterações' : 'Cadastrar' ?></button>
        </form>

        <a href="index.php?rota=dashboard">Voltar ao dashboard</a>
    </main>

    <script src="assets/js/servico.js"></script>
</body>
</html>