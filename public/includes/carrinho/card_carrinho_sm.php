<div class="list-group-item bg-body-secondary d-flex align-items-center shadow-sm item-carrinho-sm mb-2"
    data-preco-unit="<?= $item['preco_unitario'] ?>"
    data-max-qtd="<?= $item['quantidade_produto'] ?>"
    data-subtotal="<?= $subtotal ?>">

    <div class="d-flex align-items-center me-2">
        <input type="checkbox" class="form-check-input seletor-produto-sm me-2"
            name="produtos_selecionados[]" value="<?= $item['carrinho_id'] ?>" checked>
        <img src="<?= htmlspecialchars($imagem) ?>" alt="Imagem"
            class="rounded" style="width: 55px; height: 55px; object-fit: cover; cursor: pointer;"
            onclick="window.location.href='<?= $produtoUrl ?>'">
    </div>

    <div class="flex-grow-1 d-flex flex-column justify-content-center ms-1">
        <h6 class="fw-semibold text-truncate-1 mb-1" style="cursor:pointer; min-width: 240px;"
            onclick="window.location.href='<?= $produtoUrl ?>'">
            <?= htmlspecialchars($item['nome']) ?>
        </h6>

        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="d-flex flex-column align-items-start">
                <div class="fw-semibold text-dark mb-1">
                    <?php
                    if (!empty($item['promocao']) && $item['promocao'] == 1 && !empty($item['preco_promocional'])) {
                        $precoUnit = $item['preco_promocional'];
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
                    ?>
                        <span>
                            R$ <?= number_format($precoUnit, 2, ',', '.') ?>
                        </span>
                    <?php
                    }
                    ?>
                </div>
                <div class="text-danger fw-semibold btn-remover-carrinho" style="cursor:pointer;"
                    data-id="<?= $item['carrinho_id'] ?>">
                    Excluir
                </div>
            </div>
            <div class="d-flex flex-column align-items-center me-3">
                <div class="d-flex justify-content-start align-items-center">
                    <button type="button"
                        class="btn btn-sm fw-bold shadow-none border-0 btn-quantidade <?= ($item['quantidade_carrinho'] <= 1) ? 'bg-secondary text-white' : 'btn-primary' ?>"
                        data-id="<?= $item['carrinho_id'] ?>" data-action="decrement"
                        <?= ($item['quantidade_carrinho'] <= 1) ? 'disabled' : '' ?>>
                        <i class="bi bi-dash-lg fs-6"></i>
                    </button>

                    <span class="quantidade-produto-sm fw-semibold my-1 mx-2"
                        id="quantidade-<?= $item['carrinho_id'] ?>">
                        <?= $item['quantidade_carrinho'] ?>
                    </span>

                    <button type="button"
                        class="btn btn-sm fw-bold shadow-none border-0 btn-quantidade <?= ($item['quantidade_carrinho'] >= $item['quantidade_produto']) ? 'bg-secondary text-white' : 'btn-primary' ?>"
                        data-id="<?= $item['carrinho_id'] ?>" data-action="increment"
                        <?= ($item['quantidade_carrinho'] >= $item['quantidade_produto']) ? 'disabled' : '' ?>>
                        <i class="bi bi-plus-lg fs-6"></i>
                    </button>
                </div>
                <small class="text-muted mt-1 text-center">
                    Mais <?= max(0, $item['quantidade_produto'] - $item['quantidade_carrinho']) ?> disponíveis
                </small>
            </div>

        </div>

    </div>
</div>