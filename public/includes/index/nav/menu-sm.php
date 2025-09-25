<div class="offcanvas offcanvas-end custom-offcanvas" style="width:80vw;" tabindex="-1" id="offcanvasMenu">
  <div class="offcanvas-header border-bottom">
    <?php if ($usuario): ?>
      <div class="d-flex flex-column align-items-start"
        style="cursor: pointer;"
        onclick="window.location.href='account.php'">
        <div class="d-flex align-items-center mb-1">
          <img src="<?= $usuario['imagem_perfil'] ?>"
            alt="Foto de perfil"
            class="rounded-circle me-2"
            style="width:40px; height:40px; object-fit:cover;">
          <span class="fw-semibold">Olá, <?= $usuario['nome'] ?></span>
        </div>
        <small class="text-muted ms-1" style="font-size: 0.75rem;">Clique aqui para acessar sua conta</small>
      </div>
    <?php else: ?>
      <div class="d-flex align-items-center">
        <a href="login.php" class="btn btn-sm me-2 btn-warning text-white">Entrar</a>
        <a href="cadastro.php" class="btn btn-sm btn-success">Criar Conta</a>
      </div>
    <?php endif; ?>
    <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"></button>
  </div>

  <div class="offcanvas-body p-0">
    <ul class="list-group list-group-flush">
      <?php foreach ($categorias as $categoria): ?>
        <li class="list-group-item bg-white">
          <a href="categoria.php?categoria=<?= urlencode($categoria['id']) ?>"
            class="d-flex align-items-center text-dark text-decoration-none py-2 px-3 rounded hover-link">
            <?= htmlspecialchars($categoria['nome']) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>