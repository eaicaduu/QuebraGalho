<div class="container my-4">
    <h2 class="mb-4"><i class="bi bi-graph-up"></i> Relatórios de Vendas</h2>

    <!-- Filtros -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="data_inicio" class="form-label">Data Início</label>
            <input type="date" name="data_inicio" id="data_inicio" class="form-control" value="<?= $dataInicio ?>">
        </div>
        <div class="col-md-3">
            <label for="data_fim" class="form-label">Data Fim</label>
            <input type="date" name="data_fim" id="data_fim" class="form-control" value="<?= $dataFim ?>">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Gerar
            </button>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <a href="#" 
               class="btn btn-success w-100">
                <i class="bi bi-file-earmark-excel"></i> Exportar Excel
            </a>
        </div>
    </form>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">Total de Vendas</h5>
                    <p class="display-6"><?= $resumo['total_vendas'] ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">Receita Total</h5>
                    <p class="display-6 text-success">R$ <?= number_format($resumo['total_receita'] ?? 0, 2, ',', '.') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalhamento -->
    <div class="table-responsive shadow-sm">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th>Produto</th>
                    <th>Qtd</th>
                    <th>Preço Unit.</th>
                    <th>Total Venda</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($vendas): ?>
                    <?php foreach ($vendas as $v): ?>
                        <tr>
                            <td><?= $v['id'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($v['data_venda'])) ?></td>
                            <td><?= htmlspecialchars($v['cliente']) ?></td>
                            <td><?= htmlspecialchars($v['produto']) ?></td>
                            <td><?= $v['quantidade'] ?></td>
                            <td>R$ <?= number_format($v['preco_unitario'], 2, ',', '.') ?></td>
                            <td><strong>R$ <?= number_format($v['valor_total'], 2, ',', '.') ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">Nenhuma venda encontrada nesse período.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
