<?php if (count($itens_carrinho) === 0): ?>
    <div class="d-flex align-items-center justify-content-center p-4">
        <div class="alert container p-4 rounded d-flex align-items-center justify-content-center bg-body-secondary text-center">
            <i class="bi bi-cart-plus-fill text-secondary me-3 fs-1"></i>
            <div>
                <div class="fw-semibold small">Adicione produtos ao seu carrinho</div>
                <div class="text-muted small">Seu carrinho está vazio no momento.</div>
            </div>
        </div>
    <?php else: ?>
        <div class="container">
            <form method="POST" id="formFinalizar">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check ms-2">
                                <input class="form-check-input" type="checkbox" id="selecionarTodos" checked>
                                <label class="form-check-label fw-semibold" for="selecionarTodos">Selecionar todos</label>
                            </div>
                        </div>
                        <div class="list-group overflow-auto" style="max-height: 70vh;">
                            <?php foreach ($itens_carrinho as $item): ?>
                                <?php
                                $imagem = empty($item['imagem_principal']) ? 'images/default.png' : '../app/uploads/produtos/' . $item['imagem_principal'];
                                $subtotal = $item['preco_unitario'] * $item['quantidade_carrinho'];
                                $produtoUrl = "produto.php?id=" . $item['produto_id'];
                                ?>

                                <div class="d-none d-md-block">
                                    <?php include 'includes/carrinho/card_carrinho_md.php'; ?>
                                </div>

                                <div class="d-block d-md-none">
                                    <?php include 'includes/carrinho/card_carrinho_sm.php'; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="col-md-3 d-none d-xl-block">
                        <?php include 'includes/carrinho/resumo_xl.php'; ?>
                    </div>

                    <div class="d-block d-xl-none position-fixed bottom-0 start-0 w-100 p-2 bg-body-secondary border shadow-sm" style="z-index: 999;">
                        <?php include 'includes/carrinho/resumo_sm.php'; ?>
                    </div>

                </div>
            </form>
        </div>
    <?php endif; ?>