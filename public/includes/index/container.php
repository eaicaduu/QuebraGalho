<div class="container">
    <h1 class="text-center mb-4">Nossos Produtos</h1>

    <div class="row">
        <?php if (!empty($products)): ?>
        <?php foreach($products as $produto): ?>
        <div class="col-md-4 mb-4">
            <div class="card product-card h-100 shadow-sm">
                <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" class="card-img-top"
                    alt="<?php echo htmlspecialchars($produto['nome']); ?>">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                    <p class="text-success fw-bold">
                        R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                    </p>

                    <a href="#" class="btn btn-primary mt-auto">Adicionar ao Carrinho</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="col-12">
            <p class="text-center">Nenhum produto cadastrado ainda.</p>
        </div>
        <?php endif; ?>
    </div>
</div>