<div class="card mb-3 shadow-sm">
    <div class="card-body p-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-2">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <?php
                $badgeClass = 'bg-secondary';
                switch (strtolower($pedido['plataforma'])) {
                    case 'mercado livre':
                        $badgeClass = 'bg-warning text-dark';
                        break;
                    case 'shopee':
                        $badgeClass = 'bg-danger';
                        break;
                    case 'amazon':
                        $badgeClass = 'bg-primary';
                        break;
                    case 'ecommerce':
                        $badgeClass = 'bg-dark';
                        break;
                }
                ?>
                <span class="badge <?= $badgeClass ?> me-2">
                    <?= htmlspecialchars($pedido['plataforma']) ?>
                </span>
                <strong>#<?= htmlspecialchars($pedido['order_id']) ?></strong>
            </div>
            <div class="text-md-end">
                <span class="d-block"><strong>Status:</strong> <?= htmlspecialchars($pedido['status']) ?></span>
            </div>
        </div>
        <div class="mb-2">
            <span class="d-block"><strong>Cliente:</strong> <?= htmlspecialchars($pedido['cliente']) ?></span>
            <span class="d-block"><strong>Produto:</strong> <?= htmlspecialchars($pedido['produto_nome']) ?></span>
            <small class="text-muted">
                Quantidade: <?= htmlspecialchars($pedido['quantidade']) ?>
            </small>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="mb-2 mb-md-0">
                <small><strong>Entrega:</strong> <?= htmlspecialchars($pedido['data_entrega'] ?? '-') ?></small>
            </div>
            <div>
                <button class="btn btn-sm btn-primary ver-detalhes"
                    data-pedido='<?= htmlspecialchars(json_encode($pedido, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, "UTF-8") ?>'>
                    Mais detalhes
                </button>
                <a href="../../../app/models/pedidos/emitir_nfc-e.php?identificador_envio=<?= urlencode($pedido['identificador_envio']) ?>&plataforma=<?= urlencode($pedido['plataforma']) ?>"
                    target="_blank" class="btn btn-sm btn-primary">
                    Emitir NFC-e
                </a>
                <a href="../../../app/models/pedidos/emitir_etiqueta.php?identificador_envio=<?= urlencode($pedido['identificador_envio']) ?>&plataforma=<?= urlencode($pedido['plataforma']) ?>"
                    target="_blank" class="btn btn-sm btn-primary">
                    Imprimir Etiqueta
                </a>
            </div>
        </div>
    </div>
</div>