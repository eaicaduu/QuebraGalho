<nav class="navbar bg-transparent d-block d-xl-none">
  <div class="container d-flex justify-content-between align-items-center">
    <img src="images/logo.png" height="50" class="pe-none user-select-none">

    <ul class="navbar-nav d-flex flex-row align-items-center mb-0">
      <li class="nav-item mx-2">
        <a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFavoritos">
          <i class="bi bi-heart fs-4"></i>
        </a>
      </li>
      <li class="nav-item mx-2">
        <a class="nav-link js-account" id="account-sm">
          <i class="bi bi-person-circle fs-4"></i>
        </a>
      </li>
      <li class="nav-item mx-2">
        <a class="nav-link js-link-carrinho" id="linkCarrinho-sm">
          <i class="bi bi-cart3 fs-4"></i>
        </a>
      </li>
    </ul>

    <div class="w-100 mt-2">
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