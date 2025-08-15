<div class="container-fluid py-4 ps-lg-4">

    <div class="row g-4">
        <?php include 'includes/menu-desktop.php'; ?>

        <div class="col-8 col-lg-6 mx-auto">
            <div class="card shadow-sm p-4 h-100">

                <?php if (!empty($enderecos)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($enderecos as $endereco): ?>
                            <li class="list-group-item px-0">
                                <?= htmlspecialchars($endereco['logradouro']) ?>,
                                <?= htmlspecialchars($endereco['numero']) ?><br>
                                <?= htmlspecialchars($endereco['cidade']) ?> - <?= htmlspecialchars($endereco['estado']) ?><br>
                                CEP: <?= htmlspecialchars($endereco['cep']) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Nenhum endereço cadastrado.</p>
                <?php endif; ?>

                <a href="cadastrar-endereco.php" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle me-1"></i> Adicionar Endereço
                </a>
            </div>
        </div>
    </div>
</div>