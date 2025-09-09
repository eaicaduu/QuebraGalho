<?php
require_once '../../../config/database.php';
header('Content-Type: application/json; charset=utf-8');

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT * FROM produtos_ml ORDER BY last_update DESC");
$produtos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalProdutos = count($produtos_db);

ob_start();

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
    $preco = number_format($produto['price'] ?? 0, 2, ',', '.');
    $statusAtivo = $unidades > 0 ? 'Ativo' : 'Indisponível';

    echo '<div class="d-lg-none">';
    include __DIR__ . "/../painel/card_produto_sm.php";
    echo '</div>';

    echo '<div class="d-none d-lg-block">';
    include __DIR__ . "/../painel/card_produto_lg.php";
    echo '</div>';
}

$html = ob_get_clean();

echo json_encode([
    'html' => $html,
    'total' => $totalProdutos
]);
