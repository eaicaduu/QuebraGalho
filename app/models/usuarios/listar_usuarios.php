<?php

require_once '../../config/database.php';

$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 5;
$offset = ($pagina - 1) * $limite;

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM usuarios ORDER BY RAND() LIMIT :limite OFFSET :offset");
$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalStmt = $conn->query("SELECT COUNT(*) FROM usuarios");
$totalUsuarios = $totalStmt->fetchColumn();
$totalPaginas = ceil($totalUsuarios / $limite);
ob_start();
foreach ($usuarios as $usuario) {
    include __DIR__ . "/card_usuarios.php";
}
$html = ob_get_clean();


echo json_encode([
    'html' => $html,
    'totalPaginas' => $totalPaginas,
    'totalUsuarios' => $totalUsuarios
]);
