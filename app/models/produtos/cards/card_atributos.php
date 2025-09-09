<div class="card produto-item mb-3 bg-light shadow-sm p-2">
    <!-- Nome do produto -->
    <div class="d-flex align-items-center justify-content-center flex-wrap gap-3 text-muted small mb-2">
        <p class="mb-0" title="Nome do produto"><strong><?= htmlspecialchars($produto['nome']) ?></strong></p>
    </div>

    <div class="card-body">

        <!-- Linha 1: Marca, Modelo, Tamanho, Cor -->
        <div class="row mb-3">
            <div class="col-6 col-md-3 d-flex align-items-center mb-2 mb-md-0">
                <label class="me-2 mb-0">Marca</label>
                <input type="text" name="marca" class="form-control form-control-sm w-100"
                    value="<?= htmlspecialchars($produto['marca'] ?? '') ?>">
            </div>
            <div class="col-6 col-md-3 d-flex align-items-center mb-2 mb-md-0">
                <label class="me-2 mb-0">Modelo</label>
                <input type="text" name="modelo" class="form-control form-control-sm w-100"
                    value="<?= htmlspecialchars($produto['modelo'] ?? '') ?>">
            </div>
            <div class="col-6 col-md-3 d-flex align-items-center mb-2 mb-md-0">
                <label class="me-2 mb-0">Tamanho</label>
                <input type="text" name="tamanho" class="form-control form-control-sm w-100"
                    value="<?= htmlspecialchars($produto['tamanho'] ?? '') ?>">
            </div>
            <div class="col-6 col-md-3 d-flex align-items-center mb-2 mb-md-0">
                <label class="me-2 mb-0">Cor</label>
                <input type="text" name="cor" class="form-control form-control-sm w-100"
                    value="<?= htmlspecialchars($produto['cor'] ?? '') ?>">
            </div>
        </div>

        <!-- Linha 2: Material, Voltagem, Garantia -->
        <div class="row mb-3">
            <div class="col-6 col-md-4 d-flex align-items-center mb-2 mb-md-0">
                <label class="me-2 mb-0">Material</label>
                <input type="text" name="material" class="form-control form-control-sm w-100"
                    value="<?= htmlspecialchars($produto['material'] ?? '') ?>">
            </div>
            <div class="col-6 col-md-4 d-flex align-items-center mb-2 mb-md-0">
                <label class="me-2 mb-0">Voltagem</label>
                <input type="text" name="voltagem" class="form-control form-control-sm w-100"
                    value="<?= htmlspecialchars($produto['voltagem'] ?? '') ?>">
            </div>
            <div class="col-6 col-md-4 d-flex align-items-center mb-2 mb-md-0">
                <label class="me-2 mb-0">Garantia</label>
                <input type="text" name="garantia" class="form-control form-control-sm w-100"
                    value="<?= htmlspecialchars($produto['garantia'] ?? '') ?>">
            </div>
        </div>

        <!-- Linha 3: Tags -->
        <div class="row mb-3">
            <div class="col-12 d-flex align-items-center">
                <label class="me-2 mb-0">Tags</label>
                <input type="text" name="tags" class="form-control form-control-sm w-100"
                    value="<?= htmlspecialchars($produto['tags'] ?? '') ?>" placeholder="separe por vírgulas">
            </div>
        </div>

        <!-- Linha 4: Descrição completa -->
        <div class="row mb-3">
            <div class="col-12 d-flex flex-column">
                <label for="desc_completa" class="mb-1">Descrição completa</label>
                <textarea id="desc_completa" name="desc_completa" class="form-control form-control-sm"
                    placeholder="Digite a descrição completa do produto" title="Descrição completa do produto"
                    rows="3"><?= htmlspecialchars($produto['desc_completa']) ?></textarea>
            </div>
        </div>

        <!-- Botão Salvar -->
        <button type="submit" class="btn btn-primary">Salvar Atributos</button>

    </div>
</div>
