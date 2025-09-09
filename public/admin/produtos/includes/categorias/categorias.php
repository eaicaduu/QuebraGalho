<div class="container">
    <div class="row">

        <div class="col-14 col-lg-12 mx-auto">
            <div class="mb-4 mt-md-0">
                <div class="row align-items-center justify-content-center">

                    <div class="col-12 col-md-6">
                        <div class="position-relative w-100">
                            <input type="text" id="searchCategoria" class="form-control ps-5 rounded-pill shadow-sm w-100"
                                placeholder="Pesquisar categoria...">
                            <i
                                class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <i id="clearSearch"
                                class="bi bi-x-lg position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                                style="cursor: pointer; display: none; z-index: 2;"></i>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 text-md-end mt-3 mt-md-0">
                        <button id="addcategoria" class="btn btn-success btn-sm w-100 w-md-auto">
                            <i class="bi bi-plus-lg"></i> Adicionar categoria
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="categorias-body" style="max-height: 60vh;overflow-y: auto;"></div>
        <div id="paginacao-container"></div>
    </div>
</div>