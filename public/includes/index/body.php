<section class="container py-4 d-flex justify-content-center align-items-center" id="produtos">
    <div class="row" style="width:100%">
        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $produto): ?>
                <?php
                $imagemSrc = (!isset($produto['imagem_principal']) || trim($produto['imagem_principal']) === '')
                    ? "images/default.png"
                    : "../app/" . $produto['imagem_principal'];
                $produtoUrl = "produto.php?id=" . $produto['id'];
                ?>
                <div class="col-sm-6 col-md-4 col-lg-2 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 product-card position-relative overflow-hidden"
                        role="button" onclick="window.location.href='<?= $produtoUrl ?>';" style="transition: transform 0.2s;">

                        <div class="position-relative overflow-hidden">
                            <img src="<?= $imagemSrc ?>" class="card-img-top img-fluid"
                                alt="<?= htmlspecialchars($produto['nome']) ?>"
                                style="object-fit: cover; height: 200px; transition: transform 0.3s;">
                            <button
                                class="btn btn-light position-absolute top-0 end-0 m-2 p-2 rounded-circle shadow-sm btn-favorito"
                                style="width: 36px; height: 36px;" data-id="<?= $produto['id'] ?>" title="Salvar nos favoritos"
                                onclick="event.stopPropagation();">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>

                        <div class="card-body d-flex flex-column px-3 py-2">
                            <h6 class="card-title mb-1 text-truncate-2"><?= htmlspecialchars($produto['nome']) ?></h6>
                            <p class="card-text small text-muted mb-2 text-truncate-2">
                                <?= htmlspecialchars($produto['descricao']) ?></p>

                            <div class="text-warning mb-2" style="font-size: 0.9rem;">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <i class="bi bi-star-fill me-1"></i>
                                <?php endfor; ?>
                            </div>

                            <p class="text-success fw-bold fs-6 mb-3">
                                R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Nenhum produto cadastrado ainda.</p>
            </div>
        <?php endif; ?>
    </div>
</section>