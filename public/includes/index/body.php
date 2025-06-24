<section class="container py-3" id="produtos">
    <div class="row">
        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $produto): ?>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card product-card h-100 shadow-sm border-0">
                        <div class="position-relative">
                            <img src="../app/models/<?= htmlspecialchars($produto['imagem']) ?>" class="card-img-top"
                                alt="<?= htmlspecialchars($produto['nome']) ?>" style="object-fit: cover; height: 180px;">

                            <button
                                class="btn btn-light position-absolute top-0 end-0 m-2 p-2 rounded-circle shadow-sm btn-favorito"
                                style="width: 36px; height: 36px;" data-id="<?= $produto['id'] ?>" title="Salvar nos favoritos">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>

                        <div class="card-body d-flex flex-column px-3 py-2">
                            <h6 class="card-title mb-1 text-truncate"><?= htmlspecialchars($produto['nome']) ?></h6>
                            <p class="card-text small text-muted mb-2 text-truncate">
                                <?= htmlspecialchars($produto['descricao']) ?>
                            </p>

                            <div class="text-warning mb-2" style="font-size: 0.9rem;">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <i class="bi bi-star-fill me-1"></i>
                                <?php endfor; ?>
                            </div>

                            <p class="text-success fw-bold fs-6 mb-3">
                                R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                            </p>

                            <div class="mt-auto">
                                <div class="btn-group w-100" role="group">
                                    <a href="detalhes.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-success">
                                        <i class="bi bi-bag-fill me-1"></i> Comprar
                                    </a>
                                    <button class="btn btn-sm btn-warning">
                                        <i class="bi bi-cart-plus me-1"></i> Carrinho
                                    </button>
                                </div>
                            </div>
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