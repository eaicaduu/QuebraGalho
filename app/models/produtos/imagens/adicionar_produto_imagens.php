<?php
require_once __DIR__ . '/../../../config/database.php';
header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$produtoId = $_POST['produto_id'] ?? null;
$uploadedFiles = $_FILES['midias'] ?? null;

if (!$produtoId || !$uploadedFiles) {
    echo json_encode(['success' => false, 'message' => 'Produto ou arquivo não enviado']);
    exit;
}

$stmtCount = $conn->prepare("SELECT COUNT(*) as qtd FROM produtos_imagens WHERE produto_id = ?");
$stmtCount->execute([$produtoId]);
$resultCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
$qtdAtual = $resultCount['qtd'] ?? 0;

if ($qtdAtual >= 5) {
    echo json_encode(['success' => false, 'message' => 'Limite de 5 mídias atingido']);
    exit;
}

$midiasAtuais = [];
foreach ($uploadedFiles['name'] as $key => $name) {
    if ($qtdAtual + count($midiasAtuais) >= 5) break;

    $tmpName = $uploadedFiles['tmp_name'][$key];
    $ext = pathinfo($name, PATHINFO_EXTENSION);

    $tipo = in_array(strtolower($ext), ['mp4','mov','avi']) ? 'videos' : 'imagens';
    $uploadDir = $tipo === 'videos' ? __DIR__.'/../../../uploads/videos/' : __DIR__.'/../../../uploads/imagens/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $novoNome = uniqid('produto_') . '.' . $ext;
    $caminhoCompleto = $uploadDir . $novoNome;

    if (move_uploaded_file($tmpName, $caminhoCompleto)) {
        $url =  $novoNome;
        $stmt = $conn->prepare("INSERT INTO produtos_imagens (produto_id, tipo, url, ordem) VALUES (?, ?, ?, 0)");
        $stmt->execute([$produtoId, $tipo, $url]);

        $midiasAtuais[] = [
            'id' => $conn->lastInsertId(),
            'url' =>  '../../../app/uploads/' . $tipo . '/' . $novoNome,
            'tipo' => $tipo
        ];
    }
}

echo json_encode(['success' => true, 'midias' => $midiasAtuais]);
exit;
