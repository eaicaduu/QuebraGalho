<nav class="navbar navbar-expand-lg bg-transparent mb-2">
    <div class="container d-flex align-items-center justify-content-between">

        <button class="btn btn-link text-decoration-none text-dark p-0"
            onclick="window.location.href = '../account.php'">
            <i class="bi bi-arrow-left-circle" style="font-size: 1.8rem;"></i>
        </button>

        <div class="d-flex justify-content-center">
            <span class="navbar-brand d-flex align-items-center">
                <i class="bi bi-people me-2" style="font-size: 1.8rem;"></i>
                <span>
                    Olá, <?php
                    $nomes = explode(' ', $_SESSION['usuario_nome']);
                    echo htmlspecialchars($nomes[0] . (isset($nomes[1]) ? ' ' . $nomes[1] : ''));
                    ?>.
                </span>
            </span>
        </div>

        <img src="<?= $logo ?>" class="pe-none" height="50">
    </div>
</nav>