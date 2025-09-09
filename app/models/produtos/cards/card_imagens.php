<div class="card produto-item mb-3 bg-light shadow-sm p-2" data-produto-id="<?= $produto['id'] ?>">

    <div class="d-flex align-items-center justify-content-center flex-wrap gap-3 text-muted small mb-2">
        <p class="mb-0" title="Nome do produto"><strong><?= htmlspecialchars($produto['nome']) ?></strong></p>
        <p class="mb-0" title="Id do produto">Id: <?= $produto['id'] ?></p>
        <p class="mb-0" title="GTIN do produto">
            GTIN: <?= (empty($produto['cod_barras']) || strtoupper($produto['cod_barras']) === 'SEM GTIN')
                ? 'Sem GTIN'
                : htmlspecialchars($produto['cod_barras']) ?>
        </p>
        <p class="mb-0" title="SKU do produto">
            SKU: <?= !empty($produto['cod_sku']) ? sprintf('%05d', $produto['cod_sku']) : 'Sem SKU' ?>
        </p>
    </div>

    <!-- Mídias secundárias e principal -->
    <div class="d-flex flex-wrap justify-content-center gap-2 midias-secundarias"
        id="midias-produto-<?= $produto['id'] ?>">

        <!-- Imagem principal -->
        <div class="flex-shrink-0" style="width: 120px; height: 120px;">
            <img src="<?= htmlspecialchars($imagemSrc) ?>" class="w-100 h-100 object-fit-cover rounded"
                alt="Imagem principal">
        </div>

        <!-- Mídias secundárias -->
        <?php if (!empty($produto['midias'])): ?>
            <?php foreach ($produto['midias'] as $midia): ?>
                <div class="position-relative flex-shrink-0 midia-hover" data-id="<?= $midia['id'] ?>" style="width: 120px; cursor: grab; height: 120px;">
                    <?php if ($midia['tipo'] === 'video'): ?>
                        <video src="../../../app/uploads/videos/<?= htmlspecialchars($midia['url']) ?>"
                            class="w-100 h-100 object-fit-cover rounded" controls></video>
                    <?php else: ?>
                        <img src="../../../app/uploads/imagens/<?= htmlspecialchars($midia['url']) ?>"
                            class="w-100 h-100 object-fit-cover rounded">
                    <?php endif; ?>
                    <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 btn-remover-midia"
                        data-id="<?= $midia['id'] ?>" data-produto="<?= $produto['id'] ?>" title="Remover">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Input para adicionar nova mídia -->
        <?php if (count($produto['midias']) < 5): ?>
            <div class="position-relative flex-shrink-0" style="width: 120px; height: 120px;">
                <label
                    class="d-flex flex-column align-items-center justify-content-center border border-dashed rounded w-100 h-100 m-0"
                    style="cursor:pointer;">
                    <i class="bi bi-plus-lg fs-3 mb-1"></i>
                    <span class="small text-muted">Adicionar</span>
                    <input type="file" accept="image/*,video/*" multiple class="d-none upload-midia"
                        data-produto="<?= $produto['id'] ?>">
                </label>
            </div>
        <?php endif; ?>
    </div>

</div>