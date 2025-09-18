<div class="container">
    <div class="p-4 bg-body-secondary border rounded-3 shadow-sm">

        <div class="d-flex justify-content-center mb-4">
            <div id="addImageCarousel"
                class="d-flex align-items-center justify-content-center border border-primary rounded-3 bg-white shadow-sm"
                style="cursor:pointer; width:240px; height:120px; transition:0.3s;">
                <span class="text-primary" style="font-size:2.5rem; font-weight:bold;">+</span>
            </div>
            <input type="file" id="imageInput" accept="image/*" style="display:none;">
        </div>

        <div id="carouselImages" class="row g-3 justify-content-center">
            <?php foreach ($carouselImgs as $img): ?>
                <div class="col-md-3 mb-3 d-flex justify-content-center">
                    <div class="position-relative d-flex align-items-center justify-content-center border rounded-3 bg-white shadow-sm"
                        style="width:240px; height:120px; overflow:hidden;">

                        <img src="../../../app/uploads/carousel/<?= htmlspecialchars($img['imagem']) ?>"
                            class="img-fluid h-100 w-100 object-fit-cover"
                            onerror="this.onerror=null;this.src='../../images/default.png';">

                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 opacity-0 hover-overlay"
                            style="transition: opacity 0.3s;">
                            <button class="btn btn-primary me-2 editar-btn" data-id="<?= $img['id'] ?>" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-danger excluir-btn" data-id="<?= $img['id'] ?>" title="Excluir">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>