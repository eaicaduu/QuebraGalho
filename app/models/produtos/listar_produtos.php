<?php
require_once __DIR__ . '/../../config/database.php';

$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 5;
$context = $_GET['context'] ?? 'painel';
$offset = ($pagina - 1) * $limite;

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM produtos ORDER BY id ASC LIMIT :limite OFFSET :offset");
$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalStmt = $conn->query("SELECT COUNT(*) FROM produtos");
$totalProdutos = $totalStmt->fetchColumn();
$totalPaginas = ceil($totalProdutos / $limite);
ob_start();
foreach ($produtos as $produto) {
    $imagem = $produto['imagem_principal'] ?? '';
    $caminhoImagem = "../../../app/" . $imagem;
    $imagemSrc = (empty($imagem))
        ? "../../../public/images/default.png"
        : $caminhoImagem;
    $produtoUrl = "../../produto.php?id=" . $produto['id'];

    if ($context === 'painel') {
    include __DIR__ . "/cards/painel_card.php";
    }
    if ($context === 'site') {
    include __DIR__ . "/cards/site_card.php";
    }
}
$html = ob_get_clean();


echo json_encode([
    'html' => $html,
    'totalPaginas' => $totalPaginas,
    'totalProdutos' => $totalProdutos
]);
