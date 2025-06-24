<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit;
}

require_once '../../config/database.php';
$db = new Database();
$conn = $db->getConnection();

$usuario_id = $_SESSION['usuario_id'];
$produto_id = $_POST['produto_id'] ?? null;

if (!$produto_id) {
    echo json_encode(['success' => false, 'message' => 'Produto inválido.']);
    exit;
}

try {
    $stmt = $conn->prepare("INSERT IGNORE INTO favoritos (usuario_id, produto_id) VALUES (?, ?)");
    $stmt->execute([$usuario_id, $produto_id]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar no banco.']);
}
