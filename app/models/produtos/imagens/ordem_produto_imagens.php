<?php
require_once __DIR__ . '/../../../config/database.php';
header('Content-Type: application/json');

$produtoId = $_POST['produto_id'] ?? null;
$ordem = json_decode($_POST['ordem'] ?? '[]', true);

if (!$produtoId || !$ordem) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

try {
    foreach ($ordem as $posicao => $midiaId) {
        $stmt = $conn->prepare("UPDATE produtos_imagens SET ordem = :ordem WHERE id = :id AND produto_id = :produto_id");
        $stmt->execute([
            ':ordem' => $posicao + 1,
            ':id' => $midiaId,
            ':produto_id' => $produtoId
        ]);
    }
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
