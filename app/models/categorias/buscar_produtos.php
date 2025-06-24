<?php
require_once __DIR__ . '/../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT id, nome FROM produtos");
$stmt->execute();

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
