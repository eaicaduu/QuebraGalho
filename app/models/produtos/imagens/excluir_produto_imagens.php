<?php
require_once __DIR__ . '/../../../config/database.php';
header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$midiaId = $_POST['midia_id'] ?? null;

if (!$midiaId) {
    echo json_encode(['success' => false, 'message' => 'ID da mídia não fornecido']);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM produtos_imagens WHERE id = ?");
$stmt->execute([$midiaId]);
$midia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$midia) {
    echo json_encode(['success' => false, 'message' => 'Mídia não encontrada']);
    exit;
}

$caminhoArquivo = __DIR__ . '/../../../uploads/imagens/' . basename($midia['url']);
if (file_exists($caminhoArquivo)) {
    unlink($caminhoArquivo);
}

$stmtDelete = $conn->prepare("DELETE FROM produtos_imagens WHERE id = ?");
$stmtDelete->execute([$midiaId]);

echo json_encode([
    'success' => true,
    'tipo' => $midia['tipo']
]);
exit;
