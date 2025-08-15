<?php
require_once '../../config/database.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
  echo json_encode(['erro' => 'Usuário não logado']);
  exit;
}

$usuario_id = $_SESSION['usuario_id'];

$db = new Database();
$conn = $db->getConnection();

$sql = "
  SELECT p.* FROM favoritos f
  JOIN produtos p ON f.produto_id = p.id
  WHERE f.usuario_id = ?
  ORDER BY f.data_adicionado DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute([$usuario_id]);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['produtos' => $produtos]);
