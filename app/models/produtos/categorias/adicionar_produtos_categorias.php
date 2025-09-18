<?php
require_once __DIR__ . '/../../../config/database.php';
header('Content-Type: application/json');

$response = ['sucesso' => false];

try {
    $db = new Database();
    $conn = $db->getConnection();

    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';

    if (empty($nome)) {
        $response['mensagem'] = "O nome da categoria não pode ficar vazio.";
        echo json_encode($response);
        exit;
    }

    $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM categorias WHERE nome = :nome");
    $stmtCheck->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmtCheck->execute();
    if ($stmtCheck->fetchColumn() > 0) {
        $response['mensagem'] = "Já existe uma categoria com esse nome.";
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO categorias (nome, status) VALUES (:nome, 1)");
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    if ($stmt->execute()) {
        $novaCategoriaId = $conn->lastInsertId();

        ob_start();
        $categoria = [
            'id' => $novaCategoriaId,
            'nome' => htmlspecialchars($nome),
            'status' => 1,
            'total_produtos' => 0
        ];
        include __DIR__ . "/../cards/card_categorias_sm.php";
        $html_sm = ob_get_clean();

        ob_start();
        include __DIR__ . "/../cards/card_categorias_xl.php";
        $html_xl = ob_get_clean();

        $response['sucesso'] = true;
        $response['categoria'] = [
            'id' => $novaCategoriaId,
            'html_sm' => $html_sm,
            'html_xl' => $html_xl
        ];
    } else {
        $response['mensagem'] = "Erro ao adicionar a categoria.";
    }
} catch (PDOException $e) {
    $response['mensagem'] = "Erro no banco de dados: " . $e->getMessage();
}

echo json_encode($response);
