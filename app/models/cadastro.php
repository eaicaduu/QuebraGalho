<?php
session_start();
require_once __DIR__ . '/../config/database.php'; 

header('Content-Type: application/json');

$nome = trim($_POST['nome'] ?? '');
$cpf = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmarSenha = $_POST['confirmarSenha'] ?? '';

if (empty($nome) || empty($cpf) || empty($email) || empty($senha) || empty($confirmarSenha)) {
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

$stmtCPF = $conn->prepare("SELECT id FROM usuarios WHERE cpf = :cpf");
$stmtCPF->bindParam(':cpf', $cpf);
$stmtCPF->execute();

if ($stmtCPF->rowCount() > 0) {
    echo json_encode(['success' => false, 'error' => 'cpf']);
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$stmtInsert = $conn->prepare("INSERT INTO usuarios (nome, cpf, email, senha, perm_admin) VALUES (:nome, :cpf, :email, :senha, :perm_admin)");
$stmtInsert->bindParam(':nome', $nome);
$stmtInsert->bindParam(':cpf', $cpf);
$stmtInsert->bindParam(':email', $email);
$stmtInsert->bindParam(':senha', $senhaHash);
$stmtInsert->bindParam(':perm_admin', 0);

if ($stmtInsert->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'erro_ao_cadastrar']);
}