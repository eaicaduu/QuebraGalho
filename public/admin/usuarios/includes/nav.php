<nav class="navbar navbar-expand-lg bg-transparent mb-4">
    <div class="container d-flex align-items-center justify-content-between">

        <button class="btn btn-link text-decoration-none text-dark p-0" onclick="history.back()">
            <i class="bi bi-arrow-left-circle" style="font-size: 1.8rem;"></i>
        </button>

        <div class="d-flex justify-content-center">
            <span class="navbar-brand d-flex align-items-center">
                <i class="bi bi-people" style="font-size: 1.8rem;"></i>
                <span class="ms-2 text-dark">Usuários</span>
            </span>
        </div>

        <img src="../../images/logo.png" class="pe-none" height="50">
    </div>
</nav>

<div class="container mb-3">
    <div class="row align-items-center">

        <div class="col-md-4 mb-2 mb-md-0">
            <div class="position-relative">
                <input type="text" id="searchUsuario" class="form-control ps-5 rounded-pill shadow-sm"
                    placeholder="Pesquisar Usuários...">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            </div>
        </div>

        <div class="col-12 col-md-8 mt-3 mt-md-0">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="btn-group" role="group" aria-label="Ações de usuário">
                    <button id="btnCriarUsuario" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-lg"></i> Criar Usuário
                    </button>
                    <button id="btnExportarUsuarios" class="btn btn-secondary btn-sm">
                        <i class="bi bi-download"></i> Exportar
                    </button>
                </div>

                <div class="text-muted text-end text-md-start">
                    Total de Usuários: <strong id="totalUsuarios">0</strong>
                </div>
            </div>
        </div>
    </div>
</div>