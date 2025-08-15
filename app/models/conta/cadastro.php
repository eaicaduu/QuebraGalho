<?php
session_start();
require_once __DIR__ . '../../../config/database.php'; 

header('Content-Type: application/json');

$nome = trim($_POST['nome'] ?? '');
$documento = preg_replace('/\D/', '', $_POST['documento'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmarSenha = $_POST['confirmarSenha'] ?? '';

if (empty($nome) || empty($documento) || empty($email) || empty($senha) || empty($confirmarSenha)) {
    echo json_encode(['success' => false, 'error' => 'dados_incompletos']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'email_invalido']);
    exit;
}

if (strlen($senha) < 6) {
    echo json_encode(['success' => false, 'error' => 'senha_invalida']);
    exit;
}

if ($senha !== $confirmarSenha) {
    echo json_encode(['success' => false, 'error' => 'senhas_divergentes']);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'erro_conexao']);
    exit;
}

$stmtEmail = $conn->prepare("SELECT id FROM usuarios WHERE email = :email");
$stmtEmail->bindParam(':email', $email);
$stmtEmail->execute();

if ($stmtEmail->rowCount() > 0) {
    echo json_encode(['success' => false, 'error' => 'email']);
    exit;
}

$stmtDocumento = $conn->prepare("SELECT id FROM usuarios WHERE documento = :documento");
$stmtDocumento->bindParam(':documento', $documento);
$stmtDocumento->execute();

if ($stmtDocumento->rowCount() > 0) {
    echo json_encode(['success' => false, 'error' => 'documento']);
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$stmtInsert = $conn->prepare("INSERT INTO usuarios (nome, documento, email, senha) VALUES (:nome, :documento, :email, :senha)");
$stmtInsert->bindParam(':nome', $nome);
$stmtInsert->bindParam(':documento', $documento);
$stmtInsert->bindParam(':email', $email);
$stmtInsert->bindParam(':senha', $senhaHash);

if ($stmtInsert->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'erro_ao_cadastrar']);
}