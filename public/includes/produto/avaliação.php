<hr class="my-5">
    <h3 class="mb-4">Avaliações dos Clientes</h3>
    <?php foreach ($avaliacoes as $avaliacao): ?>
        <div class="mb-3 p-3 border rounded shadow-sm bg-light">
            <strong><?= htmlspecialchars($avaliacao['usuario']) ?></strong>
            <div class="text-warning small mb-1">
                <?php for ($i = 0; $i < $avaliacao['nota']; $i++): ?>
                    <i class="bi bi-star-fill"></i>
                <?php endfor; ?>
            </div>
            <p class="mb-0"><?= htmlspecialchars($avaliacao['comentario']) ?></p>
        </div>
    <?php endforeach; ?>