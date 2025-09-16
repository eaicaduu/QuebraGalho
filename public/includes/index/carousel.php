<div id="mainCarousel" class="carousel slide carousel-dark" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php foreach ($imagens as $index => $img): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <img src="../app/uploads/carousel/<?= $img['imagem'] ?>"
                     class="d-block w-100 pe-none carousel-img"
                     onerror="this.onerror=null;this.src='images/default.png';">
            </div>
        <?php endforeach; ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div>
