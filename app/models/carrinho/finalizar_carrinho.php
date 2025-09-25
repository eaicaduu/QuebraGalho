<?php
session_start();
require_once '../../config/database.php';

header("Content-Type: application/json");

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["sucesso" => false, "mensagem" => "Usuário não logado"]);
    exit;
}

$dados = json_decode(file_get_contents("php://input"), true);

if (empty($dados['itens'])) {
    echo json_encode(["sucesso" => false, "mensagem" => "Carrinho vazio"]);
    exit;
}

try {

    $stmtUpdate = $conn->prepare("UPDATE carrinho SET status = 1 WHERE usuario_id = ? AND status = 0");
    $stmtUpdate->execute([$_SESSION['usuario_id']]);

    echo json_encode(["sucesso" => true]);

} catch (Exception $e) {
    echo json_encode(["sucesso" => false, "mensagem" => $e->getMessage()]);
}
