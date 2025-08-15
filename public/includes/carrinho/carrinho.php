<?php if (count($itens_carrinho) === 0): ?>
    <div class="d-flex align-items-center justify-content-center p-4">
        <div class="d-flex align-items-center bg-body-tertiary p-4 rounded">
            <i class="bi bi-cart-plus-fill text-secondary me-3 fs-1"></i>
            <div>
                <div class="fw-semibold small">Adicione produtos ao seu carrinho</div>
                <div class="text-muted small">Seu carrinho está vazio no momento.</div>
            </div>
        </div>
    </div>
<?php else: ?>
    <form action="finalizar_compra.php" method="POST" id="formFinalizar">
        <div class="container py-4">
            <div class="row">

                <div class="col-md-7 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selecionarTodos" checked>
                            <label class="form-check-label" for="selecionarTodos">Selecionar todos</label>
                        </div>
                    </div>

                    <div class="list-group shadow-sm rounded overflow-auto" style="max-height: 70vh;">
                        <?php
                        $total = 0;
                        foreach ($itens_carrinho as $item):
                            $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
                            $stmt->execute([$item['produto_id']]);
                            $produto = $stmt->fetch(PDO::FETCH_ASSOC);
                            if (!$produto)
                                continue;

                            $imagem = empty($produto['imagem']) ? 'images/default.png' : '../app/models/' . $produto['imagem'];
                            $subtotal = $produto['preco'] * $item['quantidade'];
                            $total += $subtotal;
                            ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3 position-relative item-carrinho"
                                data-subtotal="<?= $subtotal ?>">
                                <div class="form-check position-absolute top-50 start-0 translate-middle-y"
                                    style="margin-left: -1.2rem;">
                                    <input type="checkbox" class="form-check-input seletor-produto"
                                        name="produtos_selecionados[]" value="<?= $item['id'] ?>" checked>
                                </div>

                                <div class="d-flex align-items-center ps-4">
                                    <img src="<?= htmlspecialchars($imagem) ?>" alt="Imagem"
                                        style="width: 50px; height: 50px; object-fit: cover;"
                                        class="rounded me-3 border pe-none">
                                    <div style="min-width: 180px;">
                                        <h6 class="mb-1 text-truncate"><?= htmlspecialchars($produto['nome']) ?></h6>
                                        <small class="text-muted"><?= $item['quantidade'] ?> un. — R$
                                            <?= number_format($produto['preco'], 2, ',', '.') ?></small>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <div class="fw-bold text-dark mb-2">
                                        R$ <?= number_format($subtotal, 2, ',', '.') ?>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger btn-remover-carrinho"
                                        data-id="<?= $item['id'] ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php include 'includes/carrinho/resumo.php'; ?>       

            </div>
        </div>
    </form>
<?php endif; ?>