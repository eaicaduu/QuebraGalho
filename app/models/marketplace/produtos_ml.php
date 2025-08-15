<?php
require_once '../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT * FROM produtos_ml ORDER BY last_update DESC");
$produtos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($produtos_db as $produto) {
    $imagem = $produto['thumbnail'] ?? '';
    $imagemSrc = empty($imagem) ? "../../../public/images/default.png" : $imagem;
    $sku = $produto['seller_sku'] ?? null;
    if ($sku && $sku !== 'N/A') {
        $produtoUrl = "../../produto.php?id=" . urlencode($sku);
        $linkInicio = "<a class='text-decoration-none text-dark' href='$produtoUrl'>";
        $linkFim = "</a>";
    } else {
        $linkInicio = '<span class="text-dark">';
        $linkFim = '</span>';
    }
    $nomeProduto = htmlspecialchars($produto['title'] ?? 'Produto sem nome');
    $produtoId = htmlspecialchars($produto['id'] ?? 'N/A');
    $unidades = (int) ($produto['available_quantity'] ?? 0);
    $vendidas = (int) ($produto['sold_quantity'] ?? 0);
    $preco = number_format($produto['price'] ?? 0, 2, ',', '.');
    $currencyId = htmlspecialchars($produto['currency_id'] ?? '');
    $statusAtivo = $unidades > 0 ? 'Ativo' : 'Indisponível';
    $startTime = !empty($produto['start_time']) ? date('d/m/Y H:i', strtotime($produto['start_time'])) : 'N/A';
    $stopTime = !empty($produto['stop_time']) ? date('d/m/Y H:i', strtotime($produto['stop_time'])) : 'N/A';
    $condition = htmlspecialchars($produto['condition'] ?? 'N/A');
    $warranty = htmlspecialchars($produto['warranty'] ?? 'N/A');
    $domainId = htmlspecialchars($produto['domain_id'] ?? 'N/A');
    $catalogProductId = htmlspecialchars($produto['catalog_product_id'] ?? 'N/A');
    $sellerId = htmlspecialchars($produto['seller_id'] ?? 'N/A');
    $sellerPowerStatus = htmlspecialchars($produto['seller_power_seller_status'] ?? 'N/A');
    $sellerRegistrationDate = !empty($produto['seller_registration_date']) ? date('d/m/Y', strtotime($produto['seller_registration_date'])) : 'N/A';
    $acceptsMercadoPago = !empty($produto['accepts_mercadopago']) ? 'Sim' : 'Não';
    $lastUpdate = !empty($produto['last_update']) ? date('d/m/Y H:i', strtotime($produto['last_update'])) : 'N/A';

    $tarifaVenda = ($produto['price'] ?? 0) * 0.12;
    $tarifaAdicional = 6.75;
    $aPagar = $tarifaVenda + $tarifaAdicional;

    echo "
<div class='card mb-4 shadow-sm p-4'>

  <!-- Cabeçalho do Card -->
    <div class='d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2'
    style='width: 100%'>
    <div class='d-flex flex-wrap align-items-center gap-2'>
        <span class='badge bg-warning text-dark me-1'>ML</span>
        <span class='badge me-1 bg-" . ($statusAtivo === 'Ativo' ? "success" : "secondary") . "'>$statusAtivo</span>
        </div>
        <div class'd-flex flex-wrap gap-2 align-items-center '>
        <strong>ID:</strong> $produtoId 
        <strong class='ms-2'>SKU:</strong> " . htmlspecialchars($produto['seller_sku'] ?? 'N/A') . "
        </div>
  </div>

  <!-- Corpo do Card -->
<div class='d-flex align-items-center' style='max-width: 400px;'>
    $linkInicio
      <img src='$imagemSrc' alt='$nomeProduto' 
           class='rounded pe-none' 
           style='width: 150px; height: 150px; object-fit: contain;'>
    $linkFim
    <h5 class='ms-4 mb-0'>
      $linkInicio
        <span class='text-decoration-none'>$nomeProduto</span>
      $linkFim
    </h5>
  </div>

  
</div>
";

}
