<div class="container-fluid">
    <div class="row">

        <div class="col-12 col-lg-3 d-none d-lg-block">
            <div class="list-group shadow-sm">
                <?php
                $menuProdutos = [
                    'produtos_painel.php' => ['label' => 'Painel Produtos', 'icon' => 'bi-box-seam'],
                    'produtos_geral.php' => ['label' => 'Visão Geral', 'icon' => 'bi-collection'],
                    'produtos_categorias.php' => ['label' => 'Categorias', 'icon' => 'bi-ui-checks-grid'],
                    'produtos_detalhes.php' => ['label' => 'Detalhes', 'icon' => 'bi-card-text'],
                    'produtos_imagens.php' => ['label' => 'Imagens', 'icon' => 'bi-images'],
                    'produtos_estoque.php' => ['label' => 'Estoque', 'icon' => 'bi-box-seam'],
                    'produtos_caracteristicas.php' => ['label' => 'Características', 'icon' => 'bi-circle-square'],
                    'produtos_dados_fiscais.php' => ['label' => 'Dados Fiscais', 'icon' => 'bi-file-earmark-text'],
                ]; ?>
                <?php foreach ($menuProdutos as $arquivo => $item):
                    $ativo = ($paginaAtual === $arquivo) ? $corPrincipal : '';
                ?>
                    <a href="<?= $arquivo ?>"
                        class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-2"
                        style='background-color: <?= $ativo ?>'>
                        <i class="bi <?= $item['icon'] ?> fs-4"></i> <?= $item['label'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="d-lg-none px-0">
            <div class="overflow-auto" style="white-space: nowrap; -webkit-overflow-scrolling: touch; padding-bottom: 0.5rem;">
                <?php foreach ($menuProdutos as $arquivo => $item):
                    $ativo = ($paginaAtual === $arquivo) ? 'btn-warning' : 'btn-secondary';
                    $palavras = explode(' ', $item['label']);
                    $ultimaPalavra = array_pop($palavras);
                ?>
                    <a href="<?= $arquivo ?>" class="btn <?= $ativo ?> me-2 mb-2 ms-2"
                        style="display:inline-block; width:150px; white-space:normal;">
                        <i class="bi <?= $item['icon'] ?> fs-4"></i><br><?= $ultimaPalavra ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-12 col-lg-9">
            <?php
            if ($paginaAtual === 'produtos_categorias.php') {
                include __DIR__ . '/../categorias/options.php';
            } elseif ($paginaAtual === 'produtos_geral.php') {
                include __DIR__ . '/../geral/options.php';
            } else {
                 include __DIR__ . '/options.php';
            }?>
            <?php
            switch ($paginaAtual) {
                case 'produtos_painel.php':
                    include 'includes/painel/produtos.php';
                    break;
                case 'produtos_geral.php':
                    include 'includes/geral/produtos.php';
                    break;
                case 'produtos_categorias.php':
                    include 'includes/categorias/categorias.php';
                    break;
                case 'produtos_detalhes.php':
                    include 'includes/detalhes/produtos.php';
                    break;
                case 'produtos_imagens.php':
                    include 'includes/imagens/produtos.php';
                    break;
                case 'produtos_estoque.php':
                    include 'includes/estoque/estoque.php';
                    break;
                case 'produtos_caracteristicas.php':
                    include 'includes/caracteristicas/caracteristicas.php';
                    break;
                case 'produtos_dados_fiscais.php':
                    include 'includes/dados_fiscais/dados_fiscais.php';
                    break;
            }
            ?>
        </div>

    </div>
</div>