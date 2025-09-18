<?php
$navMap = [
    'admin_painel.php' => ['titulo' => 'Painel Admin', 'icon' => 'bi-box-seam'],
    'produtos_geral.php' => ['titulo' => 'Visão Geral', 'icon' => 'bi-collection'],
    'produtos_categorias.php' => ['titulo' => 'Categorias', 'icon' => 'bi-ui-checks-grid'],
    'produtos_detalhes.php' => ['titulo' => 'Detalhes', 'icon' => 'bi-card-text'],
    'produtos_imagens.php' => ['titulo' => 'Imagens', 'icon' => 'bi-images'],
    'produtos_estoque.php' => ['titulo' => 'Estoque', 'icon' => 'bi-box-seam'],
    'produtos_caracteristicas.php' => ['titulo' => 'Características', 'icon' => 'bi-circle-square'],
    'produtos_dados_fiscais.php' => ['titulo' => 'Dados Fiscais', 'icon' => 'bi-file-earmark-text'],
    'configuracoes_painel.php' => ['titulo' => 'Informações', 'icon' => 'bi-info-circle'],
    'configuracoes_carousel.php' => ['titulo' => 'Carousel', 'icon' => 'bi-images'],
    'configuracoes_pagamentos.php' => ['titulo' => 'Pagamentos', 'icon' => 'bi-credit-card'],
    'configuracoes_outros.php' => ['titulo' => 'Outros', 'icon' => 'bi-gear'],
];

$navTitulo = $navMap[$paginaAtual]['titulo'] ?? 'Painel';
$navIcon   = $navMap[$paginaAtual]['icon'] ?? 'bi-box-seam';

?>
<nav class="navbar navbar-expand-lg bg-transparent mb-2">
    <div class="container d-flex align-items-center justify-content-between">

        <button class="btn btn-link text-decoration-none text-dark p-0" onclick="window.location.href = '../admin_painel.php'">
            <i class="bi bi-arrow-left-circle" style="font-size: 1.8rem;"></i>
        </button>

        <div class="d-flex justify-content-center">
            <span class="navbar-brand d-flex align-items-center">
                <i class="bi <?= $navIcon ?>" style="font-size: 1.8rem;"></i>
                <span class="ms-2 text-dark"><?= $navTitulo ?></span>
            </span>
        </div>

        <img src="<?= $logo ?>" height="50" class="pe-none user-select-none">
    </div>
</nav>