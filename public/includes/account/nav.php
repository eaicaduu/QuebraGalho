<nav class="navbar navbar-expand-lg bg-transparent mb-2">
    <div class="container d-flex align-items-center justify-content-between">

        <button class="btn btn-link text-decoration-none text-dark p-0" onclick="history.back()">
            <i class="bi bi-arrow-left-circle" style="font-size: 1.8rem;"></i>
        </button>

        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1): ?>
            <a href="./admin/painel.php">
            <button class="btn btn-dark mx-3">
              <i class="bi bi-database-fill-gear"></i> Admin
            </button>
            </a>
        <?php endif; ?>

        <span class="navbar-brand d-flex align-items-center">
            <i class="bi bi-person-circle" style="font-size: 1.8rem;"></i>
            <span class="ms-2 text-dark">Minha Conta</span>
        </span>
    </div>
</nav>