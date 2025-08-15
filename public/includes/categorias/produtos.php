<section class="container">
    <div class="row">
        <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $produto):
                $imagem = $produto['imagem_principal'] ?? '';
                $caminhoImagem = "../../../app/" . $imagem;
                $imagemSrc = (empty($imagem))
                    ? "images/default.png"
                    : $caminhoImagem;
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card product-card h-100 shadow-sm border-0">
                        <div class="position-relative">
                            <img src="<?= $imagemSrc ?>" class="card-img-top"
                                alt="<?= htmlspecialchars($produto['nome']) ?>" style="object-fit: cover; height: 230px;">

                            <button
                                class="btn btn-light position-absolute top-0 end-0 m-2 p-2 rounded-circle shadow-sm d-flex justify-content-center align-items-center"
                                style="width: 40px; height: 40px;" title="Salvar nos favoritos">
                                <i class="bi bi-heart"></i>
                            </button>

                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($produto['nome']) ?></h5>
                            <p class="card-text small"><?= htmlspecialchars($produto['descricao']) ?></p>
                            <p class="text-success fw-bold fs-5">
                                R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                            </p>

                            <div class="mt-auto">
                                <div class="btn-group w-100" role="group">
                                    <a href="detalhes.php?id=<?= $produto['id'] ?>" class="btn btn-success">
                                        <i class="bi bi-bag-fill me-1"></i> Comprar
                                    </a>
                                    <button class="btn btn-primary">
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
                <p class="text-center">Nenhum produto cadastrado nesta categoria.</p>
            </div>
        <?php endif; ?>
    </div>
</section>