    <div class="d-flex justify-content-between align-items-center">
        <h6 class="fw-semibold mb-0">Resumo</h6>
        <div>
            <span class="text-success fw-bold">
                R$ <?= number_format($total, 2, ',', '.') ?>
            </span>
        </div>
    </div>

    <div>
        <span class="fw-semibold text-muted me-1">Total</span>
        <span class="fw-semibold small text-muted">
            <?= $totalProdutos ?> Produto<?= $totalProdutos > 1 ? 's' : '' ?>
        </span>
    </div>

    <div class="mb-3">
        <label for="cupom-xl" class="form-label mb-1">Inserir cupom de desconto</label>
        <div class="input-group">
            <input type="text" id="cupom-xl" name="cupom" class="form-control form-control-sm"
                placeholder="Ex: QuebraGalho10">
            <button class="btn btn-primary btn-sm" type="button">Aplicar</button>
        </div>
    </div>

    <button class="btn btn-success w-100 mt-auto" id="btnFinalizar-sm">
        Finalizar Compra
    </button>
    </div>