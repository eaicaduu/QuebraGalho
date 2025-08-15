<div class="container-fluid py-4 ps-lg-4">

    <div class="row g-4">
        <?php include 'includes/menu-desktop.php'; ?>

        <div class="col-8 col-lg-6 mx-auto">
            <div class="card shadow-sm p-4 h-100">

                <?php if (!empty($compras)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($compras as $compra): ?>
                            <li class="list-group-item px-0">
                                <strong><?= htmlspecialchars($compra['produto']) ?></strong><br>
                                Data: <?= date('d/m/Y', strtotime($compra['data'])) ?><br>
                                Valor: R$ <?= number_format($compra['valor'], 2, ',', '.') ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Nenhuma compra registrada.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>