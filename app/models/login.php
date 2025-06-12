<?php
session_start();
require_once __DIR__ . '/../config/database.php'; 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
    $password = $_POST['password'] ?? '';

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

if ($user['perm_admin'] == 0) {
    echo json_encode(['success' => false, 'error' => 'sem_permissao_admin']);
    exit;
}


    $_SESSION['usuario_cpf'] = $user['cpf'];
    $_SESSION['usuario_nome'] = $user['nome'];
    $_SESSION['admin'] = $user['perm_admin'];


   echo json_encode([
    'success' => true,
    'admin' => $user['perm_admin'] == 1 ? true : false
]);

    exit;
}

echo json_encode(['success' => false, 'error' => 'requisicao_invalida']);