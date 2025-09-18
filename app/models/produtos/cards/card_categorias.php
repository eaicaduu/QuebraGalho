<div class="card produto-item mb-3 bg-light shadow-sm">
    <div class="card-body d-flex align-items-md-center justify-content-between">

        <div class="d-flex align-items-center">
            <div class="form-check form-switch">
                <input class="form-check-input editable-status" type="checkbox" role="switch"
                    data-id="<?= $categoria['id'] ?>" <?= ($categoria['status'] == 1 ? 'checked' : '') ?>>
            </div>

            <div class="flex-grow-1 ms-2 w-25 w-xl-50">
                <div class="position-relative w-100">
                    <input type="text"
                        class="form-control form-control-sm editable-nome pe-4"
                        value="<?= htmlspecialchars($categoria['nome']) ?>"
                        data-id="<?= $categoria['id'] ?>" />

                    <button class="position-absolute bg-transparent border-0 top-50 end-0 translate-middle-y btn-salvar-nome d-none"
                        type="button"
                        data-id="<?= $categoria['id'] ?>"
                        style="padding: 0.25rem 0.5rem; font-size: 1.2rem;">
                        <i class="bi bi-check-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="text-center fw-semibold mx-2 d-flex align-items-center">
            <div class="d-inline-block" title="Produtos na categoria <?= $categoria['nome']; ?>">
                <?= $categoria['total_produtos'] ?>
            </div>
        </div>

        <div>
            <button class="btn btn-danger btn-sm btn-excluir-categoria d-flex"
                data-id="<?= $categoria['id'] ?>"
                data-nome="<?= htmlspecialchars($categoria['nome']) ?>">
                <i class="bi bi-trash me-2"></i> Excluir
            </button>
        </div>

    </div>
</div>