<!-- includes/menu-desktop.php -->
<div class="col-12 col-lg-3 d-none d-lg-block">
    <div class="list-group shadow-sm">
        <a href="<?= $basePath ?>../account.php"
            class="list-group-item list-group-item-action d-flex align-items-center gap-2 <?= $paginaAtual === 'conta' ? 'bg-warning' : '' ?>">
            <i class="bi bi-person-circle text-dark fs-4"></i><span>Minha Conta</span>
        </a>
        <a href="<?= $basePath ?>historico.php"
            class="list-group-item list-group-item-action d-flex align-items-center gap-2 <?= $paginaAtual === 'historico' ? 'bg-warning' : '' ?>">
            <i class="bi bi-clock-history text-dark fs-4"></i><span>Histórico de Compras</span>
        </a>
        <a href="<?= $basePath ?>favoritos.php"
            class="list-group-item list-group-item-action d-flex align-items-center gap-2 <?= $paginaAtual === 'favoritos' ? 'bg-warning' : '' ?>">
            <i class="bi bi-heart text-dark fs-4"></i><span>Favoritos</span>
        </a>
        <a href="<?= $basePath ?>enderecos.php"
            class="list-group-item list-group-item-action d-flex align-items-center gap-2 <?= $paginaAtual === 'enderecos' ? 'bg-warning' : '' ?>">
            <i class="bi bi-geo-alt text-dark fs-4"></i><span>Endereços</span>
        </a>
        <a href="<?= $basePath ?>seguranca.php"
            class="list-group-item list-group-item-action d-flex align-items-center gap-2 <?= $paginaAtual === 'seguranca' ? 'bg-warning' : '' ?>">
            <i class="bi bi-shield-lock text-dark fs-4"></i><span>Segurança</span>
        </a>
        <a href="<?= $basePath ?>../../app/models/conta/logout.php"
            class="list-group-item list-group-item-action d-flex align-items-center gap-2 text-danger">
            <i class="bi bi-box-arrow-right fs-4"></i><span>Sair</span>
        </a>
    </div>
</div>
