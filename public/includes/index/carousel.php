<div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php foreach ($imagens as $index => $img): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" style="height: 60vh;">
                <img src="../app/uploads/carousel/<?= $img['imagem'] ?>"
                    style="object-fit: cover; object-position: center; width: 100%; height: 100%;" class="d-block w-100"
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