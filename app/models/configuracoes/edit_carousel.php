<?php
require_once __DIR__ . '../../../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_FILES['imagem'])) {
    $id = intval($_POST['id']);
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT imagem FROM carousel WHERE id=?");
    $stmt->execute([$id]);
    $img = $stmt->fetch();

    if ($img) {
        $uploadDir = __DIR__ . '/../../uploads/carousel/';
        $nomeArquivo = time() . '_' . basename($_FILES['imagem']['name']);
        $caminhoCompleto = $uploadDir . $nomeArquivo;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
            $fileOld = $uploadDir . $img['imagem'];
            if (file_exists($fileOld))
                unlink($fileOld);

            $stmt = $conn->prepare("UPDATE carousel SET imagem=? WHERE id=?");
            $stmt->execute([$nomeArquivo, $id]);

            echo json_encode([
                "success" => true,
                "novaImagem" => $nomeArquivo
            ]);
            exit;
        }
    }
}
echo json_encode(["success" => false, "message" => "Erro ao atualizar"]);
