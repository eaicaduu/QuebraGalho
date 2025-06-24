<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida']);
    exit;
}

$requiredFields = ['id', 'nome', 'preco', 'descricao', 'quantidade', 'status'];
foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        echo json_encode(['success' => false, 'message' => 'Campos obrigatórios ausentes']);
        exit;
    }
}

$id = intval($_POST['id']);
$nome = trim($_POST['nome']);
$preco = floatval($_POST['preco']);
$descricao = trim($_POST['descricao']);
$quantidade = intval($_POST['quantidade']);
$status = ($_POST['status'] == '1' || $_POST['status'] === 1 || $_POST['status'] === 'ativo') ? 1 : 0;

try {
    $db = new Database();
    $conn = $db->getConnection();

    $novaImagem = false;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
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
        $novaImagem = true;

        $stmtSelect = $conn->prepare("SELECT imagem FROM produtos WHERE id = :id");
        $stmtSelect->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtSelect->execute();
        $produtoAntigo = $stmtSelect->fetch(PDO::FETCH_ASSOC);
        if ($produtoAntigo && !empty($produtoAntigo['imagem'])) {
            $caminhoImagemAntigo = __DIR__ . '/../' . $produtoAntigo['imagem'];
            if (file_exists($caminhoImagemAntigo)) {
                @unlink($caminhoImagemAntigo);
            }
        }
    }

    if ($novaImagem) {
        $sql = "UPDATE produtos SET nome = :nome, preco = :preco, descricao = :descricao, quantidade = :quantidade, status = :status, imagem = :imagem WHERE id = :id";
    } else {
        $sql = "UPDATE produtos SET nome = :nome, preco = :preco, descricao = :descricao, quantidade = :quantidade, status = :status WHERE id = :id";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':quantidade', $quantidade);
    $stmt->bindParam(':status', $status, PDO::PARAM_BOOL);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($novaImagem) {
        $stmt->bindParam(':imagem', $caminhoImagemDB);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o produto']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
