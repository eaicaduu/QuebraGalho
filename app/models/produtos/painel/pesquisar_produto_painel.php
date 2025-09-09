<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$padrao = isset($_GET['padrao']) ? true : false;
$context = $_GET['context'] ?? 'painel';

if ($q !== '') {
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE nome LIKE ? OR cod_sku LIKE ? ORDER BY id ASC");
    $like = "%$q%";
    $stmt->execute([$like, $like]);
} elseif ($padrao) {
    $stmt = $conn->prepare("SELECT * FROM produtos ORDER BY id ASC LIMIT 5");
    $stmt->execute();
} else {
    $stmt = $conn->prepare("SELECT * FROM produtos ORDER BY id ASC LIMIT 5");
    $stmt->execute();
}

$produtosRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);

$produtosComHtml = [];

foreach ($produtosRaw as $produto) {
    $imagem = $produto['imagem_principal'] ?? '';
    $caminhoImagem = "../../../app/" . $imagem;
    $imagemSrc = (empty($imagem))
        ? "../../../public/images/default.png"
        : $caminhoImagem;
    $produtoUrl = "../../produto.php?id=" . $produto['id'];

    ob_start();
    if ($context === 'painel') {
        include __DIR__ . "/cards/painel_card.php";
    }
    if ($context === 'site') {
        include __DIR__ . "/cards/site_card.php";
    }
    $html = ob_get_clean();

    $produtosComHtml[] = ['html' => $html];
}

echo json_encode(['produtos' => $produtosComHtml]);
