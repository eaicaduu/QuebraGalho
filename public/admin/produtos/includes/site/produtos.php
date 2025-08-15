<div class="container-fluid">
    <div class="row">

        <div class="col-14 col-lg-8 mx-auto">
            <div class="mb-4 mt-md-0">
                <div class="row align-items-center justify-content-center">

                    <div class="col-12 col-md-6">
                        <div class="position-relative w-100">
                            <input type="text" id="searchProduto" class="form-control ps-5 rounded-pill shadow-sm w-100"
                                placeholder="Pesquisar produto...">
                            <i
                                class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <i id="clearSearch"
                                class="bi bi-x-lg position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                                style="cursor: pointer; display: none; z-index: 2;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div id="produtos-body" style="max-height: 70vh; overflow-y: auto;"></div>
            <div id="paginacao-container"></div>
        </div>
    </div>
</div>