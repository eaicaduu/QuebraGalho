<nav class="navbar navbar-expand-lg bg-transparent">
  <div class="container">
      <button class="navbar-toggler invisible" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand mx-auto d-lg-none" href="#">
      <img src=" <?= $config['logo'] ?>" height="50" class="pe-none" />
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarContent">
      <ul class="navbar-nav d-flex flex-lg-row gap-lg-3 mb-2 mb-lg-0">
        <li class="nav-item fw-bold">
          <a class="nav-link" href="#sobre"><i class="bi bi-info-circle me-1"></i>Sobre Nós</a>
        </li>
        <li class="nav-item fw-bold">
          <a class="nav-link" href="#footer"><i class="bi bi-telephone me-1"></i>Contato</a>
        </li>
      </ul>
      
      <a class="navbar-brand d-none d-lg-block" href="#">
        <img src="images/logo.png" height="50" class="pe-none" />
      </a>

      <!-- Menu à direita -->
      <ul class="navbar-nav d-flex flex-lg-row gap-lg-3 mb-2 mb-lg-0">
        <li class="nav-item fw-bold">
          <a class="nav-link" href="#local"><i class="bi bi-geo-alt me-1"></i>Onde estamos</a>
        </li>
        <li class="nav-item fw-bold">
          <a class="nav-link" href="#servicos"><i class="bi bi-tools me-1"></i>Serviços</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
