<nav class="navbar bg-white d-block d-xl-none">
  <div class="container d-flex justify-content-between align-items-center">

    <ul class="navbar-nav d-flex flex-row align-items-center">
      <li class="nav-item mx-2">
        <a class="nav-link js-link-carrinho" id="linkCarrinho-sm">
          <i class="bi bi-cart3 text-black" style="font-size: 2rem;"></i>
        </a>
      </li>
    </ul>

    <img src="images/logo.png" height="50" class="pe-none user-select-none">

    <ul class="navbar-nav d-flex flex-row align-items-center">
      <li class="nav-item mx-2">
        <a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
          <i class="bi bi-list text-black" style="font-size: 2.3rem;"></i>
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