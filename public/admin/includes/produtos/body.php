<div class="container-fluid mt-2">
    <div class="table-responsive" style="max-height: 60vh; overflow-y: auto;">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width: 100px;">Imagem</th>
                    <th>ID</th>
                    <th>Cód. Barras</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Descrição</th>
                    <th>Estoque</th>
                    <th>Fornecedor</th>
                    <th>Status</th>
                    <th style="width: 150px;">Ações</th>
                </tr>
            </thead>
            <tbody>

                <tr id="linha-nenhum-produto" style="display: none;">
                    <td colspan="10" class="text-center text-muted">Nenhum produto encontrado.</td>
                </tr>

                <?php if (!empty($produtos)): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td>
                                <?php if (!empty($produto['imagem'])): ?>
                                    <img src="../../app/models/<?= htmlspecialchars($produto['imagem']) ?>"
                                        alt="<?= htmlspecialchars($produto['nome']) ?>" class="img-thumbnail rounded"
                                        style="max-width: 80px; max-height: 80px;">
                                <?php else: ?>
                                    <span class="text-muted small fst-italic">Sem imagem</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($produto['id']) ?></td>
                            <td><?= htmlspecialchars($produto['codigo_barras']) ?></td>
                            <td><?= htmlspecialchars($produto['nome']) ?></td>
                            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            <td class="text-truncate" style="max-width: 200px;"
                                title="<?= htmlspecialchars($produto['descricao']) ?>">
                                <?= htmlspecialchars($produto['descricao']) ?>
                            </td>
                            <td><?= htmlspecialchars($produto['quantidade']) ?></td>
                            <td><?= htmlspecialchars($produto['fornecedor']) ?></td>
                            <td>
                                <?php if ($produto['status'] === 1): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-primary btn-editar-produto" data-id="<?= $produto['id'] ?>"
                                        data-nome="<?= htmlspecialchars($produto['nome'], ENT_QUOTES) ?>"
                                        data-preco="<?= $produto['preco'] ?>"
                                        data-descricao="<?= htmlspecialchars($produto['descricao'], ENT_QUOTES) ?>"
                                        data-quantidade="<?= $produto['quantidade'] ?>" data-status="<?= $produto['status'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button class="btn btn-sm btn-danger btn-excluir-produto" data-id="<?= $produto['id'] ?>"
                                        data-nome="<?= htmlspecialchars($produto['nome'], ENT_QUOTES) ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted fst-italic">Nenhum produto cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>