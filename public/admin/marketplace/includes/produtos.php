<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="mb-4 mt-md-0">
                <div class="row align-items-center justify-content-between text-center text-md-start">

                    <div class="col-12 col-lg-4">
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

                    <div class="col-12 col-lg-8 mt-3 mt-lg-0">
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="text-muted text-end">
                                Cadastrados: <strong id="totalCadastrados">0</strong>
                            </div>

                            <div class="d-flex align-items-center btn-group" role="group" aria-label="Ações de usuário">
                                <button id="btnAnunciar"
                                    class="btn btn-success btn-sm flex-grow-1 flex-md-grow-0">Anunciar</button>
                                <button id="btnPesquisar"
                                    class="btn btn-primary btn-sm flex-grow-1 flex-md-grow-0">Pesquisar</button>
                                <button id="btnFiltro"
                                    class="btn btn-secondary btn-sm flex-grow-1 flex-md-grow-0">Filtro</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="produtos" class="row mx-1 mx-md-0" style="max-height: 60vh; overflow-y: auto;"></div>

    <div id="paginacao-container"></div>
</div>