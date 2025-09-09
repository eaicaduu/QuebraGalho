<div class="container">
    <div class="p-4 bg-dark-subtle border rounded-3 shadow-sm">
        <h4 class="mb-4 text-center">Gerenciar Carousel</h4>

        <div class="d-flex justify-content-center">
            <div id="addImageCarousel" 
                 class="d-flex align-items-center justify-content-center border border-primary rounded-3 bg-white shadow-sm"
                 style="cursor:pointer; width:240px; height:120px; transition:0.3s;">
                <span class="text-primary" style="font-size:2.5rem; font-weight:bold;">+</span>
            </div>
        </div>

        <input type="file" id="imageInput" accept="image/*" style="display:none;">

        <div id="carouselImages" class="row mt-4 g-3 justify-content-center">
        </div>
    </div>
</div>
