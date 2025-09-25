<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID do usuário inválido']);
    exit;
}

$id = intval($_GET['id']);

try {
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao excluir']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
