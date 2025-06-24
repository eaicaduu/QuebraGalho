<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida']);
    exit;
}

$requiredFields = ['nome', 'preco', 'descricao', 'quantidade', 'status'];
foreach ($requiredFields as $field) {
    if (!isset($_POST[$field])) {
        echo json_encode(['success' => false, 'message' => 'Campos obrigatórios ausentes']);
        exit;
    }
}

$nome = trim($_POST['nome']);
$preco = floatval($_POST['preco']);
$descricao = trim($_POST['descricao']);
$quantidade = intval($_POST['quantidade']);
$status = ($_POST['status'] == '1') ? 1 : 0;

if (!isset($_FILES['imagem']) || $_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Imagem inválida ou não enviada']);
    exit;
}

$uploadDir = __DIR__ . '/../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
$nomeImagem = uniqid('produto_') . '.' . $extensao;
$caminhoImagem = $uploadDir . $nomeImagem;

if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar a imagem']);
    exit;
}

$caminhoImagemDB = 'uploads/' . $nomeImagem;

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("INSERT INTO produtos (nome, preco, descricao, quantidade, status, imagem) 
        VALUES (:nome, :preco, :descricao, :quantidade, :status, :imagem)");

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':quantidade', $quantidade);
    $stmt->bindParam(':status', $status, PDO::PARAM_BOOL);
    $stmt->bindParam(':imagem', $caminhoImagemDB);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao inserir no banco de dados']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
