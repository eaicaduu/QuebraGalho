<div class="card produto-item mb-3 bg-light shadow-sm">
    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <!-- Esquerda: status, nome e oferta -->
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2 w-100">
            
            <!-- Switch Status -->
            <div class="form-check form-switch me-2">
                <input class="form-check-input editable-status" type="checkbox" role="switch"
                    data-id="<?= $categoria['id'] ?>" <?= ($categoria['status'] == 1 ? 'checked' : '') ?>>
            </div>

            <!-- Nome editável -->
            <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold editable-nome flex-grow-1"
                value="<?= htmlspecialchars($categoria['nome']) ?>" data-id="<?= $categoria['id'] ?>"
                style="min-width: 120px;" />

            <!-- Oferta e desconto -->
            <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input editable-oferta" 
                        data-id="<?= $categoria['id'] ?>" id="ofertaCheck<?= $categoria['id'] ?>"
                        <?= ($categoria['oferta'] == 1 ? 'checked' : '') ?>>
                    <label class="form-check-label" for="ofertaCheck<?= $categoria['id'] ?>">Oferta</label>
                </div>

                <input type="number" min="0" max="100" class="form-control form-control-sm editable-desconto"
                    data-id="<?= $categoria['id'] ?>" 
                    value="<?= (!empty($categoria['desconto_percentual']) ? intval($categoria['desconto_percentual']) : '') ?>"
                    placeholder="% desconto"
                    style="width: 80px; <?= ($categoria['oferta'] == 1 ? '' : 'display:none;') ?>">
            </div>
        </div>

        <!-- Botão excluir -->
        <div class="mt-2 mt-md-0 p-0">
            <button class="btn btn-danger btn-sm btn-excluir-categoria" data-id="<?= $categoria['id'] ?>"
                data-nome="<?= htmlspecialchars($categoria['nome']) ?>">
                <i class="bi bi-trash"></i> Excluir
            </button>
        </div>
    </div>
</div>
