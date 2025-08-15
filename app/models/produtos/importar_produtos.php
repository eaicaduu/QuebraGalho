<?php

require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/erros_importacao.log');
error_reporting(E_ALL);

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
$falhas = 0;

foreach ($rows as $row) {
    $cols = $row->getElementsByTagName('td');
    if ($cols->length < 9) continue;

    $idRaw = trim($cols->item(0)->nodeValue);
    $id = is_numeric($idRaw) && intval($idRaw) > 0 ? intval($idRaw) : null;

    $codigoBarras = trim($cols->item(1)->nodeValue);
    $nome = ltrim(trim($cols->item(2)->nodeValue), '% ');

    $grupo = trim($cols->item(3)->nodeValue);

    $precoStr = str_replace(',', '.', preg_replace('/[^\d,]/', '', $cols->item(4)->nodeValue));
    $preco = number_format(floatval($precoStr), 2, '.', '');

    $custoStr = str_replace(',', '.', preg_replace('/[^\d,]/', '', $cols->item(5)->nodeValue));
    $custo = number_format(floatval($custoStr), 2, '.', '');

    $quantidade = intval(trim($cols->item(6)->nodeValue));
    $qtd_minima = intval(trim($cols->item(7)->nodeValue));

    $fornecedorNome = trim($cols->item(8)->nodeValue);
    $status = 0;

    // --- BUSCAR OU INSERIR FORNECEDOR ---
    $fornecedorId = null;
    if (!empty($fornecedorNome)) {
        $stmtFornecedor = $conn->prepare("SELECT id FROM fornecedores WHERE nome = ?");
        $stmtFornecedor->execute([$fornecedorNome]);
        $fornecedorId = $stmtFornecedor->fetchColumn();

        if (!$fornecedorId) {
            $stmtInsertFornecedor = $conn->prepare("INSERT INTO fornecedores (nome) VALUES (?)");
            $stmtInsertFornecedor->execute([$fornecedorNome]);
            $fornecedorId = $conn->lastInsertId();
        }
    }

    // --- BUSCAR OU INSERIR CATEGORIA ---
    $categoriaId = null;
    if (!empty($grupo)) {
        $stmtCategoria = $conn->prepare("SELECT id FROM categorias WHERE nome = ?");
        $stmtCategoria->execute([$grupo]);
        $categoriaId = $stmtCategoria->fetchColumn();

        if (!$categoriaId) {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $grupo));
            $stmtInsertCategoria = $conn->prepare("INSERT INTO categorias (nome, slug) VALUES (?, ?)");
            $stmtInsertCategoria->execute([$grupo, $slug]);
            $categoriaId = $conn->lastInsertId();
        }
    }

    // --- INSERIR PRODUTO ---
    try {
        if ($id !== null) {
            $stmt = $conn->prepare("
                INSERT INTO produtos 
                (id, cod_barras, nome, preco, custo, quantidade, quantidade_minima, fornecedor_id, status, categoria_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $params = [$id, $codigoBarras, $nome, $preco, $custo, $quantidade, $qtd_minima, $fornecedorId, $status, $categoriaId];
        } else {
            $stmt = $conn->prepare("
                INSERT INTO produtos 
                (cod_barras, nome, preco, custo, quantidade, quantidade_minima, fornecedor_id, status, categoria_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $params = [$codigoBarras, $nome, $preco, $custo, $quantidade, $qtd_minima, $fornecedorId, $status, $categoriaId];
        }

        if ($stmt->execute($params)) {
            $importados++;
        } else {
            $falhas++;
        }
    } catch (PDOException $e) {
        error_log("Erro ao importar produto: " . $e->getMessage());
        $falhas++;
    }
}

$totalStmt = $conn->query("SELECT COUNT(*) FROM produtos");
$totalProdutos = $totalStmt->fetchColumn();

echo json_encode([
    'success' => true,
    'importados' => $importados,
    'falhas' => $falhas,
    'total' => $totalProdutos
]);
