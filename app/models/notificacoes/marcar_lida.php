<?php
require_once __DIR__ . '/../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

$produto_id = isset($_GET['produto_id']) ? intval($_GET['produto_id']) : 0;

if($produto_id > 0){
    $stmt = $conn->prepare("UPDATE notificacoes SET status = 1 WHERE produto_id = ?");
    $stmt->execute([$produto_id]);
}

header("Location: produtos/produtos_atributos.php?id=$produto_id");
exit();
