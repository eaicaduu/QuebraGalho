<nav class="navbar navbar-expand-lg bg-transparent">
    <div class="container d-flex align-items-center justify-content-between">

        <button class="btn btn-link text-decoration-none text-dark p-0"
            onclick="window.location.href = '../painel.php'">
            <i class="bi bi-arrow-left-circle" style="font-size: 1.8rem;"></i>
        </button>

        <div class="d-flex justify-content-center">
            <span class="navbar-brand d-flex align-items-center">
                <i class="bi bi-cart-check" style="font-size: 1.8rem;"></i>
                <span class="ms-2 text-dark">Pedidos</span>
            </span>
        </div>

        <img src="../../images/logo.png" class="pe-none" height="50">
    </div>
</nav>
<?php
$plataformas = ['amazon', 'e-commerce', 'mercado_livre', 'shopee',];
$selecionadas = isset($_GET['plataforma']) ? $_GET['plataforma'] : [];
?>

<form method="GET" id="filtroPlataformas" class="mb-4 container">
    <div class="row g-3 d-flex align-items-center">

        <div class="col-md-4 mb-3 mb-md-0">
            <div class="position-relative">
                <input type="text" id="searchProduto" class="form-control ps-5 pe-5 rounded-pill shadow-sm"
                    placeholder="Pesquisar pedido...">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            </div>
        </div>

        <div class="col-12 col-md-8">
            <div class="d-flex flex-wrap gap-3">
                <?php foreach ($plataformas as $plataforma):
                    $checked = in_array($plataforma, $selecionadas) ? 'checked' : '';
                    ?>
                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input" type="checkbox" name="plataforma[]" value="<?= $plataforma ?>"
                            id="<?= $plataforma ?>" <?= $checked ?>
                            onchange="document.getElementById('filtroPlataformas').submit();">
                        <label class="form-check-label" for="<?= $plataforma ?>">
                            <?= ucfirst(str_replace('_', ' ', $plataforma)) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>  
        </div>
    </div>
</form>