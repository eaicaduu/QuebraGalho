<nav class="navbar bg-white d-block d-xl-none">
  <div class="container d-flex justify-content-between align-items-center">

    <ul class="navbar-nav d-flex flex-row align-items-center">
      <li class="nav-item mx-2 position-relative">
        <a class="nav-link js-link-carrinho" id="linkCarrinho-sm" style="position: relative;">
          <i class="bi bi-cart3 text-black" style="font-size: 2rem;"></i>
          <span id="badgeCarrinho"
            class="position-absolute fw-bold bg-danger text-white d-flex justify-content-center align-items-center"
            style="top: 0.7rem; left: 1.2rem; width: 1.2rem; height: 1.2rem; font-size: 0.75rem; border-radius: 50%;">
            <?= $totalCarrinho ?>
          </span>
          <span class="visually-hidden">produtos no carrinho</span>
          </span>
        </a>
      </li>
    </ul>

    <img src="<?= $config['logo'] ?>" height="50" class="pe-none user-select-none" onclick="">

    <ul class="navbar-nav d-flex flex-row align-items-center">
      <li class="nav-item mx-2">
        <a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
          <i class="bi bi-list text-black" style="font-size: 2.3rem;"></i>
        </a>
      </li>
    </ul>

    <div class="w-100 my-2">
      <form action="buscar.php" method="GET">
        <div class="input-group shadow-sm rounded-5 overflow-hidden w-100">
          <input type="text" name="search" style="outline: none; box-shadow: 0 0 0 0.15rem rgba(255, 255, 255, 0);"
            class="form-control border-0 bg-secondary-subtle text-center"
            placeholder="Digite aqui o que você procura..." aria-label="Buscar">
        </div>
      </form>
    </div>
  </div>
</nav>