<?php
require_once __DIR__ . '../../../config/database.php';

header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT * FROM carousel ORDER BY criado_em DESC");
$imagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($imagens);
