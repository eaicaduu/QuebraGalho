<?php
session_start();
require_once __DIR__ . '/../config/database.php'; 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
    $password = $_POST['senha'] ?? '';
    $remember = isset($_POST['remember']);

    if (empty($cpf) || empty($password)) {
        echo json_encode(['success' => false, 'error' => 'dados_incompletos']);
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        echo json_encode(['success' => false, 'error' => 'erro_conexao']);
        exit;
    }

    $stmt = $db->prepare("SELECT * FROM usuarios WHERE cpf = :cpf");
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

   if (!$user) {
    echo json_encode(['success' => false, 'error' => 'cpf']);
    exit;
}

if (!password_verify($password, $user['senha'])) {
    echo json_encode(['success' => false, 'error' => 'senha']);
    exit;
}

    $_SESSION['usuario_cpf'] = $user['cpf'];
    $_SESSION['usuario_nome'] = $user['nome'];
    $_SESSION['admin'] = $user['perm_admin'];

if ($remember) {
    $token = bin2hex(random_bytes(16)); 
    $expiracao = date('Y-m-d H:i:s', strtotime('+30 days'));

    $stmtToken = $db->prepare("INSERT INTO user_tokens (user_id, token, expires) VALUES (:user_id, :token, :expires)");
    $stmtToken->bindParam(':user_id', $user['id']);
    $stmtToken->bindParam(':token', $token);
    $stmtToken->bindParam(':expires', $expiracao);
    $stmtToken->execute();

    setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', isset($_SERVER['HTTPS']), true);
    setcookie('remember_cpf', $user['cpf'], time() + (30 * 24 * 60 * 60), '/', '', isset($_SERVER['HTTPS']), false);

    $chave = 'minha-chave-secreta'; 
    $senhaCriptografada = openssl_encrypt($password, 'AES-128-ECB', $chave);
    setcookie('remember_senha', $senhaCriptografada, time() + (30 * 24 * 60 * 60), '/', '', isset($_SERVER['HTTPS']), false);
} else {
    setcookie('remember_token', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), true);
    setcookie('remember_cpf', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), false);
    setcookie('remember_senha', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), false);
}
   echo json_encode([
    'success' => true,
    'admin' => $user['perm_admin'] == 1 ? true : false
]);

    exit;
}

echo json_encode(['success' => false, 'error' => 'requisicao_invalida']);