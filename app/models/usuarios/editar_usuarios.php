<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"), true);

$id    = intval($data['id'] ?? 0);
$nome  = trim($data['nome'] ?? '');
$email = trim($data['email'] ?? '');
$tipo  = intval($data['tipo'] ?? 0);

if ($id <= 0 || empty($nome) || empty($email)) {
    echo json_encode([
        'success' => false,
        'message' => 'Dados inválidos.'
    ]);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE usuarios SET nome = :nome, email = :email, tipo_usuario = :tipo WHERE id = :id");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
