<div class="col-12 col-lg-8 mx-auto">
    <div class="mb-4 mt-4 mt-md-0">
        <div class="row align-items-center justify-content-between">

            <!-- Campo de busca -->
            <div class="col-12 col-md-6">
                <div class="position-relative w-100">
                    <input type="text" id="searchProduto" class="form-control ps-5 rounded-pill shadow-sm w-100"
                        placeholder="Pesquisar produto...">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <i id="clearSearch"
                        class="bi bi-x-lg position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                        style="cursor: pointer; display: none; z-index: 2;"></i>
                </div>
            </div>

            <!-- Botões e total de produtos -->
            <div class="col-12 col-md-6 mt-3 mt-md-0">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="btn-group" role="group" aria-label="Ações de usuário">
                        <button id="addproduct" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-lg"></i> Anunciar
                        </button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCalculo">
                            <i class="bi bi-calculator"></i> Calcular Lucro
                        </button>
                    </div>

                    <div class="text-muted text-end">
                        Cadastrados: <strong id="totalCadastrados">0</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de produtos -->
    <div id="produtos" class="row mx-1 mx-md-0" style="max-height: 60vh; overflow-y: auto;"></div>

    <!-- Container de paginação (se necessário) -->
    <div id="paginacao-container"></div>
</div>
