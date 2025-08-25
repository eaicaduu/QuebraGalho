<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'error' => 'Produto não informado.']);
    exit;
}

if (isset($_POST['nome']) && isset($_POST['status'])) {
    $nome = trim($_POST['nome']);
    $status = (int)$_POST['status'];

    $stmt = $conn->prepare("UPDATE produtos SET nome = :nome, status = :status WHERE id = :id");
    $stmt->execute([':nome' => $nome, ':status' => $status, ':id' => $id]);

    echo json_encode(['success' => true]);
    exit;
}

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['imagem'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $novoNome = uniqid('prod_') . '.' . $ext;
    $destino = '../../../app/' . $novoNome;

    if (move_uploaded_file($file['tmp_name'], $destino)) {
        $stmt = $conn->prepare("UPDATE produtos SET imagem = :imagem WHERE id = :id");
        $stmt->execute([':imagem' => $novoNome, ':id' => $id]);

        echo json_encode([
            'success' => true,
            'novaImagemUrl' => '/app/uploads/produtos/' . $novoNome
        ]);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Falha ao mover arquivo.']);
        exit;
    }
}

echo json_encode(['success' => false, 'error' => 'Nenhuma ação detectada.']);
