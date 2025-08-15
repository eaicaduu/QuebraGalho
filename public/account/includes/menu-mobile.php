<!-- includes/menu-mobile.php -->
<div class="d-lg-none position-relative">
    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
        data-bs-target="#menuContaMobile" aria-controls="menuContaMobile" aria-expanded="false"
        aria-label="Toggle navigation">
        <i class="bi bi-list" style="font-size: 1.8rem;"></i>
    </button>

    <div class="collapse position-absolute end-0 mt-2 bg-white rounded shadow p-2" id="menuContaMobile"
        style="min-width: 220px; z-index: 1050;">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link px-2 <?= $paginaAtual === 'conta' ? 'active bg-warning text-dark rounded' : '' ?>"
                    href="<?= $basePath ?>../account.php">
                    <i class="bi bi-person-circle me-2"></i>Minha Conta
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-2 <?= $paginaAtual === 'historico' ? 'active bg-warning text-dark rounded' : '' ?>"
                    href="<?= $basePath ?>historico.php">
                    <i class="bi bi-clock-history me-2"></i>Histórico de Compras
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-2 <?= $paginaAtual === 'favoritos' ? 'active bg-warning text-dark rounded' : '' ?>"
                    href="<?= $basePath ?>favoritos.php">
                    <i class="bi bi-heart me-2"></i>Favoritos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-2 <?= $paginaAtual === 'enderecos' ? 'active bg-warning text-dark rounded' : '' ?>"
                    href="<?= $basePath ?>enderecos.php">
                    <i class="bi bi-geo-alt me-2"></i>Endereços
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link px-2 <?= $paginaAtual === 'seguranca' ? 'active bg-warning text-dark rounded' : '' ?>"
                    href="<?= $basePath ?>seguranca.php">
                    <i class="bi bi-shield-lock me-2"></i>Segurança
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger px-2" href="<?= $basePath ?>../../app/models/conta/logout.php">
                    <i class="bi bi-box-arrow-right me-2"></i>Sair
                </a>
            </li>
        </ul>
    </div>
</div>
