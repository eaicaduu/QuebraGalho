<div class="container-fluid py-4 ps-lg-4">

    <div class="row g-4">
        <?php include 'includes/menu-desktop.php'; ?>

        <div class="col-12 col-lg-8 mx-auto">
            <div class="card shadow-sm p-4 h-100">

                <?php if (!empty($favoritos)): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($favoritos as $produto): ?>
                            <?php $imagemSrc = (!isset($produto['imagem_principal']) || trim($produto['imagem_principal']) === '')
                                ? "images/default.png"
                                : "../../app/uploads/produtos/" . $produto['imagem_principal'];

                            $produtoUrl = "../produto.php?id=" . $produto['produto_id'];
                            ?>
                            <?php include __DIR__ . "/../../../includes/index/card_produto.php" ?>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted text-center">Você ainda não adicionou produtos aos favoritos.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>