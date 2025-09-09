<section class="container-fluid bg-white py-4 d-flex justify-content-center align-items-center" id="produtos">
    <div class="row" style="width:100%">
        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $produto): ?>
                <?php
                $imagemSrc = (!isset($produto['imagem_principal']) || trim($produto['imagem_principal']) === '')
                    ? "images/default.png"
                    : "../app/uploads/produtos/" . $produto['imagem_principal'];
                $produtoUrl = "produto.php?id=" . $produto['id'];
                ?>
                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-4">
                    <div class="card h-100 shadow-sm border bg-light rounded-4 product-card position-relative overflow-hidden"
                        role="button" onclick="window.location.href='<?= $produtoUrl ?>';" style="transition: transform 0.2s;">

                        <div class="position-relative overflow-hidden">
                            <img src="<?= $imagemSrc ?>" class="card-img-top img-fluid zoom-img"
                                alt="<?= htmlspecialchars($produto['nome']) ?>"
                                style="object-fit: cover; height: 200px; transition: transform 0.3s;">
                            <button
                                class="btn btn-light position-absolute top-0 end-0 m-2 p-2 rounded-circle shadow-sm btn-favorito"
                                style="width: 36px; height: 36px;" data-id="<?= $produto['id'] ?>" title="Salvar nos favoritos"
                                onclick="event.stopPropagation();">
                                <i class="bi bi-heart"></i>
                            </button>

                            <?php if (!empty($produto['promocao']) && $produto['promocao'] == 1 && !empty($produto['desconto_percentual'])): ?>
                                <div class="position-absolute bottom-0 bg-danger text-white fw-bold start-0 w-100 text-center py-1">
                                    OFERTA - <?= floatval($produto['desconto_percentual']) ?>%
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column px-3 py-2">
                            <h6 class="card-title mb-1 text-truncate-2"><?= htmlspecialchars($produto['nome']) ?></h6>
                            <p class="card-text small text-muted mb-2 text-truncate-2">
                                <?= htmlspecialchars($produto['desc_curta']) ?>
                            </p>

                            <div class="text-warning mb-2" style="font-size: 0.9rem;">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi <?=
                                        ($produto['avaliacao_media'] >= $i) ? 'bi-star-fill' :
                                        ($produto['avaliacao_media'] >= $i - 0.5 ? 'bi-star-half' : 'bi-star')
                                        ?> me-1"></i>
                                <?php endfor; ?>
                                <?php if ($produto['quantidade_avaliacoes'] > 0): ?>
                                    <span class="text-muted ms-1" style="font-size: 0.8rem;">
                                        (<?= intval($produto['quantidade_avaliacoes']) ?>)
                                    </span>
                                <?php endif; ?>
                            </div>

                            <p class="text-dark fw-bold fs-4 mb-3">
                                <?php if (!empty($produto['promocao']) && $produto['promocao'] == 1 && !empty($produto['preco_promocional'])): ?>
                                    <small class="text-muted d-block fs-5" style="text-decoration: line-through;">
                                        R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                                    </small>
                                    <span class="text-danger fs-3">
                                        R$ <?= number_format($produto['preco_promocional'], 2, ',', '.') ?>
                                    </span>
                                <?php else: ?>
                                    R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Nenhum produto cadastrado.</p>
            </div>
        <?php endif; ?>
    </div>
</section>