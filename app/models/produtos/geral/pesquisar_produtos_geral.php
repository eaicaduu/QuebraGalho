<?php
require_once __DIR__ . '/../../../config/database.php';
header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 10;
$offset = ($pagina - 1) * $limite;

if ($q !== '') {
    if (is_numeric($q)) {
        $stmtTotal = $conn->prepare("
            SELECT COUNT(*) FROM produtos 
            WHERE id = :id OR cod_sku LIKE :like OR cod_barras LIKE :like
        ");
        $stmtTotal->bindValue(':id', $q, PDO::PARAM_INT);
        $stmtTotal->bindValue(':like', "%$q%", PDO::PARAM_STR);
        $stmtTotal->execute();
        $totalProdutos = $stmtTotal->fetchColumn();

        $stmt = $conn->prepare("
    SELECT * FROM produtos 
    WHERE id = :id OR cod_sku LIKE :like OR cod_barras LIKE :like
    ORDER BY id ASC
    LIMIT :limite OFFSET :offset
");
        $stmt->bindValue(':id', $q, PDO::PARAM_INT);
        $stmt->bindValue(':like', "%$q%", PDO::PARAM_STR);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmtTotal = $conn->prepare("
            SELECT COUNT(*) FROM produtos 
            WHERE nome LIKE :q OR marca LIKE :q
        ");
        $stmtTotal->bindValue(':q', "%$q%", PDO::PARAM_STR);
        $stmtTotal->execute();
        $totalProdutos = $stmtTotal->fetchColumn();

        $stmt = $conn->prepare("
    SELECT * FROM produtos 
    WHERE nome LIKE :q OR marca LIKE :q
    ORDER BY id ASC
    LIMIT :limite OFFSET :offset
");
        $stmt->bindValue(':q', "%$q%", PDO::PARAM_STR);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
    }
} else {
    $stmtTotal = $conn->query("SELECT COUNT(*) FROM produtos");
    $totalProdutos = $stmtTotal->fetchColumn();

    $stmt = $conn->prepare("SELECT * FROM produtos ORDER BY RAND() LIMIT :limite OFFSET :offset");
}

$totalPaginas = ceil($totalProdutos / $limite);

$produtosRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);
$produtosComHtml = [];

if (count($produtosRaw) > 0) {
    ob_start();
    foreach ($produtosRaw as $produto) {
        $imagem = $produto['imagem_principal'] ?? '';
        $caminhoImagem = "../../../app/uploads/produtos/" . $imagem;
        $imagemSrc = (empty($imagem)) ? "../../../public/images/default.png" : $caminhoImagem;

        echo '<div class="d-lg-none">';
        include __DIR__ . "/../cards/card_geral_sm.php";
        echo '</div>';

        echo '<div class="d-none d-lg-block">';
        include __DIR__ . "/../cards/card_geral_xl.php";
        echo '</div>';
    }
    $produtosComHtml[] = ['html' => ob_get_clean()];
}

echo json_encode([
    'produtos' => $produtosComHtml,
    'totalPaginas' => $totalPaginas
]);
