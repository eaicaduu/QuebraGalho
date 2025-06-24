<nav class="navbar navbar-expand-lg bg-transparent mb-2">
    <div class="container d-flex align-items-center justify-content-between">

        <button class="btn btn-link text-decoration-none text-dark p-0" onclick="history.back()">
            <i class="bi bi-arrow-left-circle" style="font-size: 1.8rem;"></i>
        </button>

        <span class="navbar-brand d-flex align-items-center">
            <i class="bi bi-box-seam" style="font-size: 1.8rem;"></i>
            <span class="ms-2 text-dark">Produtos</span>
        </span>
    </div>
</nav>

<div class="container mb-3">
    <div class="row align-items-center">

        <div class="col-md-4 mb-2 mb-md-0">
            <div class="position-relative">
                <input type="text" id="searchProduto" class="form-control ps-5 rounded-pill shadow-sm"
                    placeholder="Pesquisar produto">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            </div>
        </div>

        <div class="col-12 col-md-8 mt-3 mt-md-0">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="btn-group" role="group" aria-label="Ações de usuário">
                    <button id="addproduct" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-lg"></i> Adicionar
                    </button>
                    <button id="btnImportar" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-download"></i> Importar
                    </button>
                    <input type="file" id="inputImportar" accept=".html,.xml,.pdf" style="display:none" />
                </div>

                <div class="text-muted text-end text-md-start">
                    Cadastrados: <strong><?= $totalProdutos ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>