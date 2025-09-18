<?php
require_once __DIR__ . '/../../../config/database.php';

header('Content-Type: application/json');

if (!isset($_POST['id'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'ID da categoria não fornecido.']);
    exit;
}

$id = (int) $_POST['id'];

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("DELETE FROM categorias WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['sucesso' => true]);

} catch (Exception $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao excluir a categoria.']);
}
