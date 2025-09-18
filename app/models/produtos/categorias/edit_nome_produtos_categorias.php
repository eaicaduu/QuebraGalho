<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../../config/database.php';

$response = ['sucesso' => false, 'mensagem' => ''];

if (!isset($_POST['id'], $_POST['nome'])) {
    $response['mensagem'] = 'Dados incompletos.';
    echo json_encode($response);
    exit;
}

$id = intval($_POST['id']);
$nome = trim($_POST['nome']);

if ($nome === '') {
    $response['mensagem'] = 'O nome da categoria não pode ficar vazio.';
    echo json_encode($response);
    exit;
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("UPDATE categorias SET nome = :nome WHERE id = :id");
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $response['sucesso'] = true;
        $response['mensagem'] = 'Nome atualizado com sucesso!';
    } else {
        $response['mensagem'] = 'Não foi possível atualizar o nome.';
    }

} catch (PDOException $e) {
    $response['mensagem'] = 'Erro no banco de dados: ' . $e->getMessage();
}

echo json_encode($response);
