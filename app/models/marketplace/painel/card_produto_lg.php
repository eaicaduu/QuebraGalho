<div class="card mb-4 shadow-sm p-4 w-100">

  <!-- Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
    <div class="d-flex flex-wrap align-items-center gap-2">
      <span class="badge bg-warning text-dark me-1">ML</span>
      <span class="badge <?php echo ($statusAtivo === 'Ativo' ? 'bg-success' : 'bg-secondary'); ?>">
        <?php echo $statusAtivo; ?>
      </span>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
      <strong>ID:</strong> <?php echo $produtoId; ?>
      <strong class="ms-2">SKU:</strong> <?php echo htmlspecialchars($produto['seller_sku'] ?? 'N/A'); ?>
    </div>
  </div>

  <!-- Corpo -->
  <div class="d-flex align-items-center">
    <?php echo $linkInicio; ?>
      <img src="<?php echo $imagemSrc; ?>" 
           alt="<?php echo htmlspecialchars($nomeProduto); ?>" 
           class="rounded pe-none" 
           style="width: 150px; height: 150px; object-fit: contain;">
    <?php echo $linkFim; ?>

    <h5 class="ms-4 mb-0">
      <?php echo $linkInicio; ?>
      <span class="text-decoration-none"><?php echo $nomeProduto; ?></span>
      <?php echo $linkFim; ?>
    </h5>
  </div>

</div>
