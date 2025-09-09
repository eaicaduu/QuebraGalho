<div class="container-fluid">
    <div class="row">

        <div class="col-12 col-lg-3 d-none d-lg-block">
            <div class="list-group shadow-sm">
                <a href="produtos_geral.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-collection fs-4"></i> Visão Geral
                </a>
                <a href="produtos_categorias.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-ui-checks-grid fs-4"></i> Categorias
                </a>
                <a href="produtos_detalhes.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-card-text fs-4"></i> Detalhes
                </a>
                <a href="produtos_imagens.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-images fs-4"></i> Imagens
                </a>
                <a href="produtos_estoque.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-box-seam fs-4"></i> Estoque
                </a>
                <a href="produtos_caracteristicas.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-circle-square fs-4"></i> Características
                </a>
                <a href="produtos_dados_fiscais.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-file-earmark-text text-dark fs-4"></i> Dados Fiscais
                </a>
            </div>
        </div>

        <div class="d-lg-none" style="padding-left: 0; padding-right: 0;">
            <div class="overflow-auto"
                style="white-space: nowrap; -webkit-overflow-scrolling: touch; padding-bottom: 0.5rem;">
                <a href="produtos_geral.php" class="btn btn-secondary me-2 mb-2 ms-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-collection fs-4"></i><br>Visão Geral
                </a>
                <a href="produtos_categorias.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-menu-up fs-4"></i><br>Categorias
                </a>
                <a href="produtos_detalhes.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-sliders fs-4"></i><br> Detalhes
                </a>
                <a href="produtos_imagens.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-images fs-4"></i><br>Imagens
                </a>
                <a href="produtos_estoque.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-box-seam fs-4"></i><br>Estoque
                </a>
                <a href="produtos_caracteristicas.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-ticket-perforated fs-4"></i><br> Características
                </a>
                <a href="produtos_dados_fiscais.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-file-earmark-text fs-4"></i><br>Dados Fiscais
                </a>
            </div>
        </div>

        <?php include 'produtos.php'; ?>

    </div>
</div>