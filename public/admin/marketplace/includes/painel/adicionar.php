<!-- Modal -->
<div class="modal fade" id="modalAdicionar" tabindex="-1" aria-labelledby="modalAdicionarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="modalAdicionarLabel">Adicionar Produto</h5>
                <button type="button" class="btn p-0 border-0 bg-transparent" aria-label="Voltar"
                    style="outline: none; box-shadow: none;" id="btnFechar" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left fs-4"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 g-3 mb-3">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input toggle-col" type="checkbox" data-col="Nome" id="checkNome">
                            <label class="form-check-label" for="checkNome">Nome Produto</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input toggle-col" type="checkbox" data-col="CustoProduto"
                                id="checkCustoProduto">
                            <label class="form-check-label" for="checkCustoProduto">Custo Produto</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input toggle-col" type="checkbox" data-col="Venda" id="checkVenda">
                            <label class="form-check-label" for="checkVenda">Valor Venda</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input toggle-col" type="checkbox" data-col="CustoMarketplace"
                                id="checkMarketplace">
                            <label class="form-check-label" for="checkMarketplace">Custo Marketplace</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input toggle-col" type="checkbox" data-col="Frete" id="checkFrete">
                            <label class="form-check-label" for="checkFrete">Frete</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input toggle-col" type="checkbox" data-col="CustoEmbalagem"
                                id="checkEmbalagem">
                            <label class="form-check-label" for="checkEmbalagem">Custo Embalagem</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input toggle-col" type="checkbox" data-col="Imposto"
                                id="checkImposto">
                            <label class="form-check-label" for="checkImposto">Imposto</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input toggle-col" type="checkbox" data-col="ComissaoMK"
                                id="checkComissaoMK">
                            <label class="form-check-label" for="checkComissaoMK">Comissão Marketplace</label>
                        </div>
                    </div>
                </div>

                <div id="app" class="row"></div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <button id="btnSalvarCalculo" data-bs-dismiss="modal" class="btn btn-secondary" disabled>Salvar</button>
                    <button id="btnBuscarProduto" data-bs-dismiss="modal" class="btn btn-primary">Buscar Produto</button>
                </div>
            </div>
        </div>
    </div>
</div>