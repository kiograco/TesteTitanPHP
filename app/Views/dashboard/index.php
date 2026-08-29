<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - JM Informática</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="pagina-dashboard">
    <aside class="sidebar">
        <h2>JM Informática</h2>
        <p>Logado como: <strong><?= htmlspecialchars($nomeUsuario) ?></strong></p>
        <a href="index.php?rota=service/criar" class="botao">Cadastrar Serviço</a>
        <a href="index.php?rota=auth/logout" class="link-sair">Sair</a>
    </aside>

    <main class="conteudo">
        <header class="topo">
            <h1>Dashboard</h1>
            <span><?= $dataAtual ?></span>
        </header>

        <section class="destaques">
            <div class="cartao">
                <span>Valor total dos seus serviços</span>
                <strong>R$ <?= number_format($valorTotal, 2, ',', '.') ?></strong>
            </div>

            <div class="cartao">
                <span>Seus últimos pendentes</span>
                <?php if (empty($pendentes)): ?>
                    <p class="vazio">Nenhum serviço pendente.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($pendentes as $pendente): ?>
                            <li>
                                <?= htmlspecialchars($pendente['description']) ?>
                                — R$ <?= number_format($pendente['price'], 2, ',', '.') ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </section>

        <table class="tabela-servicos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Valor</th>
                    <th>Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($servicos as $servico): ?>
                    <tr>
                        <td><?= $servico['id_service'] ?></td>
                        <td><?= htmlspecialchars($servico['description']) ?></td>
                        <td>
                            <?php if ($servico['finished_at'] === null): ?>
                                <span class="status status-pendente">PENDENTE</span>
                            <?php else: ?>
                                <span class="status status-finalizado">FINALIZADO</span>
                            <?php endif; ?>
                        </td>
                        <td>R$ <?= number_format($servico['price'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($servico['name']) ?></td>
                        <td class="acoes">
                            <a href="index.php?rota=service/editar&id=<?= $servico['id_service'] ?>">Alterar</a>

                            <form method="post" action="index.php?rota=service/excluir" class="form-inline">
                                <input type="hidden" name="id" value="<?= $servico['id_service'] ?>">
                                <button type="submit">Excluir</button>
                            </form>

                            <?php if ($servico['finished_at'] === null): ?>
                                <form method="post" action="index.php?rota=service/finalizar" class="form-inline">
                                    <input type="hidden" name="id" value="<?= $servico['id_service'] ?>">
                                    <button type="submit">Finalizar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
