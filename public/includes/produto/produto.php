<div class="container py-5">
    <div class="row g-5">

        <div class="col-md-6 text-center position-relative">
            <button
                class="btn btn-light d-flex align-items-center justify-content-center position-absolute top-0 start-0 ms-4 m-2 p-2 rounded-circle shadow-sm"
                style="width: 36px; height: 36px;" onclick="history.back();" title="Voltar">
                <i class="bi bi-arrow-left"></i>
            </button>

            <button
                class="btn btn-light d-flex align-items-center justify-content-center position-absolute top-0 end-0 me-4 m-2 p-2 rounded-circle shadow-sm btn-favorito"
                style="width: 36px; height: 36px;" data-id="<?= $produtos['id'] ?>" title="Salvar nos favoritos"
                onclick="event.stopPropagation();">
                <i class="bi bi-heart"></i>
            </button>

            <img src="<?= $imagemSrc ?>" class="img-fluid rounded shadow-sm pe-none"
                alt="<?= htmlspecialchars($produtos['nome']) ?>" style="max-height: 400px;">
        </div>

        <div class="col-md-6">
            <h1 class="mb-2"><?= htmlspecialchars($produtos['nome']) ?></h1>
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-warning mb-2" style="font-size: 1.1rem;">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="bi <?=
                            ($produtos['avaliacao_media'] >= $i) ? 'bi-star-fill' :
                            ($produtos['avaliacao_media'] >= $i - 0.5 ? 'bi-star-half' : 'bi-star')
                            ?> me-1"></i>
                    <?php endfor; ?>
                    <?php if (!empty($produtos['quantidade_avaliacoes']) && $produtos['quantidade_avaliacoes'] > 0): ?>
                        <span class="text-muted ms-1" style="font-size: 0.9rem;">
                            (<?= intval($produtos['quantidade_avaliacoes']) ?> avaliações)
                        </span>
                    <?php endif; ?>
                </div>
                <div>
                    <strong>Marca:</strong> <?= htmlspecialchars($produtos['fornecedor_id']) ?>
                </div>
                <div style="color: #666;">
                    Produto: #<?= $produtos['id'] ?>
                </div>
            </div>


            <div class="mb-3">
                <?php if (!empty($produtos['promocao']) && $produtos['promocao'] == 1 && !empty($produtos['preco_promocional'])): ?>
                    <small class="text-muted d-block fs-5" style="text-decoration: line-through;">
                        R$ <?= number_format($produtos['preco'], 2, ',', '.') ?>
                    </small>
                    <h1 class="text-danger fw-bold fs-1">
                        R$ <?= number_format($produtos['preco_promocional'], 2, ',', '.') ?>
                    </h1>
                    <?php if (!empty($produtos['desconto_percentual'])): ?>
                        <span class="badge bg-danger fs-6">
                            -<?= floatval($produtos['desconto_percentual']) ?>% OFF
                        </span>
                    <?php endif; ?>
                <?php else: ?>
                    <h1 class="text-success fw-bold fs-1">
                        R$ <?= number_format($produtos['preco'], 2, ',', '.') ?>
                    </h1>
                <?php endif; ?>
            </div>

            <p><strong>Produto
                    <?= htmlspecialchars($produtos['status'] == 1 ? 'Disponível' : 'Indisponível') ?>
            </p></strong>

            <p>Quantidade:
                <span id="quantidadeTexto" <?= (int) $produtos['quantidade'] === 0 ? 'style="display: none;"' : '' ?>>
                    <strong>1 unidade</strong>
                </span>

                <button id="btnEditarQuantidade" type="button" title="Editar quantidade"
                    class="btn btn-link p-0 align-middle text-center text-dark" <?= (int) $produtos['quantidade'] === 0 ? 'style="display: none;"' : '' ?>>
                    <i class="bi bi-chevron-down"></i>
                </button>

                <select id="selectQuantidade" class="form-select form-select-sm" style="width: 70px; display:none;">
                    <?php for ($i = 1; $i <= (int) $produtos['quantidade']; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>

                <span style="color: #666; font-size: 0.9em;">
                    (<?= (int) $produtos['quantidade'] ?> disponíveis)
                </span>
            </p>



            <div class="mt-4">
                <?php if ((int) $produtos['quantidade'] === 0): ?>
                    <button class="btn btn-secondary btn-lg px-4 shadow-sm w-100" disabled>
                        Produto indisponível
                    </button>
                <?php else: ?>
                    <div class="d-grid d-md-flex gap-3">
                        <button class="btn btn-success btn-lg px-4 shadow-sm flex-fill">
                            Comprar agora
                        </button>

                        <button class="btn btn-primary btn-lg px-4 shadow-sm flex-fill btn-carrinho"
                            data-id="<?= $produtos['id'] ?>" title="Adicionar ao carrinho"
                            onclick="event.stopPropagation();">
                            Adicionar ao carrinho
                        </button>
                    </div>
                <?php endif; ?>
            </div>


        </div>
    </div>
</div>