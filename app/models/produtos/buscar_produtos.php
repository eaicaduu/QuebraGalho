<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($q !== '') {
  $stmt = $conn->prepare("SELECT * FROM produtos WHERE nome LIKE ? OR codigo_barras LIKE ? ORDER BY id DESC");
  $like = "%$q%";
  $stmt->execute([$like, $like]);
} else {
  $stmt = $conn->prepare("SELECT * FROM produtos ORDER BY id DESC");
  $stmt->execute();
}

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['produtos' => $produtos]);
exit;
?>
