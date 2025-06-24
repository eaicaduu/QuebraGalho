<nav class="navbar navbar-expand-lg bg-transparnt">
    <div class="container d-flex align-items-center justify-content-between">
        <img src="images/logo.png" class="pe-none" height="50">
        <ul class="navbar-nav d-flex flex-row align-items-center">
            <li class="nav-item mx-3">
                <a class="nav-link d-flex align-items-center" href="salvos.php">
                    <i class="bi bi-heart" style="font-size: 1.5rem;"></i>
                    <span class="ms-2 d-none d-md-inline">Itens Salvos</span>
                </a>
            </li>

            <li class="nav-item dropdown mx-3">
                <a class="nav-link d-flex align-items-center"
                    href="<?php echo isset($_SESSION['usuario_cpf']) ? 'account.php' : 'login.php'; ?>" id="userMenu"
                    role="button">
                    <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                    <span class="ms-2 d-none d-md-inline">Minha conta</span>
                </a>
                <?php if (!isset($_SESSION['usuario_cpf'])): ?>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="login.php">
                            <i class="bi bi-person-fill-check" style="font-size: 1.2rem;"></i> Entrar
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="cadastro.php">
                            <i class="bi bi-person-fill-add" style="font-size: 1.2rem;"></i> Cadastrar
                        </a>
                    </li>
                </ul>
                <?php endif; ?>
            </li>
            <li class="nav-item mx-3">
                <a class="nav-link d-flex align-items-center" href="carrinho.php">
                    <i class="bi bi-cart3" style="font-size: 1.5rem;"></i>
                    <span class="ms-2 d-none d-md-inline">Meu Carrinho</span>
                </a>
            </li>
        </ul>
    </div>
</nav>