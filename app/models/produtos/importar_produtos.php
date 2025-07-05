<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Arquivo inválido.']);
    exit;
}

$dom = new DOMDocument();
libxml_use_internal_errors(true);

$htmlContent = file_get_contents($_FILES['arquivo']['tmp_name']);
$dom->loadHTML($htmlContent);
libxml_clear_errors();

$rows = $dom->getElementsByTagName('tr');

$db = new Database();
$conn = $db->getConnection();

$importados = 0;

foreach ($rows as $row) {
    $cols = $row->getElementsByTagName('td');
    if ($cols->length < 5) continue;

    $id = intval(trim($cols->item(0)->nodeValue)); 
    $codigoBarras = trim($cols->item(1)->nodeValue);
    $nome = trim($cols->item(2)->nodeValue); 

    $precoStr = str_replace(',', '.', preg_replace('/[^\d,]/', '', $cols->item(3)->nodeValue));
    $preco = number_format(floatval($precoStr), 2, '.', '');

    $quantidade = intval(trim($cols->item(4)->nodeValue));

    $descricao = '';
    $fornecedor = '';
    $status = 1;

    $stmt = $conn->prepare("
        INSERT INTO produtos (id, codigo_barras, nome, preco, descricao, quantidade, fornecedor, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if ($stmt->execute([$id, $codigoBarras, $nome, $preco, $descricao, $quantidade, $fornecedor, $status])) {
        $importados++;
    }
}

echo json_encode(['success' => true, 'importados' => $importados]);