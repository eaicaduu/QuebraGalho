<?php
require_once '../../config/database.php';

header('Content-Type: application/json; charset=utf-8');

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT * FROM usuarios ORDER BY criado_em DESC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtTotal = $conn->query("SELECT COUNT(*) AS total FROM usuarios");
$totalUsuarios = (int) $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];


echo json_encode([
    "success" => true,
    "usuarios" => $usuarios,
    "totalUsuarios" => $totalUsuarios
]);
