<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');
$db = new Database();
$conn = $db->getConnection();

$existentes = [];
$stmt = $conn->query("SELECT produto_id, mensagem FROM notificacoes");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $existentes[$row['produto_id']][$row['mensagem']] = true;
}

$notificacoes = [];

$produtos = $conn->query("SELECT id, nome, preco, cod_barras FROM produtos")->fetchAll(PDO::FETCH_ASSOC);

foreach ($produtos as $p) {
    if (!$p['cod_barras']) {
        $mensagem = "Produto sem código de barras: {$p['nome']} (ID: {$p['id']})";
        if (empty($existentes[$p['id']][$mensagem])) {
            $conn->prepare("INSERT INTO notificacoes (produto_id, tipo, mensagem, status) VALUES (?, 'erro', ?, 0)")
                 ->execute([$p['id'], $mensagem]);
        }
        $notificacoes[] = ['tipo'=>'erro','mensagem'=>$mensagem,'produto_id'=>$p['id']];
    }

    if (!$p['preco'] || $p['preco'] <= 0) {
        $mensagem = "Produto sem preço definido: {$p['nome']} (ID: {$p['id']})";
        if (empty($existentes[$p['id']][$mensagem])) {
            $conn->prepare("INSERT INTO notificacoes (produto_id, tipo, mensagem, status) VALUES (?, 'erro', ?, 0)")
                 ->execute([$p['id'], $mensagem]);
        }
        $notificacoes[] = ['tipo'=>'erro','mensagem'=>$mensagem,'produto_id'=>$p['id']];
    }
}

$html = '';
foreach ($notificacoes as $n) {
    $tipoClass = $n['tipo'] === 'erro' ? 'border-danger text-bg-danger' : ($n['tipo']==='aviso'?'border-warning text-bg-warning':'border-info text-bg-info');
    $html .= '<div class="card mb-2 '.$tipoClass.'" style="max-width:100%; cursor:pointer;" onclick="window.location.href=\'notificacoes/marcar_lida.php?produto_id='.$n['produto_id'].'\'">';
    $html .= '<div class="card-body d-flex justify-content-between align-items-center">';
    $html .= '<h5 class="card-title mb-0 d-flex align-items-center gap-2">';
    $html .= $n['tipo']==='erro'?'<i class="bi bi-exclamation-triangle-fill"></i> Erro':'<i class="bi bi-info-circle-fill"></i> Informação';
    $html .= '</h5>';
    $html .= '<span class="card-text mb-0">'.htmlspecialchars($n['mensagem']).'</span>';
    $html .= '</div></div>';
}

echo json_encode(['html'=>$html]);
exit();
