<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || empty($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("UPDATE usuarios SET nome = :nome, email = :email, tipo_usuario = :tipo_usuario WHERE id = :id");
    $stmt->bindParam(':nome', $data['nome']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':tipo_usuario', $data['tipo']);
    $stmt->bindParam(':id', $data['id']);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
