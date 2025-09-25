<?php
require_once '../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $nome       = trim($data['nome'] ?? '');
    $documento  = trim($data['documento'] ?? '');
    $email      = trim($data['email'] ?? '');
    $tipoUsuario = isset($data['tipo_usuario']) ? intval($data['tipo_usuario']) : 0;

    if (empty($nome) || empty($documento) || empty($email)) {
        echo json_encode([
            'success' => false,
            'message' => 'Preencha todos os campos obrigatórios.'
        ]);
        exit;
    }

    try {
        $stmt = $conn->prepare("
            INSERT INTO usuarios (nome, documento, email, tipo_usuario, primeiro_acesso, criado_em)
            VALUES (:nome, :documento, :email, :tipo_usuario, 1, NOW())
        ");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':documento', $documento);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':tipo_usuario', $tipoUsuario);

        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Usuário criado com sucesso! Ele deverá definir a senha no primeiro login.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao criar usuário.'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Erro: ' . $e->getMessage()
        ]);
    }
}
