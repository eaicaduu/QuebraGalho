<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida']);
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID do produto inválido']);
    exit;
}

$id = intval($_GET['id']);

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmtSelect = $conn->prepare("SELECT imagem FROM produtos WHERE id = :id");
    $stmtSelect->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtSelect->execute();
    $produto = $stmtSelect->fetch(PDO::FETCH_ASSOC);

    if ($produto && !empty($produto['imagem'])) {
        $caminhoImagem = __DIR__ . '/../' . $produto['imagem'];
        if (file_exists($caminhoImagem)) {
            @unlink($caminhoImagem);
        }
    }

    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao excluir o produto']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
