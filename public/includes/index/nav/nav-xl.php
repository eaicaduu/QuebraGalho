<nav class="navbar bg-transparent d-none d-xl-flex">
  <div class="container d-flex justify-content-between align-items-center">
    <img src="images/logo.png" height="50" class="pe-none user-select-none">

    <div class="flex-grow-1" style="max-width: 50%">
      <div class="input-group overflow-hidden">
        <input type="text" style="outline: none; box-shadow: 0 0 0 0.15rem rgba(255, 255, 255, 0);" name="search"
          class="form-control border-0 bg-secondary-subtle text-center" placeholder="Digite aqui o que você procura...">
      </div>
    </div>

    <ul class="navbar-nav d-flex flex-row align-items-center mb-0">
      <li class="nav-item mx-2">
        <a class="nav-link d-flex align-items-center" style="cursor: pointer;" data-bs-toggle="offcanvas"
          data-bs-target="#offcanvasFavoritos">
          <i class="bi bi-heart fs-4"></i>
          <span class="ms-1">Favoritos</span>
        </a>
      </li>
      <li class="nav-item mx-2">
        <a class="nav-link d-flex align-items-center js-account" style="cursor: pointer;" id="account-xl">
          <i class="bi bi-person-circle fs-4"></i>
          <span class="ms-1">Minha Conta</span>
        </a>
      </li>
      <li class="nav-item mx-2">
        <a class="nav-link d-flex align-items-center js-link-carrinho" style="cursor: pointer;" id="linkCarrinho-xl">
          <i class="bi bi-cart3 fs-4"></i>
          <span class="ms-1">Carrinho</span>
        </a>
      </li>
    </ul>
  </div>
</nav>