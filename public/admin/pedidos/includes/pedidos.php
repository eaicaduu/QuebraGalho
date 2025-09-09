<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="mb-4 mt-md-0">
                <div class="row align-items-center justify-content-between text-center text-md-start">

                    <div class="col-12 col-md-6 col-lg-6 mb-2 mb-md-0">
                        <div class="position-relative w-100">
                            <input type="text" id="searchPedido" class="form-control ps-5 rounded-pill shadow-sm w-100"
                                placeholder="Pesquisar pedidos...">
                            <i
                                class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <i id="clearSearch"
                                class="bi bi-x-lg position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                                style="cursor: pointer; display: none; z-index: 2;"></i>
                        </div>
                    </div>

                    <div class="col-12 col-md-2 col-lg-2">
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <select id="filtroPedidos" class="form-select shadow-sm w-auto w-25 flex-grow-1">
                                <option value="hoje">Pedidos de hoje</option>
                                <option value="amanha">Pedidos de amanhã</option>
                                <option value="todos">Todos os pedidos</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="mb-4 mt-md-0">
                <div
                    class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2">

                    <div class="d-flex gap-2 flex-wrap w-100">
                        <button id="btnImprimirTodasEtiquetas"
                            class="btn btn-secondary btn-sm flex-grow-1 flex-md-grow-0">Imprimir Todas
                            Etiquetas</button>
                        <button id="btnEmitirTodasNFCe"
                            class="btn btn-secondary btn-sm flex-grow-1 flex-md-grow-0">Emitir Todas NFC-e</button>
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0" style="white-space: nowrap;">
                        <span id="totalPedidos" class="text-muted"></span>
                        <span id="loadingPedidos" class="text-primary d-none align-items-center ms-2">
                            <div class="spinner-border spinner-border-sm" role="status"></div> Atualizando...
                        </span>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div id="pedidos-body" style="max-height: 60vh; overflow-y: auto;"></div>
</div>
</div>