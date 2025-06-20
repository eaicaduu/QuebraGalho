<div class="container mt-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gerenciar Produtos</h2>
        <button id="addproduct" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Adicionar Produto
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width: 100px;">Imagem</th>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Descrição</th>
                    <th>Estoque</th>
                    <th>Status</th>
                    <th style="width: 150px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                <?php foreach($products as $produto): ?>
                <tr>
                    <td>
                        <?php if (!empty($produto['imagem'])): ?>
                        <img src="<?= htmlspecialchars($produto['imagem']) ?>"
                            alt="<?= htmlspecialchars($produto['nome']) ?>" class="img-thumbnail"
                            style="max-width: 80px; max-height: 80px;">
                        <?php else: ?>
                        <span class="text-muted">Sem imagem</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($produto['id']) ?></td>
                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                    <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($produto['descricao']) ?></td>
                    <td><?= htmlspecialchars($produto['quantidade']) ?></td>
                    <td>
                        <?php if ($produto['status'] == 1): ?>
                        <span class="badge bg-success">Ativo</span>
                        <?php else: ?>
                        <span class="badge bg-secondary">Inativo</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <a href="editar_produto.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="excluir_produto.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Tem certeza que deseja excluir?');">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Nenhum produto cadastrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>