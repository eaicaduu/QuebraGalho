<?php
require_once __DIR__ . '/../../../config/database.php';
header('Content-Type: application/json');

$db = new Database();
$conn = $db->getConnection();

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'error' => 'Produto não informado.']);
    exit;
}

$fields = [];
$params = [':id' => $id];

if (isset($_POST['nome'])) {
    $fields[] = "nome = :nome";
    $params[':nome'] = trim($_POST['nome']);
}
if (isset($_POST['desc_curta'])) {
    $fields[] = "desc_curta = :desc_curta";
    $params[':desc_curta'] = trim($_POST['desc_curta']);
}

if (isset($_POST['preco'])) {
    $fields[] = "preco = :preco";
    $params[':preco'] = trim($_POST['preco']);
}

if (isset($_POST['preco_pj'])) {
    $fields[] = "preco_pj = :preco_pj";
    $params[':preco_pj'] = trim($_POST['preco_pj']);
}

if (isset($_POST['promocao'])) {
    $fields[] = "promocao = :promocao";
    $params[':promocao'] = $_POST['promocao'] ? 1 : 0;
}

if (isset($_POST['destaque'])) {
    $fields[] = "destaque = :destaque";
    $params[':destaque'] = $_POST['destaque'] ? 1 : 0;
}

if (isset($_POST['desconto_percentual'])) {
    $fields[] = "desconto_percentual = :desconto_percentual";
    $params[':desconto_percentual'] = floatval(str_replace(",", ".", $_POST['desconto_percentual']));
}

if (isset($_POST['preco_promocional'])) {
    $fields[] = "preco_promocional = :preco_promocional";
    $params[':preco_promocional'] = floatval(str_replace(",", ".", $_POST['preco_promocional']));
}

if (isset($_POST['status'])) {
    $fields[] = "status = :status";
    $params[':status'] = (int) $_POST['status'];
}

if (!empty($fields)) {
    $sql = "UPDATE produtos SET " . implode(", ", $fields) . " WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    echo json_encode(['success' => true, 'message' => 'Produto atualizado com sucesso.']);
    exit;
}

function baixarImagem($url, $destino)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $data = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status == 200 && $data) {
        return file_put_contents($destino, $data) !== false;
    }
    return false;
}

function removerImagemAntiga($conn, $id)
{
    $stmt = $conn->prepare("SELECT imagem_principal FROM produtos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $imagemAntiga = $stmt->fetchColumn();

    if ($imagemAntiga) {
        $caminhoAntigo = __DIR__ . '/../../../../app/uploads/produtos/' . $imagemAntiga;
        if (file_exists($caminhoAntigo)) {
            @unlink($caminhoAntigo);
        }
    }
}

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    removerImagemAntiga($conn, $id);
    $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $novoNome = uniqid('prod_') . '.' . strtolower($ext);
    $destino = __DIR__ . '/../../../../app/uploads/produtos/' . $novoNome;

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
        $stmt = $conn->prepare("UPDATE produtos SET imagem_principal = :imagem_principal WHERE id = :id");
        $stmt->execute([':imagem_principal' => $novoNome, ':id' => $id]);

        echo json_encode([
            'success' => true,
            'novaImagemUrl' => '../../../app/uploads/produtos/' . $novoNome
        ]);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Falha ao mover o arquivo enviado.']);
        exit;
    }
}

if (isset($_POST['imagem']) && filter_var($_POST['imagem'], FILTER_VALIDATE_URL)) {
    removerImagemAntiga($conn, $id);
    $url = $_POST['imagem'];
    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: "jpg";
    $novoNome = uniqid('prod_') . '.' . strtolower($ext);
    $destino = __DIR__ . '/../../../../app/uploads/produtos/' . $novoNome;

    if (baixarImagem($url, $destino)) {
        $stmt = $conn->prepare("UPDATE produtos SET imagem_principal = :imagem_principal WHERE id = :id");
        $stmt->execute([':imagem_principal' => $novoNome, ':id' => $id]);

        echo json_encode([
            'success' => true,
            'novaImagemUrl' => '../../../app/uploads/produtos/' . $novoNome
        ]);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Falha ao baixar a imagem da URL.']);
        exit;
    }
}

echo json_encode(['success' => false, 'error' => 'Nenhuma ação detectada.']);
