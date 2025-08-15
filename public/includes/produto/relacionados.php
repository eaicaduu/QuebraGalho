    <!-- Produtos Relacionados -->
    <hr class="my-5">
    <h3 class="mb-4">Produtos Relacionados</h3>
    <div class="row g-4">
        <?php foreach ($relacionados as $rel): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?= $rel['imagem'] ?>" class="card-img-top" alt="<?= htmlspecialchars($rel['nome']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($rel['nome']) ?></h5>
                        <p class="text-success fw-bold">R$ <?= number_format($rel['preco'], 2, ',', '.') ?></p>
                        <a href="#" class="btn btn-primary btn-sm">Ver produto</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>