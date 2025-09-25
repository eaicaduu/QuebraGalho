<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Não autorizado"]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$carrinho_id = $_POST['carrinho_id'] ?? null;
$action = $_POST['action'] ?? null;

if (!$carrinho_id || !$action) {
    http_response_code(400);
    echo json_encode(["error" => "Dados inválidos"]);
    exit;
}

$stmt = $conn->prepare("
    SELECT c.quantidade, p.quantidade AS quantidade_produto 
    FROM carrinho c 
    INNER JOIN produtos p ON c.produto_id = p.id
    WHERE c.id = ?
");
$stmt->execute([$carrinho_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    http_response_code(404);
    echo json_encode(["error" => "Item não encontrado"]);
    exit;
}

$novaQuantidade = $item['quantidade'];

if ($action === "increment" && $item['quantidade'] < $item['quantidade_produto']) {
    $novaQuantidade++;
} elseif ($action === "decrement" && $item['quantidade'] > 1) {
    $novaQuantidade--;
}

// Atualiza no banco
$stmt = $conn->prepare("UPDATE carrinho SET quantidade = ? WHERE id = ?");
$stmt->execute([$novaQuantidade, $carrinho_id]);

echo json_encode([
    "quantidade" => $novaQuantidade,
    "max" => $item['quantidade_produto']
]);
