<div class="container-fluid mt-2">
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome da Categoria</th>
                    <th>Oferta</th>
                    <th>Produto</th>
                    <th style="width: 150px;">Ações</th>
                </tr>
            </thead>
            <tbody>

                <tr id="linha-nenhuma-categoria" style="display: none;">
                    <td colspan="5" class="text-center text-muted">Nenhuma categoria encontrada.</td>
                </tr>

                <?php if (!empty($categorias)): ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td><?= htmlspecialchars($categoria['id']) ?></td>
                            <td><?= htmlspecialchars($categoria['nome']) ?></td>
                            <td><?= htmlspecialchars($categoria['oferta'] ?? '') ?></td>
                            <td><?= htmlspecialchars($categoria['produtos_nome'] ?? 'Nenhum produto vinculado') ?></td>
                            <td class="text-center">
                                <div class="d-flex flex-wrap gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-primary btn-editar-categoria"
                                        data-id="<?= $categoria['id'] ?>"
                                        data-nome="<?= htmlspecialchars($categoria['nome'], ENT_QUOTES) ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button class="btn btn-sm btn-danger btn-excluir-categoria"
                                        data-id="<?= $categoria['id'] ?>"
                                        data-nome="<?= htmlspecialchars($categoria['nome'], ENT_QUOTES) ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhuma categoria cadastrada.</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>