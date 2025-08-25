<div class="card produto-item mb-3 shadow-sm p-2" data-produto-id="<?= $produto['id'] ?>">
  <div class="d-flex flex-column gap-2">

    <!-- Bloco: imagem + infos + botão -->
    <div class="d-flex flex-md-row align-items-md-center gap-2">
      <!-- Imagem -->
      <div class="position-relative flex-shrink-0 alterar-imagem" style="width: 70px; height: 70px;">
        <img src="<?= $imagemSrc ?>" alt="Imagem do produto"
          class="rounded w-100 h-100 object-fit-cover produto-imagem">
        <button type="button" class="btn btn-light btn-sm rounded-circle shadow position-absolute top-0 end-0 p-1"
          style="font-size: 1rem; line-height: 1; background: rgba(255,255,255,0.9);" title="Alterar imagem">
          <i class="bi bi-camera-fill text-primary"></i>
        </button>
      </div>

      <!-- Código + ID no mobile -->
      <div class="d-flex flex-column text-muted small justify-content-center align-items-center w-100 d-md-none">
        <p class="mb-0" title="Código de barras">
          <?= (empty($produto['cod_barras']) || strtoupper($produto['cod_barras']) === 'SEM GTIN')
            ? 'Sem código de barras'
            : htmlspecialchars($produto['cod_barras']) ?>
        </p>
        <p class="mb-0" title="ID do produto">
          <?= !empty($produto['id']) ? sprintf('%05d', $produto['id']) : 'Sem ID.' ?>
        </p>
      </div>
      <div class="d-none w-100 d-md-flex">
        <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>"
          class="form-control form-control-sm w-75 nome-produto" placeholder="Nome do produto" title="Nome do produto">
        <select name="status" class="form-select form-select-sm ms-2 w-25 status-produto" title="Status do produto">
          <option value="1" <?= $produto['status'] ? 'selected' : '' ?>>Ativo</option>
          <option value="0" <?= !$produto['status'] ? 'selected' : '' ?>>Inativo</option>
        </select>
      </div>
      <!-- Código + ID + botão no desktop -->
    </div>
    <div class="d-flex w-100 d-md-none">
      <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>"
        class="form-control form-control-sm nome-produto" placeholder="Nome do produto">
    </div>
    <div class="d-flex justify-content-between w-100 d-md-none">
      <select name="status" class="form-select form-select-sm w-50 status-produto" title="Status do produto">
        <option value="1" <?= $produto['status'] ? 'selected' : '' ?>>Ativo</option>
        <option value="0" <?= !$produto['status'] ? 'selected' : '' ?>>Inativo</option>
      </select>
      <button type="button"
        class="btn btn-success btn-sm d-flex align-items-center justify-content-center gap-1 salvar-produto"
        data-produto-id="<?= $produto['id'] ?>" title="Salvar alterações">
        <i class="bi bi-check-lg"></i> Salvar
      </button>
    </div>
    <div class="d-none d-md-flex justify-content-between align-items-center flex-grow-1">
      <div class="d-flex gap-3 text-muted small">
        <p class="mb-0" title="Código de barras">
          <?= (empty($produto['cod_barras']) || strtoupper($produto['cod_barras']) === 'SEM GTIN')
            ? 'Sem código de barras'
            : htmlspecialchars($produto['cod_barras']) ?>
        </p>
        <p class="mb-0" title="ID do produto">
          <?= !empty($produto['id']) ? sprintf('%05d', $produto['id']) : 'Sem ID.' ?>
        </p>
      </div>
      <button type="button"
        class="btn btn-success btn-sm d-flex align-items-center justify-content-center gap-1 salvar-produto"
        data-produto-id="<?= $produto['id'] ?>" title="Salvar alterações">
        <i class="bi bi-check-lg"></i> Salvar
      </button>
    </div>

  </div>
</div>