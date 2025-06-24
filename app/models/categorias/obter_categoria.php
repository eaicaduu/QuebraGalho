<?php
require_once __DIR__ . '/../../config/database.php';
$db = new Database();
$conn = $db->getConnection();

header('Content-Type: application/json');

if (empty($_GET['id'])) {
    echo json_encode(['error' => 'ID da categoria não informado']);
    exit;
}

$id = intval($_GET['id']);

try {

    $stmt = $conn->prepare("SELECT id, nome, oferta FROM categorias WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$categoria) {
        echo json_encode(['error' => 'Categoria não encontrada']);
        exit;
    }


    $stmt = $conn->prepare("
        SELECT p.id, p.nome 
        FROM produtos p
        INNER JOIN categoria_produto cp ON cp.produto_id = p.id
        WHERE cp.categoria_id = :id
    ");
    $stmt->execute([':id' => $id]);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $categoria['produtos'] = $produtos;

    echo json_encode($categoria);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
