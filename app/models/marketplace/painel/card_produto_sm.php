<div class="card mb-3 shadow-sm p-2 w-100">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-2">
    <div class="d-flex flex-wrap align-items-center gap-1">
      <span class="badge bg-warning text-dark">ML</span>
      <span class="badge <?php echo ($statusAtivo === 'Ativo' ? 'bg-success' : 'bg-secondary'); ?>">
        <?php echo $statusAtivo; ?>
      </span>
    </div>
    <small><strong>ID:</strong> <?php echo $produtoId; ?></small>
  </div>

  <!-- Corpo -->
  <div class="d-flex align-items-center">
    <?php echo $linkInicio; ?>
      <img src="<?php echo $imagemSrc; ?>" 
           alt="<?php echo htmlspecialchars($nomeProduto); ?>" 
           class="rounded pe-none" 
           style="width: 80px; height: 80px; object-fit: contain;">
    <?php echo $linkFim; ?>

    <div class="ms-3">
      <h6 class="mb-1">
        <?php echo $linkInicio; ?>
        <span class="text-decoration-none"><?php echo $nomeProduto; ?></span>
        <?php echo $linkFim; ?>
      </h6>
      <small><strong>SKU:</strong> <?php echo htmlspecialchars($produto['seller_sku'] ?? 'N/A'); ?></small>
    </div>
  </div>

</div>
