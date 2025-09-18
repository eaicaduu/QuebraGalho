<nav class="navbar bg-white d-none d-xl-flex">
  <div class="container d-flex justify-content-between align-items-center">
    <div onclick="window.location.href = 'index.php'"><img src="<?= $logo ?>" height="50" class="pe-none user-select-none"></div>

    <div class="flex-grow-1" style="max-width: 50%">
      <div class="input-group overflow-hidden">
        <input type="text" style="outline: none; box-shadow: 0 0 0 0.15rem rgba(255, 255, 255, 0);" name="search"
          class="form-control border-0 bg-secondary-subtle text-center" placeholder="Digite aqui o que você procura...">
      </div>
    </div>

    <ul class="navbar-nav d-flex flex-row align-items-center mb-0 justify-content-between">
      <li class="nav-item mx-2">
        <?php if ($usuario): ?>
          <a class="nav-link d-flex align-items-center js-account" style="cursor: pointer;" id="account-xl">
            <i class="bi bi-person-circle fs-4"></i>
            <span class="ms-1">Minha Conta</span>
          </a>
        <?php else: ?>
          <div class="d-flex gap-2">
            <a class="nav-link d-flex align-items-center js-login" style="cursor: pointer;" id="login-xl">
              <i class="bi bi-box-arrow-in-right fs-4"></i>
              <span class="ms-1">Entrar</span>
            </a>
            <a class="nav-link d-flex align-items-center js-cadastro ms-2" style="cursor: pointer;" id="cadastro-xl">
              <i class="bi bi-person-plus fs-4"></i>
              <span class="ms-1">Criar Conta</span>
            </a>
          </div>
        <?php endif; ?>
      </li>
      <li class="nav-item mx-2 position-relative">
        <a class="nav-link d-flex align-items-center js-link-carrinho" style="cursor: pointer; position: relative;" id="linkCarrinho-xl">
          <i class="bi bi-cart3 fs-4"></i>
          <span class="ms-1">Carrinho</span>
          <span id="badgeCarrinhoXL"
            class="position-absolute bg-danger text-white d-flex justify-content-center align-items-center"
            style="top: 0.5rem; left: -0.5rem; width: 1.2rem; height: 1.2rem; font-size: 0.75rem; border-radius: 50%;">
            <?= $totalCarrinho ?>
          </span>
        </a>
      </li>
    </ul>
  </div>
</nav>