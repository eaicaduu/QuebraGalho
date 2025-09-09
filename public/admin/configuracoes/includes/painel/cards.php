<div class="container-fluid">
    <div class="row">

        <div class="col-12 col-lg-3 d-none d-lg-block">
            <div class="list-group shadow-sm">
                <?php
                $menu = [
                    'principal' => ['label' => 'Informações Principais', 'icon' => 'bi-info-circle', 'link' => 'configuracoes_painel.php'],
                    'carousel' => ['label' => 'Imagens Carousel', 'icon' => 'bi-images', 'link' => 'configuracoes_carousel.php'],
                    'pagamentos' => ['label' => 'Pagamentos', 'icon' => 'bi-credit-card', 'link' => 'configuracoes_pagamentos.php'],
                    'outros' => ['label' => 'Outros', 'icon' => 'bi-gear', 'link' => 'configuracoes_outros.php'],
                ];

                foreach ($menu as $key => $item):
                    $ativo = ($paginaAtual === $key) ? 'bg-warning' : '';
                    ?>
                    <a href="<?= $item['link'] ?>"
                        class="list-group-item list-group-item-action d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center gap-2 <?= $ativo ?>">
                        <i class="bi <?= $item['icon'] ?> fs-4"></i> <?= $item['label'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="d-lg-none" style="padding-left:0; padding-right:0;">
            <div class="overflow-auto"
                style="white-space: nowrap; -webkit-overflow-scrolling: touch; padding-bottom:0.5rem;">
                <?php foreach ($menu as $key => $item):
                    $ativo = ($paginaAtual === $key) ? 'btn-warning' : 'btn-secondary';
                    $palavras = explode(' ', $item['label']);
                    $ultimaPalavra = array_pop($palavras);
                    ?>
                    <a href="<?= $item['link'] ?>" class="btn <?= $ativo ?> me-2 mb-2 ms-2"
                        style="display:inline-block; width:150px; white-space:normal;">
                        <i class="bi <?= $item['icon'] ?> fs-4"></i><br><?= $ultimaPalavra ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-12 col-lg-9">
            <?php
            if ($paginaAtual === 'principal') {
                include 'includes/principal/config_principal.php';
            } elseif ($paginaAtual === 'carousel') {
                include 'includes/carousel/config_carousel.php';
            } elseif ($paginaAtual === 'pagamentos') {
                include 'includes/pagamentos/config_pagamentos.php';
            } elseif ($paginaAtual === 'outros') {
                include 'includes/outros/config_outros.php';
            }
            ?>
        </div>

    </div>
</div>