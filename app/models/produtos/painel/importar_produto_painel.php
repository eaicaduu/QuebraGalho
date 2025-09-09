<?php
set_time_limit(0);
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/importar/importar_fornecedor.php';
require_once __DIR__ . '/importar/importar_categorias.php';
header('Content-Type: application/json');

//CASO DER ERROS
//$logFile = __DIR__ . '/importar_erros.log';
//ini_set("log_errors", 1);
//ini_set("error_log", $logFile);

$db = new Database();
$conn = $db->getConnection();

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
if ($rows->length === 0) {
    echo json_encode(['success' => false, 'message' => 'Nenhuma linha encontrada no arquivo.']);
    exit;
}

$existentes = [];
$stmtAll = $conn->query("SELECT cod_sku, cod_barras, cod_ref, nome, observacao, preco, preco_pj, custo, ult_compra, quantidade, quantidade_minima, localizacao, un_medida, data_validade, ibpt, ncm, cest, cfop, icms, ipi, pis, cofins FROM produtos");
while ($row = $stmtAll->fetch(PDO::FETCH_ASSOC)) {
    $existentes[] = $row;
}

$categorias = [];
$stmtCat = $conn->query("SELECT id, nome FROM categorias");
while ($row = $stmtCat->fetch(PDO::FETCH_ASSOC)) {
    $categorias[strtolower($row['nome'])] = $row['id'];
}

$fornecedores = [];
$stmtForn = $conn->query("SELECT id, nome FROM fornecedores");
while ($row = $stmtForn->fetch(PDO::FETCH_ASSOC)) {
    $fornecedores[strtolower($row['nome'])] = $row['id'];
}

function getIdFromName(array $array, string $name, PDO $conn, string $table)
{
    $key = strtolower($name);
    if (!empty($array[$key]))
        return $array[$key];

    $stmt = $conn->prepare("INSERT INTO $table (nome) VALUES (:nome)");
    $stmt->execute([':nome' => $name]);
    $id = $conn->lastInsertId();
    $array[$key] = $id;
    return $id;
}

$importados = 0;
$atualizados = 0;
$falhas = 0;

foreach ($rows as $row) {
    $cols = $row->getElementsByTagName('td');
    if ($cols->length === 0)
        continue;

    $codsku = trim($cols->item(0)->nodeValue ?? '');
    $codBarras = trim($cols->item(1)->nodeValue ?? '');
    $nome = ltrim(trim($cols->item(2)->nodeValue ?? ''), '% ');
    $grupo = trim($cols->item(3)->nodeValue ?? '');
    $medida = trim($cols->item(4)->nodeValue ?? '');
    $preco = floatval(str_replace(',', '.', preg_replace('/[^\d,]/', '', $cols->item(5)->nodeValue ?? '0')));
    $custo = floatval(str_replace(',', '.', preg_replace('/[^\d,]/', '', $cols->item(7)->nodeValue ?? '0')));
    $ultimaCompra = trim($cols->item(8)->nodeValue ?? '');
    $quantidade = intval(trim($cols->item(10)->nodeValue ?? '0'));
    $qtd_minima = intval(trim($cols->item(11)->nodeValue ?? '0'));
    $codref = intval(trim($cols->item(17)->nodeValue ?? '0'));
    $localEstoque = intval(trim($cols->item(18)->nodeValue ?? '0'));
    $dataValidade = trim($cols->item(19)->nodeValue ?? '');
    $precoPJ = floatval(str_replace(',', '.', preg_replace('/[^\d,]/', '', $cols->item(20)->nodeValue ?? '0')));
    $observacao = trim($cols->item(21)->nodeValue ?? '');
    $fornecedor = trim($cols->item(26)->nodeValue ?? '');
    $ibpt = trim($cols->item(27)->nodeValue ?? '');
    $icms = trim($cols->item(33)->nodeValue ?? '');
    $ipi = trim($cols->item(34)->nodeValue ?? '');
    $pisE = trim($cols->item(38)->nodeValue ?? '');
    $cofinsE = trim($cols->item(39)->nodeValue ?? '');
    $ncm = trim($cols->item(43)->nodeValue ?? '');
    $cest = trim($cols->item(44)->nodeValue ?? '');
    $cfop = trim($cols->item(45)->nodeValue ?? '');

    $categoriaId = getIdFromName($categorias, $grupo, $conn, 'categorias');
    $fornecedorId = getIdFromName($fornecedores, $fornecedor, $conn, 'fornecedores');

    $data = [
        'cod_barras' => $codBarras,
        'cod_sku' => $codsku,
        'cod_ref' => $codref,
        'nome' => $nome,
        'observacao' => $observacao,
        'categoria_id' => $categoriaId,
        'preco' => $preco,
        'preco_pj' => $precoPJ,
        'custo' => $custo,
        'ult_compra' => $ultimaCompra,
        'quantidade' => $quantidade,
        'quantidade_minima' => $qtd_minima,
        'localizacao' => $localEstoque,
        'un_medida' => $medida,
        'data_validade' => $dataValidade,
        'fornecedor_id' => $fornecedorId,
        'status' => 0,
        'ibpt' => $ibpt,
        'ncm' => $ncm,
        'cest' => $cest,
        'cfop' => $cfop,
        'icms' => $icms,
        'ipi' => $ipi,
        'pis' => $pisE,
        'cofins' => $cofinsE
    ];

    $stmtCheck = $conn->prepare("SELECT * FROM produtos WHERE cod_barras = :cod_barras LIMIT 1");
    $stmtCheck->execute([':cod_barras' => $codBarras]);
    $produtoExistente = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($produtoExistente) {
          $updateFields = [];
        $updateData = [];
        foreach ($data as $key => $val) {
            if ((empty($produtoExistente[$key]) || $produtoExistente[$key] === '0') && !empty($val)) {
                $updateFields[] = "$key = :$key";
                $updateData[$key] = $val;
            }
        }
        if (!empty($updateFields)) {
            $sql = "UPDATE produtos SET " . implode(', ', $updateFields) . " WHERE id = :id";
            $updateData['id'] = $produtoExistente['id'];
            $stmtUpdate = $conn->prepare($sql);
            if ($stmtUpdate->execute($updateData)) $atualizados++;
        }
    } else {
        $fields = [];
        foreach ($data as $key => $val) {
            $fields[] = "$key = :$key";
        }
        $sql = "INSERT INTO produtos SET " . implode(', ', $fields);
        $stmtInsert = $conn->prepare($sql);
        if ($stmtInsert->execute($data)) $importados++;
        else $falhas++;
    }
}

$totalStmt = $conn->query("SELECT COUNT(*) FROM produtos");
$totalProdutos = $totalStmt->fetchColumn();

echo json_encode([
    'success' => true,
    'atualizados' => $atualizados,
    'importados' => $importados,
    'falhas' => $falhas,
    'total' => $totalProdutos
]);
exit;
