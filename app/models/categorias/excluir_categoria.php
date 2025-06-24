<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

if (empty($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID da categoria não informado']);
    exit;
}

$id = intval($_POST['id']);

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("DELETE FROM categoria_produto WHERE categoria_id = :id");
    $stmt->execute([':id' => $id]);

    $stmt = $conn->prepare("DELETE FROM categorias WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Categoria excluída com sucesso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Categoria não encontrada']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
