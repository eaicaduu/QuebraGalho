<?php
require_once __DIR__ . '/../../../config/database.php';

header("Content-Type: application/json");

try {
    $dados = json_decode(file_get_contents("php://input"), true);

    if (!isset($dados['modo_site'])) {
        echo json_encode(["sucesso" => false, "mensagem" => "Dados inválidos"]);
        exit;
    }

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("UPDATE configuracao SET modo_site = :modo_site");
    $stmt->execute([':modo_site' => (int)$dados['modo_site']]);

    echo json_encode(["sucesso" => true]);
} catch (Exception $e) {
    echo json_encode(["sucesso" => false, "mensagem" => $e->getMessage()]);
}
