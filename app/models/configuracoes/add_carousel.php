<?php
require_once __DIR__ . '../../../config/database.php'; 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagem'])) {
    $uploadDir = __DIR__ . '/../../uploads/carousel/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $nomeArquivo = time() . '_' . basename($_FILES['imagem']['name']);
    $caminhoCompleto = $uploadDir . $nomeArquivo;

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("INSERT INTO carousel (imagem) VALUES (?)");
        $stmt->execute([$nomeArquivo]);

        echo json_encode(["success" => true, "filename" => $nomeArquivo]);
    } else {
        echo json_encode(["success" => false, "message" => "Falha no upload"]);
    }
    exit;
}

echo json_encode(["success" => false, "message" => "Requisição inválida"]);
