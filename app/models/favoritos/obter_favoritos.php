<?php
header('Content-Type: application/json');

require_once '../../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['ids']) || !is_array($data['ids']) || count($data['ids']) === 0) {
    echo json_encode(['success' => false, 'produtos' => []]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$placeholders = implode(',', array_fill(0, count($data['ids']), '?'));
$stmt = $conn->prepare("SELECT * FROM produtos WHERE id IN ($placeholders)");
$stmt->execute($data['ids']);

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'produtos' => $produtos]);
