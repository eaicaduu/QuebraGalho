<div class="card produto-item mb-3 shadow-sm p-2 d-flex flex-column flex-md-row align-items-start gap-3">
  <div class="position-relative flex-shrink-0" style="width: 70px; height: 70px;">
    <img src="<?= $imagemSrc ?>" alt="Imagem do produto" class="rounded w-100 h-100" style="object-fit: cover;">
    <button 
      type="button" 
      class="btn btn-primary btn-sm rounded-pill position-absolute top-0 end-0 p-1"
      style="font-size: 0.8rem; line-height: 1;"
      data-produto-id="<?= $produto['id'] ?>" 
      title="Alterar imagem">
      <i class="bi bi-pencil"></i>
    </button>
  </div>

  <div class="flex-grow-1 d-flex flex-column gap-2">
    <input 
      type="text" 
      name="nome" 
      value="<?= htmlspecialchars($produto['nome']) ?>" 
      class="form-control form-control-sm"
      placeholder="Nome do produto"
      title="Nome do produto"
      style="max-width: 50%; min-width: 0;"
    >

    <div class="d-flex flex-wrap gap-3 text-muted small">
      <p class="mb-0" title="Código de barras">
        <?= (empty($produto['cod_barras']) || strtoupper($produto['cod_barras']) === 'SEM GTIN')
            ? 'Sem código de barras'
            : htmlspecialchars($produto['cod_barras']) ?>
      </p>
      <p class="mb-0" title="ID do produto">
        <?= !empty($produto['id'])
            ? sprintf('%05d', $produto['id'])
            : 'Sem ID.' ?>
      </p>
    </div>
  </div>

  <!-- Status e botão salvar -->
  <div class="d-flex flex-column flex-md-row align-items-center gap-2 flex-shrink-0" style="min-width: 140px;">
    <select 
      name="status" 
      class="form-select form-select-sm" 
      style="width: 110px;"
      title="Status do produto"
    >
      <option value="1" <?= $produto['status'] ? 'selected' : '' ?>>Ativo</option>
      <option value="0" <?= !$produto['status'] ? 'selected' : '' ?>>Inativo</option>
    </select>
    <button 
      type="button" 
      class="btn btn-success btn-sm d-flex align-items-center gap-1"
      data-produto-id="<?= $produto['id'] ?>"
      title="Salvar alterações"
    >
      <i class="bi bi-check-lg"></i> Salvar
    </button>
  </div>
</div>
