<nav class="nav justify-content-center mb-2">
  <?php if (!empty($categorias)): ?>
    <?php foreach ($categorias as $categoria): ?>
      <a 
        class="nav-link text-dark px-3 py-2" 
        href="produtos.php?categoria=<?= urlencode($categoria['id']) ?>"
      >
        <?= htmlspecialchars($categoria['nome']) ?>
      </a>
    <?php endforeach; ?>
  <?php else: ?>
    <span class="text-muted">Nenhuma categoria encontrada.</span>
  <?php endif; ?>
</nav>