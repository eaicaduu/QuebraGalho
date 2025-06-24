<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || empty($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID não fornecido']);
    exit;
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $data['id']);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
