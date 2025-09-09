<?php
require_once __DIR__ . '/../../../config/database.php';
header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$padrao = isset($_GET['padrao']) ? true : false;

if ($q !== '') {
    if (is_numeric($q)) {
        $stmt = $conn->prepare("
            SELECT * FROM produtos 
            WHERE id LIKE ? 
               OR cod_sku LIKE ? 
               OR cod_barras LIKE ?
            ORDER BY id ASC
        ");
        $like = "%$q%";
        $stmt->execute([$like, $like, $like]);
    } else {
        if (strlen($q) >= 2) {
            $stmt = $conn->prepare("
                SELECT * FROM produtos 
                WHERE nome LIKE ? 
                   OR marca LIKE ? 
                ORDER BY id ASC
            ");
            $like = "%$q%";
            $stmt->execute([$like, $like]);
        } else {
            $stmt = $conn->prepare("SELECT * FROM produtos ORDER BY id ASC LIMIT 0");
            $stmt->execute();
        }
    }
} elseif ($padrao) {
    $stmt = $conn->prepare("SELECT * FROM produtos LIMIT 5");
    $stmt->execute();
} else {
    $stmt = $conn->prepare("SELECT * FROM produtos LIMIT 5");
    $stmt->execute();
}

$produtosRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);
$produtosComHtml = [];

foreach ($produtosRaw as $produto) {
    $imagem = $produto['imagem_principal'] ?? '';
    $caminhoImagem = "../../../app/uploads/produtos/" . $imagem;
    $imagemSrc = (empty($imagem)) ? "../../../public/images/default.png" : $caminhoImagem;

    ob_start();
    echo '<div class="d-lg-none">';
    include __DIR__ . "/../cards/card_geral_sm.php";
    echo '</div>';

    echo '<div class="d-none d-lg-block">';
    include __DIR__ . "/../cards/card_geral_xl.php";
    echo '</div>';
    $html = ob_get_clean();

    $produtosComHtml[] = ['html' => $html];
}

echo json_encode(['produtos' => $produtosComHtml]);
