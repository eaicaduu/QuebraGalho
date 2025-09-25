<div class="list-group-item bg-body-secondary d-flex justify-content-between align-items-center py-3 border rounded mb-2 shadow-sm item-carrinho-md"
    data-preco-unit="<?= $item['preco_unitario'] ?>"
    data-max-qtd="<?= $item['quantidade_produto'] ?>"
    data-subtotal="<?= $subtotal ?>">
    <div class="d-flex align-items-center ps-2">

        <div class="form-check d-flex justify-content-center align-items-center me-4">
            <input type="checkbox" class="form-check-input seletor-produto-xl"
                name="produtos_selecionados[]" value="<?= $item['carrinho_id'] ?>" checked>
        </div>
        <img src="<?= htmlspecialchars($imagem) ?>" alt="Imagem"
            style="width: 50px; height: 50px; cursor: pointer; object-fit: cover;"
            class="rounded me-4" onclick="window.location.href='<?= $produtoUrl ?>'">
        <div style="min-width: 180px;">
            <h6 class="mb-1 fw-semibold text-truncate" style="cursor: pointer; max-width: 300px;"
                onclick="window.location.href='<?= $produtoUrl ?>'">
                <?= htmlspecialchars($item['nome']) ?>
            </h6>
            <small class="text-danger fw-semibold btn-remover-carrinho" style="cursor: pointer;" data-id="<?= $item['carrinho_id'] ?>">
                Excluir
            </small>
        </div>
    </div>

    <div class="d-none d-md-block">
        <div class="d-flex align-items-center justify-content-center">
            <button type="button"
                class="btn btn-sm fw-bold shadow-none border-0 btn-quantidade <?= ($item['quantidade_carrinho'] <= 1) ? 'bg-secondary text-white' : 'btn-primary' ?>"
                data-id="<?= $item['carrinho_id'] ?>"
                data-action="decrement"
                <?= ($item['quantidade_carrinho'] <= 1) ? 'disabled' : '' ?>>
                <i class="bi bi-dash-lg fs-5"></i>
            </button>

            <span class="quantidade-produto-xl px-3 fw-semibold"
                style="text-align: center;"
                id="quantidade-<?= $item['carrinho_id'] ?>">
                <?= $item['quantidade_carrinho'] ?>
            </span>

            <button type="button"
                class="btn btn-sm fw-bold shadow-none border-0 btn-quantidade <?= ($item['quantidade_carrinho'] >= $item['quantidade_produto']) ? 'bg-secondary text-white' : 'btn-primary' ?>"
                data-id="<?= $item['carrinho_id'] ?>"
                data-action="increment"
                <?= ($item['quantidade_carrinho'] >= $item['quantidade_produto']) ? 'disabled' : '' ?>>
                <i class="bi bi-plus-lg fs-5"></i>
            </button>
        </div>

        <small class="text-muted d-block mt-1">
            Mais <?= max(0, $item['quantidade_produto'] - $item['quantidade_carrinho']) ?> disponíveis
        </small>
    </div>

    <div class="text-end d-none d-md-block">
        <div class="fw-semibold fs-6 text-dark mb-2 subtotal">
            <?php
            if (!empty($item['promocao']) && $item['promocao'] == 1 && !empty($item['preco_promocional'])) {
                $precoUnit = $item['preco_promocional'];
                $subtotal = $precoUnit * $item['quantidade_carrinho'];
            ?>
                <small class="text-muted d-block" style="text-decoration: line-through;">
                    R$ <?= number_format($item['preco'], 2, ',', '.') ?>
                </small>
                <span class="text-dark">
                    R$ <?= number_format($precoUnit, 2, ',', '.') ?>
                </span>
            <?php
            } else {
                $precoUnit = $item['preco_unitario'];
                $subtotal = $precoUnit * $item['quantidade_carrinho'];
                echo "R$ " . number_format($subtotal, 2, ',', '.');
            }
            ?>
        </div>
    </div>

</div>