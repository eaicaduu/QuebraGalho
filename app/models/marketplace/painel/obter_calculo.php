<?php
require_once '../../../config/database.php';
header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT * FROM calculo ORDER BY id DESC");
$calculo = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($calculo);
