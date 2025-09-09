<?php
require_once '../../../config/database.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['Nome']) || empty($data['CustoProduto']) || empty($data['Venda'])) {
    echo json_encode(["status" => "erro", "mensagem" => "Campos obrigatórios faltando"]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

try {
    $stmt = $conn->prepare("INSERT INTO calculo (nome, custo_produto, venda, frete, custo_embalagem, custo_marketplace, comissao_mk, imposto) VALUES (:nome, :custo, :venda, :frete, :embalagem, :marketplace, :comissao_mk, :imposto)");
    $stmt->execute([
        ":nome" => $data['Nome'],
        ":custo" => $data['CustoProduto'],
        ":venda" => $data['Venda'],
        ":frete" => $data['Frete'] ?? 0,
        ":embalagem" => $data['CustoEmbalagem'] ?? 0,
        ":marketplace" => $data['CustoMarketplace'] ?? 0,
        ":comissao_mk" => $data['ComissaoMK'] ?? 0,
        ":imposto" => $data['Imposto'] ?? 0
    ]);

    echo json_encode(["status" => "ok"]);
} catch (Exception $e) {
    echo json_encode(["status" => "erro", "mensagem" => $e->getMessage()]);
}
