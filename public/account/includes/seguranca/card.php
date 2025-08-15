<div class="container-fluid py-4 ps-lg-4">

    <div class="row g-4">
        <?php include 'includes/menu-desktop.php'; ?>

        <div class="col-8 col-lg-6 mx-auto">
            <div class="card shadow-sm p-4 h-100">

                <p><strong>Última alteração de senha:</strong>
                    <?php
                    if (!empty($user['data_reset_senha'])) {
                        echo date('d/m/Y', strtotime($user['data_reset_senha']));
                    } elseif (!empty($user['criado_em'])) {
                        echo date('d/m/Y', strtotime($user['criado_em']));
                    } else {
                        echo 'Data não disponível';
                    }
                    ?>
                </p>
                <a href="alterar-senha.php" class="btn btn-danger mt-auto">
                    <i class="bi bi-shield-lock-fill me-1"></i> Alterar Senha
                </a>
            </div>
        </div>
    </div>
</div>