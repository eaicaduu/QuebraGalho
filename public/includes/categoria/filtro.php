    <div class="row mb-4 d-none d-xl-block">
        <div class="col-12">
            <div class="p-2 shadow-sm border bg-light rounded d-flex flex-wrap gap-2 align-items-center justify-content-between">

                <button class="btn btn-link text-decoration-none text-dark p-0 ms-4" onclick="history.back()">
                    <i class="bi bi-arrow-left-circle" style="font-size: 1.8rem;"></i>
                </button>

                <div class="d-flex align-items-center">
                    <label class="form-label fw-semibold mx-2 mb-0">Categoria</label>
                    <select class="form-select form-select-sm w-50" id="filtroCategoria" onchange="redirecionarCategoria(this)">
                        <option value="" <?= empty($categoria_id) ? 'selected' : '' ?>>Todas</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id'] ?>" <?= ($categoria_id == $categoria['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($categoria['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="d-flex align-items-center">
                    <label class="form-label fw-semibold me-2 mb-0">Marca</label>
                    <select class="form-select form-select-sm w-auto" id="filtroMarca" onchange="redirecionarMarca(this)">
                        <option value="">Todas</option>
                        <?php foreach ($marcas as $marca): ?>
                            <option value="<?= htmlspecialchars($marca['marca']) ?>"
                                <?= (isset($_GET['marca']) && $_GET['marca'] === $marca['marca']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($marca['marca']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-auto d-flex align-items-center">
                    <label for="filtroPreco" class="form-label fw-semibold mx-2 mb-0">Preço até:</label>
                    <input type="range" class="form-range w-100" min="0" max="5000" step="50"
                        id="filtroPreco"
                        value="<?= isset($_GET['preco_max']) ? htmlspecialchars($_GET['preco_max']) : 1000 ?>"
                        oninput="atualizarPreco(this.value)">
                    <span id="valorPreco"><?= isset($_GET['preco_max']) ? htmlspecialchars($_GET['preco_max']) : 1000 ?></span>
                </div>

                <div class="col-auto d-flex align-items-center">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="filtroPromocao"
                            <?= isset($_GET['promocao']) && $_GET['promocao'] == '1' ? 'checked' : '' ?>
                            onchange="aplicarFiltros()">
                        <label class="form-check-label mb-0" for="filtroPromocao">Promoção</label>
                    </div>
                </div>

            </div>
        </div>
    </div>