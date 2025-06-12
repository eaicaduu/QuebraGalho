<?php
session_start();
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_cpf'])) {
    echo json_encode(['success' => false, 'error' => 'Sessão expirada. Faça login novamente.']);
    exit;
}

$cpf = $_SESSION['usuario_cpf'];
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senhaAtual = $_POST['senha_atual'] ?? '';
$novaSenha = $_POST['nova_senha'] ?? '';
$confirmarSenha = $_POST['confirmar_senha'] ?? '';

if (empty($nome) || empty($email) || empty($senhaAtual)) {
    echo json_encode(['success' => false, 'error' => 'Preencha todos os campos obrigatórios.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'E-mail inválido.']);
    exit;
}

if (!empty($novaSenha) || !empty($confirmarSenha)) {
    if (strlen($novaSenha) < 6) {
        echo json_encode(['success' => false, 'error' => 'A nova senha deve ter no mínimo 6 caracteres.']);
        exit;
    }
    if ($novaSenha !== $confirmarSenha) {
        echo json_encode(['success' => false, 'error' => 'As senhas não coincidem.']);
        exit;
    }
}

try {
    $database = new Database();
    $db = $database->getConnection();

    $stmt = $db->prepare("SELECT senha FROM usuarios WHERE cpf = :cpf");
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($senhaAtual, $user['senha'])) {
        echo json_encode(['success' => false, 'error' => 'Senha atual incorreta.']);
        exit;
    }


    if (!empty($novaSenha)) {
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE cpf = :cpf";
    } else {
        $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE cpf = :cpf";
    }

    $stmtUpdate = $db->prepare($sql);
    $stmtUpdate->bindParam(':nome', $nome);
    $stmtUpdate->bindParam(':email', $email);
    if (!empty($novaSenha)) {
        $stmtUpdate->bindParam(':senha', $senhaHash);
    }
    $stmtUpdate->bindParam(':cpf', $cpf);

    if ($stmtUpdate->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erro ao atualizar dados.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erro no servidor.']);
}
?>