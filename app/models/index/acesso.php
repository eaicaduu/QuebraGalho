<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/database.php';

$dados = json_decode(file_get_contents("php://input"), true);

if (!isset($dados['senha'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Senha não informada']);
    exit;
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmtConfig = $conn->query("SELECT senha_acesso FROM configuracao LIMIT 1");
    $config = $stmtConfig->fetch(PDO::FETCH_ASSOC);

    if (!$config || empty($config['senha_acesso'])) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Senha não configurada']);
        exit;
    }

    $senha_digitada = $dados['senha'];
    $senha_acesso = $config['senha_acesso'];

    if (password_verify($senha_digitada, $senha_acesso)) {
        $_SESSION['acesso'] = true;
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Senha incorreta']);
    }

} catch (PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
