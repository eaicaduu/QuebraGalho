<?php
session_start();
require_once '../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

$usuario_id = $_SESSION['usuario_id'] ?? null;
$produto_id = $_POST['produto_id'] ?? null;
$quantidade = isset($_POST['quantidade']) ? (int) $_POST['quantidade'] : 1;

if (!$usuario_id) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não autenticado.']);
    exit;
}

if (!$produto_id) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Produto inválido.']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT id, quantidade FROM carrinho WHERE usuario_id = ? AND produto_id = ? AND status = 0");
    $stmt->execute([$usuario_id, $produto_id]);
    $itemExistente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($itemExistente) {
        $novaQuantidade = $itemExistente['quantidade'] + $quantidade;
        $stmt = $conn->prepare("UPDATE carrinho SET quantidade = ? WHERE id = ?");
        $stmt->execute([$novaQuantidade, $itemExistente['id']]);
    } else {
        $stmt = $conn->prepare("INSERT INTO carrinho (usuario_id, produto_id, quantidade, status) VALUES (?, ?, ?, 0)");
        $stmt->execute([$usuario_id, $produto_id, $quantidade]);
    }

    $stmt = $conn->prepare("SELECT SUM(quantidade) FROM carrinho WHERE usuario_id = ? AND status = 0");
    $stmt->execute([$usuario_id]);
    $total = (int) $stmt->fetchColumn();

    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Produto adicionado ao carrinho!',
        'total' => $total
    ]);
} catch (Exception $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar o carrinho.']);
}
