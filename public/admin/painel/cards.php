<div class="container-fluid">
    <div class="row">

        <div class="col-12 col-lg-3 d-none d-lg-block">
            <div class="list-group shadow-sm">
                <a href="produtos/produtos_painel.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-box-seam text-primary fs-4"></i>
                    <span>Produtos</span>
                </a>
                <a href="pedidos/pedidos_painel.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-cart-check text-success fs-4"></i> Pedidos
                </a>
                <a href="usuarios/usuarios_painel.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-people text-danger fs-4"></i> Usuários
                </a>
                <a href="relatorios/relatorios_painel.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-bar-chart-line text-secondary fs-4"></i> Relatórios
                </a>
                <a href="marketplace/marketplace_painel.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-shop text-info fs-4"></i> Marketplace
                </a>
                <a href="avaliacoes/avaliacoes_painel.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-star-half text-warning fs-4"></i> Avaliações
                </a>
                <a href="configuracoes/configuracoes_painel.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-gear text-dark fs-4"></i> Configurações
                </a>
            </div>
        </div>

        <div class="d-lg-none" style="padding-left: 0; padding-right: 0;">
            <div class="overflow-auto"
                style="white-space: nowrap; -webkit-overflow-scrolling: touch; padding-bottom: 0.5rem;">
                <a href="produtos/produtos_painel.php" class="btn btn-secondary me-2 mb-2 ms-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-box-seam fs-4"></i><br>Produtos
                </a>
                <a href="pedidos/pedidos_painel.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-cart-check fs-4"></i><br>Pedidos
                </a>
                <a href="usuarios/usuarios_painel.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-people fs-4"></i><br>Usuários
                </a>
                <a href="relatorios/relatorios_painel.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-bar-chart-line fs-4"></i><br>Relatórios
                </a>
                <a href="marketplace/marketplace_painel.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-shop fs-4"></i><br>Marketplace
                </a>
                <a href="avaliacoes/avaliacoes_painel.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-star-half fs-4"></i><br>Avaliações
                </a>
                <a href="configuracoes/configuracoes_painel.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-gear fs-4"></i><br>Configurações
                </a>
            </div>
        </div>

        <?php include 'painel/notificacoes.php'; ?>

    </div>
</div>