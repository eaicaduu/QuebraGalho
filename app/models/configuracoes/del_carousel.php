<?php
require_once __DIR__ . '../../../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT imagem FROM carousel WHERE id=?");
    $stmt->execute([$id]);
    $img = $stmt->fetch();

    if ($img) {
        $stmt = $conn->prepare("DELETE FROM carousel WHERE id=?");
        $stmt->execute([$id]);

        $file = __DIR__ . '/../../uploads/carousel/' . $img['imagem'];
        if (file_exists($file)) {
            unlink($file);
        }

        echo json_encode(["success" => true]);
        exit;
    }
}
echo json_encode(["success" => false, "message" => "Erro ao excluir"]);
