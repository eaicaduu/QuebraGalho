<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida']);
    exit;
}

$requiredFields = ['nome', 'preco', 'status'];
foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        echo json_encode(['success' => false, 'message' => "Campo obrigatório ausente: $field"]);
        exit;
    }
}

$nome = trim($_POST['nome']);
$preco = floatval($_POST['preco']);
$status = ($_POST['status'] == '1') ? 1 : 0;

if (!isset($_FILES['imagem']) || $_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Imagem inválida ou não enviada']);
    exit;
}

$uploadDir = __DIR__ . '../../../uploads/produtos/';
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

$caminhoImagemDB = 'uploads/produtos/' . $nomeImagem;

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("INSERT INTO produtos (nome, preco, status, imagem_principal) 
                            VALUES (:nome, :preco, :status, :imagem_principal)");

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':status', $status, PDO::PARAM_BOOL);
    $stmt->bindParam(':imagem_principal', $caminhoImagemDB);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Produto adicionado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao inserir no banco de dados']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
