<?php
require_once __DIR__ . '/../../../config/database.php';

$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 10;
$offset = ($pagina - 1) * $limite;

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM categorias ORDER BY RAND() LIMIT :limite OFFSET :offset");
$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalStmt = $conn->query("SELECT COUNT(*) FROM categorias");
$totalCategorias = $totalStmt->fetchColumn();
$totalPaginas = ceil($totalCategorias / $limite);
ob_start();
echo '<div class="row">';

foreach ($categorias as $categoria) {
    $stmtProd = $conn->prepare("SELECT COUNT(*) FROM produtos WHERE categoria_id = :id");
    $stmtProd->bindValue(':id', $categoria['id'], PDO::PARAM_INT);
    $stmtProd->execute();
    $categoria['total_produtos'] = $stmtProd->fetchColumn();

    echo '<div class="col-12 col-xl-6">';
    include __DIR__ . "/../cards/card_categorias.php";
    echo '</div>';
}

echo '</div>';
$html = ob_get_clean();


echo json_encode([
    'html' => $html,
    'totalPaginas' => $totalPaginas
]);
