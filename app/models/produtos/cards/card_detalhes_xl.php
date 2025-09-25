<div class="card produto-item mb-3 bg-light shadow-sm p-2" data-produto-id="<?= $produto['id'] ?>">
    <div class="d-flex flex-column gap-2">

        <div class="d-flex flex-md-row align-items-md-center gap-2">
            <p class="mb-0 text-muted small" title="Nome do produto"><strong><?= htmlspecialchars($produto['nome']) ?></strong></p>
            <div style="width: 150px;">
                <select class="form-select form-select-sm"
                    id="categoria_<?= $produto['id'] ?>"
                    name="categoria_id">
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id'] ?>"
                            <?= $produto['categoria_id'] == $categoria['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categoria['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="width: 80px;">
                <input type="text"
                    class="form-control form-control-sm"
                    id="id_<?= $produto['id'] ?>"
                    name="id"
                    value="<?= htmlspecialchars($produto['id']) ?>"
                    placeholder="ID">
            </div>

            <div style="width: 120px;">
                <input type="text"
                    class="form-control form-control-sm"
                    id="cod_barras_<?= $produto['id'] ?>"
                    name="cod_barras"
                    value="<?= htmlspecialchars($produto['cod_barras'] ?? '') ?>"
                    placeholder="Cod. Barras">
            </div>

            <div style="width: 100px;">
                <input type="text"
                    class="form-control form-control-sm"
                    id="cod_ref_<?= $produto['id'] ?>"
                    name="cod_ref"
                    value="<?= htmlspecialchars($produto['cod_ref'] ?? '') ?>"
                    placeholder="Referência">
            </div>

            <div style="width: 100px;">
                <input type="text"
                    class="form-control form-control-sm"
                    id="cod_sku_<?= $produto['id'] ?>"
                    name="cod_sku"
                    value="<?= htmlspecialchars($produto['cod_sku'] ?? '') ?>"
                    placeholder="SKU">
            </div>

        </div>

        <div class="d-flex justify-content-between align-items-center flex-grow-1">
            <button type="button"
                class="btn btn-secondary btn-sm d-flex align-items-center justify-content-center salvar-produto"
                data-produto-id="<?= $produto['id'] ?>" title="Salvar alterações" disabled>
                <i class="bi bi-check-lg me-1"></i> Salvar
            </button>
        </div>
    </div>
</div>