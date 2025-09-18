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
    $stmtTotal = $conn->prepare("
        SELECT COUNT(*) FROM categorias
        WHERE nome LIKE ?
    ");
    $like = "%$q%";
    $stmtTotal->execute([$like]);
    $totalCategorias = $stmtTotal->fetchColumn();

    $stmt = $conn->prepare("
        SELECT * FROM categorias
        WHERE nome LIKE ?
        ORDER BY nome ASC
        LIMIT :limite OFFSET :offset
    ");
    $stmt = $conn->prepare("
    SELECT * FROM categorias
    WHERE nome LIKE :like
    ORDER BY nome ASC
    LIMIT :limite OFFSET :offset
");
    $stmt->bindValue(':like', "%$q%", PDO::PARAM_STR);
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $stmtTotal = $conn->query("SELECT COUNT(*) FROM categorias");
    $totalCategorias = $stmtTotal->fetchColumn();

    $stmt = $conn->prepare("SELECT * FROM categorias ORDER BY nome ASC LIMIT :limite OFFSET :offset");
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
}

$totalPaginas = ceil($totalCategorias / $limite);

$categoriasRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);
$categoriasComHtml = [];

if (count($categoriasRaw) > 0) {
    ob_start();
    echo '<div class="row">';
    foreach ($categoriasRaw as $categoria) {
        $stmtProd = $conn->prepare("SELECT COUNT(*) FROM produtos WHERE categoria_id = :id");
        $stmtProd->bindValue(':id', $categoria['id'], PDO::PARAM_INT);
        $stmtProd->execute();
        $categoria['total_produtos'] = $stmtProd->fetchColumn();

        echo '<div class="col-12 col-xl-6">';
        include __DIR__ . "/../cards/card_categorias.php";
        echo '</div>';
    }
    echo '</div>';
    $categoriasComHtml[] = ['html' => ob_get_clean()];
}

echo json_encode([
    'categorias' => $categoriasComHtml,
    'totalPaginas' => $totalPaginas
]);
