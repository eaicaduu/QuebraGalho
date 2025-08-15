<div class='card produto-item mb-3 shadow-sm p-2 d-flex flex-row align-items-center gap-3'>
    <a href="<?= $produtoUrl ?>" class='d-flex align-items-center text-decoration-none text-dark flex-grow-1'>
        <img src="<?= $imagemSrc ?>" class='rounded me-2' style='width: 60px; height: 60px; object-fit: cover;'>
        <div>
            <h5 class='mb-1'><?= htmlspecialchars($produto['nome']) ?></h5>
            <div class="d-flex align-items-center gap-2">
                <p class='mb-0'>
                    <?= $produto['status']
                        ? '<span class="badge bg-success">Ativo</span>'
                        : '<span class="badge bg-secondary">Inativo</span>' ?>
                </p>
                <p class="mb-0">
                    <?= (empty($produto['cod_barras']) || strtoupper($produto['cod_barras']) === 'SEM GTIN')
                        ? 'Sem código de barras'
                        : htmlspecialchars($produto['cod_barras']) ?>
                </p>
                <p class="mb-0">
                    <?= !empty($produto['id'])
                        ? sprintf('%05d', $produto['id'])
                        : 'Sem ID.' ?>
                </p>
            </div>

        </div>
    </a>

    <div class='d-flex gap-1 me-2'>
        <button class='btn btn-sm btn-danger btn-excluir-produto' type='button' data-id='<?= $produto['id'] ?>'
            data-nome='<?= htmlspecialchars($produto['nome']) ?>'>
            <i class='bi bi-trash me-2'></i>Excluir
        </button>
    </div>
</div>