<nav class="navbar navbar-expand-lg bg-transparent mb-4">
    <div class="container d-flex align-items-center justify-content-between">

        <button class="btn btn-link text-decoration-none text-dark p-0" onclick="history.back()">
            <i class="bi bi-arrow-left-circle" style="font-size: 1.8rem;"></i>
        </button>

        <h4 class="mb-0">
            Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>.
        </h4>

        <img src="../images/logo.png" class="pe-none" height="50">
    </div>
</nav>