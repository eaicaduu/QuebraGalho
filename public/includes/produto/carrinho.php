<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCarrinho" aria-labelledby="offcanvasCarrinhoLabel">
  <div class="offcanvas-header">
    <button type="button" class="btn btn-link p-0 text-dark" data-bs-dismiss="offcanvas" aria-label="Fechar" style="font-size: 1.5rem;">
      <i class="bi bi-x"></i>
    </button>
  </div>

  <div class="offcanvas-body d-flex flex-column p-3">
    <?php
    if (!empty($carrinho)) {
      $ultimo_item = end($carrinho);

      $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
      $stmt->execute([$ultimo_item['produto_id']]);
      $produto = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($produto) {
        $imagem = (!isset($produto['imagem']) || trim($produto['imagem']) === '')
          ? "images/default.png"
          : "../app/models/" . $produto['imagem'];
    ?>
        <div class="d-flex align-items-center border rounded p-2 shadow-sm mb-4 bg-light">
          <div class="position-relative me-3">
            <img src="<?= htmlspecialchars($imagem) ?>" alt="Produto"
              class="rounded-circle border border-2 border-success pe-none"
              style="width: 50px; height: 50px; object-fit: cover;">
            <span class="position-absolute bottom-0 end-0 translate-middle p-1 bg-success rounded-circle border border-light"
              style="width: 18px; height: 18px;">
              <i class="bi bi-check2 text-white" style="font-size: 0.75rem;"></i>
            </span>
          </div>
          <div class="flex-grow-1">
            <strong class="text-success d-block">Adicionado ao carrinho</strong>
            <span class="text-dark d-block text-truncate" style="max-width: 180px;">
              <?= htmlspecialchars($produto['nome']) ?>
            </span>
            <small class="text-muted"><?= $ultimo_item['quantidade'] ?> unidade<?= $ultimo_item['quantidade'] > 1 ? 's' : '' ?></small>
          </div>
        </div>

        <h6 class="text-secondary mb-2">Produtos Relacionados</h6>
        <div class="row row-cols-2 g-2 mb-4">
          <?php
          $stmtCat = $conn->prepare("SELECT categoria_id FROM categoria_produto WHERE produto_id = ?");
          $stmtCat->execute([$produto['id']]);
          $categorias = $stmtCat->fetchAll(PDO::FETCH_COLUMN);

          $relacionados = [];

          if (!empty($categorias)) {
            $placeholders = implode(',', array_fill(0, count($categorias), '?'));
            $params = [...$categorias, $produto['id']];

            $sqlRelacionados = "
              SELECT DISTINCT p.* FROM produtos p
              INNER JOIN categoria_produto cp ON cp.produto_id = p.id
              WHERE cp.categoria_id IN ($placeholders)
              AND p.id != ?
              LIMIT 4
            ";

            $stmtRelacionados = $conn->prepare($sqlRelacionados);
            $stmtRelacionados->execute($params);
            $relacionados = $stmtRelacionados->fetchAll(PDO::FETCH_ASSOC);
          }

          if (empty($relacionados)) {
          ?>
            <div class="col-12">
              <div class="alert alert-info text-center w-100">
                Nenhum produto relacionado encontrado.
              </div>
            </div>
          <?php
          } else {
            foreach ($relacionados as $rel) {
              $imgRel = (!isset($rel['imagem']) || trim($rel['imagem']) === '')
                ? "images/default.png"
                : "../app/models/" . $rel['imagem'];
          ?>
              <div class="col">
                <a href="produto.php?id=<?= $rel['id'] ?>" class="text-decoration-none text-dark">
                  <div class="card h-100 border-0 shadow-sm">
                    <img src="<?= htmlspecialchars($imgRel) ?>" class="card-img-top pe-none"
                      alt="<?= htmlspecialchars($rel['nome']) ?>" style="height: 100px; object-fit: cover;">
                    <div class="card-body p-2">
                      <h6 class="card-title text-truncate mb-1" title="<?= htmlspecialchars($rel['nome']) ?>">
                        <?= htmlspecialchars($rel['nome']) ?>
                      </h6>
                      <div class="d-flex justify-content-between small">
                        <small class="text-muted">R$ <?= number_format($rel['preco'], 2, ',', '.') ?></small>
                        <small class="text-muted">Cód: <?= $rel['id'] ?></small>
                      </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-2">
                      <button type="button" class="btn btn-sm btn-success w-100 btn-carrinho" data-id="<?= $rel['id'] ?>"
                        onclick="event.stopPropagation(); event.preventDefault();">
                        <i class="bi bi-cart-plus me-1"></i> Adicionar
                      </button>
                    </div>
                  </div>
                </a>
              </div>
          <?php
            }
          }
          ?>
        </div>
    <?php
      }
    } 
    ?>
  </div>

  <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-white shadow-lg border-top">
    <div class="d-grid gap-2">
      <button class="btn btn-success" data-bs-dismiss="offcanvas">
        <i class="bi bi-shop-window me-1"></i> Continuar Comprando
      </button>
      <a href="carrinho.php" class="btn btn-primary fw-semibold">
        <i class="bi bi-cart-check me-1"></i> Ir para Carrinho
      </a>
    </div>
  </div>
</div>
