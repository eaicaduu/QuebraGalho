<?php
require_once __DIR__ . '/../../../config/database.php';

$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 5;
$offset = ($pagina - 1) * $limite;

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM produtos LIMIT :limite OFFSET :offset");
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
    $caminhoImagem = "../../../app/uploads/produtos/" . $imagem;
    $imagemSrc = (empty($imagem))
        ? "../../../public/images/default.png"
        : $caminhoImagem;

    $stmtMidias = $conn->prepare("SELECT * FROM produtos_imagens WHERE produto_id = ? ORDER BY ordem ASC, id ASC");
    $stmtMidias->execute([$produto['id']]);
    $produto['midias'] = $stmtMidias->fetchAll(PDO::FETCH_ASSOC);

    include __DIR__ . "/../cards/card_imagens.php";
}
$html = ob_get_clean();


echo json_encode([
    'html' => $html,
    'totalPaginas' => $totalPaginas
]);
