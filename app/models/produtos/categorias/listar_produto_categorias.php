<?php
require_once __DIR__ . '/../../../config/database.php';

$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 5;
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
foreach ($categorias as $categoria) {

    include __DIR__ . "/../cards/card_categorias.php";
}
$html = ob_get_clean();


echo json_encode([
    'html' => $html,
    'totalPaginas' => $totalPaginas
]);
