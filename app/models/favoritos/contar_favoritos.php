<?php
session_start();
require_once '../../config/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
  echo json_encode(['total' => 0]);
  exit;
}

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT COUNT(*) FROM favoritos WHERE usuario_id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$total = $stmt->fetchColumn();

echo json_encode(['total' => (int) $total]);
