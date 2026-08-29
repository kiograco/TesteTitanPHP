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

        <?php if (!empty($mensagemSucesso)): ?>
            <p class="mensagem mensagem-sucesso"><?= htmlspecialchars($mensagemSucesso) ?></p>
        <?php endif; ?>

        <?php if (!empty($mensagemErro)): ?>
            <p class="mensagem mensagem-erro"><?= htmlspecialchars($mensagemErro) ?></p>
        <?php endif; ?>

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

        <form id="form-filtros" method="get" action="index.php" class="filtros">
            <input type="hidden" name="rota" value="dashboard">

            <div>
                <label for="data_inicial">De</label>
                <input type="date" id="data_inicial" name="data_inicial" value="<?= htmlspecialchars($filtros['data_inicial']) ?>">
            </div>

            <div>
                <label for="data_final">Até</label>
                <input type="date" id="data_final" name="data_final" value="<?= htmlspecialchars($filtros['data_final']) ?>">
            </div>

            <div>
                <label for="description">Serviço</label>
                <input type="text" id="description" name="description" value="<?= htmlspecialchars($filtros['description']) ?>">
            </div>

            <div>
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="">Todos</option>
                    <option value="pendente" <?= $filtros['status'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="finalizado" <?= $filtros['status'] === 'finalizado' ? 'selected' : '' ?>>Finalizado</option>
                </select>
            </div>

            <div>
                <label for="nome_usuario">Usuário</label>
                <input type="text" id="nome_usuario" name="nome_usuario" value="<?= htmlspecialchars($filtros['nome_usuario']) ?>">
            </div>

            <button type="submit">Filtrar</button>
            <a href="index.php?rota=dashboard">Limpar</a>
        </form>

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

    <script src="assets/js/servico.js"></script>
</body>
</html>