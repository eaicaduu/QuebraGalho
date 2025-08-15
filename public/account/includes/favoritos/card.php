<div class="container-fluid py-4 ps-lg-4">

    <div class="row g-4">
        <?php include 'includes/menu-desktop.php'; ?>

        <div class="col-8 col-lg-6 mx-auto">
            <div class="card shadow-sm p-4 h-100">

                <?php if (!empty($favoritos)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($favoritos as $item): ?>
                            <li class="list-group-item px-0">
                                <strong><?= htmlspecialchars($item['nome']) ?></strong><br>
                                Preço: R$ <?= number_format($item['preco'], 2, ',', '.') ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Você ainda não adicionou produtos aos favoritos.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>