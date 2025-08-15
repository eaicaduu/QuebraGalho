<?php
session_start();

require_once '../../config/database.php';
$db = new Database();
$conn = $db->getConnection();

$usuario_id = $_SESSION['usuario_id'] ?? null;
$produto_id = $_POST['produto_id'] ?? null;

if (!$usuario_id) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit;
}

if (!$produto_id) {
    echo json_encode(['success' => false, 'message' => 'Produto inválido.']);
    exit;
}

try {
    $stmt = $conn->prepare("DELETE FROM favoritos WHERE usuario_id = ? AND produto_id = ?");
    $stmt->execute([$usuario_id, $produto_id]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao remover favorito.']);
}
