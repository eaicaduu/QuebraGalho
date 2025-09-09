<div class="card produto-item mb-3 bg-light shadow-sm p-2" data-produto-id="<?= $produto['id'] ?>">
  <div class="d-flex flex-column gap-2">

    <div class="d-flex align-items-center gap-3">

      <div class="position-relative flex-shrink-0" style="width: 70px; height: 70px;">
        <img src="<?= $imagemSrc ?>" alt="Imagem do produto"
          class="rounded w-100 h-100 object-fit-cover produto-imagem">
        <button type="button"
          class="btn btn-light btn-sm rounded-circle shadow position-absolute top-0 end-0 p-1 alterar-imagem"
          style="font-size: 1rem; line-height: 1; background: rgba(255,255,255,0.9);" title="Alterar imagem">
          <i class="bi bi-camera-fill text-primary"></i>
        </button>
      </div>

      <div class="d-flex flex-column flex-lg-row flex-wrap small text-muted w-100 gap-2">
        <div class="d-flex justify-content-between">
          <p class="mb-0" title="Id do produto">
            Id: <?= $produto['id'] ?>
          </p>
          <p class="mb-0 ms-2" title="SKU do produto">
            SKU: <?= !empty($produto['cod_sku']) ? sprintf('%05d', $produto['cod_sku']) : 'Sem SKU' ?>
          </p>
          <div class="d-flex">
            <input class="form-check-input promocao-produto" type="checkbox" name="promocao-produto"
              id="promo-<?= $produto['id'] ?>" <?= !empty($produto['promocao']) && $produto['promocao'] == 1 ? 'checked' : '' ?>>
            <label class="form-check-label ms-1" for="promo-<?= $produto['id'] ?>">
              Promoção
            </label>
          </div>
        </div>
        <div class="d-flex justify-content-between">
          <p class="mb-0" title="GTIN do produto">
            GTIN: <?= (empty($produto['cod_barras']) || strtoupper($produto['cod_barras']) === 'SEM GTIN')
              ? 'Sem GTIN'
              : htmlspecialchars($produto['cod_barras']) ?>
          </p>
          <div class="d-flex">
            <input class="form-check-input destaque-produto" type="checkbox" name="destaque-produto"
              id="destaque-<?= $produto['id'] ?>" <?= !empty($produto['destaque']) && $produto['destaque'] == 1 ? 'checked' : '' ?>>
            <label class="form-check-label ms-1" for="destaque-<?= $produto['id'] ?>">
              Destaque
            </label>
          </div>
        </div>
        <p class="mb-0" title="Data de cadastro">
          Data de cadastro: <?= (new DateTime($produto['criado_em']))->format('d/m/Y') ?>
        </p>
      </div>
    </div>

    <div class="d-flex w-100">
      <input type="text" name="nome-produto" value="<?= htmlspecialchars($produto['nome']) ?>"
        class="form-control form-control-sm nome-produto" placeholder="Nome do produto" maxlength="100">
      <input type="text" maxlength="4" name="desconto-percentual-<?= $produto['id'] ?>"
        class="form-control ms-2 ms-lg-0 form-control-sm desconto-percentual" placeholder="%"
        style="width: 70px; display: <?= (!empty($produto['promocao']) && $produto['promocao'] == 1) ? 'block' : 'none' ?>;"
        value="<?= isset($produto['desconto_percentual']) && $produto['desconto_percentual'] !== ''
          ? rtrim(rtrim(number_format($produto['desconto_percentual'], 2, '.', ''), '0'), '.') . '%'
          : '' ?>">
    </div>

    <div class="d-flex w-100">
      <input type="text" name="desc_curta" value="<?= htmlspecialchars($produto['desc_curta']) ?>"
        class="form-control form-control-sm desc_curta" placeholder="Descrição curta" title="Descrição curta do produto"
        maxlength="100">
    </div>

    <div class="d-flex justify-content-between w-100">
      <select name="status-produto" class="form-select form-select-sm w-25 status-produto" title="Status do produto">
        <option value="1" <?= $produto['status'] ? 'selected' : '' ?>>Ativo</option>
        <option value="0" <?= !$produto['status'] ? 'selected' : '' ?>>Inativo</option>
      </select>
      <input type="text" name="preco-produto" <input type="text" name="preco-produto"
        class="form-control form-control-sm ms-2 w-25 preco-produto"
        value="R$<?= number_format((float) $produto['preco'], 2, ',', '.') ?>"
        style="<?= (!empty($produto['promocao']) && $produto['promocao'] == 1) ? 'text-decoration: line-through; color: #888;' : '' ?>"
        placeholder="Preço do produto" title="Preço do produto"
        class="form-control form-control-sm ms-2 w-25 preco-produto" placeholder="Preço do produto"
        title="Preço do produto">
      <input type="text" name="preco-promocional-<?= $produto['id'] ?>"
        class="form-control form-control-sm ms-2 w-25 preco-promocional" placeholder="Preço promocional"
        style="display: <?= (!empty($produto['promocao']) && $produto['promocao'] == 1) ? 'block' : 'none' ?>;" value="<?= !empty($produto['preco_promocional'])
                    ? 'R$' . number_format((float) $produto['preco_promocional'], 2, ',', '.')
                    : 'R$' . number_format((float) $produto['preco'], 2, ',', '.') ?>">
      <button type="button"
        class="btn btn-secondary btn-sm d-flex align-items-center ms-2 justify-content-center gap-1 salvar-produto"
        data-produto-id="<?= $produto['id'] ?>" title="Salvar alterações" disabled>
        <i class="bi bi-check-lg"></i> Salvar
      </button>
    </div>
  </div>
</div>
</div>