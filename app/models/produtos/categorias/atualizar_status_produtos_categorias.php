<?php
require_once __DIR__ . '/../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($id !== null && $status !== null) {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("UPDATE categorias SET status = :status WHERE id = :id");
        $stmt->bindValue(":status", $status, PDO::PARAM_INT);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["sucesso" => true]);
            exit;
        }
    }
}

echo json_encode(["sucesso" => false]);
