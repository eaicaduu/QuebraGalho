<div class="container-fluid">
    <div class="row">

        <div class="col-12 col-lg-3 d-none d-lg-block">
            <div class="list-group shadow-sm">
                <a href="produtos_site.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-globe2 text-primary fs-4"></i> Site
                </a>
                <a href="protudos_img.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-images text-success fs-4"></i> Imagens
                </a>
                <a href="produtos_categorias.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-menu-up text-danger fs-4"></i> Categorias
                </a>
                <a href="produtos_atributos.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-sliders text-secondary fs-4"></i> Atributos
                </a>
                <a href="produtos_cupons.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-ticket-perforated text-info fs-4"></i> Cupons
                </a>
                <a href="produtos_estoque.php"
                    class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-1 gap-md-2">
                    <i class="bi bi-box-seam text-warning fs-4"></i> Estoque
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
                <a href="produtos_site.php" class="btn btn-secondary me-2 mb-2 ms-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-globe2 fs-4"></i><br>Site
                </a>
                <a href="produtos_imgens.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-images fs-4"></i><br>Imagens
                </a>
                <a href="produtos_categorias.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-menu-up fs-4"></i><br>Categorias
                </a>
                <a href="produtos_atributos.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-sliders fs-4"></i><br>Atributos
                </a>
                <a href="produtos_cupons.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-ticket-perforated fs-4"></i><br> Cupons
                </a>
                <a href="produtos_estoque.php" class="btn btn-secondary me-2 mb-2"
                    style="display: inline-block; white-space: normal; width: 150px;">
                    <i class="bi bi-box-seam fs-4"></i><br>Estoque
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