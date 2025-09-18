<div class="col-md-3">
    <div class="p-3 shadow-sm rounded border bg-white d-flex flex-column justify-content-between" style="height: 30vh;">

        <div class="d-flex justify-content-between align-items-center">
            <h6 class="fw-semibold mb-3">Resumo</h6>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-semibold text-muted me-2">Total</span>
                <span class="text-success fw-bold" id="totalFinal">
                    R$ <?= number_format($total, 2, ',', '.') ?>
                </span>
            </div>

        </div>

        <div>
            <!-- Cupom de desconto -->
            <div class="mb-3">
                <label for="cupom" class="form-label mb-1">Inserir cupom de desconto</label>
                <div class="input-group">
                    <input type="text" id="cupom" name="cupom" class="form-control form-control-sm"
                        placeholder="Ex: QuebraGalho10">
                    <button class="btn btn-primary btn-sm" type="button">Aplicar</button>
                </div>
            </div>
            <!-- Finalizar Compra -->
            <button type="submit" class="btn btn-success w-100 mt-auto" id="btnFinalizar">
                Finalizar Compra
            </button>
        </div>
    </div>
</div>