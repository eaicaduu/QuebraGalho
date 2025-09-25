<section class="container-fluid bg-white py-4 d-flex justify-content-center align-items-center" id="produtos">
    <div class="row" style="width:100%">
        <?php if (!empty($destaques)): ?>
            <?php foreach ($destaques as $produto): ?>
                <?php
                $imagemSrc = (!isset($produto['imagem_principal']) || trim($produto['imagem_principal']) === '')
                    ? "images/default.png"
                    : "../app/uploads/produtos/" . $produto['imagem_principal'];
                $produtoUrl = "produto.php?id=" . $produto['id'];
                ?>
                <?php include 'card_produto.php'; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Nenhum destaque ativo.</p>
            </div>
        <?php endif; ?>
    </div>
</section>