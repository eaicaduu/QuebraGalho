<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

$nome = $_POST['nome'] ?? '';
$produtos = $_POST['produtos'] ?? [];
$oferta = $_POST['oferta'] ?? null;
$id = $_POST['id'] ?? null;

if (!$nome || empty($produtos)) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos.']);
    exit;
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    if ($id) {
        $stmt = $conn->prepare("UPDATE categorias SET nome = ?, oferta = ? WHERE id = ?");
        $stmt->execute([$nome, $oferta, $id]);

        $stmt = $conn->prepare("DELETE FROM categoria_produto WHERE categoria_id = ?");
        $stmt->execute([$id]);

        $categoria_id = $id;

    } else {
        $stmt = $conn->prepare("INSERT INTO categorias (nome, oferta) VALUES (?, ?)");
        $stmt->execute([$nome, $oferta]);
        $categoria_id = $conn->lastInsertId();
    }

    $stmt = $conn->prepare("INSERT INTO categoria_produto (categoria_id, produto_id) VALUES (?, ?)");
    foreach ($produtos as $produto_id) {
        $stmt->execute([$categoria_id, $produto_id]);
    }

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
