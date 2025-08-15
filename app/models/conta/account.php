<?php
session_start();
require_once __DIR__ . '../../../config/database.php'; 
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_documento'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Sessão expirada. Faça login novamente.']);
    exit;
}

$documento = $_SESSION['usuario_documento'];

$campos = [];
$params = [':documento' => $documento];

if (!empty(trim($_POST['nome'] ?? ''))) {
    $campos[] = "nome = :nome";
    $params[':nome'] = trim($_POST['nome']);
    $_SESSION['usuario_nome'] = $params[':nome'];
}

if (!empty(trim($_POST['email'] ?? ''))) {
    $campos[] = "email = :email";
    $params[':email'] = trim($_POST['email']);
}

if (!empty(trim($_POST['telefone'] ?? ''))) {
    $campos[] = "telefone = :telefone";
    $params[':telefone'] = trim($_POST['telefone']);
}

if (!empty(trim($_POST['data_nascimento'] ?? ''))) {
    $campos[] = "data_nascimento = :data_nascimento";
    $params[':data_nascimento'] = trim($_POST['data_nascimento']);
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    if (isset($_FILES['nova_foto']) && $_FILES['nova_foto']['error'] === UPLOAD_ERR_OK) {
        $fotoTmp = $_FILES['nova_foto']['tmp_name'];
        $fotoNomeOriginal = basename($_FILES['nova_foto']['name']);
        $extensao = strtolower(pathinfo($fotoNomeOriginal, PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($extensao, $permitidas)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Formato de imagem inválido.']);
            exit;
        }

        $stmtFotoAntiga = $conn->prepare("SELECT imagem_perfil FROM usuarios WHERE documento = :documento");
        $stmtFotoAntiga->bindParam(':documento', $documento);
        $stmtFotoAntiga->execute();
        $fotoAntiga = $stmtFotoAntiga->fetchColumn();

        if ($fotoAntiga && file_exists(__DIR__ . '../../../' . $fotoAntiga)) {
            unlink(__DIR__ . '../../../' . $fotoAntiga);
        }

        $novoNome = 'perfil_' . uniqid() . '.' . $extensao;
        $destino = __DIR__ . '../../../uploads/perfil/' . $novoNome;
        $caminhoWeb = 'uploads/perfil/' . $novoNome;

        if (move_uploaded_file($fotoTmp, $destino)) {
            $campos[] = "imagem_perfil = :imagem_perfil";
            $params[':imagem_perfil'] = $caminhoWeb;
            $_SESSION['usuario_imagem'] = $caminhoWeb;
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Falha ao salvar a nova imagem.']);
            exit;
        }
    }

    if (empty($campos)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Nenhuma informação foi enviada para atualizar.']);
        exit;
    }

    $sql = "UPDATE usuarios SET " . implode(', ', $campos) . " WHERE documento = :documento";
    $stmt = $conn->prepare($sql);

    foreach ($params as $chave => $valor) {
        $stmt->bindValue($chave, $valor);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Dados atualizados com sucesso!']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Erro ao atualizar os dados no banco de dados.']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro de conexão com o servidor.']);
}
