<nav class="navbar navbar-expand-lg bg-transparent mb-4">
    <div class="container d-flex align-items-center justify-content-between">

        <button class="btn btn-link text-decoration-none text-dark p-0" onclick="history.back()">
            <i class="bi bi-arrow-left-circle" style="font-size: 1.8rem;"></i>
        </button>

         <span class="navbar-brand d-flex align-items-center">
            <i class="bi bi-menu-up" style="font-size: 1.8rem;"></i>
            <span class="ms-2 text-dark">Categorias</span>
        </span>
    </div>
</nav>

<div class="container mb-3">
    <div class="row align-items-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="flex-grow-1 me-3" style="max-width: 250px;">
                    <div class="position-relative">
                        <input type="text" id="searchCategoria" class="form-control ps-5 rounded-pill shadow-sm"
                            placeholder="Pesquisar categoria">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    </div>
                </div>

                <div>
                    <button id="addcategoria" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-lg"></i> Adicionar categoria
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
